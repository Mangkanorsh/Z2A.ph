<?php
session_start();
include("mysql/config.php");
include("functions/functions.php");
$isLoggedIn = isset($_SESSION['customer_email']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cart | Z2A</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Custom CSS -->
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <!-- Header Section Starts -->
  <?php include("includes/header.php"); ?>


  <section>
    <div class="container mt-5">
      <div class="row">
        <div class="col-md-9" id="cart">
          <div class="card">
            <div class="card-body">
              <form action="cart.php" method="post" enctype="multipart/form-data" id="cartForm">
                <h1 class="mb-4">Shopping Cart</h1>
                <?php
                $ip_add = getUserIp();
                $select_cart = "select * from cart where ip_add='$ip_add'";
                $run_cart = mysqli_query($con, $select_cart);
                $count = mysqli_num_rows($run_cart);
                ?>
                <p class="text-muted">Currently you have <?php echo $count ?> items in your cart</p>
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Select</th>
                        <th colspan="2">Product</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Size</th>
                        <th>Delete</th>
                        <th>Sub Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $total = 0;
                      while ($row = mysqli_fetch_array($run_cart)) {
                        $pro_id = $row['p_id'];
                        $pro_size = $row['size'];
                        $pro_qty = $row['qty'];
                        $get_product = "select * from products where product_id='$pro_id'";
                        $run_pro = mysqli_query($con, $get_product);
                        while ($row = mysqli_fetch_array($run_pro)) {
                          $p_title = $row['product_title'];
                          $p_img1 = $row['product_img1'];
                          $p_price = $row['product_price'];
                          $sub_total = $row['product_price'] * $pro_qty;
                          $total += $sub_total;
                      ?>
                          <tr data-price="<?php echo $p_price ?>" data-qty="<?php echo $pro_qty ?>">
                            <td><input type="checkbox" name="selected[]" value="<?php echo $pro_id ?>" class="select-item-checkbox"></td>
                            <td><img src="admin_area/product_images/<?php echo $p_img1 ?>" class="img-fluid" style="width: 50px;"></td>
                            <td><?php echo $p_title ?></td>
                            <td><?php echo $pro_qty ?></td>
                            <td>₱ <?php echo $p_price ?></td>
                            <td><?php echo $pro_size ?></td>
                            <td><button type="submit" name="delete" value="<?php echo $pro_id ?>" class="btn btn-danger btn-sm">Remove</button></td>
                            <td>₱ <span class="sub-total"><?php echo $sub_total ?></span></td>
                          </tr>
                      <?php }
                      } ?>
                    </tbody>
                  </table>
                </div>
                <div class="d-flex justify-content-between align-items-center my-4">
                  <h4>Total Price: ₱ <span id="totalPrice"><?php echo $total; ?></span></h4>
                </div>
                <div class="d-flex justify-content-between">
                  <a href="index.php" class="btn btn-secondary">
                    <i class="fa fa-chevron-left"></i> Continue Shopping
                  </a>
                  <div>
                    <button class="btn btn-warning" type="submit" name="checkout" value="proceed to checkout" id="checkoutButton" disabled>
                      Proceed to checkout <i class="fa fa-chevron-right"></i>
                    </button>
                  </div>
                </div>
              </form>
              <?php
              if (isset($_POST['delete'])) {
                $remove_id = $_POST['delete'];
                $delete_product = "delete from cart where p_id='$remove_id'";
                $run_del = mysqli_query($con, $delete_product);
                if ($run_del) {
                  echo "<script>window.open('cart.php','_self')</script>";
                }
              }

              if (isset($_POST['checkout'])) {
                $selected_products = $_POST['selected'];
                // Process selected products for checkout
                // Redirect to checkout page with selected products
                $_SESSION['selected_products'] = $selected_products;
                echo "<script>window.open('checkout.php','_self')</script>";
              }
              ?>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Order Summary</h4>
            </div>
            <div class="card-body">
              <p class="text-muted">Shipping and additional costs are calculated based on the values you have entered</p>
              <table class="table">
                <tr>
                  <td>Order Sub Total</td>
                  <th>₱ <span id="summarySubTotal"><?php echo $total ?></span></th>
                </tr>
                <tr>
                  <td>Shipping and handling</td>
                  <td>₱ 0</td>
                </tr>
                <tr>
                  <td>Tax</td>
                  <td>₱ 0</td>
                </tr>
                <tr class="total">
                  <td>Total</td>
                  <th>₱ <span id="summaryTotal"><?php echo $total ?></span></th>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php include("includes/footer.php") ?>


  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Custom JS -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const checkboxes = document.querySelectorAll('.select-item-checkbox');
      const checkoutButton = document.getElementById('checkoutButton');
      const totalPriceEl = document.getElementById('totalPrice');
      const summarySubTotalEl = document.getElementById('summarySubTotal');
      const summaryTotalEl = document.getElementById('summaryTotal');

      function updateCheckoutButtonState() {
        const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
        checkoutButton.disabled = !anyChecked;
      }

      function updateTotal() {
        let total = 0;
        checkboxes.forEach(checkbox => {
          const row = checkbox.closest('tr');
          const price = parseFloat(row.getAttribute('data-price'));
          const qty = parseInt(row.getAttribute('data-qty'));
          if (checkbox.checked) {
            total += price * qty;
          }
        });
        totalPriceEl.textContent = total.toFixed(2);
        summarySubTotalEl.textContent = total.toFixed(2);
        summaryTotalEl.textContent = total.toFixed(2);
      }

      function handleCheckboxChange() {
        updateCheckoutButtonState();
        updateTotal();
      }

      checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', handleCheckboxChange);
      });

      // Initial check
      handleCheckboxChange();
    });
  </script>
</body>
</html>
