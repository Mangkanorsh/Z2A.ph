<?php
session_start();
include("../mysql/config.php");
include("../functions/functions.php"); 

if (!isset($_SESSION['customer_email'])) {
    echo "<script>alert('You need to log in first.')</script>";
    echo "<script>window.open('../login.php', '_self')</script>";
    exit();
}

$customer_session = $_SESSION['customer_email'];
$get_customer = "SELECT * FROM customers WHERE customer_email=?";
$stmt_customer = $con->prepare($get_customer);
$stmt_customer->bind_param("s", $customer_session);
$stmt_customer->execute();
$result_customer = $stmt_customer->get_result();
$row_cust = $result_customer->fetch_assoc();
$customer_id = $row_cust['customer_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders | Z2A</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="container mt-5">
    <center>
        <h1>My Orders</h1>
        <p>Shipping and additional costs are calculated based on the values you have entered</p>
    </center>
    <hr>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sr.No</th>
                    <th>Due Amount</th>
                    <th>Invoice Number</th>
                    <th>Quantity</th>
                    <th>Size</th>
                    <th>Order Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $get_order = "SELECT * FROM customer_order WHERE customer_id=?";
                $stmt_order = $con->prepare($get_order);
                $stmt_order->bind_param("i", $customer_id);
                $stmt_order->execute();
                $result_order = $stmt_order->get_result();
                
                $i = 0;
                while ($row_order = $result_order->fetch_assoc()) {
                    $i++;
                    $order_id = $row_order['order_id'];
                    $order_due_amount = $row_order['due_amount'];
                    $order_invoice = $row_order['invoice_no'];
                    $order_qty = $row_order['qty'];
                    $order_size = $row_order['size'];
                    $order_date = substr($row_order['order_date'], 0, 10);
                    $order_status = $row_order['order_status'];
                    
                    if ($order_status == 'pending') {
                        $order_status = 'Unpaid';
                    } else {
                        $order_status = 'Paid';
                    }
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($i); ?></td>
                    <td><?php echo htmlspecialchars($order_due_amount); ?></td>
                    <td><?php echo htmlspecialchars($order_invoice); ?></td>
                    <td><?php echo htmlspecialchars($order_qty); ?></td>
                    <td><?php echo htmlspecialchars($order_size); ?></td>
                    <td><?php echo htmlspecialchars($order_date); ?></td>
                    <td><?php echo htmlspecialchars($order_status); ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
