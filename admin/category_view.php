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
    margin: 0 2px;
}

.action-button.edit {
    background-color: #3498db;
}

.action-button.edit:hover {
    background-color: #2980b9;
}

.action-button:hover {
    background-color: #c0392b;
    color: white;
    text-decoration: none;
}

.dataTables_wrapper {
    padding: 15px;
}
</style>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <i class="fa fa-tags fa-fw"></i> Category Management
                <div class="pull-right">
                    <a href="category_add.php" class="btn btn-primary">
                        <i class="fa fa-plus-circle fa-fw"></i> Add New Category
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
                    <i class="fa fa-list fa-fw"></i> Category List
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Category Name</th>
                                    <th width="200">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $cat_q = "SELECT * FROM category";
                                $cat_res = $link->query($cat_q);

                                $count = 1;

                                while ($cat_row = $cat_res->fetch_assoc()) {
                                    echo '<tr class="odd gradeX">
                                              <td>' . $count . '</td>
                                              <td><span class="label label-success">' . $cat_row['cat_nm'] . '</span></td>
                                              <td align="center">
                                                  <a href="category_edit.php?id=' . $cat_row['cat_id'] . '" class="action-button edit">
                                                      <i class="fa fa-edit fa-fw"></i> Edit
                                                  </a>
                                                  <a href="process_category_del.php?id=' . $cat_row['cat_id'] . '" class="action-button" onclick="return confirm(\'Are you sure you want to delete this category?\')">
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
