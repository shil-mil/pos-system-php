<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Purchase Orders</h4>
        </div>
        <div class="card-body">

        <?php
            $query = "SELECT po.*, a.* FROM purchaseOrders po, admins a WHERE a.id = po.customer_id ORDER BY po.order_date DESC";
            $purchaseOrders = mysqli_query($conn, $query);

            if($purchaseOrders){
                if(mysqli_num_rows($purchaseOrders) > 0){

                    // Prepare arrays to hold orders by their status
                    $pendingPurchaseOrders = [];
                    $deliveredPurchaseOrders = [];

                    // Categorize orders based on their status
                    foreach($purchaseOrders as $orderItem) {
                        switch ($orderItem['order_status']) {
                            case 'Pending':
                                $pendingPurchaseOrders[] = $orderItem;
                                break;
                            case 'Delivered':
                                $deliveredPurchaseOrders[] = $orderItem;
                                break;
                        }
                    }
                    ?>
                    <!-- Pending Purchase Orders -->
                    <h5>Pending Purchase Orders</h5>
                    <table class="table table-striped table-bordered align-items-center justify-content-center">
                        <thead>
                            <tr>
                                <th>Tracking No.</th>
                                <th>Name</th>
                                <th>Order Date</th>
                                <th>Order Status</th>
                                <th>Payment Method</th>
                                <th style="width: 250px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($pendingPurchaseOrders as $ingredientItem): ?>
                                <tr>
                                    <td class="fw-bold"><?= $ingredientItem['tracking_no']; ?></td>
                                    <td><?= $ingredientItem['firstname']; ?></td>
                                    <td><?= $ingredientItem['order_date']; ?></td>
                                    <td><?= $ingredientItem['order_status']; ?></td>
                                    <td><?= $ingredientItem['ingPayment_mode']; ?></td>
                                    <td style="display: flex; justify-content: space-evenly; gap: 5px;">
                                        <input type="hidden" name="order_track" value="<?= $ingredientItem['tracking_no']; ?>">
                                        <button class="btn btn-warning btn-sm complete-btn w-100 proceedToDeliveredIng">Delivered</button>
                                        <a href="purchase-orders-view.php?track=<?= $ingredientItem['tracking_no']; ?>" class="btn btn-info mb-0 px-2 btn-sm w-100">View</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- Delivered Purchase Orders -->
                    <h5>Delivered Purchase Orders</h5>
                    <table class="table table-striped table-bordered align-items-center justify-content-center">
                        <thead>
                            <tr>
                                <th>Tracking No.</th>
                                <th>Name</th>
                                <th>Order Date</th>
                                <th>Order Status</th>
                                <th>Payment Method</th>
                                <th style="width: 250px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($deliveredPurchaseOrders as $ingredientItem): ?>
                                <tr>
                                    <td class="fw-bold"><?= $ingredientItem['tracking_no']; ?></td>
                                    <td><?= $ingredientItem['firstname']; ?></td>
                                    <td><?= $ingredientItem['order_date']; ?></td>
                                    <td><?= $ingredientItem['order_status']; ?></td>
                                    <td><?= $ingredientItem['ingPayment_mode']; ?></td>
                                    <td>
                                        <a href="purchase-orders-view.php?track=<?= $ingredientItem['tracking_no']; ?>" class="btn btn-info mb-0 px-2 btn-sm w-100">View</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php
                } else {
                    echo "<h5>No Record Available</h5>";
                }
            } else {
                echo "<h5>Something went wrong</h5>";
            }
        ?>

        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>