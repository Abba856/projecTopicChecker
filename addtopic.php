<?php
// We include the header which starts the session, so we don't need to start it again

include("includes/connection.php");
include("includes/header.php");

// Include the similarity checker
include("ml/similarity-checker.php");

// Check if user is logged in (after including header to ensure session is started)
if (!isset($_SESSION['client']['status'])) {
    header("location:login.php");
    exit();
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $topic_title = isset($_POST['topic_title']) ? trim($_POST['topic_title']) : '';
    $topic_text = isset($_POST['topic_text']) ? trim($_POST['topic_text']) : '';
    $project_abstract = isset($_POST['project_abstract']) ? trim($_POST['project_abstract']) : '';
    
    // Validate input
    if (!empty($topic_title) && !empty($project_abstract)) {
        // Check for similar projects using the similarity checker
        // Use the JSSimilarityChecker to get suggestions and store them in the comment
        include("ml/similarity-checker-endpoint.php");
        $jsChecker = new JSSimilarityChecker();
        $suggestions = $jsChecker->getSimilaritySuggestions($topic_title, $project_abstract, 3);
        
        // Format suggestions as comment text to store in the database
        $comment = '';
        if (!empty($suggestions)) {
            $comment = "Similar project suggestions:\n\n";
            foreach ($suggestions as $index => $suggestion) {
                $comment .= ($index + 1) . ". " . $suggestion['title'] . "\n";
                $comment .= "   Similarity: " . $suggestion['similarity_score'] . "\n";
                $comment .= "   Abstract: " . (strlen($suggestion['abstract']) > 150 ? substr($suggestion['abstract'], 0, 150) . "..." : $suggestion['abstract']) . "\n\n";
            }
        } else {
            $comment = "No similar projects found. Your topic appears to be unique.";
        }
        
        // Check if any similar projects were found for display purposes
        $has_similar = false;
        $similar_topics = [];
        $checker = new SimilarityChecker();
        $similar_projects = $checker->checkSimilarityPHPOnly($topic_title, $project_abstract, 3);
        if (!isset($similar_projects['error']) && is_array($similar_projects)) {
            foreach ($similar_projects as $project) {
                if ($project['avg_similarity'] > 0.3) { // Threshold for similarity
                    $has_similar = true;
                    $similar_topics[] = $project;
                }
            }
        }
        
        // If similar topics found, show them but still allow submission
        if ($has_similar) {
            $warning_message = "Similar projects were found. Consider reviewing these suggestions before submitting:";
            $similar_projects_found = $similar_topics;
        }
        
        // Use prepared statement to prevent SQL injection
        // Set default status to 'available' for new topics
        $status = 'available';
        $user_id = $_SESSION['client']['id']; // Get user ID from session
        $stmt = $link->prepare("INSERT INTO topics (topic_title, comment, project_abstract, status, user_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $topic_title, $comment, $project_abstract, $status, $user_id);
        
        if ($stmt->execute()) {
            $success_message = "Topic added successfully!";
        } else {
            $error_message = "Error adding topic. Please try again.";
        }
    } else {
        $error_message = "Please fill in all required fields.";
    }
}
?>

<style>
/* Enhanced Modern Add Topic Styles */
.modern-content {
    float: right;
    width: 670px;
}

.modern-post {
    margin-bottom: 30px;
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    padding: 30px;
    position: relative;
    overflow: hidden;
}

.modern-post::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 5px;
    background: linear-gradient(90deg, #667eea, #764ba2);
}

.modern-title {
    color: #2c3e50;
    font-size: 32px;
    margin-bottom: 15px;
    font-weight: 700;
    position: relative;
    padding-bottom: 15px;
}

.modern-title::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 60px;
    height: 4px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 2px;
}

.modern-subtitle {
    color: #7f8c8d;
    font-size: 18px;
    margin-top: 0;
    margin-bottom: 30px;
    font-weight: 400;
}

.form-group {
    margin-bottom: 25px;
}

