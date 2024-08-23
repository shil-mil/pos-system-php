<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Menu Products
                <a href="products-create.php" class = "btn btn-primary float-end">Add Menu Product</a> 
            </h4>
        </div>
        <div class="card-body">
        <?php  alertMessage(); ?>
        <?php 
            $products = getAll('products'); 
            if(!$products) {
                 echo '<h4>Something went wrong.</h4>';
                 return false;
            }
            if(mysqli_num_rows($products)>0) {
        ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Menu Product Name</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($products as $productItem) : ?>
                        <tr>
                            <td><?= $productItem['id'] ?></td>
                            <td><?= $productItem['productname'] ?></td>
                            <td><?= $productItem['price'] ?></td>
                            <td><?= $productItem['category'] ?></td>
                            <td>
                                <a href="products-edit.php?id=<?= $productItem['id'];?>" class="btn btn-success btn-sm">Edit</a>
                                <a href="products-delete.php?id=<?= $productItem['id'];?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php 
                } else {
                    ?>
                        <h4 class="mb-0">No record found.</h4>
                    <?php
                } 
                ?>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>