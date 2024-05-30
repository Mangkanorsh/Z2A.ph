
<?php
// include("../mysql/config.php");

// $db = mysqli_connect("localhost", "root", "", "e_comm");
//for getting user ip start
function getUserIp()
{
	switch (true) {
		case (!empty($_SERVER['HTTP_X_REAL_IP'])):
			return $_SERVER['HTTP_X_REAL_IP'];
		case (!empty($_SERVER['HTTP_CLIENT_IP'])):
			return $_SERVER['HTTP_CLIENT_IP'];
		case (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])):
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		default:
			return $_SERVER['REMOTE_ADDR'];
	}
}


function addCart()
{
	global $con;
	if (isset($_GET['add_cart'])) {
		$ip_add = getUserIp();
		$p_id = $_GET['add_cart'];
		$product_qty = $_POST['product_qty'];
		$product_size = $_POST['product_size'];
		$check_product = "select * from cart where ip_add='$ip_add' AND p_id='$p_id'";
		$run_check = mysqli_query($con, $check_product);
		if (mysqli_num_rows($run_check) > 0) {
			echo "<script>alert('This product is already added in your cart')</script>";
			echo "<script>window.open('cart.php?pro_id=$p_id','_self')</script>";
		} else {
			$query = "insert into cart(p_id,ip_add,qty,size ) values('$p_id','$ip_add','$product_qty','$product_size')";
			$run_query = mysqli_query($con, $query);
			echo "<script>window.open('cart.php?pro_id=$p_id','_self')</script>";
		}
	}
}
//items count start

function item()
{
	global $con;
	$ip_add = getUserIp();
	$get_items = "select * from cart where ip_add='$ip_add'";
	$run_item = mysqli_query($con, $get_items);
	$count = mysqli_num_rows($run_item);
	echo $count;
}

//items count End

//total price start

function totalPrice()
{
	global $con;
	$ip_add = getUserIp();
	$total = 0;
	$select_cat = "select * from cart where ip_add='$ip_add'";
	$run_cart = mysqli_query($con, $select_cat);
	while ($record = mysqli_fetch_array($run_cart)) {
		$pro_id = $record['p_id'];
		$pro_qty = $record['qty'];
		$get_price = "select * from products where product_id='$pro_id' ";
		$run_price = mysqli_query($con, $get_price);
		while ($row = mysqli_fetch_array($run_price)) {
			$sub_total = $row['product_price'] * $pro_qty;
			$total += $sub_total;
		}
	}
	echo $total;
}


//total price End
//for getting user ip start
function getPro()
{
	global $con;
	$get_product = "SELECT * FROM products ORDER by 1 DESC LIMIT 0,8";
	$run_products = mysqli_query($con, $get_product);
	while ($row_product = mysqli_fetch_array($run_products)) {
		$pro_id = $row_product['product_id']; // a href='details.php?pro_id=$pro_id
		$pro_title = $row_product['product_title']; //name
		$pro_price = $row_product['product_price']; // price
		$pro_img1 = $row_product['product_img1']; // image


		echo "
		<div class='col-md-4 col-lg-3 py-3'>
			<div class='card'>
				<img src='admin_area/product_images/$pro_img1' class='card-img-top' alt='$pro_title' style='width: 100%; height: 300px	;'>
				<div class='card-body'>
					<h4 class='card-title text-truncate'>$pro_title</h4>
					<p class='card-text'>Price: ₱$pro_price</p>
					<a href='details.php?pro_id=$pro_id' class='btn btn-warning'>Add to Cart</a>
				</div>
			</div>
		</div>
		";
	}
}

//product images start



function getMenPro()
{
	global $con;
	$get_product = "SELECT * FROM products WHERE p_cat_id = 1 LIMIT 0,12;";
	$run_products = mysqli_query($con, $get_product);
	while ($row_product = mysqli_fetch_array($run_products)) {
		$pro_id = $row_product['product_id']; // a href='details.php?pro_id=$pro_id
		$pro_title = $row_product['product_title']; //name
		$pro_price = $row_product['product_price']; // price
		$pro_img1 = $row_product['product_img1']; // image
		echo "
		<div class='col-md-4 col-lg-3 py-3'>
			<div class='card'>
				<img src='admin_area/product_images/$pro_img1' class='card-img-top' alt='$pro_title' style='width: 100%; height: 300px;'>
				<div class='card-body'>
					<h4 class='card-title text-truncate'>$pro_title</h4>
					<p class='card-text'>Price: ₱$pro_price</p>
					<a href='details.php?pro_id=$pro_id' class='btn btn-warning'>Add to Cart</a>
				</div>
			</div>
		</div>
		";
	}
}

