<?php
/**
 * PHP class to interface with the JavaScript similarity checker
 * Returns similarity results as PHP arrays
 */

class JSSimilarityChecker {
    private $csvPath;
    private $jsPath;

    public function __construct() {
        $this->csvPath = __DIR__ . '/../database/paper_details_final_data.csv';
        $this->jsPath = __DIR__ . '/similarity-checker.js';
    }

    /**
     * Check similarity using the JavaScript implementation (not currently used in web context)
     */
    public function checkSimilarity($newTitle, $newAbstract, $topN = 3) {
        // Validate inputs
        if (empty($newTitle) || empty($newAbstract)) {
            return ['error' => 'Both title and abstract are required'];
        }

        // Create a temporary JS file to call the similarity checker with the new data
        $tempJs = tempnam(sys_get_temp_dir(), 'sim_check_');
        $tempJs .= '.js';

        // Escape single quotes for JavaScript
        $escapedTitle = addslashes($newTitle);
        $escapedAbstract = addslashes($newAbstract);

        $jsCode = "
const ProjectSimilarityChecker = require('./similarity-checker.js');

async function checkNewProject() {
    try {
        const checker = new ProjectSimilarityChecker();
        await checker.loadCSV('./paper_details_final_data.csv');
        checker.preprocessData();
        checker.prepareData();
        
        // Use the checkSimilarity method (which logs results) and return them
        const results = await checker.checkSimilarity('$escapedTitle', '$escapedAbstract', $topN);
        console.log('SIMILARITY_RESULTS:' + JSON.stringify(results));
    } catch (error) {
        console.error('ERROR:' + JSON.stringify({ error: error.message }));
    }
}

checkNewProject();
";

        file_put_contents($tempJs, $jsCode);

        // Execute the node command
        $cmd = "cd " . dirname($this->jsPath) . " && node " . escapeshellarg($tempJs);
        $output = shell_exec($cmd . " 2>&1");

        // Clean up temporary file
        unlink($tempJs);

        // Parse the output to extract similarity information
        return $this->parseJSOutput($output, $topN);
    }

    /**
     * Alternative method that only returns suggestions without calling Node.js
     * This is a fallback if Node.js is not available or when used in web context
     */
    public function getSimilaritySuggestions($newTitle, $newAbstract, $topN = 3) {
        // Include the PHP similarity checker as backup if class doesn't already exist
        if (!class_exists('SimilarityChecker')) {
            include(__DIR__ . '/similarity-checker.php');
        }
        
        $checker = new SimilarityChecker();
        $similar_projects = $checker->checkSimilarityPHPOnly($newTitle, $newAbstract, $topN);
        
        if (isset($similar_projects['error']) || !is_array($similar_projects)) {
            return [];
        }
        
        $suggestions = [];
        
        foreach ($similar_projects as $project) {
            if ($project['avg_similarity'] > 0.3) { // Threshold for similarity
                $suggestions[] = [
                    'title' => $project['title'],
                    'abstract' => $project['abstract'],
                    'similarity_score' => round($project['avg_similarity'] * 100, 2) . '%'
                ];
            }
        }
        
        return $suggestions;
    }

    /**
     * Parse the JavaScript output to extract similarity information
     */
    private function parseJSOutput($output, $topN) {
        // Look for our custom marker in the output
        $resultMarker = 'SIMILARITY_RESULTS:';
        $errorMarker = 'ERROR:';
        
        if (strpos($output, $resultMarker) !== false) {
            $resultStart = strpos($output, $resultMarker) + strlen($resultMarker);
            $resultJson = trim(substr($output, $resultStart));
            
            // Extract just the JSON part
            $jsonStart = strpos($resultJson, '{');
            if ($jsonStart !== false) {
                $jsonEnd = strrpos($resultJson, '}');
                if ($jsonEnd !== false) {
                    $jsonStr = substr($resultJson, $jsonStart, $jsonEnd - $jsonStart + 1);
                    $parsed = json_decode($jsonStr, true);
                    
                    if ($parsed !== null && json_last_error() === JSON_ERROR_NONE) {
                        return $parsed;
                    }
                }
            }
        } elseif (strpos($output, $errorMarker) !== false) {
            $errorStart = strpos($output, $errorMarker) + strlen($errorMarker);
            $errorJson = trim(substr($output, $errorStart));
            $parsed = json_decode($errorJson, true);
            
            if ($parsed !== null && json_last_error() === JSON_ERROR_NONE) {
                return ['error' => $parsed['error']];
            }
        }
        
        // If we couldn't parse the output, return an error
        return [
            'error' => 'Failed to parse JavaScript output',
            'output' => $output,
            'fallback_used' => true
        ];
    }
}

// Handle the request if running as a web endpoint directly (only when the script is accessed directly, not included)
if (basename($_SERVER['SCRIPT_FILENAME']) === basename(__FILE__) && php_sapi_name() !== 'cli' && isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    include(__DIR__ . '/../includes/connection.php');
    
    $input = json_decode(file_get_contents('php://input'), true);
    $topic_title = isset($input['topic_title']) ? trim($input['topic_title']) : '';
    $project_abstract = isset($input['project_abstract']) ? trim($input['project_abstract']) : '';
    
    if (empty($topic_title) || empty($project_abstract)) {
        echo json_encode(['error' => 'Both topic title and abstract are required']);
        exit();
    }
    
    $checker = new JSSimilarityChecker();
    $results = $checker->getSimilaritySuggestions($topic_title, $project_abstract, 3);
    
    echo json_encode([
        'success' => true,
        'suggestions' => $results
    ]);
}
?>