<?php
#region Imports

require_once("/home/rcasanova2/data/connect.php");
require_once("../private/prepared.php");

#endregion

#region Session
session_start();
if (isset($_SESSION['spiderman'])) {

} else {
    header("Location:login.php");
}

if (isset($_POST["logout"])) {

} else if (isset($_POST["home"])) { 
    session_destroy();
    header("Location:index.php");
}

#endregion

#region Variables

$add_brand = isset($_POST['brand']) ? trim($_POST['brand']) : "";
$add_rgb = isset($_POST['rgb']) ? $_POST['rgb'] : 0;
$add_led_type = isset($_POST['led_type']) ? trim($_POST['led_type']) : "";
$add_size = isset($_POST['size']) ? trim($_POST['size']) : "";
$add_price = isset($_POST['price']) ? $_POST['price'] : 0;
$add_connectivity = isset($_POST['connectivity']) ? trim($_POST['connectivity']) : "";
$add_name = isset($_POST['name']) ? trim($_POST['name']) : "";
$add_case_material = isset($_POST['case_material']) ? trim($_POST['case_material']) : "";
$add_color = isset($_POST['color']) ? trim($_POST['color']) : "";
$add_image = isset($_POST['image']) ? trim($_POST['image']) : "";
$add_site = isset($_POST['site']) ? trim($_POST['site']) : "";
$add_description = isset($_POST['description']) ? trim($_POST['description']) : "";
$add_youtube_link = isset($_POST['youtube_link']) ? trim($_POST['youtube_link']) : "";

#endregion

#region Validation & Configuration

if (isset($_POST["submit"])) {
    $update_message = ""; // cumulitave validation message
    $proceed = true; // Bool for whether validation has passed
    extract($_POST);


    // IMAGES
    if ($_FILES['myfile']['type'] != "image/jpeg") {
        $proceed = false;
        $update_message .= "<p>Not a JPG image.</p>";
    }
    if ($_FILES['myfile']['size'] > (4 * 1024 * 1024)) {
        $proceed = false;
        $update_message .= "<p>File is too large</p>";
    }

    // CATEGORY
    if ($add_category == 'null') {
        $proceed = false;
        $update_message .= "\n<p>Please choose a category.</p>";
    }

    // RATING
    if ($add_rating == '0') {
        $proceed = false;
        $update_message .= "\n<p>Please choose a rating.</p>";
    }

    // AREA OF TOWN
    if ($add_area_of_town == 'nowhere') {
        $proceed = false;
        $update_message .= "\n<p>Please choose an area of Edmonton.</p>";
    }

    // SEASON
    if ($new_season == 'construction') {
        $proceed = false;
        $update_message .= "\n<p>Please choose a season.</p>";
    }

    // DESCRIPTION
    $new_description = filter_var($new_description, FILTER_SANITIZE_STRING);
    $new_description = mysqli_real_escape_string($connection, $new_description);
    if (strlen($new_description) < 2 || strlen($new_description) > 500) {
        $proceed = false;
        $update_message .= "\n<p>Please enter a description that is either less than 500 characters or more than 2.</p>";
    }

    // ATTRACTION NAME
    $new_attraction_name = filter_var($new_attraction_name, FILTER_SANITIZE_STRING);
    $new_attraction_name = mysqli_real_escape_string($connection, $new_attraction_name);
    if (strlen($new_attraction_name) < 2 || strlen($new_attraction_name) > 30) {
        $proceed = false;
        $update_message .= "\n<p>Please enter an attraction name that is between 2 and 30 characters in length.</p>";
    }

    // URL
    if ($new_url) {
        $new_url = filter_var($new_url, FILTER_SANITIZE_URL);
        $url_arr = get_headers($new_url);
        $response = $url_arr[0];
        if (strpos($response, "200")) {
    
        } else {
            $proceed = false;
            $update_message .= "\n<p>URL INVALID: Please enter a URL that leads to a current site. If there is not site to be entered, lead the link back to the home page.</p>";
        }
    } else {
        $proceed = false;
        $update_message .= "\n<p>Please enter a URL.</p>";
    }


    // ADDRESS
    $new_address = filter_var($new_address, FILTER_SANITIZE_STRING);
    $new_address = mysqli_real_escape_string($connection, $new_address);
    if (strlen($new_address) < 2 || strlen($new_address) > 30) {
        $proceed = false;
        $update_message .= "\n<p>Please enter an address that is between 2 and 30 characters in length.</p>";
    }

    if ($proceed == true) {
        insert_attraction($new_attraction_name, $new_category, $new_cost, $new_address, $new_url, $new_description, $new_rating, $new_area_of_town, $new_family_friendly, $new_season);
        $message = "<p>Attraction added successfully</p>";
        $new_attraction_name = "";
        $new_category = "";
        $new_cost = "";
        $new_address = "";
        $new_url = "";
        $new_rating = "";
        $new_description = "";
        $new_area_of_town = "";
        $new_family_friendly = 0;
        $new_season = "";

        if (move_uploaded_file($_FILES['myfile']['tmp_name'], "_uploads/" . $_FILES['myfile']['name'])) {

            // grabing the source file (stored image)
            $thisFile = "_uploads/" . $_FILES['myfile']['name']; 


            // creating thumbnail for gallery
            $thisFolder = "_thumbs200/";
            $thisWidth = 200;
                // function call
            createSquareImageCopy($thisFile, $thisFolder, $thisWidth);

            // creating usable image for display page
            $thisFolder = "_display800/";
            $thisWidth = 800;
                 // function call
            createImageCopy($thisFile, $thisFolder, $thisWidth, 0);


            // adding image name to db
            $filename = $_FILES['myfile']['name'];
            mysqli_query($connection, "INSERT INTO keyboards(image) VALUES('$filename')");


            echo "<h3 class=\"alert alert-success\">Upload Successful</h3>";
        } else {
            echo "<h3 class=\"alert alert-danger\">ERROR" . $_FILES['myfile']['error'] . "</div>";
        }
        
    } else {
        global $connection;
        $message = "<p>There was an issue: " . $connection->error . "</p>";
    }
}

