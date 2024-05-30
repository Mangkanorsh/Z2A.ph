<!-- NAVBAR FOR index.php -->

<?php


$sql_pcat = "SELECT p_cat_id, p_cat_title FROM product_category";
$result_pcat = mysqli_query($con, $sql_pcat);

$product_categories = array();
if (mysqli_num_rows($result_pcat) > 0) {
    while ($row = mysqli_fetch_assoc($result_pcat)) {
        $product_categories[] = $row;
    }
}

$sql_cat = "SELECT cat_id, cat_title FROM categories";
$result_cat = mysqli_query($con, $sql_cat);

$categories = array();
if (mysqli_num_rows($result_cat) > 0) {
    while ($row = mysqli_fetch_assoc($result_cat)) {
        $categories[] = $row;
    }
}
?>

<nav class="navbar navbar-expand-lg sticky-top" id="navbar">
    <div class="container">
        <a class="navbar-brand" href="index.php" id="logo"><span>Z</span>2A</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
            <span><i class="fa-solid fa-bars"></i></span>
        </button>
        <div class="collapse navbar-collapse" id="mynavbar">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Home</a>
                </li>
                <li class="nav-item dropdown position-static">
                    <a class="nav-link dropdown-toggle" href="#" id="shopDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Shop
                    </a>
                    <ul class="dropdown-menu mega-menu w-100 p-4" aria-labelledby="shopDropdown">
                        <div class="container">
                            <div class="row">
                                <?php foreach ($product_categories as $product_category) : ?>
                                    <div class="col-md-3">
                                        <li>
                                            <a href="product.php?p_cat=<?php echo $product_category['p_cat_id']; ?>" class="nav-link px-4 text-dark ">
                                                <h6 class="dropdown-header px-3"><?php echo $product_category['p_cat_title']; ?></h6>
                                            </a>
                                        </li>
                                        <?php foreach ($categories as $category) : ?>
                                            <li>
                                                <a href="product.php?p_cat=<?php echo $product_category['p_cat_id']; ?>&cat_id=<?php echo $category['cat_id']; ?>" class="nav-link px-4 text-dark"><?php echo $category['cat_title']; ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endforeach; ?>
                                <div class="col-md-3">
                                    <li>
                                        <a href="product.php" class="nav-link px-4 text-dark">
                                            <h6 class="dropdown-header px-3">View all</h6>
                                        </a>
                                    </li>
                                </div>
                            </div>
                        </div>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact us</a>
                </li>
                <form class="d-flex">
                    <input class="form-control me-2" type="text" placeholder="Search">
                    <button class="btn btn-primary" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </ul>

        </div>
    </div>
</nav>