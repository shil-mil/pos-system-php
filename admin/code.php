<?php

include('../config/function.php');

if(isset($_POST['saveAdmin'])){
    $firstname = validate($_POST['firstname']);
    $lastname = validate($_POST['lastname']);
    $username = validate($_POST['username']);
    $password = validate($_POST['password']);
    $position = validate($_POST['position']);
    $is_banned = isset($_POST['is_banned']) == true ? 1 : 0;

    if($firstname != '' && $lastname != '' && $username != '' && $position != '' && $password != ''){

        $usernameCheck = mysqli_query($conn, "SELECT * FROM  admins WHERE username='$username'");
        if($usernameCheck){
            if(mysqli_num_rows($username) > 0){
                redirect('admins-create.php', 'Username already in use.');
            }
        }

        $bcrypt_password = password_hash($password, PASSWORD_BCRYPT);

        $data = [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'username' => $username,
            'password' => $password,
            'position' => $position,
            'is_banned' => $is_banned
        ];
        
        $result = insert('admins', $data);
        if($result){
            redirect('admins.php', 'Admin created successfully!');
        } else {
            redirect('admins-create.php', 'Something went wrong.');
        }

    } else {
        redirect('admins-create.php','Please fill required fields.');
    }
}

?>