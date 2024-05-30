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
    <title>Z2A | Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

<body>
    <?php include("includes/header.php"); ?>



    <!-- SLIDER -->
    <div class="slider mb-5">
        <!-- PHP to fetch and display sliders -->
        <?php
        $get_slider = "SELECT * FROM slider";
        $run_slider = mysqli_query($con, $get_slider);
        $slider_count = mysqli_num_rows($run_slider);
        $counter = 0;

        while ($row = mysqli_fetch_assoc($run_slider)) {
            $slider_name = $row['slider_name'];
            $slider_image = $row['slider_image'];
            $slider_url = $row['slider_url'];
            $counter++;
            echo "
        <div class='myslide fade' style='display: " . ($counter == 1 ? "block" : "none") . ";'>
        <a href=''><img src='admin_area/slider_images/$slider_image' alt='$slider_name' style='width: 100%; height: 100%;'></a>
        </div>";
        }
        ?>

        <!-- Navigation Arrows -->
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>

        <!-- Dots -->
        <div class="dotsbox" style="text-align:center">
            <?php for ($i = 1; $i <= $slider_count; $i++) : ?>
                <span class="dot" onclick="currentSlide(<?php echo $i; ?>)"></span>
            <?php endfor; ?>
        </div>
    </div>

    <!-- Banner -->

    <div class="container">
        <h1 class='text-center'>New Arrivals</h1>
        <div class="container my-4">
            <div class="row">
                <!-- Card  -->
                <?php getpro() ?>

            </div>
        </div>
    </div>

    <section id="1">
        <div class="container">
            <h1 class="text-center">Men</h1>
            <div class="container my-4">
                <div class="row">
                    <!-- Card  -->
                    <?php getMenpro() ?>

                </div>
            </div>
        </div>
    </section>

    <section id="2">
        <div class="container">
            <h1 class="text-center">Women</h1>
            <div class="container my-4">
                <div class="row">
                    <!-- Card  -->
                    <?php getWomenpro() ?>

                </div>
            </div>
        </div>
    </section>

    <section id="3">
        <div class="container">
            <h1 class="text-center">Kids' & Baby</h1>
            <div class="container my-4">
                <div class="row">
                    <!-- Card  -->
                    <?php getKidBabypro() ?>

                </div>
            </div>
        </div>
    </section>
    <script>
        const myslide = document.querySelectorAll('.myslide'),
            dot = document.querySelectorAll('.dot');
        let counter = 1;
        slidefun(counter);

        let timer = setInterval(autoSlide, 1500);

        function autoSlide() {
            counter += 1;
            slidefun(counter);
        }

        function plusSlides(n) {
            counter += n;
            slidefun(counter);
            resetTimer();
        }

        function currentSlide(n) {
            counter = n;
            slidefun(counter);
            resetTimer();
        }

        function resetTimer() {
            clearInterval(timer);
            timer = setInterval(autoSlide, 1000);
        }

        function slidefun(n) {
            let i;
            for (i = 0; i < myslide.length; i++) {
                myslide[i].style.display = "none";
            }
            for (i = 0; i < dot.length; i++) {
                dot[i].classList.remove('active');
            }
            if (n > myslide.length) {
                counter = 1;
            }
            if (n < 1) {
                counter = myslide.length;
            }
            myslide[counter - 1].style.display = "block";
            dot[counter - 1].classList.add('active');
        }
    </script>
    <?php include("includes/footer.php") ?>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>



</body>

</html>