<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Asia/Manila');

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
                redirect('order-create.php', 'Only ' .$row['quantity']. ' ' .$row['productname']. ' available.');
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
                    $newQuantity = $prodSessionItem['quantity'] + $quantity;
                    if($prodSessionItem['product_id'] == $row['id']){
                        if($row['quantity'] < $newQuantity){ //if available is less than order
                            redirect('order-create.php', 'Only ' .$row['quantity']. ' ' .$row['productname']. ' available.');
                        } else {
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
            }
            redirect('order-create.php', 'Item added: ' .$quantity. ' ' .$row['productname']);
        } else {
            redirect('order-create.php', 'No such product found!');
        }
    } else {
        redirect('order-create.php','Something went wrong!');
    }
}

if(isset($_POST['productIncDec'])) {
    $productId = validate($_POST['product_id']);
    $quantity = validate($_POST['quantity']);

    // Fetch product details from the database
    $checkProduct = mysqli_query($conn, "SELECT * FROM products WHERE id='$productId' LIMIT 1");

    // Initialize flags
    $flag = false;
    $flag1 = false;

    // Check if product exists
    if (mysqli_num_rows($checkProduct) > 0) {
        $row = mysqli_fetch_assoc($checkProduct);
            // Check against session items
            foreach($_SESSION['productItems'] as $key => $item) {
                if ($item['product_id'] == $productId) {
                    // Check if requested quantity exceeds available quantity
                    if ($row['quantity'] < $quantity + 1) {
                        $flag1 = true; // Not enough available
                    } else {
                        // Enough available, update the quantity
                        $_SESSION['productItems'][$key]['quantity'] = $quantity;
                        $flag = true; // Quantity changed
                    }
                    break; // Break once we find the item
                }
            }
        
    }
    if ($flag1) {
        jsonResponse(500, 'success', "Maximum quantity reached!");
    } else if ($flag) {
        jsonResponse(200, 'success', "Quantity changed.");
    } else {
        jsonResponse(500, 'error', "Something went wrong!");
    }
}


if (isset($_POST['proceedToPlaceBtn'])) {
    $name = validate($_POST['cname']);
    $payment_mode = validate($_POST['payment_mode']);
    $order_status = validate($_POST['order_status']);

    $checkCustomer = mysqli_query($conn, "SELECT * FROM customers WHERE name='$name' LIMIT 1");

    if ($checkCustomer) {
        if (mysqli_num_rows($checkCustomer) > 0) {
            $_SESSION['invoice_no'] = "INV-" .rand(111111, 999999);
            $_SESSION['cname'] = $name;
            $_SESSION['payment_mode'] = $payment_mode;
            $_SESSION['order_status'] = $order_status;

            jsonResponse(200, 'success', 'Customer found');
        } else {
            $_SESSION['cname'] = $name;
            jsonResponse(404, 'warning', 'Customer not found');
        }
    } else {
        jsonResponse(500, 'error', 'Something Went Wrong');
    }
}


if (isset($_POST['proceedToUpdateBtn'])) {
    $order_status = validate($_POST['order_status']);
    $order_id = validate($_POST['order_id']);

    // Fetch order details
    $orderData = getByID('orders', $order_id);
    if ($orderData['status'] != 200) {
        jsonResponse(404, 'error', 'Order not found');
        exit();
    }

    // Update order status
    if ($order_status != '') {
        $data = ['order_status' => $order_status];
        $updateResult = update('orders', $order_id, $data);

        if (!$updateResult) {
            jsonResponse(500, 'error', 'Failed to update order status');
            exit();
        }

        // Deduct product quantity if the order is being prepared
        if ($order_status == 'Preparing') {
            $orderItemQuery = "SELECT oi.quantity as orderItemQuantity, oi.product_id, p.quantity as productQuantity 
                               FROM order_items as oi 
                               JOIN products as p ON oi.product_id = p.id 
                               WHERE oi.order_id = '$order_id'";

            $orderItemsRes = mysqli_query($conn, $orderItemQuery);

            if ($orderItemsRes && mysqli_num_rows($orderItemsRes) > 0) {
                while ($orderItemRow = mysqli_fetch_assoc($orderItemsRes)) {
                    $productId = $orderItemRow['product_id'];
                    $orderItemQuantity = $orderItemRow['orderItemQuantity'];
                    $productQuantity = $orderItemRow['productQuantity'];

                    // Ensure there is enough stock before deducting
                    if ($productQuantity >= $orderItemQuantity) {
                        $newQuantity = $productQuantity - $orderItemQuantity;

                        $updateProductQtyQuery = "UPDATE products SET quantity='$newQuantity' WHERE id='$productId'";
                        $updateProductQtyResult = mysqli_query($conn, $updateProductQtyQuery);

                        if (!$updateProductQtyResult) {
                            jsonResponse(500, 'error', 'Failed to update product quantity for product ID: ' . $productId);
                            exit();
                        }
                    } else {
                        jsonResponse(400, 'error', 'Insufficient stock for product ID: ' . $productId);
                        exit();
                    }
                }

                jsonResponse(200, 'success', 'Order updated and product quantities deducted successfully');
            } else {
                jsonResponse(404, 'error', 'No order items found');
            }
        } else {
            jsonResponse(200, 'success', 'Order updated successfully');
        }
    } else {
        jsonResponse(400, 'error', 'Invalid order status');
    }
}


