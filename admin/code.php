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

if(isset($_POST['updateAdmin'])){
    $adminId = validate($_POST['adminId']);

    $adminData = getById('admins',$adminId);

    if($adminData['status'] != 200) {
        redirect('admins-edit.php?id='.$adminId, 'Admin not found.');
    }

    $firstname = validate($_POST['firstname']);
    $lastname = validate($_POST['lastname']);
    $username = validate($_POST['username']);
    $password = validate($_POST['password']);
    $position = validate($_POST['position']);
    $is_banned = isset($_POST['is_banned']) == true ? 1 : 0;

    if($password != ''){
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    } else {
        $hashedPassword = $adminData['data']['password'];
    }

    if($firstname != '' && $lastname != '' && $username != '' && $position != ''){
        $data = [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'username' => $username,
            'password' => $hashedPassword,
            'position' => $position,
            'is_banned' => $is_banned
        ];

        $result = update('admins', $adminId, $data);
        if($result){
            redirect('admins.php', 'Admin updated successfully!');
        } else {
            redirect('admins-edit.phpid='.$adminId, 'Something went wrong.');
        }

    } else {
        redirect('admins-edit.php','Please fill required fields.');
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

if(isset($_POST['updateSupplier'])){
    $supplierId = validate($_POST['supplierId']);

    $supplierData = getById('suppliers',$supplierId);

    if($supplierData['status'] != 200) {
        redirect('suppliers-edit.php?id='.$supplierId, 'Supplier not found.');
    }

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

        $result = update('suppliers', $supplierId, $data);
        if($result){
            redirect('suppliers.php', 'Supplier updated successfully!');
        } else {
            redirect('suppliers-edit.phpid='.$supplierId, 'Something went wrong.');
        }
    } else {
        redirect('suppliers-edit.php','Please fill required fields.');
    }
}

if(isset($_POST['saveProduct'])){
    $category_id = validate($_POST['category_id']);
    $productname = validate($_POST['productname']);
    $description = validate($_POST['description']);
    $price = validate($_POST['price']);

    if($_FILES['image']['size'] > 0) {
        $path = "../assets/uploads/products/";
        $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

        $filename = time().'.'.$image_ext;

        move_uploaded_file($_FILES['image']['tmp_name'], $path."/".$filename);
        $finalImage = "assets/uploads/products/".$filename;
    } else {
        $finalImage = '';
    }

    $data = [
        'category_id' => $category_id,
        'productname' => $productname,
        'description' => $description,
        'price' => $price,
        'image' => $finalImage
    ];
    
    $result = insert('products', $data);
    if($result){
        redirect('products.php', 'Menu product created successfully!');
    } else {
        redirect('products-create.php', 'Something went wrong.');
    }
}

if(isset($_POST['updateProduct'])){
    $productId = validate($_POST['productId']);

    $productData = getById('products',$productId);

    if($productData['status'] != 200) {
        redirect('products-edit.php?id='.$productId, 'Product not found.');
    }

    $productname = validate($_POST['productname']);
    $price = validate($_POST['price']);
    $category = validate($_POST['category']);

    if($productname != '' && $price != '' && $category!= ''){
        $data = [
            'productname' => $productname,
            'price' => $price,
            'category' => $category
        ];

        $result = update('products', $productId, $data);
        if($result){
            redirect('products.php', 'Menu product updated successfully!');
        } else {
            redirect('products-edit.phpid='.$productId, 'Something went wrong.');
        }

    } else {
        redirect('products-edit.php','Please fill required fields.');
    }
}

if(isset($_POST['saveCategory'])){
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) == true ? 1 : 0;

    $data = [
        'name' => $name,
        'description' => $description,
        'status' => $status
    ];
    $result = insert('categories',$data);

    if($result){
        redirect('categories.php','Category created successfully!');
    } else {
        redirect('categories-create.php','Someting went wrong.');
    }
}

if(isset($_POST['updateCategory'])){
    $categoryId = validate($_POST['categoryId']);

    $categoryData = getById('categories', $categoryId);

    if($categoryData['status'] != 200) {
        redirect('categories-edit.php?id='.$categoryId, 'Category not found.');
    }

    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) == true ? 1 : 0;
    
    if($name != '' && $description != '') {
        $data = [
            'name' => $name,
            'description' => $description,
            'status' => $status
        ];
        $result = update('categories', $categoryId, $data);

        if($result){
            redirect('categories.php','Category updated successfully!');
        } else {
            redirect('categories.php','Someting went wrong.');
        }
    } else {
        redirect('categories-edit.php','Please fill required fields.');
    }
}
?>