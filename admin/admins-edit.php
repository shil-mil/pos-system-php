<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Admin
                <a href="admins.php" class = "btn btn-danger float-end">Back</a> 
            </h4>
        </div>
        <div class="card-body">
        <?php alertMessage();?>
            <form action="code.php" method="POST">

            <?php 
                if(isset($_GET['id'])) {
                    if($_GET['id'] != '') {
                        $adminId = $_GET['id'];
                    } else {
                        echo '<h5>No ID found.</h5>';
                        return false;
                    }
                } else {
                    echo '<h5>No ID given in parameters.</h5>';
                    return false;
                }

                $adminData = getById('admins', $adminId);
                if($adminData){
                    if($adminData['status'] = 200) {
                        ?>
                        <input type="hidden" name="adminId" value="<?= $adminData['data']['id']; ?>" >

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="">First Name *</label>
                                <input type="text" name="firstname" required value="<?= $adminData['data']['firstname']; ?>" class="form-control" />
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Last Name *</label>
                                <input type="text" name="lastname" required value="<?= $adminData['data']['lastname']; ?>" class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Username *</label>
                                <input type="text" name="username" required value="<?= $adminData['data']['username']; ?>" class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Password *</label>
                                <input type="password" name="password" class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Position *</label>
                                <input type="text" name="position" required value="<?= $adminData['data']['position']; ?>" class="form-control" />
                            </div>   
                            <div class="col-md-3 mb-3">
                                <label for="">Is Banned</label>
                                <br/>
                                <input type="checkbox" name="is_banned" <?= $adminData['data']['is_banned'] == true ? 'checked':''; ?> style="width:30px;height:30px;" />
                            </div>
                            <div class="col-md-12 mb-3 text-end">
                                <button type="submit" name="updateAdmin" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                        <?php
                    } else {
                        echo '<h5'.$adminData>['message'].'</h5>';
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