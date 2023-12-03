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

// text
$add_name = isset($_POST['add_name']) ? trim($_POST['add_name']) : "";
$add_brand = isset($_POST['brand']) ? trim($_POST['brand']) : "";
$add_price = isset($_POST['price']) ? $_POST['price'] : 0;
$add_color = isset($_POST['color']) ? trim($_POST['color']) : "";
$add_site = isset($_POST['site']) ? trim($_POST['site']) : "";
$add_description = isset($_POST['description']) ? trim($_POST['description']) : "";
$add_youtube_link = isset($_POST['youtube_link']) ? trim($_POST['youtube_link']) : "";

// radio
$add_rgb = isset($_POST['rgb']) ? $_POST['rgb'] : 0;

// select
$add_led_type = isset($_POST['led_type']) ? trim($_POST['led_type']) : "";
$add_size = isset($_POST['size']) ? trim($_POST['size']) : "";
$add_case_material = isset($_POST['case_material']) ? trim($_POST['case_material']) : "";

// checkboxes - done
$add_connectivity[] =+ isset($_POST['connectivity']) ? trim($_POST['connectivity']) : "";

// upload file - done
$add_image = isset($_POST['image']) ? trim($_POST['image']) : "";



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

    
    // KEYBOARD NAME
    $add_name = filter_var($add_name, FILTER_SANITIZE_STRING);
    $add_name = mysqli_real_escape_string($connection, $add_name);
    if (strlen($add_name) < 2 || strlen($add_name) > 30) {
        $proceed = false;
        $update_message .= "\n<p>Please enter a keyboard name that is between 2 and 30 characters in length.</p>";
    }

    // KEYBOARD BRAND
    $add_brand = filter_var($add_brand, FILTER_SANITIZE_STRING);
    $add_brand = mysqli_real_escape_string($connection, $add_brand);
    if (strlen($add_brand) < 2 || strlen($add_brand) > 30) {
        $proceed = false;
        $update_message .= "\n<p>Please enter a keyboard brand that is between 2 and 30 characters in length.</p>";
    }

    // KEYBOARD PRICE
    $add_price = filter_var($add_price, FILTER_SANITIZE_STRING);
    $add_price = mysqli_real_escape_string($connection, $add_price);
    if (strlen($add_price) < 2 || strlen($add_price) > 6) {
        $proceed = false;
        $update_message .= "\n<p>Please enter a keyboard price that is between 2 and 6 characters in length -- its not a corvette...</p>";
    }
    
    // KEYBOARD COLOR -- there can be multiple
    $add_color = filter_var($add_color, FILTER_SANITIZE_STRING);
    $add_color = mysqli_real_escape_string($connection, $add_color);
    if (strlen($add_color) < 2 || strlen($add_color) > 50) {
        $proceed = false;
        $update_message .= "\n<p>Please enter a keyboard color that is between 2 and 50 characters in length.</p>";
    }

    // KEYBOARD DESCRIPTION
    $add_description = filter_var($add_description, FILTER_SANITIZE_STRING);
    $add_description = mysqli_real_escape_string($connection, $add_description);
    if (strlen($add_description) < 2 || strlen($add_description) > 250) {
        $proceed = false;
        $update_message .= "\n<p>Please enter a description that is either less than 250 characters or more than 2.</p>";
    }

    // KEYBOARD SITE 
    $add_site = filter_var($add_site, FILTER_SANITIZE_STRING);
    $add_site = mysqli_real_escape_string($connection, $add_site);
    if (strlen($add_site) < 2 || strlen($add_site) > 250) {
        $proceed = false;
        $update_message .= "\n<p>Please enter a link that is either less than 250 characters or more than 2.</p>";
    }

    // KEYBOARD YOUTUBE
    $add_youtube_link = filter_var($add_youtube_link, FILTER_SANITIZE_STRING);
    $add_youtube_link = mysqli_real_escape_string($connection, $add_youtube_link);
    if (strlen($add_youtube_link) < 2 || strlen($add_youtube_link) > 250) {
        $proceed = false;
        $update_message .= "\n<p>That link is too long</p>";
    }

    // KEYBOARD RGB
    if ($add_rgb == 'null' || $add_rgb == "") {
        $proceed = false;
        $update_message .= "\n<p>Please verify backlighting.</p>";
    }

    // KEYBOARD LED_TYPE
    if ($add_led_type == '0') {
        $proceed = false;
        $update_message .= "\n<p>Please choose an led type.</p>";
    }

    // KEYBOARD CASE MATERIAL
    if ($add_case_material == 'select') {
        $proceed = false;
        $update_message .= "\n<p>Please choose a case material.</p>";
    }

    // KEYBOARD SIZE
    if ($add_size == 'select') {
        $proceed = false;
        $update_message .= "\n<p>Please choose a size.</p>";
    }

    // KEYBOARD CONNECTIVITY
    if ($add_connectivity == null || $add_connectivity == "") {
        $proceed = false;
        $update_message .= "\n<p>Please choose a how the keyboard connects.</p>";
    }



    if ($proceed == true) {
        insert_keyboard($add_name, $add_brand, $add_price, $add_rgb, $add_led_type, $add_description, $add_size, $add_connectivity, $add_case_material, $add_color, $add_image, $add_site, $add_youtube_link);
        $update_message = "<p>Keyboard added successfully</p>";
        $add_name = "";
        $add_brand = "";
        $add_price = "";
        $add_rgb = 0;
        $add_led_type = "";
        $add_description = "";
        $add_size = "";
        $add_connectivity = [];
        $add_case_material = "";
        $add_color = "";
        $add_site = "";
        $add_youtube_link = "";

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

        $add_image = "";
        
    } else {
        global $connection;
        $message = "<p>There was an issue: " . $connection->error . "</p>";
    }
}

