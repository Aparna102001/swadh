<?php include('./constant/layout/head.php'); ?>
<?php include('./constant/layout/header.php'); ?>
<?php include('./constant/layout/sidebar.php'); ?>
<?php include('connect.php');

$sql = "SELECT categories_id, categories_name, categories_active, categories_status FROM categories WHERE categories_status = 1";
$result = $connect->query($sql);
//echo $sql;exit;

?>

<div class="page-wrapper">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary"> View Categories</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">View Categories</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">

        <div class="card">
            <div class="card-body">

                <a href="add-category.php"><button class="btn btn-primary">Add Categories</button></a>

                <div class="table-responsive m-t-40">
                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Categories Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result as $row) { ?>
                                <tr>
                                    <td><?php echo $row['categories_id'] ?></td>
                                    <td><?php echo $row['categories_name'] ?></td>
                                    <td>
                                        <?php
                                        if ($row['categories_active'] == 1) {
                                            echo "Available";
                                        } else {
                                            echo "Not Available";
                                        } ?>
                                    </td>
                                    <td>
                                        <a href="editcategory.php?id=<?php echo $row['categories_id'] ?>"><button type="button" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></button></a>
                                        <button type="button" class="btn btn-xs btn-danger deleteCategoryBtn" data-id="<?php echo $row['categories_id'] ?>"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

        <?php include('./constant/layout/footer.php'); ?>
    </div>
</div>

<form id="deleteCategoryForm" action="php_action/removeCategories.php" method="POST">
    <input type="hidden" id="categoryIdInput" name="categories_id" value="">
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.deleteCategoryBtn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const categoryId = this.getAttribute('data-id');
                document.getElementById('categoryIdInput').value = categoryId;
                if (confirm('Are you sure to delete this record?')) {
                    document.getElementById('deleteCategoryForm').submit();
                }
            });
        });
    });
</script>
