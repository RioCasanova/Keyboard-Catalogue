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
$add_brand = isset($_POST['add_brand']) ? trim($_POST['add_brand']) : "";
$add_price = isset($_POST['add_price']) ? $_POST['add_price'] : 0;
$add_color = isset($_POST['add_color']) ? trim($_POST['add_color']) : "";
$add_site = isset($_POST['add_site']) ? trim($_POST['add_site']) : "";
$add_description = isset($_POST['add_description']) ? trim($_POST['add_description']) : "";
$add_youtube_link = isset($_POST['add_youtube_link']) ? trim($_POST['add_youtube_link']) : "";

// radio
$add_rgb = isset($_POST['add_rgb']) ? $_POST['add_rgb'] : null;

// select
$add_led_type = isset($_POST['add_led_type']) ? trim($_POST['add_led_type']) : "";
$add_size = isset($_POST['add_size']) ? trim($_POST['add_size']) : "";
$add_case_material = isset($_POST['add_case_material']) ? trim($_POST['add_case_material']) : "";

// checkboxes - done
$add_connectivity = isset($_POST['add_connectivity']) ? $_POST['add_connectivity'] : [];

// upload file - done
$add_image = isset($_POST['add_image']) ? trim($_POST['add_image']) : "";

#endregion


#region Validation & Configuration

if (isset($_POST["submit"])) {
    $update_message = ""; // cumulitave validation message
    $proceed = true; // Bool for whether validation has passed
    extract($_POST);


    // KEYBOARD NAME
    $add_name = filter_var($add_name, FILTER_SANITIZE_STRING);
    $add_name = mysqli_real_escape_string($connection, $add_name);
    if (strlen($add_name) < 2 || strlen($add_name) > 30) {
        $proceed = false;
        $update_message .= "\n<p>Error: Keyboard Name Invalid -- see 'Model/Name'</p>";
        $message_name = "<p class=\"text-danger m-0\">Model/Name is a required field under 30 characters</p>";
    }

    // KEYBOARD BRAND
    $add_brand = filter_var($add_brand, FILTER_SANITIZE_STRING);
    $add_brand = mysqli_real_escape_string($connection, $add_brand);
    if (strlen($add_brand) < 2 || strlen($add_brand) > 30) {
        $proceed = false;
        $update_message .= "\n<p>Error: Keyboard Brand Invalid -- see 'Brand'</p>";
        $message_brand = "<p class=\"text-danger m-0\">Brand is a required field under 30 characters</p>";
    }

    // KEYBOARD PRICE
    $add_price = filter_var($add_price, FILTER_SANITIZE_STRING);
    $add_price = mysqli_real_escape_string($connection, $add_price);
    if (strlen($add_price) < 2 || strlen($add_price) > 50) {
        $proceed = false;
        $update_message .= "\n<p>Error: Keyboard Price Invalid -- see 'Price'</p>";
        $message_price = "<p class=\"text-danger m-0\">Price is a required field under 30 characters</p>";
    }

    // KEYBOARD COLOR -- there can be multiple
    $add_color = filter_var($add_color, FILTER_SANITIZE_STRING);
    $add_color = mysqli_real_escape_string($connection, $add_color);
    if (strlen($add_color) < 2 || strlen($add_color) > 50) {
        $proceed = false;
        $update_message .= "\n<p>Error: Keyboard Color(s) Invalid -- see 'Color(s)'</p>";
        $message_color = "<p class=\"text-danger m-0\">Color is a required field under 30 characters</p>";
    }

    // KEYBOARD DESCRIPTION
    $add_description = filter_var($add_description, FILTER_SANITIZE_STRING);
    $add_description = mysqli_real_escape_string($connection, $add_description);
    if (strlen($add_description) < 2 || strlen($add_description) > 250) {
        $proceed = false;
        $update_message .= "\n<p>Error: Keyboard Description Invalid -- see 'Description'</p>";
        $message_description = "<p class=\"text-danger m-0\">Description is a required field under 250 characters</p>";
    }

    // KEYBOARD SITE 
    $add_site = filter_var($add_site, FILTER_SANITIZE_STRING);
    $add_site = mysqli_real_escape_string($connection, $add_site);
    if (strlen($add_site) < 2 || strlen($add_site) > 250) {
        $proceed = false;
        $update_message .= "\n<p>Error: Keyboard Purchase Site Invalid -- see 'Site'</p>";
        $message_site = "<p class=\"text-danger m-0\">Purchase Site is a required field under 250 characters</p>";
    }

    // KEYBOARD YOUTUBE
    $add_youtube_link = filter_var($add_youtube_link, FILTER_SANITIZE_STRING);
    $add_youtube_link = mysqli_real_escape_string($connection, $add_youtube_link);
    if (strlen($add_youtube_link) < 2 || strlen($add_youtube_link) > 800) {
        $proceed = false;
        $update_message .= "\n<p>Error: Keyboard Youtube Link Invalid -- see 'Youtube Link'</p>";
        $message_youtube_link = "<p class=\"text-danger m-0\">YouTube Link is a required field under 800 characters</p>";
    }

    // KEYBOARD RGB
    if ($add_rgb == null) {
        $proceed = false;
        $update_message .= "\n<p>Error: Keyboard RGB is a required field</p>";
        $message_rgb = "<p class=\"text-danger m-0\">Backlight specification is a required field</p>";
    }

    // KEYBOARD LED_TYPE
    if ($add_led_type == 'select') {
        $proceed = false;
        $update_message .= "\n<p>Error: Keyboard LED Type is a required field</p>";
        $message_led_type = "<p class=\"text-danger m-0\">LED Type is a required field</p>";
    }

    // KEYBOARD CASE MATERIAL
    if ($add_case_material == 'select') {
        $proceed = false;
        $update_message .= "\n<p>Error: Keyboard Case Material is a required field</p>";
        $message_case_material = "<p class=\"text-danger m-0\">Case Material is a required field</p>";
    }

    // KEYBOARD SIZE
    if ($add_size == 'select') {
        $proceed = false;
        $update_message .= "\n<p>Error: Keyboard Size is a required field</p>";
        $message_size = "<p class=\"text-danger m-0\">Keyboard Size is a required field</p>";
    }

    // KEYBOARD CONNECTIVITY
    if ($add_connectivity == null || $add_connectivity == "") {
        $proceed = false;
        $update_message .= "\n<p>Error: Keyboard Connectivity is a required field</p>";
        $message_connectivity = "<p class=\"text-danger m-0\">Connectivity is a required field</p>";
    }

    // IMAGES
    if ($_FILES['myfile']['type'] != "image/jpeg") {
        $proceed = false;
        $update_message .= "<p>Error: JPG Image Requried -- see 'File'</p>";
        $message_image = "<p class=\"text-danger m-0\">JPG image upload is required</p>";
    }
    if ($_FILES['myfile']['size'] > (4 * 1024 * 1024)) {
        $proceed = false;
        $update_message .= "<p>Error: File is too large -- see 'File'</p>";
    }
    // After form submission logic
    if ($proceed == false) {
        // Store the filename for later use
        $uploadedFilename = $_FILES['myfile']['name'];
    }
}
#endregion


