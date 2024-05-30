<?php
session_start();
include("mysql/config.php");
include("functions/functions.php");
$isLoggedIn = isset($_SESSION['customer_email']);


if (isset($_GET['pro_id'])) {
    $pro_id = $_GET['pro_id'];
    $get_product = "SELECT * FROM products WHERE product_id='$pro_id'";
    $run_product = mysqli_query($con, $get_product);
    $row_product = mysqli_fetch_array($run_product);
    $p_cat_id = $row_product['p_cat_id'];
    $p_title = $row_product['product_title'];
    $p_price = $row_product['product_price'];
    $p_desc = $row_product['product_desc'];
    $p_img1 = $row_product['product_img1'];
    $p_img2 = $row_product['product_img2'];
    $p_img3 = $row_product['product_img3'];
    $get_p_cat = "SELECT * FROM product_category WHERE p_cat_id='$p_cat_id'";
    $run_p_cat = mysqli_query($con, $get_p_cat);
    $row_p_cat = mysqli_fetch_array($run_p_cat);
    $p_cat_title = $row_p_cat['p_cat_title'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $p_title ?> | Z2A</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<style>
    body {
        background-color: #f8f9fa;
        color: #212529;
    }

    .card {
        border: 1px solid #000;
        border-radius: 0;
    }

    .product-image {
        max-width: 100%;
        height: auto;
    }

    .quantity-control {
        display: flex;
        align-items: center;
        max-width: 150px;
        margin-bottom: 1rem;
    }

    .quantity-control input {
        text-align: center;
        border: 1px solid #000;
        border-left: none;
        border-right: none;
        width: 50px;
        height: 38px;
        color: #000;
    }

    .quantity-control button {
        border: 1px solid #000;
        background-color: #ffc107;
        color: #000;
        height: 38px;
        width: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .quantity-control button:hover {
        background-color: #e0a800;
    }

    .size-button {
        margin-right: 5px;
        border: 1px solid #000;
        background-color: #fff;
        color: #000;
    }

    .size-button.active {
        background-color: #ffc107;
        color: #000;
    }

    .size-button:hover {
        background-color: #e0a800;
        color: #000;
    }

    .btn-primary {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #000;
    }

    .btn-primary:hover {
        background-color: #e0a800;
        border-color: #e0a800;
    }

    .thumb img {
        border: 2px solid #ffeb3b;
    }

    .carousel-item img {
        width: 100%;
        height: 700px;

        object-fit: cover;
        /* fil cover contain Ensures the image covers the container without distortion */
    }
</style>
</head>

<body>
    <?php include("includes/header.php"); ?>


    <div class="container mt-5 mb-5">
        <div class="card">
            <div class="row g-0">
                <div class="col-md-6">
                    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="admin_area/product_images/<?php echo $p_img1 ?>" class="d-block w-100" alt="Product Image 1">
                            </div>
                            <div class="carousel-item">
                                <img src="admin_area/product_images/<?php echo $p_img2 ?>" class="d-block w-100" alt="Product Image 2">
                            </div>
                            <div class="carousel-item">
                                <img src="admin_area/product_images/<?php echo $p_img3 ?>" class="d-block w-100" alt="Product Image 3">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $p_title ?></h5>
                        <?php

                        addCart();
                        ?>
                        <p class="card-text">₱ <?php echo $p_price; ?></p>
                        <p class="card-text"><?php echo $p_desc ?></p>
                        <form action="details.php?add_cart=<?php echo $pro_id ?>" method="post">
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <div class="quantity-control">
                                    <button type="button" id="decrease-quantity">-</button>
                                    <input type="number" id="quantity" name="product_qty" value="1" min="1" oninput="this.value = Math.abs(this.value)">
                                    <button type="button" id="increase-quantity">+</button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Size</label>
                                <div>
                                    <button type="button" class="btn size-button" data-size="XS">XS</button>
                                    <button type="button" class="btn size-button" data-size="S">Small</button>
                                    <button type="button" class="btn size-button" data-size="M">Medium</button>
                                    <button type="button" class="btn size-button" data-size="L">Large</button>
                                    <button type="button" class="btn size-button" data-size="XL">XL</button>
                                    <button type="button" class="btn size-button" data-size="2XL">2XL</button>
                                    <button type="button" class="btn size-button" data-size="3XL">3XL</button>
                                </div>
                                <input type="hidden" id="selected-size" name="product_size" value="" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <h1 class='text-center'>You may also like</h1>
        <div class="container my-4">
            <div class="row">
                <?php mightLike() ?>
            </div>
        </div>
    </div>




    <?php include("includes/footer.php") ?>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        document.getElementById('increase-quantity').addEventListener('click', function() {
            var quantityInput = document.getElementById('quantity');
            quantityInput.value = parseInt(quantityInput.value) + 1;
        });

        document.getElementById('decrease-quantity').addEventListener('click', function() {
            var quantityInput = document.getElementById('quantity');
            if (quantityInput.value > 1) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
            }
        });

        document.querySelectorAll('.size-button').forEach(function(button) {
            button.addEventListener('click', function() {
                document.querySelectorAll('.size-button').forEach(function(btn) {
                    btn.classList.remove('active');
                });
                button.classList.add('active');
                document.getElementById('selected-size').value = button.getAttribute('data-size');
            });
        });
    </script>
</body>

</html>