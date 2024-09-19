<?php

include('../config/function.php');

if(!isset($_SESSION['productItems'])) {
    $_SESSION['productItems'] = [];
}

if(!isset($_SESSION['productItemIds'])) {
    $_SESSION['productItemIds'] = [];
}

if(isset($_POST['addItem'])){
    $productId = validate($_POST['product_id']);
    $quantity = validate($_POST['quantity']);

    $checkProduct = mysqli_query($conn, "SELECT * FROM products WHERE id='$productId' LIMIT 1");
    if($checkProduct){
        if(mysqli_num_rows($checkProduct)>0){
            $row = mysqli_fetch_assoc($checkProduct);
            if($row['quantity'] < $quantity){
                redirect('order-create.php', 'Only' .$row['quantity']. 'quantity available.');
            }

            $productData = [
                'product_id' => $row['id'],
                'name' => $row['productname'],
                'image' => $row['image'],
                'price' => $row['price'],
                'quantity' => $quantity,
            ];

            if(!in_array($row['id'], $_SESSION['productItemIds'])){
                array_push($_SESSION['productItemIds'],$row['id']);
                array_push($_SESSION['productItems'],$productData);
            }else{
                foreach($_SESSION['productItems'] as $key => $prodSessionItem) {
                    if($prodSessionItem['product_id'] == $row['id']){
                        $newQuantity = $prodSessionItem['quantity'] + $quantity;

                        $productData = [
                            'product_id' => $row['id'],
                            'name' => $row['productname'],
                            'image' => $row['image'],
                            'price' => $row['price'],
                            'quantity' => $newQuantity,
                        ];

                        $_SESSION['productItems'][$key] = $productData;
                    }
                }
            }
            redirect('order-create.php', 'Item added ' .$row['productname']);
        } else {
            redirect('order-create.php', 'No such product found!');
        }
    } else {
        redirect('order-create.php','Something went wrong!');
    }
}

if(isset($_POST['productIncDec'])){
    $productId = validate($_POST['product_id']);
    $quantity = validate($_POST['quantity']);

    $flag = false;
    foreach($_SESSION['productItems'] as $key => $item){
        if($item['product_id'] == $productId){

            $flag = true;
            $_SESSION['productItems'][$key]['quantity']= $quantity;
        }

    }

    if($flag){
        jsonRespone(200, 'success', "Quantity Changed." );
    }else{
        jsonRespone(500, 'error', "Something went wrong!" );
    }
}
?>