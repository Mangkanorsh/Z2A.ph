<?php
session_start();
if (!isset($_SESSION['customer_email'])) {
  echo "<script>window.open('../checkout.php','_self')</script>";
}else{
include("../mysql/config.php");

include("../functions/functions.php");

if (isset($_GET['order_id'])) {
  $order_id=$_GET['order_id'];
 
}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganpati Cosmetics</title>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- owl carousel css file cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../style.css">
  <style>


  </style>
 
</head>
<body>



 <div class="co-9">
  <div class="trx">
    <h1 align="center">Please confirm your payment</h1>
    <form action="confirm.php?update_id=<?php echo $order_id ?>" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label> Invoice Number</label>
        <input type="text" class="form-control" name="invoice_number" required="">
      </div>
      <div class="form-group">
        <label> Amount</label>
        <input type="text" class="form-control" name="amount" required="">
      </div>
      <div class="form-group">
        <label>Select Payment Mode</label>
       <select class="form-control" name="payment_mode">
         <option>Bank transfer</option>
         <option>Paypal</option>
         <option>Paytm</option>
         <option>google pay</option>
       </select>
      </div>
      <div class="form-group">
        <label>Transection Number </label>
        <input type="text" class="form-control" name="trfr_number" required="">
      </div>
      <div class="form-group">
        <label>Payment Date </label>
        <input type="date" class="form-control" name="date" required="">
      </div>
      <div class="text-center">
        <button type="submit" name="confirm_payment" class="btn btn-primary btn-lg">Confirm Payment</button>
      </div>
    </form>

    <?php

       if (isset($_POST['confirm_payment'])) {
           $update_id=$_GET['update_id'];
           $invoice_number=$_POST['invoice_number'];
           $amount=$_POST['amount'];
           $payment_mode=$_POST['payment_mode'];
           $trfr_number=$_POST['trfr_number'];
           $date=$_POST['date'];
           $complete="Complete";
           $insert="insert into payments (invoice_id,amount,payment_mode, ref_no, payment_date) values ('$invoice_number','$amount','$payment_mode','$trfr_number','$date')";
           $run_insert=mysqli_query($con,$insert);

           $update_q="update customer_order set order_status ='$complete' where order_id='$update_id'";
           $run_insert=mysqli_query($con,$update_q);

          // $update_p="update pending_order set order_status ='$complete' where order_id='$update_id'";
          // $run_insert=mysqli_query($con,$update_p);

           echo "<script> alert('Your order has been received') </script>";
            echo "<script>window.open('my_account.php?order','_self') </script>";
       }

     ?>

  </div>
 </div>
    
  



<?php } ?>

</body>
</html>