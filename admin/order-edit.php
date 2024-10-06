<?php
include('includes/header.php'); 
?>

<div class="modal fade" id="addCustomerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Customer</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Enter Name</label>
                    <input type="text" class="form-control" id="c_name"/>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary saveCustomer">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-4 pb-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Order
                <a href="orders.php" class="btn btn-outline-danger float-end">Back</a> 
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <?php
            if(isset($_GET['track']) && $_GET['track'] != ''){
                $trackingNo = validate($_GET['track']);

                $query = "SELECT o.*, c.* FROM orders o, customers c WHERE 
                          c.id = o.customer_id AND tracking_no='$trackingNo' 
                          ORDER BY o.id DESC";
                $orders = mysqli_query($conn, $query);

                if ($orders && mysqli_num_rows($orders) > 0) {
                    $orderData = mysqli_fetch_assoc($orders);
                    $orderId = $orderData['id'];

                    // Fetch order items
                    $orderItemQuery = "SELECT oi.quantity as orderItemQuantity, oi.price as orderItemPrice, o.*, oi.*, p.* 
                                       FROM orders as o, order_items as oi, products as p 
                                       WHERE oi.order_id = o.id AND p.id = oi.product_id AND o.tracking_no='$trackingNo'";
                    $orderItemsRes = mysqli_query($conn, $orderItemQuery);

                    if ($orderItemsRes && mysqli_num_rows($orderItemsRes) > 0) {
                        ?>
                        <form action="orders-code.php" method="POST">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="">Select Products</label>
                                    <select name="product_id" class="form-select mySelect2">
                                        <option value="">-- Select Product --</option>
                                        <?php
                                        $products = getAll('products');
                                        if ($products) {
                                            if (mysqli_num_rows($products) > 0) {
                                                foreach ($products as $prodItem) {
                                                    ?>
                                                    <option value="<?= $prodItem['id']; ?>"><?= $prodItem['productname']; ?></option>
                                                    <?php
                                                }
                                            } else {
                                                echo '<option value="">No product found!</option>';
                                            }
                                        } else {
                                            echo '<option value="">Something went wrong!</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="">Quantity</label>
                                    <input type="number" name="quantity" value="1" min="1" class="form-control" />
                                </div>
                                <div class="col-md-3 mb-3">
                                    <br/>
                                    <button type="submit" name="addItem" class="btn btn-outline-primary">Add Item</button>
                                </div>
                            </div>
                        </form>
                        <div class="card mt-3">
                            <div class="card-header">
                                <h4 class="mb-0">Products</h4>
                            </div>
                            <div class="card-body" id="productArea">
                                <div class="mb-3" id="productContent">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Product Name</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Total Price</th> 
                                                <th>Remove</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while($orderItemRow = mysqli_fetch_assoc($orderItemsRes)): ?>
                                                <tr>
                                                    <td><?= $orderItemRow['product_id']; ?></td>
                                                    <td><?= $orderItemRow['productname']; ?></td>
                                                    <td>Php <?= number_format($orderItemRow['orderItemPrice'], 2); ?></td>
                                                    <td>
                                                        <div class="input-group qtyBox">
                                                            <input type="hidden" value="<?= $orderItemRow['product_id'];?>" class="prodId">
                                                            <button class="input-group-text decrement">-</button>
                                                            <input type="text" value="<?= $orderItemRow['quantity']; ?>" class="qty quantityInput" />
                                                            <button class="input-group-text increment">+</button>
                                                        </div>
                                                    </td>
                                                    <td>Php <?= number_format($orderItemRow['orderItemPrice'] * $orderItemRow['quantity'], 2); ?></td>
                                                    <td>
                                                        <a href="order-item-delete.php?index=<?= $orderItemRow['id']; ?>" class="btn btn-danger">Remove</a>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>

                                    <div class="mt-2">
                                        <hr>
                                        <?php
                                        // Get payment mode from the first order item (or adjust as necessary)
                                        $payment_mode = $orderData['payment_mode']; ?>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Select Payment Method</label>
                                                <select id="payment_mode" class="form-select">
                                                    <option value="">-- Select Payment --</option>
                                                    <option value="Cash Payment" <?= ($payment_mode == 'Cash Payment') ? 'selected' : ''; ?>>Cash Payment</option>
                                                    <option value="Online Payment" <?= ($payment_mode == 'Online Payment') ? 'selected' : ''; ?>>Online Payment</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Enter Customer Name</label>
                                                <input type="text" id="cname" class="form-control" value="<?= htmlspecialchars($orderData['customer_name']); ?>" />
                                            </div>
                                            <div class="col-md-4">
                                                <br/>
                                                <button type="button" class="btn btn-warning w-100 proceedToPlace">Proceed to place order</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    } else {
                        echo '<h5>No record Found!</h5>';
                    }
                } else {
                    echo '<h5>No record Found!</h5>';
                }
            } else {
                echo '<h5>No tracking number found!</h5>';
            }
            ?>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
