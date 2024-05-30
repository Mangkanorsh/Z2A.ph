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
  <title>Products | Z2A</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">

<body>
  <?php include("includes/header.php"); ?>


  <!-- PUT YOUR SECTION HERE -->
  <section>
    <div class="container mt-5">
      <div class="row">
        <?php
        // Conditional logic to call specific functions
        if (isset($_GET['p_cat']) && isset($_GET['cat_id'])) {
          getSpecificProducts();
        } elseif (isset($_GET['p_cat'])) {
          getPcatPro();
        } elseif (isset($_GET['cat_id'])) {
          getCatPro();
        } else {
          // Default case: display all products with pagination
          $per_page = 8;
          $page = isset($_GET['page']) ? $_GET['page'] : 1;
          $start_from = ($page - 1) * $per_page;
          $get_product = "SELECT * FROM products ORDER BY 1 DESC LIMIT $start_from, $per_page";
          $run_pro = mysqli_query($con, $get_product);

          while ($row = mysqli_fetch_array($run_pro)) {
            $pro_id = $row['product_id'];
            $pro_title = $row['product_title'];
            $pro_price = $row['product_price'];
            $pro_img1 = $row['product_img1'];

            echo "<div class='col-md-4 col-lg-3 py-3'>
            <div class='card'>
              <img src='admin_area/product_images/$pro_img1' class='card-img-top' alt='$pro_title' style='width: 100%; height: 300px;'>
              <div class='card-body'>
                <h4 class='card-title text-truncate'>$pro_title</h4>
                <p class='card-text'>Price: ₱$pro_price</p>
                <a href='details.php?pro_id=$pro_id' class='btn btn-warning'>Add to Cart</a>
              </div>
            </div>
          </div>";
          }
        ?>
      </div>

      <nav>
        <ul class="pagination d-flex justify-content-center">
          <?php
          $query = "SELECT * FROM products";
          $result = mysqli_query($con, $query);
          $total_record = mysqli_num_rows($result);
          $total_pages = ceil($total_record / $per_page);
          echo "<li class='page-item'><a class='page-link' href='product.php?page=1'>First Page</a></li>";

          for ($i = 1; $i <= $total_pages; $i++) {
            echo "<li class='page-item'><a class='page-link' href='product.php?page=" . $i . "'>" . $i . "</a></li>";
          }

          echo "<li class='page-item'><a class='page-link' href='product.php?page=$total_pages'>Last Page</a></li>";
          ?>
        </ul>
      </nav>
    <?php
        }
    ?>
    </div>
    </div>
  </section>

  <!-- FOOTER -->
  <?php include("includes/footer.php") ?>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>



</body>

</html>