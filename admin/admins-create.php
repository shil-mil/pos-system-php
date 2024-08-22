<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Add Admin
                <a href="admins.php" class = "btn btn-primary float-end">Back</a> 
            </h4>
        </div>
        <div class="card-body">
            
            <form action="admins-code.php" method="POST">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="">First Name *</label>
                        <input type="text" name="firstname" required class="form-control" />
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Last Name *</label>
                        <input type="text" name="lastname" required class="form-control" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Username *</label>
                        <input type="text" name="username" required class="form-control" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Password *</label>
                        <input type="password" name="password" required class="form-control" />
                    </div>
                    <!-- <div class="col-md-6 mb-3">
                        <label for="">Phone Number *</label>
                        <input type="number" name="phone" required class="form-control" />
                    </div>    -->
                    <div class="col-md-6 mb-3">
                        <label for="">Position *</label>
                        <input type="text" name="position" required class="form-control" />
                    </div>   
                    <div class="col-md-3 mb-3">
                        <label for="">Is Banned</label>
                        <input type="checkbox" name="is_banned" style="width:30px;height:30px;" />
                    </div>
                    <div class="col-md-12 mb-3 text-end">
                        <button type="submit" name="saveAdmin" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>