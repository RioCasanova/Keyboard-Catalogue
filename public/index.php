<?php

#region App Info
//  ****************************************************************************************************
// Created By: Rio Casanova
// Purpose: CRUD SQL Configuration back-end for a front-end keyboard application
//          that displays keyboards to the users, and if an admin, can make 
//          changes to the database.
//
// Date Created: December 1, 2023
// Last Updated: December 1, 2023
// Created For: PHP Course @ NAIT
//
// Comments: Template was taken from a previous assignment and retrofitted for this 
//           assignment. The difference is that this assignment uses photo uploading 
//           functionality and thumbnails.
//  *******************************************************************************************************

#endregion

#region Imports

require_once("/home/rcasanova2/data/connect.php");
require_once("../private/prepared.php");

#endregion

#region Variables
$keyboard_id = isset($_GET['keyboard_id']) ? $_GET['keyboard_id'] : "";
if (isset($_GET['keyboard_id'])) {
    $keyboard_id = $_GET['keyboard_id'];
} elseif (isset($_POST['keyboard_id'])) {
    $keyboard_id = $_POST['keyboard_id'];
} else {
    $keyboard_id = "";
}
$brand = isset($_GET['brand']) ? $_GET['brand'] : "";
$rgb = isset($_GET['rgb']) ? $_GET['rgb'] : 0;
$led_type = isset($_GET['led_type']) ? $_GET['led_type'] : "";
$size = isset($_GET['size']) ? $_GET['size'] : "";
$price = isset($_GET['price']) ? $_GET['price'] : 0;
$connectivity = isset($_GET['connectivity']) ? $_GET['connectivity'] : "";

// Also attributes -- but will not be filtered by
$name = isset($_GET['name']) ? $_GET['name'] : "";
$case_material = isset($_GET['case_material']) ? $_GET['case_material'] : 0;
$color = isset($_GET['color']) ? $_GET['color'] : "";
$image = isset($_GET['image']) ? $_GET['image'] : "";
$site = isset($_GET['site']) ? $_GET['site'] : 0;
$description = isset($_GET['description']) ? $_GET['description'] : "";
$youtube_link = isset($_GET['$youtube_link']) ? $_GET['$youtube_link'] : "";
#endregion

include("includes/header.php") ?> <!--***********************************-->

<?php
session_start();

if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
    // Unset the message
    unset($_SESSION['message']);
}

// Rest of your code...
?>

<body class="container">
    <header class="mt-5">
        <nav class="mb-5 pb-5">
            <a href="index.php" class="btn btn-dark">Home</a>
            <a href="login.php" class="btn btn-success">Login</a>
        </nav>
        <div class="">
            <h1 class="fw-light text-center mt-5">Catalogue Template</h1>
            <p class="text-muted mb-4">This index page is here just so I can use it for reference and have a landing
                page to access my admin area</p>
            <p>Add Page: There is not much to say about this page it is pretty straight forward, it comes complete with
                error handling for each input.</p>
            <p class="mt-4">Display Page: A unique feature of this project is that when you click to view a particular
                item there is
                an embedded youtube video that pertains to the selected item.</p>
            <p>Edit Page: It didn't make sense in this context to be able to edit the name and brand of a keyboard
                including some other attributes of an already added keyboard.
                I made it so that you can only edit certain attributes that would make sense from a consumer
                perspective, like price, description, color, etc.
            </p>
            <p>Delete Page: There is no delete page, it is briefly visited to call a function and then it re-routes the
                user to the index page</p>
        </div>
    </header>
    <main>
        <section class="mb-4">

            <!-- Filter options here -->

            <!-- <h2 class="fw-bold mt-5 mb-3">Browse by:</h2>
            <div class="text-center">
                <button class="btn btn-outline-primary m-2">
                    <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?category=Shopping"
                        class="text-decoration-none text-reset">Brand</a>
                </button>
                <button class="btn btn-outline-secondary m-2">
                    <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?category=Historical%20Buildings%20%26%20Monuments"
                        class="text-decoration-none text-reset">
                        RGB</a>
                </button>
                <button class="btn btn-outline-success m-2">
                    <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?category=Parks%20%26%20Natural%20Attractions"
                        class="text-decoration-none text-reset">LED</a>
                </button>
                <button class="btn btn-outline-danger m-2">
                    <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?category=Fine%20Arts"
                        class="text-decoration-none text-reset">60%</a>
                </button>
                <button class="btn btn-outline-warning m-2">
                    <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?category=Science%20%26%20Technology"
                        class="text-decoration-none text-reset">65%</a>
                </button>
                <button class="btn btn-outline-info m-2">
                    <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?category=Live%20Music%20%26%20Theatre"
                        class="text-decoration-none text-reset">75%</a>
                </button>
                <button class="btn btn-outline-dark m-2">
                    <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?category=Recreational%20Facilities"
                        class="text-decoration-none text-reset">98%</a>
                </button>
                <button class="btn btn-outline-primary m-2">
                    <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?category=Year-Round%20Attractions"
                        class="text-decoration-none text-reset">Year-Round Attractions</a>
                </button>
                <button class="btn btn-outline-secondary m-2">
                    <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?category=Restaurants%20%26%20Food%20Vendors"
                        class="text-decoration-none text-reset">Restaurants & Food Vendors</a>
                </button>
                <button class="btn btn-outline-success m-2">
                    <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?category=Festivals"
                        class="text-decoration-none text-reset">Festivals</a>
                </button>
            </div> -->


            <!-- Display items -- Gallery -->
            <div>
                <?php
                // if (isset($_GET['category']) && !empty($_GET['category'])) {
                //     $attractions = filter_by_category();
                // } else {
                
                // }
                $keyboards = get_all_keyboards();
                ?>

                <div class="row row-cols-1 row-cols-md-3 g-4 mt-4">
                    <?php foreach ($keyboards as $x) { ?>
                        <div class="col card">
                            <img src="_thumbs200/<?php echo $x['image'] ?>" class="card-img-top mt-3"
                                alt="picture of keyboard">
                            <div class="card-body h-100">
                                <?php
                                echo "<h4 class=\"card-title\"><b>" . $x['name'] . "</b></h4>";
                                echo "<h5 class=\"text-muted card-text\">" . $x['brand'] . "</h5>";
                                echo "<p class=\"card-text\"><b>Cost: </b>" . $x['price'] . "</p>";
                                echo "<p class=\"card-text\"><b>RGB: </b>" . $x['rgb'] . "</p>";
                                echo "<p class=\"card-text\"><b>LED: </b>" . $x['led_type'] . "</p>";
                                echo "<p class=\"card-text\"><b>Size: </b>" . $x['size'] . "</p>";
                                echo "<p class=\"card-text\"><b>Connectivity: </b>" . $x['connectivity'] . "</p>";
                                echo "<p class=\"card-text\"><a href=\"display.php?keyboard_id=" . $x['keyboard_id'] . "\">View</a></p>";
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>
    </main>
    <?php include("includes/footer.php") ?>