if (isset($_POST['proceedToCompleteBtn'])) {
    // Check what POST data is received
    error_log(print_r($_POST, true)); // Log POST data for debugging

    $order_status = validate($_POST['order_status'] ?? ''); // Use null coalescing to avoid undefined index
    $order_track = validate($_POST['order_track'] ?? ''); // Use null coalescing to avoid undefined index

    if (empty($order_track)) {
        jsonResponse(400, 'error', 'Invalid order tracking number');
        exit();
    }

    // Fetch the order ID based on the tracking number
    $query = "SELECT id FROM orders WHERE tracking_no = '$order_track' LIMIT 1";
    $result = mysqli_query($conn, $query);
    
    // Check for query error
    if (!$result) {
        jsonResponse(500, 'error', 'Database query failed: ' . mysqli_error($conn));
        exit();
    }

    $orderData = mysqli_fetch_assoc($result);

    if ($orderData) {
        $order_id = $orderData['id']; // Get the order ID

        $data = ['order_status' => $order_status];
        $updateResult = update('orders', $order_id, $data);

        if ($updateResult) {
            jsonResponse(200, 'success', 'Order updated successfully');
        } else {
            jsonResponse(500, 'error', 'Failed to update order status');
        }
    } else {
        jsonResponse(404, 'error', 'Order not found');
    }
}
 





if(isset($_POST['saveCustomerBtn'])){
    $name = validate($_POST['name']);  // Change 'c_name' to 'name'

    if($name != ''){
       $data = [
            'name' => $name
        ];

        $result = insert('customers', $data);

        if($result){
            jsonResponse(200, 'success', 'Customer Added Successfully!');
        }else{
            jsonResponse(500, 'error', 'Something Went Wrong');
        }
    }else{
        jsonResponse(422, 'warning', 'Please fill required fields');
    }
}

if (isset($_POST['saveOrder'])) {
    $name = validate($_SESSION['cname']);
    $invoice_no = validate($_SESSION['invoice_no']);
    $payment_mode = validate($_SESSION['payment_mode']);
    $order_placed_by_id = validate($_SESSION['loggedInUser']['firstname']);
    $order_status = validate($_SESSION['order_status']);

    // Check if customer exists
    $checkCustomer = mysqli_query($conn, "SELECT * FROM customers WHERE name='$name' LIMIT 1");
    if (!$checkCustomer) {
        jsonResponse(500, 'error', 'Something Went Wrong');
    }

    if (mysqli_num_rows($checkCustomer) > 0) {
        $customerData = mysqli_fetch_assoc($checkCustomer);

        if (!isset($_SESSION['productItems'])) {
            jsonResponse(404, 'warning', 'No items to place order');
            exit;
        }

        $totalAmount = 0;
        $sessionProducts = $_SESSION['productItems'];  // Make sure this exists
        foreach ($sessionProducts as $amtItem) {
            $totalAmount += $amtItem['price'] * $amtItem['quantity'];  // Fix typo
        }

        $data = [
            'customer_id' => $customerData['id'],
            'tracking_no' => rand(111111, 999999),
            'invoice_no' => $invoice_no,
            'total_amount' => $totalAmount,
            'order_date' => date('Y-m-d H:i:s'),
            'order_status' => $order_status,
            'payment_mode' => $payment_mode,
            'order_placed_by_id' => $order_placed_by_id
        ];

        $result = insert('orders', $data);
        $lastOrderId = mysqli_insert_id($conn);

        foreach ($sessionProducts as $prodItem) {
            $productId = $prodItem['product_id'];
            $price = $prodItem['price'];
            $quantity = $prodItem['quantity'];

            $dataOrderItem = [
                'order_id' => $lastOrderId,
                'product_id' => $productId,
                'price' => $price,
                'quantity' => $quantity,
            ];

            $orderItemQuery = insert('order_items', $dataOrderItem);

            // // Update product quantities
            // $checkProductQuantityQuery = mysqli_query($conn, "SELECT * FROM products WHERE id='$productId'");
            // $productQtyData = mysqli_fetch_assoc($checkProductQuantityQuery);
            // $totalProductsQuantity = $productQtyData['quantity'] - $quantity;

            // $dataUpdate = [
            //     'quantity' => $totalProductsQuantity
            // ];

            // $updateProductQty = update('products', $productId, $dataUpdate);
        }

        unset($_SESSION['productItemIds'], $_SESSION['productItems'], $_SESSION['payment_mode'], $_SESSION['invoice_no']);
        jsonResponse(200, 'success', 'Order placed successfully!');
    } else {
        jsonResponse(404, 'warning', 'No Customer found');
    }
}


?>

