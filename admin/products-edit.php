<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Menu Product
                <a href="products.php" class = "btn btn-danger float-end">Back</a> 
            </h4>
        </div>
        <div class="card-body">
        <?php alertMessage();?>
            <form action="code.php" method="POST">

            <?php 
                if(isset($_GET['id'])) {
                    if($_GET['id'] != '') {
                        $productId = $_GET['id'];
                    } else {
                        echo '<h5>No ID found.</h5>';
                        return false;
                    }
                } else {
                    echo '<h5>No ID given in parameters.</h5>';
                    return false;
                }

                $productData = getById('products', $productId);
                if($productData){
                    if($productData['status'] = 200) {
                        ?>
                        <input type="hidden" name="productId" value="<?= $productData['data']['id']; ?>" >

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="">Menu Product Name *</label>
                                <input type="text" name="productname" required value="<?= $productData['data']['productname']; ?>" class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Price *</label>
                                <input type="number" name="price" required value="<?= $productData['data']['price']; ?>" class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Category *</label>
                                <input type="category" name="category" required value="<?= $productData['data']['category']; ?>" class="form-control" />
                            </div>
                            <div class="col-md-12 mb-3 text-end">
                                <button type="submit" name="updateProduct" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                        <?php
                    } else {
                        echo '<h5'.$productData>['message'].'</h5>';
                    }
                } else {
                    echo 'Something went wrong.';
                    return false;

                }
            ?>

                
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>