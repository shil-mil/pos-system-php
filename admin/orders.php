<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Orders</h4>
        </div>
        <div class="card-body">
        <?php alertMessage(); ?>
        
        <?php
            $query = "SELECT o.*, c.* FROM orders o, customers c WHERE c.id = o.customer_id ORDER BY o.id DESC";
            $orders = mysqli_query($conn, $query);

            if($orders){
                if(mysqli_num_rows($orders) > 0){
                    
                    // Prepare arrays to hold orders by their status
                    $completedOrders = [];
                    $cancelledOrders = [];
                    $preparingOrders = [];
                    $placedOrders = [];

                    // Categorize orders based on their status
                    foreach($orders as $orderItem) {
                        switch ($orderItem['order_status']) {
                            case 'Completed':
                                $completedOrders[] = $orderItem;
                                break;
                            case 'Cancelled':
                                $cancelledOrders[] = $orderItem;
                                break;
                            case 'Preparing':
                                $preparingOrders[] = $orderItem;
                                break;
                            case 'Placed':
                                $placedOrders[] = $orderItem;
                                break;
                        }
                    }
                    ?>

                    
                    <!-- Placed Orders -->
                    <div class="mt-4">
                        <h5>Placed Orders</h5>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Tracking No.</th>
                                    <th>Name</th>
                                    <th>Order Date</th>
                                    <th>Order Status</th>
                                    <th>Payment Method</th>
                                    <th style="width: 175px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($placedOrders as $orderItem): ?>
                                    <tr>
                                        <td class="fw-bold"><?= $orderItem['tracking_no']; ?></td>
                                        <td><?= $orderItem['name']; ?></td>
                                        <td><?= $orderItem['order_date']; ?></td>
                                        <td><?= $orderItem['order_status']; ?></td>
                                        <td><?= $orderItem['payment_mode']; ?></td>
                                        <td style="display: flex; justify-content: space-between; gap: 5px;">
                                            <a href="order-edit.php?track=<?= $orderItem['tracking_no']; ?>" class="btn btn-primary btn-sm w-100">Edit</a>
                                            <a href="orders-view.php?track=<?= $orderItem['tracking_no']; ?>" class="btn btn-info btn-sm w-100">View</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Preparing Orders -->
                    <div class="mt-4">
                        <h5>Preparing Orders</h5>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Tracking No.</th>
                                    <th>Name</th>
                                    <th>Order Date</th>
                                    <th>Order Status</th>
                                    <th>Payment Method</th>
                                    <th style="width: 175px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($preparingOrders as $orderItem): ?>
                                    <tr>
                                        <td class="fw-bold"><?= $orderItem['tracking_no']; ?></td>
                                        <td><?= $orderItem['name']; ?></td>
                                        <td><?= $orderItem['order_date']; ?></td>
                                        <td><?= $orderItem['order_status']; ?></td>
                                        <td><?= $orderItem['payment_mode']; ?></td>
                                        <td style="display: flex; justify-content: space-evenly; gap: 5px;">
                                            <input type="hidden" name="order_track" value="<?= $orderItem['tracking_no']; ?>">
                                            <button class="btn btn-warning btn-sm complete-btn w-100 proceedToComplete">Completed</button>
                                            <a href="orders-view.php?track=<?= $orderItem['tracking_no']; ?>" class="btn btn-info btn-sm w-100">View</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Completed Orders -->
                    <div class="mt-4">
                        <h5>Completed Orders</h5>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Tracking No.</th>
                                    <th>Name</th>
                                    <th>Order Date</th>
                                    <th>Order Status</th>
                                    <th>Payment Method</th>
                                    <th style="width: 175px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($completedOrders as $orderItem): ?>
                                    <tr>
                                        <td class="fw-bold"><?= $orderItem['tracking_no']; ?></td>
                                        <td><?= $orderItem['name']; ?></td>
                                        <td><?= $orderItem['order_date']; ?></td>
                                        <td><?= $orderItem['order_status']; ?></td>
                                        <td><?= $orderItem['payment_mode']; ?></td>
                                        <td><a href="orders-view.php?track=<?= $orderItem['tracking_no']; ?>" class="btn btn-info btn-sm w-100">View</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Cancelled Orders -->
                    <div class="mt-4">
                        <h5>Cancelled Orders</h5>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Tracking No.</th>
                                    <th>Name</th>
                                    <th>Order Date</th>
                                    <th>Order Status</th>
                                    <th>Payment Method</th>
                                    <th style="width: 175px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($cancelledOrders as $orderItem): ?>
                                    <tr>
                                        <td class="fw-bold"><?= $orderItem['tracking_no']; ?></td>
                                        <td><?= $orderItem['name']; ?></td>
                                        <td><?= $orderItem['order_date']; ?></td>
                                        <td><?= $orderItem['order_status']; ?></td>
                                        <td><?= $orderItem['payment_mode']; ?></td>
                                        <td><a href="orders-view.php?track=<?= $orderItem['tracking_no']; ?>" class="btn btn-info btn-sm w-100">View</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    

                    

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