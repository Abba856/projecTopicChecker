<?php
/**
 * PHP wrapper for the JavaScript similarity checker
 */

class SimilarityChecker {
    private $csvPath;
    private $jsPath;

    public function __construct() {
        $this->csvPath = __DIR__ . '/../database/paper_details_final_data.csv';
        $this->jsPath = __DIR__ . '/similarity-checker.js';
    }

    /**
     * Check similarity of a new project topic against existing projects
     * 
     * @param string $newTitle The new project title
     * @param string $newAbstract The new project abstract
     * @param int $topN Number of similar projects to return
     * @return array Similarity results
     */
    public function checkSimilarity($newTitle, $newAbstract, $topN = 3) {
        // Create a temporary file with the new project data
        $tempData = [
            'title' => $newTitle,
            'abstract' => $newAbstract
        ];
        
        // Create a temporary CSV file for the new project
        $tempFile = tempnam(sys_get_temp_dir(), 'new_project_');
        $tempFile .= '.csv';
        
        $fp = fopen($tempFile, 'w');
        fputcsv($fp, ['title', 'abstract']);
        fputcsv($fp, [$newTitle, $newAbstract]);
        fclose($fp);

        // Create a temporary JS file to call the similarity checker with the new data
        $tempJs = tempnam(sys_get_temp_dir(), 'sim_check_');
        $tempJs .= '.js';
        
        $jsCode = "
const ProjectSimilarityChecker = require('./similarity-checker.js');

async function checkNewProject() {
    try {
        const checker = new ProjectSimilarityChecker();
        await checker.loadCSV('./paper_details_final_data.csv');
        checker.preprocessData();
        checker.prepareData();
        
        const results = await checker.checkSimilarity('$newTitle', '$newAbstract', $topN);
        return results;
    } catch (error) {
        console.error('Error:', error);
        return { error: error.message };
    }
}

checkNewProject();
";

        file_put_contents($tempJs, $jsCode);

        // Execute the node command
        $cmd = "cd " . dirname($this->jsPath) . " && node " . escapeshellarg($tempJs);
        $output = shell_exec($cmd . " 2>&1");

        // Clean up temporary files
        unlink($tempFile);
        unlink($tempJs);

        // Parse the output to extract similarity information
        return $this->parseOutput($output, $topN);
    }

    /**
     * Alternative method: Use a simpler PHP-based similarity checker
     */
    public function checkSimilarityPHPOnly($newTitle, $newAbstract, $topN = 3) {
        // Load the CSV data
        if (!file_exists($this->csvPath)) {
            return ['error' => 'CSV file not found: ' . $this->csvPath];
        }

        $data = [];
        if (($handle = fopen($this->csvPath, "r")) !== FALSE) {
            // Read header
            $header = fgetcsv($handle);
            
            // Read data rows
            while (($row = fgetcsv($handle)) !== FALSE) {
                $dataRow = [];
                foreach ($header as $i => $colName) {
                    $dataRow[$colName] = $row[$i] ?? '';
                }
                $data[] = $dataRow;
            }
            fclose($handle);
        }

        // Calculate similarities with existing projects
        $similarities = [];
        foreach ($data as $index => $row) {
            $titleSimilarity = $this->calculateTextSimilarity($newTitle, $row['final_keywords'] ?? '');
            $abstractSimilarity = $this->calculateTextSimilarity($newAbstract, $row['abstracts'] ?? '');
            
            // Average similarity score
            $avgSimilarity = ($titleSimilarity + $abstractSimilarity) / 2;
            
            $similarities[] = [
                'index' => $index,
                'title' => $row['final_keywords'] ?? '',
                'abstract' => $row['abstracts'] ?? '',
                'title_similarity' => $titleSimilarity,
                'abstract_similarity' => $abstractSimilarity,
                'avg_similarity' => $avgSimilarity
            ];
        }

        // Sort by average similarity (descending)
        usort($similarities, function($a, $b) {
            return $b['avg_similarity'] <=> $a['avg_similarity'];
        });

        // Return top N results
        return array_slice($similarities, 0, $topN);
    }

    /**
     * Calculate text similarity using a simple approach
     */
    private function calculateTextSimilarity($text1, $text2) {
        if (empty($text1) || empty($text2)) {
            return 0;
        }
        
        // Clean and tokenize texts
        $tokens1 = $this->tokenizeText($this->cleanText($text1));
        $tokens2 = $this->tokenizeText($this->cleanText($text2));
        
        if (empty($tokens1) || empty($tokens2)) {
            return 0;
        }

        // Calculate Jaccard similarity
        $intersection = array_intersect($tokens1, $tokens2);
        $union = array_unique(array_merge($tokens1, $tokens2));
        
        if (empty($union)) {
            return 0;
        }
        
        return count($intersection) / count($union);
    }

    /**
     * Clean text by removing special characters and converting to lowercase
     */
    private function cleanText($text) {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9\s]/', ' ', $text);
        return trim($text);
    }

    /**
     * Tokenize text into words
     */
    private function tokenizeText($text) {
        $stopWords = [
            'i', 'me', 'my', 'myself', 'we', 'our', 'ours', 'ourselves', 'you', 'your', 
            'yours', 'yourself', 'yourselves', 'he', 'him', 'his', 'himself', 'she', 
            'her', 'hers', 'herself', 'it', 'its', 'itself', 'they', 'them', 'their', 
            'theirs', 'themselves', 'what', 'which', 'who', 'whom', 'this', 'that', 
            'these', 'those', 'am', 'is', 'are', 'was', 'were', 'be', 'been', 'being', 
            'have', 'has', 'had', 'having', 'do', 'does', 'did', 'doing', 'a', 'an', 
            'the', 'and', 'but', 'if', 'or', 'because', 'as', 'until', 'while', 'of', 
            'at', 'by', 'for', 'with', 'through', 'during', 'before', 'after', 'above', 
            'below', 'up', 'down', 'in', 'out', 'on', 'off', 'over', 'under', 'again', 
            'further', 'then', 'once'
        ];
        
        $tokens = array_filter(
            explode(' ', $this->cleanText($text)),
            function($token) use ($stopWords) {
                return !empty($token) && strlen($token) > 2 && !in_array($token, $stopWords);
            }
        );
        
        return array_values($tokens);
    }

    /**
     * Parse the JavaScript output (placeholder - needs to be implemented based on actual output)
     */
    private function parseOutput($output, $topN) {
        // For now, we'll use the PHP-only method which is more reliable
        return ['error' => 'Node.js execution failed', 'output' => $output];
    }
}