<?php
include("includes/header.php");
include("../includes/connection.php");
?>

<style>
.enhanced-panel {
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    border: none;
    margin-bottom: 20px;
}

.enhanced-panel .panel-heading {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 10px 10px 0 0;
    padding: 15px 20px;
    font-weight: 600;
    font-size: 1.2em;
}

.action-button {
    display: inline-block;
    padding: 5px 10px;
    background-color: #e74c3c;
    color: white;
    border-radius: 4px;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.action-button:hover {
    background-color: #c0392b;
    color: white;
    text-decoration: none;
}

.book-image {
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.book-image:hover {
    transform: scale(1.05);
}

.dataTables_wrapper {
    padding: 15px;
}
</style>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <i class="fa fa-book fa-fw"></i> Book Management
                <div class="pull-right">
                    <a href="book_add.php" class="btn btn-primary">
                        <i class="fa fa-plus-circle fa-fw"></i> Add New Book
                    </a>
                </div>
            </h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    
    <div class="row">
        <div class="col-lg-12">
            <div class="enhanced-panel">
                <div class="panel-heading">
                    <i class="fa fa-list fa-fw"></i> Book List
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Book Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Image</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $book_q = "SELECT * FROM book INNER JOIN category ON b_cat = cat_id";
                                $book_res = $link->query($book_q);

                                $count = 1;

                                while ($book_row = $book_res->fetch_assoc()) {
                                    echo '<tr class="odd gradeX">
                                              <td>' . $count . '</td>
                                              <td>' . $book_row['b_nm'] . '</td>
                                              <td><span class="label label-primary">' . $book_row['cat_nm'] . '</span></td>
                                              <td>
 . $book_row['b_price'] . '</td>
                                              <td width="120"><center><img src="../' . $book_row['b_img'] . '" class="book-image" width="80" height="100"></center></td>
                                              <td>' . date("d-M-y", $book_row['b_time']) . '</td>
                                              <td align="center">
                                                <a href="process_book_del.php?id=' . $book_row['b_id'] . '" class="action-button" onclick="return confirm(\'Are you sure you want to delete this book?\')">
                                                    <i class="fa fa-trash fa-fw"></i> Delete
                                                </a>
                                              </td>
                                          </tr>';
                                    $count++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<?php
include("includes/footer.php");
?>
