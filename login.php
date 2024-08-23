<?php include('includes/header.php'); ?>
    <div class="py-5 bg-light">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow rounded-4">
                        <?php alertMessage(); ?>
                        <div class="p-5">
                            <h4 class="text-dark mb-3">Sign into Kapitan Sisig System</h4>
                            <form action="login-code.php" method="POST">
                                <div class="mb-3">
                                    <label >Enter username</label>
                                    <input type="text" name="username" class="form-control" required />
                                </div>
                                <div class="mb-3">
                                <label for="">Enter password</label>
                                    <input type="password" name="password" class="form-control" required />
                                </div>
                                <div class="my-3">
                                    <button type="submit" name="loginBtn" class="btn btn-primary w-100 mt-2">Sign In</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include('includes/footer.php'); ?>
