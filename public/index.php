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

#region Filter Variables

// filter
$filter = isset($_GET['filter']) ? $_GET['filter'] : null;

// text fields
$filter_brand = isset($_GET['filter_brand']) ? trim($_GET['filter_brand']) : "";
$filter_color = isset($_GET['filter_color']) ? trim($_GET['filter_color']) : "";

// prices
$minPrice = isset($_GET['minPrice']) ? $_GET['minPrice'] : null;
$maxPrice = isset($_GET['maxPrice']) ? $_GET['maxPrice'] : null;

// radio
$filter_rgb = isset($_GET['filter_rgb']) ? $_GET['filter_rgb'] : null;

// select
$filter_led_type = isset($_GET['filter_led_type']) ? trim($_GET['filter_led_type']) : "";
$filter_size = isset($_GET['filter_size']) ? trim($_GET['filter_size']) : "";
$filter_case_material = isset($_GET['filter_case_material']) ? trim($_GET['filter_case_material']) : "";

// checkboxes - done
$filter_connectivity = isset($_GET['filter_connectivity']) ? $_GET['filter_connectivity'] : [];
#endregion

include("includes/header.php") ?> <!--***********************************-->


<body class="container-fluid">
    <div class="row">
        <!-- Filter Area -->
        <div class="col-md-2 ps-0">
            <div class="d-flex flex-column p-3  h-100 w-100 text-bg-dark">
                <a href="/" class="d-flex align-items-center mb-3 mb-md-0 text-white text-decoration-none">
                    <svg class="bi pe-none me-2" width="40" height="32">
                        <use xlink:href="#bootstrap"></use>
                    </svg>
                    <span class="fs-4">Filters</span>
                </a>
                <hr>
                <form method="GET" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div class="mb-3">
                        <label for="filter_brand" class="form-label">Brand</label>
                        <input type="text" class="form-control" id="filter_brand" name="filter_brand"
                            value="<?php echo isset($_GET['filter_brand']) ? $_GET['filter_brand'] : "" ?>">
                    </div>
                    <div class="mb-3">
                        <label for="minPrice" class="form-label">Minimum Price</label>
                        <input type="number" class="form-control" id="minPrice" name="minPrice" min="0" step="0.05"
                            value="<?php echo isset($_GET['minPrice']) ? $_GET['minPrice'] : "" ?>">
                    </div>
                    <div class="mb-3">
                        <label for="maxPrice" class="form-label">Maximum Price</label>
                        <input type="number" class="form-control" id="maxPrice" name="maxPrice" min="0" step="0.05"
                            value="<?php echo isset($_GET['maxPrice']) ? $_GET['maxPrice'] : "" ?>">
                    </div>
                    <div class="mb-3">
                        <label for="filter_case_material" class="form-label">Case Material</label>
                        <select name="filter_case_material" id="filter_case_material" class="form-select">
                            <?php $materials =
                                [
                                    'select' => 'Select Material...',
                                    'aluminum' => 'Aluminum',
                                    'plastic' => 'Plastic',
                                    'wood' => 'Wood'
                                ];

                            foreach ($materials as $key => $value) {
                                if ($filter_case_material == $key) {
                                    $selected = 'selected';
                                } else {
                                    $selected = '';
                                }
                                echo "\n<option value=\"$key\" $selected>$value</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="filter_size" class="form-label">Size</label>
                        <select name="filter_size" id="filter_size" class="form-select">
                            <?php $sizes =
                                [
                                    'select' => 'Select Size...',
                                    '60%' => '60%',
                                    '65%' => '65%',
                                    '75%' => '75%',
                                    '98%' => '98%',
                                ];

                            foreach ($sizes as $key => $value) {
                                if ($filter_size == $key) {
                                    $selected = 'selected';
                                } else {
                                    $selected = '';
                                }
                                echo "\n<option value=\"$key\" $selected>$value</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="led_type" class="form-label">LED Type</label>
                        <div class="mb-3">
                            <select name="filter_led_type" id="filter_led_type" class="form-select">
                                <?php $led_types =
                                    [
                                        'select' => 'Select LED...',
                                        'south' => 'South-Facing',
                                        'north' => 'North-Facing',
                                    ];

                                foreach ($led_types as $key => $value) {
                                    if ($filter_led_type == $key) {
                                        $selected = 'selected';
                                    } else {
                                        $selected = '';
                                    }
                                    echo "\n<option value=\"$key\" $selected>$value</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="connectivity" class="form-label">Connectivity</label>
                        <div class="ps-2 mb-3">
                            <div class="form-check m-0 ">
                                <input class="form-check-input" type="checkbox" value="bluetooth"
                                    name="filter_connectivity[]" id="bluetooth" <?php echo (in_array('bluetooth', $filter_connectivity)) ? 'checked="checked"' : ''; ?>>
                                <label class="form-check-label" for="filter_connectivity">
                                    Bluetooth
                                </label>
                            </div>
                            <div class="form-check m-0">
                                <input class="form-check-input" type="checkbox" value="dongle"
                                    name="filter_connectivity[]" id="dongle" <?php echo (in_array('dongle', $filter_connectivity)) ? 'checked="checked"' : ''; ?>>
                                <label class="form-check-label" for="filter_connectivity">
                                    2.4
                                </label>
                            </div>
                            <div class="form-check m-0">
                                <input class="form-check-input" type="checkbox" value="wired"
                                    name="filter_connectivity[]" id="wired" <?php echo (in_array('wired', $filter_connectivity)) ? 'checked="checked"' : ''; ?>>
                                <label class="form-check-label" for="filter_connectivity">
                                    Wired
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="case_material" class="form-label">RGB</label>
                        <div class="ps-2 mb-3">
                            <div class="form-check m-0">
                                <input class="form-check-input" value="1" type="radio" name="filter_rgb"
                                    id="filter_rgb_yes" <?php echo $filter_rgb == '1' ? 'checked="checked"' : null; ?>>
                                <label class="form-check-label" for="filter_rgb_yes">
                                    Yes
                                </label>
                            </div>
                            <div class="form-check m-0">
                                <input class="form-check-input" value="0" type="radio" name="filter_rgb"
                                    id="filter_rgb_no" <?php echo ($filter_rgb == '0') ? 'checked="checked"' : null; ?>>
                                <label class="form-check-label" for="filter_rgb_no">
                                    No
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="filter_color" class="form-label">Color</label>
                        <input type="text" class="form-control" id="filter_color" name="filter_color"
                            value="<?php echo isset($_GET['filter_color']) ? $_GET['filter_color'] : "" ?>">
                    </div>
                    <button type="submit" class="btn btn-primary" name="filter">Apply Filters</button>
                </form>
                <hr>
                <div>
                    <p>Unique Features:
                    <ul>
                        <li>Sidebar</li>
                        <li>Youtube Video Embedding</li>
                    </ul>
                    </p>
                </div>
            </div>
        </div>

        <!-- Main Area -->
        <div class="container col-md-10">
            <header class="mt-5">
                <nav class="mb-5 pb-5">
                    <a href="index.php" class="btn btn-dark">Home</a>
                    <a href="login.php" class="btn btn-success">Login</a>
                </nav>
                <div class="text-center">
                    <h1 class="fw-light text-center mt-5">Keyboards</h1>
                    <p class="text-muted">View a keyboard for more details</p>
                </div>
            </header>
            <!-- Display items -- Gallery -->
            <main>
                <section class="mb-4">

                    <div>
                        <?php
                        if (isset($_GET['filter']) && !empty($_GET['filter'])) {
                            $keyboards = filter_by_all();
                        } else {
                            $keyboards = get_all_keyboards();
                        }

                        ?>

                        <div class="row p-5 justify-content-center">
                            <?php foreach ($keyboards as $x) { ?>
                                <div class="col-md-3 card mx-1 flex-nowrap mb-2">
                                    <img src="_thumbs200/<?php echo $x['image'] ?>" class="card-img-top mt-3"
                                        alt="picture of keyboard">
                                    <div class="card-body">
                                        <?php
                                        echo "<h4 class=\"card-title\"><b>" . $x['name'] . "</b></h4>";
                                        echo "<h5 class=\"text-muted card-text\">" . $x['brand'] . "</h5>";
                                        echo "<p class=\"card-text\"><b>(USD) Cost: </b>$" . $x['price'] . "</p>";
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