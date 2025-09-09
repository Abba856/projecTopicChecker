<?php
// We include the header which starts the session, so we don't need to start it again

include("includes/connection.php");
include("includes/header.php");

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
    $status = isset($_POST['status']) ? $_POST['status'] : 'available';
    
    // Validate input
    if (!empty($topic_title) && !empty($project_abstract)) {
        // Use prepared statement to prevent SQL injection
        $stmt = $link->prepare("INSERT INTO topics (topic_title, comment, project_abstract, status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $topic_title, $topic_text, $project_abstract, $status);
        
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

.select-wrapper {
    position: relative;
}

.select-wrapper::after {
    content: "\f078";
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #7f8c8d;
    pointer-events: none;
}

.select-wrapper select {
    appearance: none;
    background-image: none;
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

/* Responsive adjustments */
@media (max-width: 768px) {
    .modern-content {
        width: 100%;
        float: none;
    }
    
    .modern-post {
        padding: 20px;
    }
    
    .modern-title {
        font-size: 28px;
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
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="topic_title">Topic Title <span class="required">*</span></label>
                <input type="text" id="topic_title" name="topic_title" class="form-control" placeholder="Enter the project topic title" required>
            </div>
            
            <div class="form-group">
                <label for="topic_text">Topic Description</label>
                <textarea id="topic_text" name="topic_text" class="form-control" placeholder="Provide a brief description of the topic (optional)"></textarea>
            </div>
            
            <div class="form-group">
                <label for="project_abstract">Project Abstract <span class="required">*</span></label>
                <textarea id="project_abstract" name="project_abstract" class="form-control" placeholder="Provide a detailed abstract of the project" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="status">Status</label>
                <div class="select-wrapper">
                    <select id="status" name="status" class="form-control">
                        <option value="available">Available</option>
                        <option value="taken">Taken</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
            </div>
            
            <button type="submit" class="btn-primary">
                <i class="fas fa-plus-circle"></i> Add Topic
            </button>
        </form>
    </div>
</div><!-- end .main-content -->

<?php
include("includes/footer.php");
?>