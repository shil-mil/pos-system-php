<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Suppliers
                <a href="suppliers-create.php" class = "btn btn-primary float-end">Add Supplier</a> 
            </h4>
        </div>
        <div class="card-body">
        <?php  alertMessage(); ?>
        <?php 
            $suppliers = getAll('suppliers'); 
            if(!$suppliers) {
                 echo '<h4>Something went wrong.</h4>';
                 return false;
            }
            if(mysqli_num_rows($suppliers)>0) {
        ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php foreach($suppliers as $supplierItem) : ?>
                        <tr>
                            <td><?= $supplierItem['id'] ?></td>
                            <td><?= $supplierItem['firstname'] ?></td>
                            <td><?= $supplierItem['lastname'] ?></td>
                            <td><?= $supplierItem['phonenumber'] ?></td>
                            <td><?= $supplierItem['address'] ?></td>
                            <td>
                                <a href="suppliers-edit.php?id=<?= $supplierItem['id'];?>" class="btn btn-success btn-sm">Edit</a>
                                <a href="suppliers-delete.php" class="btn btn-danger btn-sm">Delete</a>
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