<!-- GOODS NA TO -->
<?php
session_start();
include("mysql/config.php");
$isLoggedIn = isset($_SESSION['customer_email']);
include("functions/functions.php");

if (isset($_POST['submit'])) {
    $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($con, $_POST['lastname']);
    $fullname = "$firstname $lastname";

    $address = mysqli_real_escape_string($con, $_POST['address']);
    $barangay = mysqli_real_escape_string($con, $_POST['barangay']);
    $postal_code = mysqli_real_escape_string($con, $_POST['postal_code']);
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $region = mysqli_real_escape_string($con, $_POST['region']);
    $country = mysqli_real_escape_string($con, $_POST['country']);

    $customer_full_address = "$address,$barangay,$postal_code,$city, $region,$country";

    $c_email = mysqli_real_escape_string($con, $_POST['c_email']);
    $c_password = mysqli_real_escape_string($con, $_POST['c_password']);
    $hashed_password = password_hash($c_password, PASSWORD_BCRYPT); // Hash the password
    $c_contact = mysqli_real_escape_string($con, $_POST['c_contact']);
    $c_image = $_FILES['c_image']['name'];
    $c_tmp_image = $_FILES['c_image']['tmp_name'];
    $c_ip = getUserIp();

    move_uploaded_file($c_tmp_image, "customer/customer_images/$c_image");

    $insert_customer = $con->prepare("INSERT INTO customers (customer_name, customer_email, customer_pass, customer_full_address, customer_contact, customer_image, customer_ip) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $insert_customer->bind_param("sssssss", $fullname, $c_email, $hashed_password, $customer_full_address, $c_contact, $c_image, $c_ip);

    if ($insert_customer->execute()) {
        $sel_cart = $con->prepare("SELECT * FROM cart WHERE ip_add = ?");
        $sel_cart->bind_param("s", $c_ip);
        $sel_cart->execute();
        $run_cart = $sel_cart->get_result();
        $check_cart = $run_cart->num_rows;

        $_SESSION['customer_email'] = $c_email;

        if ($check_cart > 0) {
            echo "<script>alert('You have been registered successfully');</script>";
            echo "<script>window.open('login.php', '_self');</script>";
        } else {
            echo "<script>alert('You have been registered successfully');</script>";
            echo "<script>window.open('index.php', '_self');</script>";
        }
    } else {
        echo "<script>alert('Registration failed, please try again');</script>";
    }

    $insert_customer->close();
    $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Z2A | Sign up</title>
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
            /* background: #ffa500; */
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
    


    <section class="container">
        <div class="form-container bg-dark text-dark">
            <h2 class="text-center mb-4 text-warning">Sign up</h2>
            <form action="signup.php" method="post" enctype="multipart/form-data">
                <div class="mb-4 form-floating">

                    <input type="email" class="form-control" id="email" placeholder="Enter your email" name="c_email" required>
                    <label for="email" class="form-label">Email</label>
                </div>

                <div class="mb-4 form-floating">
                    <select class="form-select" id="country" name="country" required>
                        <option selected="Philippines">Philippines</option>
                    </select>
                    <label for="country" class="form-label">Country</label>
                </div>


                <div class="row">
                    <div class="col">
                        <div class="mb-4 form-floating">

                            <input type="text" class="form-control" id="firstname" placeholder="First name" name="firstname" required>
                            <label for="firstname" class="form-label">First name</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-4 form-floating">

                            <input type="text" class="form-control" id="lastname" placeholder="Last name" name="lastname" required>
                            <label for="lastname" class="form-label">Last name</label>
                        </div>
                    </div>
                </div>

                <div class="mb-4 form-floating">
                    <input type="text" class="form-control" id="address" placeholder="Address" name="address" required>
                    <label for="address" class="form-label">Address</label>
                </div>
                <div class="mb-4 form-floating">
                    <input type="text" class="form-control" id="barangay" placeholder="Barangay" name="barangay" required>
                    <label for="barangay" class="form-label">Barangay</label>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="mb-4 form-floating">
                            <input type="text" class="form-control" id="postal-code" placeholder="postal-code" name="postal_code" required>
                            <label for="postal-code" class="form-label">Postal code</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-4 form-floating">
                            <input type="text" class="form-control" id="city" placeholder="Enter your city" name="city" required>
                            <label for="city" class="form-label">City</label>
                        </div>
                    </div>
                </div>
                <div class="mb-4 form-floating">
                    <select class="form-select" id="region" name="region" required>
                        <!-- List of Regions in the Philippines -->
                        <option value=""></option>
                        <option value="NCR">National Capital Region (NCR)</option>
                        <option value="CAR">Cordillera Administrative Region (CAR)</option>
                        <option value="I">Region I (Ilocos Region)</option>
                        <option value="II">Region II (Cagayan Valley)</option>
                        <option value="III">Region III (Central Luzon)</option>
                        <option value="IV-A">Region IV-A (CALABARZON)</option>
                        <option value="IV-B">Region IV-B (MIMAROPA)</option>
                        <option value="V">Region V (Bicol Region)</option>
                        <option value="VI">Region VI (Western Visayas)</option>
                        <option value="VII">Region VII (Central Visayas)</option>
                        <option value="VIII">Region VIII (Eastern Visayas)</option>
                        <option value="IX">Region IX (Zamboanga Peninsula)</option>
                        <option value="X">Region X (Northern Mindanao)</option>
                        <option value="XI">Region XI (Davao Region)</option>
                        <option value="XII">Region XII (SOCCSKSARGEN)</option>
                        <option value="XIII">Region XIII (Caraga)</option>
                        <option value="BARMM">Bangsamoro Autonomous Region in Muslim Mindanao (BARMM)</option>
                    </select>
                    <label for="region" class="form-label">Region</label>
                </div>

                <div class="mb-4 form-floating">
                    <input type="text" class="form-control" id="contact" placeholder="Enter your contact number" name="c_contact" required>
                    <label for="contact" class="form-label">Contact number</label>

                </div>

                <div class="mb-4 form-floating">

                    <input type="password" class="form-control" id="password" placeholder="Enter your password" aria-describedby="passwordHelpBlock" name="c_password" required>
                    <label for="password" class="form-label">Password</label>

                </div>
                <div class="mb-4">
                    <label for="image" class="form-label text-warning">Upload Image</label>
                    <input class="form-control" type="file" id="image" name="c_image">
                </div>
                <button type="submit" class="btn btn-primary mt-3 w-100 text-dark " name="submit">Sign up</button>
                <div class="center-text mb-5">
                    <span class="text-white">Already have an account?<a href="login.php" class="text-warning">Log in</a></span>
                </div>
            </form>
        </div>
    </section>

    <?php include("includes/footer.php") ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>