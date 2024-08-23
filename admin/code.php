<?php

include('../config/function.php');

if(isset($_POST['saveAdmin'])){
    $firstname = validate($_POST['firstname']);
    $lastname = validate($_POST['lastname']);
    $username = validate($_POST['username']);
    $password = validate($_POST['password']);
    $position = validate($_POST['position']);
    $is_banned = isset($_POST['is_banned']) == true ? 1 : 0;

    if($firstname != '' && $lastname != '' && $username != '' && $password != '' && $position != ''){

        $usernameCheck = mysqli_query($conn, "SELECT * FROM  admins WHERE username='$username'");
        if ($usernameCheck && mysqli_num_rows($usernameCheck) > 0) {
            redirect('admins-create.php', 'Username already used by another user.');
        }

        $bcrypt_password = password_hash($password, PASSWORD_BCRYPT);

        $data = [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'username' => $username,
            'password' => $bcrypt_password,
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

if(isset($_POST['saveProduct'])){
    $productname = validate($_POST['productname']);
    $price = validate($_POST['price']);
    $category = validate($_POST['category']);

    if($productname != '' && $price != '' && $category!= ''){

        $productNameCheck = mysqli_query($conn, "SELECT * FROM  products WHERE productName='$productName'");
        if ($productNameCheck && mysqli_num_rows($productNameCheck) > 0) {
            redirect('products-create.php', 'Menu product already made.');
        }

        $data = [
            'productname' => $productname,
            'price' => $price,
            'category' => $category
        ];
        
        $result = insert('products', $data);
        if($result){
            redirect('products.php', 'Menu product created successfully!');
        } else {
            redirect('products-create.php', 'Something went wrong.');
        }

    } else {
        redirect('products-create.php','Please fill required fields.');
    }
}

if(isset($_POST['saveSupplier'])){
    $firstname = validate($_POST['firstname']);
    $lastname = validate($_POST['lastname']);
    $phonenumber = validate($_POST['phonenumber']);
    $address = validate($_POST['address']);

    if($firstname != '' && $lastname != '' && $phonenumber != '' && $address != ''){

        $data = [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'phonenumber' => $phonenumber,
            'address' => $address
        ];
        
        $result = insert('suppliers', $data);
        if($result){
            redirect('suppliers.php', 'Supplier added successfully!');
        } else {
            redirect('suppliers-create.php', 'Something went wrong.');
        }

    } else {
        redirect('suppliers-create.php','Please fill required fields.');
    }
}
?>