function getWomenPro()
{
	global $con;
	$get_product = "SELECT * FROM products WHERE p_cat_id = 2 LIMIT 0,12;";
	$run_products = mysqli_query($con, $get_product);
	while ($row_product = mysqli_fetch_array($run_products)) {
		$pro_id = $row_product['product_id']; // a href='details.php?pro_id=$pro_id
		$pro_title = $row_product['product_title']; //name
		$pro_price = $row_product['product_price']; // price
		$pro_img1 = $row_product['product_img1']; // image
		echo "
		<div class='col-md-4 col-lg-3 py-3'>
			<div class='card'>
				<img src='admin_area/product_images/$pro_img1' class='card-img-top' alt='$pro_title' style='width: 100%; height: 300px;'>
				<div class='card-body'>
					<h4 class='card-title text-truncate'>$pro_title</h4>
					<p class='card-text'>Price: ₱$pro_price</p>
					<a href='details.php?pro_id=$pro_id' class='btn btn-warning'>Add to Cart</a>
				</div>
			</div>
		</div>
		";
	}
}

function getKidBabyPro()
{
	global $con;
	$get_product = "SELECT * FROM products WHERE p_cat_id = 3 LIMIT 0,12;";
	$run_products = mysqli_query($con, $get_product);
	while ($row_product = mysqli_fetch_array($run_products)) {
		$pro_id = $row_product['product_id']; // a href='details.php?pro_id=$pro_id
		$pro_title = $row_product['product_title']; //name
		$pro_price = $row_product['product_price']; // price
		$pro_img1 = $row_product['product_img1']; // image
		echo "
		<div class='col-md-4 col-lg-3 py-3'>
			<div class='card'>
				<img src='admin_area/product_images/$pro_img1' class='card-img-top' alt='$pro_title' style='width: 100%; height: 300px;'>
				<div class='card-body'>
					<h4 class='card-title text-truncate'>$pro_title</h4>
					<p class='card-text'>Price: ₱$pro_price</p>
					<a href='details.php?pro_id=$pro_id' class='btn btn-warning'>Add to Cart</a>
				</div>
			</div>
		</div>
		";
	}
}


/* product Categories */

function getPCats()
{
	global $con;
	$get_p_cats = "select * from product_category";
	$run_p_cats = mysqli_query($con, $get_p_cats);
	while ($row_p_cats = mysqli_fetch_array($run_p_cats)) {
		$p_cat_id = $row_p_cats['p_cat_id'];
		$p_cat_title = $row_p_cats['p_cat_title'];
		echo "<li><a href='product.php?p_cat=$p_cat_id'>$p_cat_title</a></li>";
	}
}

/* Categories */

function getCat()
{
	global $con;
	$get_cat = "select * from categories";
	$run_cat = mysqli_query($con, $get_cat);
	while ($row_cat = mysqli_fetch_array($run_cat)) {
		$cat_id = $row_cat['cat_id'];
		$cat_title = $row_cat['cat_title'];
		echo "<li><a href='product.php?cat_id=$cat_id'>$cat_title</a></li>";
	}
}

function getPcatPro()
{

	global $con;
	if (isset($_GET['p_cat'])) {
        $p_cat_id = $_GET['p_cat'];
        $get_p_cat = "select * from product_category where p_cat_id='$p_cat_id' ";
        $run_p_cat = mysqli_query($con, $get_p_cat);
        $row_p_cat = mysqli_fetch_array($run_p_cat);
        $p_cat_title = $row_p_cat['p_cat_title'];


		$get_products = "select * from products where p_cat_id='$p_cat_id'";
		$run_products = mysqli_query($con, $get_products);
		$count = mysqli_num_rows($run_products);
		if ($count == 0) {
			echo "<h1 class='text-center'>No product found in this category</h1>";
		} else {
			echo "<h1 class='text-center'>$p_cat_title</h1>";
		}
		while ($row_products = mysqli_fetch_array($run_products)) {

			$pro_id = $row_products['product_id'];
			$pro_title = $row_products['product_title'];
			$pro_price = $row_products['product_price'];
			$pro_img1 = $row_products['product_img1'];

			echo "
			<div class='col-md-4 col-lg-3 py-3'>
			<div class='card'>
				<img src='admin_area/product_images/$pro_img1' class='card-img-top' alt='$pro_title' style='width: 100%; height: 300px;'>
				<div class='card-body'>
					<h4 class='card-title text-truncate'>$pro_title</h4>
					<p class='card-text'>Price: ₱$pro_price</p>
					<a href='details.php?pro_id=$pro_id' class='btn btn-warning'>Add to Cart</a>
				</div>
			</div>
		</div>
			";
		}
	}
}

/*Get Categories */

