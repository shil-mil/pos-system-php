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
                            <th>Image</th>
                            <th>Menu Product Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($products as $productItem) : ?>
                        <tr>
                            <td><?= $productItem['id'] ?></td>
                            <td><img src="../<?=$productItem['image']; ?>" style="width:70px;height:70px;" alt="product image" /></td>
                            <td><?= $productItem['productname'] ?></td>
                            <?php
                            $categoryId = $productItem['category_id'];

                            // Fetch the category name from the database using the category_id
                            $categoryQuery = "SELECT name FROM categories WHERE id = '$categoryId'";
                            $categoryResult = mysqli_query($conn, $categoryQuery);

                            if ($categoryResult && mysqli_num_rows($categoryResult) > 0) {
                                $category = mysqli_fetch_assoc($categoryResult);
                                $categoryName = $category['name'];
                            } else {
                                $categoryName = "Unknown Category";
                            }
                            ?>

                            <td><?= $categoryName ?></td>
                            <td>Php <?= $productItem['price'] ?></td>
                            <td>
                                <a href="products-edit.php?id=<?= $productItem['id'];?>" class="btn btn-success btn-sm">Edit</a>
                                <a 
                                href="products-delete.php?id=<?= $productItem['id'];?>" 
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete product?')">
                                Delete</a>
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