#region Success
if (isset($_POST["submit"])) {
    if ($proceed == true) {
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


            // calling the insert statement with the information
            $filename = $_FILES['myfile']['name'];
            $connectivityString = implode(', ', $add_connectivity);
            insert_keyboard($add_name, $add_brand, $add_price, $add_rgb, $add_led_type, $add_description, $add_size, $connectivityString, $add_case_material, $add_color, $filename, $add_site, $add_youtube_link);

            // displaying text to user and clearing the form inputs
            $success_message = "<p>Keyboard added successfully</p>";
            $_POST['add_name'] = "";
            $_POST['add_brand'] = "";
            $_POST['add_price'] = "";
            $_POST['add_color'] = "";
            $_POST['add_led_type'] = "";
            $_POST['add_description'] = "";
            $_POST['add_size'] = "";
            $_POST['add_connectivity'] = [];
            $_POST['add_case_material'] = "";
            $_POST['add_site'] = "";
            $_POST['add_youtube_link'] = "";
            $_POST['add_image'] = "";
            $_POST['add_rgb'] = null;

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
            <h1 class="fw-light text-center mt-5">Add a Keyboard</h1>
            <p class="text-muted text-center  mb-5">To add a record to our database, simply fill out the form below and
                hit "Add keyboard".</p>
        </div>
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
                class="mb-5 formstyle col-lg-8 border border-primary p-4 mb-2 border-opacity-25 rounded"
                enctype="multipart/form-data">
                <?php if (isset($message)): ?>
                    <div class="alert alert-danger">
                        <?php echo $message; ?>
                        <?php echo $update_message; ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($success_message)): ?>
                    <div class="alert alert-success">
                        <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>

                <!-- KEYBOARD NAME -->
                <div class="mb-3">
                    <label for="add_name" class="form-label fw-semibold">Model/Name</label>
                    <?php if (isset($message_name)): ?>
                        <?php echo $message_name; ?>
                    <?php endif; ?>
                    <input type="text" id="add_name" name="add_name" class="form-control"
                        value="<?php echo isset($_POST['add_name']) ? $_POST['add_name'] : "" ?>">
                </div>

                <!-- KEYBOARD BRAND -->
                <div class="mb-3">
                    <label for="add_brand" class="form-label fw-semibold">Brand</label>
                    <?php if (isset($message_brand)): ?>
                        <?php echo $message_brand; ?>
                    <?php endif; ?>
                    <input type="text" id="add_brand" name="add_brand" class="form-control"
                        value="<?php echo isset($_POST['add_brand']) ? $_POST['add_brand'] : "" ?>">
                </div>

                <!-- KEYBOARD PRICE -->
                <div class="mb-3">
                    <label for="add_price" class="form-label fw-semibold">Price</label>
                    <?php if (isset($message_price)): ?>
                        <?php echo $message_price; ?>
                    <?php endif; ?>
                    <input type="text" id="add_price" name="add_price" class="form-control"
                        value="<?php echo isset($_POST['add_price']) ? $_POST['add_price'] : "" ?>">
                </div>

                <!-- KEYBOARD COLOR -->
                <div class="mb-3">
                    <label for="add_color" class="form-label fw-semibold">Color</label>
                    <?php if (isset($message_color)): ?>
                        <?php echo $message_color; ?>
                    <?php endif; ?>
                    <input type="text" id="add_color" name="add_color" class="form-control"
                        value="<?php echo isset($_POST['add_color']) ? $_POST['add_color'] : "" ?>">
                </div>

                <!-- LED TYPE -->
                <div class="mb-3">
                    <label for="add_led_type" class="form-label fw-semibold">LED Type</label>
                    <?php if (isset($message_led_type)): ?>
                        <?php echo $message_led_type; ?>
                    <?php endif; ?>
                    <select name="add_led_type" id="add_led_type" class="form-select">
                        <?php $led_types =
                            [
                                'select' => 'Select LED',
                                'south' => 'South-Facing',
                                'north' => 'North-Facing'
                            ];

                        foreach ($led_types as $key => $value) {
                            if ($add_led_type == $key) {
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
                    <label for="add_size" class="form-label fw-semibold">Size</label>
                    <?php if (isset($message_size)): ?>
                        <?php echo $message_size; ?>
                    <?php endif; ?>
                    <select name="add_size" id="add_size" class="form-select">
                        <?php $sizes =
                            [
                                'select' => 'Select Size',
                                '60%' => '60%',
                                '65%' => '65%',
                                '75%' => '75%',
                                '98%' => '98%',
                                'other' => 'Other'
                            ];

                        foreach ($sizes as $key => $value) {
                            if ($add_size == $key) {
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
                    <label for="add_case_material" class="form-label fw-semibold">Case Material</label>
                    <?php if (isset($message_case_material)): ?>
                        <?php echo $message_case_material; ?>
                    <?php endif; ?>
                    <select name="add_case_material" id="add_case_material" class="form-select">
                        <?php $materials =
                            [
                                'select' => 'Select Material...',
                                'aluminum' => 'Aluminum',
                                'plastic' => 'Plastic',
                                'wood' => 'Wood'
                            ];

                        foreach ($materials as $key => $value) {
                            if ($add_case_material == $key) {
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
                    <p class="fw-semibold mb-0 mt-3 ">Connectivity</p>
                    <?php if (isset($message_connectivity)): ?>
                        <?php echo $message_connectivity; ?>
                    <?php endif; ?>
                    <div class="ps-2 mb-3">
                        <div class="form-check m-0 ">
                            <input class="form-check-input" type="checkbox" value="bluetooth" name="add_connectivity[]"
                                id="bluetooth" <?php echo (in_array('bluetooth', $add_connectivity)) ? 'checked="checked"' : ''; ?>>
                            <label class="form-check-label" for="add_connectivity">
                                Bluetooth
                            </label>
                        </div>
                        <div class="form-check m-0">
                            <input class="form-check-input" type="checkbox" value="dongle" name="add_connectivity[]"
                                id="dongle" <?php echo (in_array('dongle', $add_connectivity)) ? 'checked="checked"' : ''; ?>>
                            <label class="form-check-label" for="add_connectivity">
                                2.4
                            </label>
                        </div>
                        <div class="form-check m-0">
                            <input class="form-check-input" type="checkbox" value="wired" name="add_connectivity[]"
                                id="wired" <?php echo (in_array('wired', $add_connectivity)) ? 'checked="checked"' : ''; ?>>
                            <label class="form-check-label" for="add_connectivity">
                                Wired
                            </label>
                        </div>
                    </div>
                </div>


                <!-- DESCRIPTION -->
                <div class="mb-3">
                    <label for="add_description" class="form-label fw-semibold">Description</label>
                    <?php if (isset($message_description)): ?>
                        <?php echo $message_description; ?>
                    <?php endif; ?>
                    <textarea name="add_description" class="form-control" id="add_description" cols="30"
                        rows="4"><?php echo trim(isset($_POST['add_description']) ? $add_description : "") ?></textarea>
                </div>

                <!-- YOUTUBE LINK -->
                <div class="mb-3">
                    <label for="add_youtube_link" class="form-label fw-semibold">Youtube Link</label>
                    <?php if (isset($message_youtube_link)): ?>
                        <?php echo $message_youtube_link; ?>
                    <?php endif; ?>
                    <input type="text" id="add_youtube_link" name="add_youtube_link" class="form-control"
                        value="<?php echo isset($_POST['add_youtube_link']) ? $_POST['add_youtube_link'] : "" ?>">
                </div>



                <!-- SITE -->
                <div class="mb-3">
                    <label for="add_site" class="form-label fw-semibold">Purchase Link</label>
                    <?php if (isset($message_site)): ?>
                        <?php echo $message_site; ?>
                    <?php endif; ?>
                    <input type="text" id="add_site" name="add_site" class="form-control"
                        value="<?php echo isset($_POST['add_site']) ? $_POST['add_site'] : "" ?>">
                </div>

                <!-- FILE UPLOAD -->
                <div class="mb-3">
                    <label for="myfile" class="form-label">File</label>
                    <?php if (isset($message_image)): ?>
                        <?php echo $message_image; ?>
                    <?php endif; ?>
                    <input type="file" class="form-control" id="myfile" name="myfile"
                        value="<?php echo isset($uploadedFilename) ? $uploadedFilename : ''; ?>">
                </div>

                <!-- RGB -->
                <div class="form-check m-0 p-0">
                    <p class="fw-semibold mb-0 mt-3 ">Backlight</p>
                    <?php if (isset($message_rgb)): ?>
                        <?php echo $message_rgb; ?>
                    <?php endif; ?>
                    <div class="ps-2 mb-3">
                        <div class="form-check m-0">
                            <input class="form-check-input" value="1" type="radio" name="add_rgb" id="add_rgb_yes" <?php echo $add_rgb == '1' ? 'checked="checked"' : null; ?>>
                            <label class="form-check-label" for="add_rgb_yes">
                                RGB
                            </label>
                        </div>
                        <div class="form-check m-0">
                            <input class="form-check-input" value="0" type="radio" name="add_rgb" id="add_rgb_no" <?php echo ($add_rgb == '0') ? 'checked="checked"' : null; ?>>
                            <label class="form-check-label" for="add_rgb_no">
                                NONE
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Hidden Values -->
                <input type="hidden" name="keyboard_id" value="<?php echo $keyboard_id; ?>">
                <!-- Because we're storing our city id number in $_GET, we need to include it here again; otherwise, we may lose it when we submit the form and nothing will happen. -->

                <!-- Submit -->
                <input type="submit" value="Add Keyboard" name="submit" class="btn btn-success mt-3">
            </form>
        </section>
    </main>
    <?php include("includes/footer.php") ?>