<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Add Menu Product
                <a href="products.php" class = "btn btn-primary float-end">Back</a> 
            </h4>
        </div>
        <div class="card-body">
        <form action="code.php" method="POST">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="">Menu Product Name *</label>
                        <input type="text" name="productname" required class="form-control" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Price *</label>
                        <input type="number" name="price" required class="form-control" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Category *</label>
                        <input type="category" name="category" required class="form-control" />
                    </div>
                    <!-- <div class="col-md-6 mb-3">
                        <label for="">Phone Number *</label>
                        <input type="number" name="phone" required class="form-control" />
                    </div> FOR PIC???-->
                    <div class="col-md-12 mb-3 text-end">
                        <button type="submit" name="saveProduct" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>