#endregion

include("includes/header.php") ?> <!--***********************************-->


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
                hit "Add keyboard".</p>
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

                <!-- KEYBOARD NAME -->
                <div class="mb-3">
                    <label for="add_name" class="form-label fw-semibold">Attraction Name:</label>
                    <input type="text" id="add_name" name="add_name" class="form-control"
                        value="<?php echo isset($_POST['add_name']) ? $_POST['add_name'] : "" ?>">
                </div>

                <!-- KEYBOARD BRAND -->
                <div class="mb-3">
                    <label for="add_name" class="form-label fw-semibold">Attraction Name:</label>
                    <input type="text" id="add_name" name="add_name" class="form-control"
                        value="<?php echo isset($_POST['add_name']) ? $_POST['add_name'] : "" ?>">
                </div>

                <!-- KEYBOARD PRICE -->
                <div class="mb-3">
                    <label for="add_name" class="form-label fw-semibold">Attraction Name:</label>
                    <input type="text" id="add_name" name="add_name" class="form-control"
                        value="<?php echo isset($_POST['add_name']) ? $_POST['add_name'] : "" ?>">
                </div>

                <!-- KEYBOARD COLOR -->
                <div class="mb-3">
                    <label for="add_name" class="form-label fw-semibold">Attraction Name:</label>
                    <input type="text" id="add_name" name="add_name" class="form-control"
                        value="<?php echo isset($_POST['add_name']) ? $_POST['add_name'] : "" ?>">
                </div>

                <!-- LED TYPE -->
                <div class="mb-3">
                    <label for="new_category" class="form-label fw-semibold">Category:</label>
                    <select name="new_category" id="new_category" class="form-select">
                        <?php $categories =
                            [
                                'null' => 'Select Category',
                                'Shopping' => 'Shopping',
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

                <!-- KEYBOARD SIZE -->
                <div class="mb-3">
                    <label for="new_category" class="form-label fw-semibold">Category:</label>
                    <select name="new_category" id="new_category" class="form-select">
                        <?php $categories =
                            [
                                'null' => 'Select Category',
                                'Shopping' => 'Shopping',
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

                <!-- CASE MATERIAL -->
                <div class="mb-3">
                    <label for="new_category" class="form-label fw-semibold">Category:</label>
                    <select name="new_category" id="new_category" class="form-select">
                        <?php $categories =
                            [
                                'null' => 'Select Category',
                                'Shopping' => 'Shopping',
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

                <!-- KEYBOARD CONNECTIVITY -->
                <div class="form-check m-0 p-0">
                    <p class="fw-semibold mb-0 mt-3 ">Connectivity:</p>
                    <div class="ps-2 mb-3">
                        <div class="form-check m-0 ">
                        <input class="form-check-input" type="checkbox" value="1" name="new_family_friendly"
                            id="new_family_friendly" <?php echo ($new_family_friendly == 1) ? 'checked="checked"' : ""; ?>>
                            <label class="form-check-label" for="new_family_friendly">
                                Bluetooth
                            </label>
                        </div>
                        <div class="form-check m-0">
                            <input class="form-check-input" type="checkbox" value="1" name="new_family_friendly"
                                id="new_family_friendly" <?php echo ($new_family_friendly == 1) ? 'checked="checked"' : ""; ?>>
                            <label class="form-check-label" for="new_family_friendly">
                                Yes
                            </label>
                        </div>
                        <div class="form-check m-0">
                            <input class="form-check-input" type="checkbox" value="1" name="new_family_friendly"
                                id="new_family_friendly" <?php echo ($new_family_friendly == 1) ? 'checked="checked"' : ""; ?>>
                            <label class="form-check-label" for="new_family_friendly">
                                Yes
                            </label>
                        </div>
                    </div>
                </div>


                    <!-- DESCRIPTION -->
                    <div class="mb-3">
                        <label for="new_description" class="form-label fw-semibold">Description:</label>
                        <textarea name="new_description" class="form-control" id="new_description" cols="30" rows="4">
                        <?php echo isset($_POST['new_description']) ? $new_description : "" ?>
                    </textarea>
                    </div>

                    <!-- YOUTUBE LINK -->
                    <div class="mb-3">
                        <label for="new_description" class="form-label fw-semibold">Description:</label>
                        <textarea name="new_description" class="form-control" id="new_description" cols="30" rows="4">
                        <?php echo isset($_POST['new_description']) ? $new_description : "" ?>
                    </textarea>
                    </div>


                    <!-- RGB -->
                    <p class="fw-semibold mb-0 mt-3">Family Friendly:</p>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="1" name="new_family_friendly"
                            id="new_family_friendly" <?php echo ($new_family_friendly == 1) ? 'checked="checked"' : ""; ?>>
                        <label class="form-check-label" for="new_family_friendly">
                            Yes
                        </label>
                    </div>

                <!-- KEYBOARD CONNECTIVITY -->
                <div class="form-check m-0 p-0">
                    <p class="fw-semibold mb-0 mt-3 ">Cost:</p>
                    <div class="ps-2 mb-3">
                        <div class="form-check m-0 ">
                            <input class="form-check-input " value="free" type="check" name="new_cost" id="new_cost"
                                <?php echo ($new_cost == 'free') ? 'checked="checked"' : ""; ?>>
                            <label class="form-check-label" for="new_cost">
                                Bluetooth
                            </label>
                        </div>
                        <div class="form-check m-0">
                            <input class="form-check-input" value="$" type="radio" name="new_cost" id="new_cost"
                                <?php echo $new_cost == '$' ? 'checked="checked"' : ''; ?>>
                            <label class="form-check-label" for="new_cost">
                                2.4
                            </label>
                        </div>
                        <div class="form-check m-0">
                            <input class="form-check-input" value="$$" type="radio" name="new_cost" id="new_cost"
                                <?php echo ($new_cost == '$$') ? 'checked="checked"' : ''; ?>>
                            <label class="form-check-label" for="new_cost">
                                Wired
                            </label>
                        </div>
                    </div>
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