.form-group label {
    display: block;
    margin-bottom: 10px;
    color: #2c3e50;
    font-weight: 600;
    font-size: 16px;
}

.form-control {
    width: 100%;
    padding: 14px 16px;
    border: 2px solid #e1e8ed;
    border-radius: 10px;
    font-size: 16px;
    transition: all 0.3s ease;
    box-sizing: border-box;
    background: #ffffff;
    color: #2c3e50;
    font-weight: 400;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.03);
}

.form-control:focus {
    outline: none;
    border-color: #667eea;
    background: #fff;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.15);
}

textarea.form-control {
    min-height: 150px;
    resize: vertical;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 14px 30px;
    border-radius: 10px;
    cursor: pointer;
    font-size: 16px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    letter-spacing: 0.5px;
    display: inline-flex;
    align-items: center;
    gap: 10px;
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.6);
}

.btn-primary:active {
    transform: translateY(-1px);
}

.alert {
    padding: 15px 20px;
    border-radius: 10px;
    margin-bottom: 25px;
    font-weight: 500;
}

.alert-success {
    background: linear-gradient(135deg, #00b09b, #96c93d);
    color: white;
    border-left: 4px solid #27ae60;
}

.alert-danger {
    background: linear-gradient(135deg, #ff9a9e, #fecfef);
    color: #c0392b;
    border-left: 4px solid #e74c3c;
}

.required {
    color: #e74c3c;
}

.similarity-suggestions {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 10px;
    padding: 15px;
    margin-top: 15px;
    max-height: 300px;
    overflow-y: auto;
}

.similarity-suggestion {
    padding: 10px;
    margin-bottom: 10px;
    background: white;
    border-radius: 8px;
    border-left: 3px solid #667eea;
}

.similarity-suggestion h4 {
    margin: 0 0 5px 0;
    color: #2c3e50;
    font-size: 16px;
}

.similarity-suggestion p {
    margin: 5px 0;
    font-size: 14px;
    color: #7f8c8d;
}

.similarity-score {
    font-weight: bold;
    color: #667eea;
}

.loading {
    color: #667eea;
    font-style: italic;
}

/* Responsive adjustments */
@media (max-width: 992px) {
    .modern-content {
        width: 100%;
        float: none;
    }
    
    .modern-post {
        padding: 25px;
    }
    
    .modern-title {
        font-size: 28px;
    }
}

@media (max-width: 768px) {
    .modern-post {
        padding: 20px;
    }
    
    .modern-title {
        font-size: 26px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-control {
        padding: 12px;
        font-size: 15px;
    }
    
    textarea.form-control {
        min-height: 120px;
    }
    
    .btn-primary {
        padding: 12px 20px;
        font-size: 15px;
    }
    
    .alert {
        padding: 12px 16px;
        font-size: 14px;
    }
}

@media (max-width: 480px) {
    .modern-post {
        padding: 15px;
    }
    
    .modern-title {
        font-size: 24px;
    }
    
    .form-control {
        padding: 10px;
        font-size: 14px;
    }
    
    textarea.form-control {
        min-height: 100px;
    }
    
    .btn-primary {
        padding: 10px 15px;
        font-size: 14px;
        width: 100%;
        justify-content: center;
    }
    
    .alert {
        padding: 10px 14px;
        font-size: 13px;
    }
    
    .similarity-suggestions {
        padding: 12px;
    }
    
    .similarity-suggestion {
        padding: 8px;
    }
}
</style>

<div class="main-content">
    <div class="modern-post">
        <h1 class="modern-title">Add New Project Topic</h1>
        <p class="modern-subtitle">Submit a new project topic for students to work on</p>
        
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($warning_message) && !empty($similar_projects_found)): ?>
            <div class="alert alert-warning" style="background: linear-gradient(135deg, #f093fb, #f5576c); color: white; border-left: 4px solid #e67e22;">
                <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($warning_message); ?>
                <div style="margin-top: 10px;">
                    <strong>Suggested similar projects:</strong>
                    <ul style="margin-top: 10px; padding-left: 20px;">
                        <?php foreach ($similar_projects_found as $project): ?>
                            <li style="margin-bottom: 8px;">
                                <strong><?php echo htmlspecialchars($project['title']); ?></strong> 
                                <div style="font-size: 0.9em; margin-top: 3px;"><?php echo htmlspecialchars(substr($project['abstract'], 0, 150)) . (strlen($project['abstract']) > 150 ? '...' : ''); ?></div>
                                <div style="font-size: 0.8em; color: #ecf0f1; margin-top: 3px;">Similarity: <?php echo round($project['avg_similarity'] * 100, 2); ?>%</div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="topic_title">Topic Title <span class="required">*</span></label>
                <input type="text" id="topic_title" name="topic_title" class="form-control" placeholder="Enter the project topic title" required>
            </div>
            
            <div class="form-group">
                <label for="project_abstract">Project Abstract <span class="required">*</span></label>
                <textarea id="project_abstract" name="project_abstract" class="form-control" placeholder="Provide a detailed abstract of the project" required></textarea>
            </div>
            
            <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-plus-circle"></i> Add Topic
                </button>
                <a href="user_topics.php" class="btn-primary" style="background: #f1f5f9; color: #2c3e50; border: 1px solid #e2e8f0; text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                    <i class="fas fa-book"></i> View My Topics
                </a>
            </div>
            
            <!-- Real-time similarity suggestions container -->
            <div id="similarity-suggestions-container" style="display: none;">
                <h3 style="color: #2c3e50; margin-top: 25px;">Similar Projects Found:</h3>
                <div id="similarity-suggestions" class="similarity-suggestions">
                    <div class="loading">Checking for similar projects...</div>
                </div>
            </div>
        </form>
    </div>
</div><!-- end .main-content -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const topicTitleInput = document.getElementById('topic_title');
    const projectAbstractInput = document.getElementById('project_abstract');
    const suggestionsContainer = document.getElementById('similarity-suggestions-container');
    const suggestionsDiv = document.getElementById('similarity-suggestions');
    
    // Debounce function to limit API calls
    let debounceTimer;
    
    function checkSimilarity() {
        const topicTitle = topicTitleInput.value.trim();
        const projectAbstract = projectAbstractInput.value.trim();
        
        // Only check if both fields have sufficient content
        if (topicTitle.length < 5 || projectAbstract.length < 20) {
            suggestionsContainer.style.display = 'none';
            return;
        }
        
        // Show loading indicator
        suggestionsContainer.style.display = 'block';
        suggestionsDiv.innerHTML = '<div class="loading">Checking for similar projects...</div>';
        
        // Send data to server
        fetch('check_similarity.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                topic_title: topicTitle,
                project_abstract: projectAbstract
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.similar_projects && data.similar_projects.length > 0) {
                displaySuggestions(data.similar_projects);
            } else {
                suggestionsDiv.innerHTML = '<p>No similar projects found. Your topic appears to be unique!</p>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            suggestionsDiv.innerHTML = '<p style="color: #e74c3c;">Error checking for similar projects. Please try again.</p>';
        });
    }
    
    function displaySuggestions(projects) {
        if (projects.length === 0) {
            suggestionsDiv.innerHTML = '<p>No similar projects found. Your topic appears to be unique!</p>';
            return;
        }
        
        let html = '';
        projects.forEach(project => {
            html += `
                <div class="similarity-suggestion">
                    <h4>${project.title || 'Untitled Project'}</h4>
                    <p>${project.abstract.substring(0, 200) + (project.abstract.length > 200 ? '...' : '')}</p>
                    <p>Avg Similarity: <span class="similarity-score">${project.avg_similarity}%</span></p>
                </div>
            `;
        });
        
        suggestionsDiv.innerHTML = html;
    }
    
    // Add event listeners with debounce
    topicTitleInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(checkSimilarity, 1000); // 1 second delay
    });
    
    projectAbstractInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(checkSimilarity, 1000); // 1 second delay
    });
});
</script>

<?php
include("includes/footer.php");
?>