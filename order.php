<?php
session_start();
include("mysql/config.php");
include("functions/functions.php"); 

if (!isset($_GET['c_id'])) {
    echo "<script>alert('Customer ID is missing.')</script>";
    echo "<script>window.open('index.php', '_self')</script>";
    exit();
}

$customer_id = $_GET['c_id'];
$ip_add = getUserIp();
$status = "completed";
$invoice_no = mt_rand();
$select_cart = "SELECT * FROM cart WHERE ip_add=?";
$stmt_cart = $con->prepare($select_cart);
$stmt_cart->bind_param("s", $ip_add);
$stmt_cart->execute();
$result_cart = $stmt_cart->get_result();

if ($result_cart->num_rows == 0) {
    echo "<script>alert('Your cart is empty.')</script>";
    echo "<script>window.open('index.php', '_self')</script>";
    exit();
}

// Collect the total amount
$total_amount = 0;
while ($row_cart = $result_cart->fetch_assoc()) {
    $pro_id = $row_cart['p_id'];
    $size = $row_cart['size'];
    $qty = $row_cart['qty'];

    $get_product = "SELECT * FROM products WHERE product_id=?";
    $stmt_product = $con->prepare($get_product);
    $stmt_product->bind_param("i", $pro_id);
    $stmt_product->execute();
    $result_product = $stmt_product->get_result();
    $row_product = $result_product->fetch_assoc();

    $sub_total = $row_product['product_price'] * $qty;
    $total_amount += $sub_total;

    $insert_customer_order = "INSERT INTO customer_order (customer_id, product_id, due_amount, invoice_no, qty, size, order_date, order_status) VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)";
    $stmt_order = $con->prepare($insert_customer_order);
    $stmt_order->bind_param("iidisis", $customer_id, $pro_id, $sub_total, $invoice_no, $qty, $size, $status);
    $stmt_order->execute();
}

$delete_cart = "DELETE FROM cart WHERE ip_add=?";
$stmt_del_cart = $con->prepare($delete_cart);
$stmt_del_cart->bind_param("s", $ip_add);
$stmt_del_cart->execute();

// Assume you have the payment method and ref_no from a form or other source
$payment_method = "COD"; // Replace with actual method from form input

$ref_no = mt_rand( 100000000000,999999999999);
; // Replace with actual reference number if applicable

$insert_payment = "INSERT INTO payments (invoice_id, amount, payment_mode, ref_no, payment_date) VALUES (?, ?, ?, ?, NOW())";
$stmt_payment = $con->prepare($insert_payment);
$stmt_payment->bind_param("idss", $invoice_no, $total_amount, $payment_method, $ref_no);
$stmt_payment->execute();

echo "<script>alert('Your order has been submitted, thanks!')</script>";
echo "<script>window.open('customer/my_order.php', '_self')</script>";
?>
