<?php
include("includes/header.php");
?>

<div id="content">
    <div class="post">
        <h2 class="title"><a href="#">
            <?php 
                if (isset($_GET['topic'])) {
                    echo htmlspecialchars($_GET['topic']);
                } else {
                    echo "Project Details";
                }
            ?>
        </a></h2>
        <p class="meta"></p>
        <div class="entry">

            <?php
            include("includes/connection.php");

            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if ($id > 0) {
                // Use prepared statement to prevent SQL injection
                $blq = "SELECT * FROM topics WHERE id = ?";
                $stmt = $link->prepare($blq);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $blres = $stmt->get_result();

                while ($blrow = $blres->fetch_assoc()) {
                    echo '
                            <a href="book_detail.php?id=' . $blrow['id'] . '" style="text-decoration:none; color:#000;">
                                <h1>Status: '. htmlspecialchars($blrow['status']). '</h1><br>
                                <h2>' . htmlspecialchars($blrow['topic_title']) . '</h2>
                                <h4>Abstract</h4>
                                <p>' . htmlspecialchars($blrow['project_abstract']) . '</p>
                            </a>
                        ';
                }
            }
            ?>

            <div style="clear:both;"></div>

        </div>
    </div>
</div><!-- end #content -->

<?php
include("includes/footer.php");
?>
