<!-- include("includes/header.php"); -->
<header>
        <div class="top-navbar">
            <div class="top-icons">
                <a href="#" class="text-white me-4">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="#" class="text-white me-4">
                    <i class="fa-brands fa-twitter"></i>
                </a>
                <a href="#" class="text-white me-4">
                    </i><i class="fa-brands fa-instagram"></i>
                </a>
            </div>
            <div class="other-links">
                <?php if ($isLoggedIn) : ?>

                    <div class="dropdown d-inline">
                        <button class="btn btn-white dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown" style="z-index: 9999;">
                            <li><span class="dropdown-item text-dark-lg me-4"><?php echo htmlspecialchars($_SESSION['customer_email']); ?></span></li>
                            <li><a class="dropdown-item" href="customer/my_account.php">Profile</a></li>
                            <li><a class="dropdown-item" href="customer/my_order.php">Orders</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </div>
                <?php else : ?>
                    <div class="dropdown d-inline">
                        <button class="btn btn-white dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown" style="z-index: 9999;">
                            <li><a class="dropdown-item" href="login.php">Login</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="signup.php">Sign up</a></li>
                        </ul>
                    </div>
                <?php endif; ?>
                <button type="button" class="btn btn-white position-relative" id="userDropdown">
                    <a href="cart.php"><i class="fas fa-shopping-cart"></i></a>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill text-bg-danger"><?php item(); ?> <span class="visually-hidden">unread messages</span></span>
                </button>
            </div>
        </div>

        <?php include("includes/navbar-all.php") ?>
    </header>