<?php
session_start();

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['customer_email']);

// Include necessary files
include("mysql/config.php");
include("functions/functions.php");

// Redirect to login if not logged in
if (!$isLoggedIn) {
  echo "<script>alert('You need to log in first to checkout this item')</script>";
  echo "<script>window.open('login.php','_self')</script>";
  exit();
}

$customer_email = $_SESSION['customer_email'];

// Use prepared statements to prevent SQL injection
$query = "SELECT * FROM customers WHERE customer_email = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("s", $customer_email);
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();

if (!$customer) {
  echo "<script>alert('Customer not found')</script>";
  echo "<script>window.open('index.php','_self')</script>";
  exit();
}

$customer_id = $customer['customer_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout | Z2A</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Custom CSS -->
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <?php include("includes/header.php"); ?>



  <section>
    <div class="container mt-5 mb-5">
      <?php
      $ip_add = getUserIp();
      $select_cart = "SELECT * FROM cart WHERE ip_add=?";
      $stmt_cart = $con->prepare($select_cart);
      $stmt_cart->bind_param("s", $ip_add);
      $stmt_cart->execute();
      $result_cart = $stmt_cart->get_result();
      $cart_items_count = $result_cart->num_rows;

      if ($cart_items_count > 0) {
        $total = 0;
        $cart_items = [];
        while ($row = $result_cart->fetch_assoc()) {
          $cart_items[] = $row;
        }
      ?>
        <div class="card mt-5 border-1 shadow-sm">

          <div class="card-body">
            <h1 class="mb-4 text-center">Checkout</h1>

            <form action="checkout.php" method="post" enctype="multipart/form-data" id="cartForm">
              <div class="table-responsive">
                <table class="table table-borderless">
                  <tbody>
                    <?php foreach ($cart_items as $item) :
                      $pro_id = $item['p_id'];
                      $pro_size = $item['size'];
                      $pro_qty = $item['qty'];

                      // Use prepared statements to fetch product details
                      $get_product = "SELECT * FROM products WHERE product_id=?";
                      $stmt_product = $con->prepare($get_product);
                      $stmt_product->bind_param("i", $pro_id);
                      $stmt_product->execute();
                      $product = $stmt_product->get_result()->fetch_assoc();

                      $p_title = $product['product_title'];
                      $p_img1 = $product['product_img1'];
                      $p_price = $product['product_price'];
                      $sub_total = $product['product_price'] * $pro_qty;
                      $total += $sub_total;
                    ?>
                      <tr class="text-center align-middle">
                        <td><img src="admin_area/product_images/<?php echo htmlspecialchars($p_img1) ?>" class="img-fluid" style="width: 200px;"></td>
                        <td><?php echo htmlspecialchars($p_title) ?></td>
                        <td><?php echo htmlspecialchars($pro_size) ?></td>
                        <td>₱ <?php echo htmlspecialchars($p_price) ?></td>
                        <td><?php echo htmlspecialchars($pro_qty) ?></td>
                        <td>
                          <?php if ($cart_items_count == 1) : ?>
                            <button type="button" class="btn btn-danger btn-sm" onclick="showAlert()">Remove</button>
                          <?php else : ?>
                            <button type="submit" name="delete" value="<?php echo htmlspecialchars($pro_id) ?>" class="btn btn-danger btn-sm">Remove</button>
                          <?php endif; ?>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </form>
          </div>
          <div class="row g-4">
            <div class="col-lg-6">
              <div class="mx-4 card border-0">
                <div class="card-body">
                  <h4 class="card-title">Shipping Address</h4>
                  <p><strong>Name:</strong> <?php echo htmlspecialchars($customer['customer_name']); ?></p>
                  <p><strong>Address:</strong> <?php echo htmlspecialchars($customer['customer_full_address']); ?></p>
                  <p><strong>Contact Number:</strong> <?php echo htmlspecialchars($customer['customer_contact']); ?></p>
                  <p><strong>Email:</strong> <?php echo htmlspecialchars($customer['customer_email']); ?></p>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="mx-4 card border-0 ">
                <div class="card-body">
                  <h4 class="card-title">Payment Method</h4>
                  <form action="checkout.php" method="post" id="paymentForm">
                    <!-- Add CSRF Token -->
                    <!-- <input type="hidden" name="csrf_token" value="<?php //echo $_SESSION['csrf_token']; 
                                                                        ?>"> -->
                    <div class="mb-3">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" id="cod" value="COD" checked>
                        <label class="form-check-label" for="cod">Cash on Delivery</label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" id="card" value="Card">
                        <label class="form-check-label" for="card">Card Payment</label>
                      </div>
                    </div>
                    <div class="card mt-4 border-0">
                      <div class="card-body">
                        <h4 class="card-title">Order Summary</h4>
                        <p><strong>Total:</strong> ₱<?php echo number_format($total, 2); ?></p>
                        <button type="submit" class="btn btn-warning w-100" name="place_order">Place Order</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php
      } else {
        echo "<p class='text-center'>Your cart is empty! Please select item(s) before checkout.</p>";
      }
      ?>
    </div>
  </section>

  <?php include("includes/footer.php") ?>


  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    function showAlert() {
      alert("You cannot delete the last item from your cart.");
    }
  </script>
</body>

</html>

<?php
if (isset($_POST['delete'])) {
  $remove_id = $_POST['delete'];
  $select_cart = "SELECT * FROM cart WHERE ip_add=?";
  $stmt_cart = $con->prepare($select_cart);
  $stmt_cart->bind_param("s", $ip_add);
  $stmt_cart->execute();
  $result_cart = $stmt_cart->get_result();
  $cart_items_count = $result_cart->num_rows;

  if ($cart_items_count > 1) {
    $delete_product = "DELETE FROM cart WHERE p_id=?";
    $stmt_del = $con->prepare($delete_product);
    $stmt_del->bind_param("i", $remove_id);
    $stmt_del->execute();
    if ($stmt_del->affected_rows > 0) {
      echo "<script>window.open('checkout.php','_self')</script>";
    }
  } else {
    echo "<script>alert('You cannot delete the last item from your cart.');</script>";
  }
}

if (isset($_POST['place_order'])) {
  // Validate CSRF token
  if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    echo "<script>alert('Invalid CSRF token');</script>";
    exit();
  }

  $payment_method = $_POST['payment_method'];
  if ($payment_method == 'COD') {
    echo "<script>window.open('order.php?c_id=$customer_id','_self')</script>";
  } else {
    echo "<script>alert('Card Payment selected. Redirecting to payment gateway...')</script>";
  }
}
?>