#endregion

include("includes/header.php") ?> <!--***********************************-->
<!-- On this add page I want the navigation to have a home button, and a button to go to the edit page
There shouldn't be a need for a delete navigation page, it should only be accessible from the edit page -->

<body class="container">
    <header class="mt-5">
        <nav class="mb-5 pb-5">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" class="">
            <input type="submit" class="btn btn-dark" name="home" value="Home">
            <a href="edit.php" class="btn btn-warning">Edit a Record</a>
            <input type="submit" class="btn btn-secondary" name="logout" value="Logout">
        </form>
        </nav>
        <div class="">
            <h1 class="fw-light text-center mt-5">Add An Attraction</h1>
            <p class="text-muted text-center  mb-5">To add a record to our database, simply fill out the form below and
                hit "Add Attraction".</p>
        </div>
        <?php if (isset($update_message)): ?>
            <div class="message text-danger">
                <?php echo $update_message; ?>
            </div>

        <?php endif; ?>
 
        <style type="text/css">
            .formstyle {
                /* optional: in case you don't like the really wide form */
                max-width: 700px;
            }
        </style>
    </header>
    <main class="container">
        <section class="justify-content-center row">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST"
                class="mb-5 formstyle col-lg-8 border border-primary p-4 mb-2 border-opacity-25 rounded" enctype="multipart/form-data">
                <?php if (isset($message)): ?>
                    <div class="alert alert-success">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <!-- FILE UPLOAD -->
                <div class="mb-3">
                    <label for="myfile" class="form-label">File</label>
                    <input type="file" class="form-control" id="myfile" name="myfile">
                </div>

                <!-- ATTRACTION NAME -->
                <div class="mb-3">
                    <label for="new_attraction_name" class="form-label fw-semibold">Attraction Name:</label>
                    <input type="text" id="new_attraction_name" name="new_attraction_name" class="form-control"
                        value="<?php echo isset($_POST['new_attraction_name']) ? $_POST['new_attraction_name'] : "" ?>">
                </div>

                <!-- CATEGORY -->
                <div class="mb-3">
                    <label for="new_category" class="form-label fw-semibold">Category:</label>
                    <select name="new_category" id="new_category" class="form-select">
                        <?php $categories =
                            [
                                'null' => 'Select Category',
                                'Shopping' => 'Shopping',
                                'Historical Buildings & Monuments' => 'Historical Buildings & Monuments',
                                'Parks & Natural Attractions' => 'Parks & Natural Attractions',
                                'Fine Arts' => 'Fine Arts',
                                'Science & Technology' => 'Science & Technology',
                                'Live Music & Theatre' => 'Live Music & Theatre',
                                'Recreational Facilities' => 'Recreational Facilities',
                                'Year-Round Attractions' => 'Year-Round Attractions',
                                'Restaurants & Food Vendors' => 'Restaurants & Food Vendors',
                                'Festivals' => 'Festivals'
                            ];

                        foreach ($categories as $key => $value) {
                            if ($new_category == $key) {
                                $selected = 'selected';
                            } else {
                                $selected = '';
                            }
                            echo "\n<option value=\"$key\" $selected>$value</option>";
                        }
                        ?>
                    </select>
                </div>


                <!-- COST -->
                <div class="form-check m-0 p-0">
                    <p class="fw-semibold mb-0 mt-3 ">Cost:</p>
                    <div class="ps-2 mb-3">
                        <div class="form-check m-0 ">
                            <input class="form-check-input " value="free" type="radio" name="new_cost" id="new_cost"
                                <?php echo ($new_cost == 'free') ? 'checked="checked"' : ""; ?>>
                            <label class="form-check-label" for="new_cost">
                                Free
                            </label>
                        </div>
                        <div class="form-check m-0">
                            <input class="form-check-input" value="$" type="radio" name="new_cost" id="new_cost"
                                <?php echo $new_cost == '$' ? 'checked="checked"' : ''; ?>>
                            <label class="form-check-label" for="new_cost">
                                $
                            </label>
                        </div>
                        <div class="form-check m-0">
                            <input class="form-check-input" value="$$" type="radio" name="new_cost" id="new_cost"
                                <?php echo ($new_cost == '$$') ? 'checked="checked"' : ''; ?>>
                            <label class="form-check-label" for="new_cost">
                                $$
                            </label>
                        </div>
                        <div class="form-check m-0">
                            <input class="form-check-input" value="$$$" type="radio" name="new_cost" id="new_cost"
                                <?php echo ($new_cost == '$$$') ? 'checked="checked"' : ''; ?>>
                            <label class="form-check-label" for="new_cost">
                                $$$
                            </label>
                        </div>
                    </div>
                </div>

                    <!-- ADDRESS -->
                    <div class="mb-3">
                        <label for="new_address" class="form-label fw-semibold">Address:</label>
                        <input type="text" id="new_address" name="new_address" class="form-control"
                            value="<?php echo isset($_POST['new_address']) ? $new_address : "" ?>">
                    </div>

                    <!-- WEBSITE -->
                    <div class="mb-3">
                        <label for="new_url" class="form-label fw-semibold">Website:</label>
                        <input type="text" id="new_url" name="new_url" class="form-control"
                            value="<?php echo isset($_POST['new_url']) ? $new_url : "" ?>">
                    </div>

                    <!-- DESCRIPTION -->
                    <div class="mb-3">
                        <label for="new_description" class="form-label fw-semibold">Description:</label>
                        <textarea name="new_description" class="form-control" id="new_description" cols="30" rows="4">
                        <?php echo isset($_POST['new_description']) ? $new_description : "" ?>
                    </textarea>
                    </div>

                    <!-- RATING -->
                    <div class="mb-3">
                        <label for="new_rating" class="form-label fw-semibold">Rating:</label>
                        <select name="new_rating" id="new_rating" class="form-select">
                            <?php $ratings =
                                [
                                    '0' => 'Select Rating',
                                    '1' => '1',
                                    '2' => '2',
                                    '3' => '3',
                                    '4' => '4',
                                    '5' => '5'
                                ];

                            foreach ($ratings as $key => $value) {
                                if ($new_rating == $key) {
                                    $selected = 'selected';
                                } else {
                                    $selected = '';
                                }
                                echo "\n<option value=\"$key\" $selected>$value</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- AREA OF TOWN -->
                    <div class="mb-3">
                        <label for="new_area" class="form-label fw-semibold">Area of Town:</label>
                        <select name="new_area" id="new_area" class="form-select">
                            <?php $areas =
                                [
                                    'nowhere' => 'Select Area',
                                    'West Edmonton' => 'West Edmonton',
                                    'Southwest Edmonton' => 'Southwest Edmonton',
                                    'Northwest Edmonton' => 'Northwest Edmonton',
                                    'Downtown' => 'Downtown',
                                    'East Edmonton' => 'East Edmonton',
                                    'Southeast Edmonton' => 'Southeast Edmonton',
                                    'Northeast Edmonton' => 'Northeast Edmonton',
                                    'Central Edmonton' => 'Central Edmonton',
                                    'South Central Edmonton' => 'South Central Edmonton',
                                    'North Central Edmonton' => 'North Central Edmonton',
                                    'South Edmonton' => 'South Edmonton',
                                    'North Edmonton' => 'North Edmonton',
                                    'University Area' => 'University Area',
                                    'Westmount' => 'Westmount',
                                    'Various' => 'Multiple Locations'
                                ];

                            foreach ($areas as $key => $value) {
                                if ($new_area_of_town == $key) {
                                    $selected = 'selected';
                                } else {
                                    $selected = '';
                                }
                                echo "\n<option value=\"$key\" $selected>$value</option>";
                            }
                            ?>
                        </select>
                    </div>


                    <!-- FAMILY FRIENDLY -->
                    <p class="fw-semibold mb-0 mt-3">Family Friendly:</p>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="1" name="new_family_friendly"
                            id="new_family_friendly" <?php echo ($new_family_friendly == 1) ? 'checked="checked"' : ""; ?>>
                        <label class="form-check-label" for="new_family_friendly">
                            Yes
                        </label>
                    </div>

                    <!-- SEASON -->
                    <div class="mb-3">
                        <label for="new_season" class="form-label fw-semibold">Season:</label>
                        <select name="new_season" id="new_season" class="form-select">
                            <?php $seasons =
                                [
                                    'construction' => 'Select Season',
                                    'Year-round' => 'Year-round',
                                    'Summer' => 'Summer',
                                    'Winter' => 'Winter'
                                ];

                            foreach ($seasons as $key => $value) {
                                if ($new_season == $key) {
                                    $selected = 'selected';
                                } else {
                                    $selected = '';
                                }
                                echo "\n<option value=\"$key\" $selected>$value</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Hidden Values -->
                    <input type="hidden" name="attraction_id" value="<?php echo $attraction_id; ?>">
                    <!-- Because we're storing our city id number in $_GET, we need to include it here again; otherwise, we may lose it when we submit the form and nothing will happen. -->

                    <!-- Submit -->
                    <input type="submit" value="Add New Attraction" name="submit" class="btn btn-success mt-3">
            </form>
        </section>
    </main>
    <?php include("includes/footer.php") ?>