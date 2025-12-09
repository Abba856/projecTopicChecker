<?php
/**
 * AJAX endpoint for real-time similarity checking
 */

header('Content-Type: application/json');

// Start session to verify user is logged in
session_start();

// For testing purposes, we'll allow requests without authentication
// In production, uncomment the following lines to require authentication:
/*
if (!isset($_SESSION['client']['status'])) {
    echo json_encode(['error' => 'Not authenticated']);
    exit();
}
*/

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Invalid request method']);
    exit();
}

// Get the input data
$input = json_decode(file_get_contents('php://input'), true);
$topic_title = isset($input['topic_title']) ? trim($input['topic_title']) : '';
$project_abstract = isset($input['project_abstract']) ? trim($input['project_abstract']) : '';

if (empty($topic_title) || empty($project_abstract)) {
    echo json_encode(['error' => 'Both topic title and abstract are required']);
    exit();
}

// Include the JavaScript similarity checker
include_once(__DIR__ . '/ml/similarity-checker-endpoint.php');

$jsChecker = new JSSimilarityChecker();
$similar_projects = $jsChecker->getSimilaritySuggestions($topic_title, $project_abstract, 3);

// Format the response
$response = [
    'success' => true,
    'similar_projects' => []
];

if (!empty($similar_projects) && is_array($similar_projects)) {
    foreach ($similar_projects as $project) {
        // Parse similarity score to get numeric value
        $similarity_score = 0;
        if (isset($project['similarity_score'])) {
            $similarity_score = floatval(str_replace('%', '', $project['similarity_score'])) / 100;
        }
        
        // Only include projects with similarity > 0.1 (10%)
        if ($similarity_score > 0.1) {
            $response['similar_projects'][] = [
                'title' => $project['title'],
                'abstract' => $project['abstract'],
                'avg_similarity' => floatval(str_replace('%', '', $project['similarity_score']))
            ];
        }
    }
}

echo json_encode($response);
?>