function getCatPro()
{
	global $con;
	if (isset($_GET['cat_id'])) {
		$cat_id = $_GET['cat_id'];
		$get_cat = "select * from categories where cat_id='$cat_id'";
		$run_cats = mysqli_query($con, $get_cat);
		$row_cat = mysqli_fetch_array($run_cats);
		$cat_title = $row_cat['cat_title'];

		$get_products = "select * from products where cat_id='$cat_id'";
		$run_products = mysqli_query($con, $get_products);
		$count = mysqli_num_rows($run_products);
		if ($count == 0) {

			echo "<h1 class='text-center'>No product found in this category</h1>";
		} else {
			echo "<h1 class='text-center'>$cat_title</h1>";
		}
		while ($row_products = mysqli_fetch_array($run_products)) {

			$pro_id = $row_products['product_id'];
			$pro_title = $row_products['product_title'];
			$pro_price = $row_products['product_price'];
			$pro_img1 = $row_products['product_img1'];

			echo "
			<div class='col-md-4 col-lg-3 py-3'>
			<div class='card'>
				<img src='admin_area/product_images/$pro_img1' class='card-img-top' alt='$pro_title' style='width: 100%; height: 300px;'>
				<div class='card-body'>
					<h4 class='card-title text-truncate'>$pro_title</h4>
					<p class='card-text'>Price: ₱$pro_price</p>
					<a href='details.php?pro_id=$pro_id' class='btn btn-warning'>Add to Cart</a>
				</div>
			</div>
		</div>
			";
		}
	}
}

function getSpecificProducts()
{
    global $con;
    if (isset($_GET['p_cat']) && isset($_GET['cat_id'])) {
        $p_cat_id = $_GET['p_cat']; // ID in the product_category table
        $cat_id = $_GET['cat_id'];  // ID in the categories table

        // Fetch the category titles for display purposes
        $get_p_cat = "SELECT p_cat_title FROM product_category WHERE p_cat_id='$p_cat_id'";
        $run_p_cat = mysqli_query($con, $get_p_cat);
        $row_p_cat = mysqli_fetch_array($run_p_cat);
        $p_cat_title = $row_p_cat['p_cat_title'];

        $get_cat = "SELECT cat_title FROM categories WHERE cat_id='$cat_id'";
        $run_cat = mysqli_query($con, $get_cat);
        $row_cat = mysqli_fetch_array($run_cat);
        $cat_title = $row_cat['cat_title'];

        // Fetch products that match both the "Men" product category and the "Tops" category
        $get_products = "SELECT * FROM products WHERE p_cat_id='$p_cat_id' AND cat_id='$cat_id'";
        $run_products = mysqli_query($con, $get_products);
        $count = mysqli_num_rows($run_products);

        if ($count == 0) {
            echo "<h1 class='text-center'>No products found in this category</h1>";
        } else {
            echo "<h1 class='text-center'>$p_cat_title - $cat_title</h1>";
        }

        while ($row_products = mysqli_fetch_array($run_products)) {
            $pro_id = $row_products['product_id'];
            $pro_title = $row_products['product_title'];
            $pro_price = $row_products['product_price'];
            $pro_img1 = $row_products['product_img1'];

            echo "
            <div class='col-md-4 col-lg-3 py-3'>
            <div class='card'>
                <img src='admin_area/product_images/$pro_img1' class='card-img-top' alt='$pro_title' style='width: 100%; height: 300px;'>
                <div class='card-body'>
                    <h4 class='card-title text-truncate'>$pro_title</h4>
                    <p class='card-text'>Price: ₱$pro_price</p>
                    <a href='details.php?pro_id=$pro_id' class='btn btn-warning'>Add to Cart</a>
                </div>
            </div>
            </div>
            ";
        }
    }
}




function mightLike()
{
	global $con;
	if (isset($_GET['pro_id'])){
		$pro_id = $_GET['pro_id'];
		$get_product = "SELECT * FROM products WHERE product_id NOT IN ('$pro_id') ORDER BY RAND() LIMIT 12";
		$run_product = mysqli_query($con, $get_product);
		while ($row_product = mysqli_fetch_array($run_product)) {
			$pro_id = $row_product['product_id']; // a href='details.php?pro_id=$pro_id
			$pro_title = $row_product['product_title']; //name
			$pro_price = $row_product['product_price']; // price
			$pro_img1 = $row_product['product_img1']; // image
			echo "
			<div class='col-md-4 col-lg-3 py-3'>
				<div class='card'>
					<img src='admin_area/product_images/$pro_img1' class='card-img-top' alt='$pro_title' style='width: 100%; height: 300px;'>
					<div class='card-body'>
						<h4 class='card-title text-truncate'>$pro_title</h4>
						<p class='card-text'>Price: ₱$pro_price</p>
						<a href='details.php?pro_id=$pro_id' class='btn btn-warning'>Add to Cart</a>
					</div>
				</div>
			</div>
			";
		}


	}
}

?>
 





        