<?php
session_start();
include("mysql/config.php");
$isLoggedIn = isset($_SESSION['customer_email']);
include("functions/functions.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Z2A | Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <style>
    h2 {
      font-weight: bolder;
    }

    .form-container {
      max-width: 600px;
      margin: 50px auto;
      padding: 30px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 50px;
    }

    .form-control:focus {
      border-color: #ffd700;
      box-shadow: 0 0 5px rgba(255, 215, 0, 0.5);
    }

    .btn-primary {
      background-color: #ffd700;
      border-color: #ffd700;
    }

    .btn-primary:hover {
      background-color: #ffc107;
      border-color: #ffc107;
    }

    .form-label {
      font-weight: bold;
    }

    .center-text {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }
  </style>

<body>
  <?php include("includes/header.php"); ?>


  <!-- PUT YOUR SECTION HERE -->
  <section>
    <div class="container">
      <div class="form-container bg-dark text-dark">
        <h2 class="text-center mb-4 text-warning">Log in</h2>
        <form accept="login.php" method="post">
          <div class="mb-4 form-floating">
            <input type="email" class="form-control" id="email" placeholder="Enter your email" name="c_email" required>
            <label for="email" class="form-label">Email</label>
          </div>
          <div class="mb-4 form-floating">
            <input type="password" class="form-control" id="password" placeholder="Enter your password" aria-describedby="passwordHelpBlock" name="c_password" required>
            <label for="password" class="form-label">Password</label>
          </div>
          <button type="submit" class="btn btn-primary mt-3 w-100 text-dark" name="login" value="login">Log in</button>
        </form>
        <div class="center-text">
          <span class="text-white">Don't have an account? <a href="signup.php" class="text-warning">Sign up</a></span>
        </div>
      </div>
    </div>
  </section>

  <?php include("includes/footer.php") ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
<?php

if (isset($_POST['login'])) {
  $customer_email = $_POST['c_email'];
  $customer_pass = $_POST['c_password'];

  $query = "SELECT * FROM customers WHERE customer_email = ?";
  $stmt = $con->prepare($query);
  $stmt->bind_param("s", $customer_email);
  $stmt->execute();
  $result = $stmt->get_result();
  $customer = $result->fetch_assoc();

  if ($customer && password_verify($customer_pass, $customer['customer_pass'])) {
    $_SESSION['customer_email'] = $customer_email;

    $get_ip = getUserIp();
    $select_cart = "SELECT * FROM cart WHERE ip_add='$get_ip'";
    $run_cart = mysqli_query($con, $select_cart);
    $check_cart = mysqli_num_rows($run_cart);

    if ($check_cart == 0) {
      echo "<script>alert('You are logged In')</script>";
      echo "<script>window.open('customer/my_account.php','_self')</script>";
    } else {
      echo "<script>alert('You are logged In')</script>";
      echo "<script>window.open('index.php','_self')</script>";
    }
  } else {
    echo "<script>alert('Password/Email Wrong')</script>";
  }
}
?>