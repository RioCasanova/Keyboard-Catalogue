<?php

#region Imports

require_once("/home/rcasanova2/data/connect.php");
require_once("../private/prepared.php");

#endregion

#region Session
session_start();
if (isset($_SESSION['spiderman'])) {
    $txtMsg = "You are now logged in";

} else {

    header("Location:login.php");
}
if (isset($_POST["logout"])) {
    session_destroy();
    header("Location:login.php");
} else if (isset($_POST["home"])) {
    session_destroy();
    header("Location:index.php");
}
#endregion

#region Variables & Configuration
$current_id = isset($_GET['keyboard_id']) ? $_GET['keyboard_id'] : "";
if (isset($_GET['keyboard_id'])) {
    $current_id = $_GET['keyboard_id'];
} elseif (isset($_POST['keyboard_id'])) {
    $current_id = $_POST['keyboard_id'];
} else {
    $current_id = "";
}

$message = "";
$update_message = "";

$new_price = isset($_POST['price']) ? trim($_POST['price']) : "";
$new_site = isset($_POST['site']) ? trim($_POST['site']) : "";
$new_description = isset($_POST['description']) ? trim($_POST['description']) : "";
$new_color = isset($_POST['color']) ? trim($_POST['color']) : "";
$new_youtube = isset($_POST['youtube_link']) ? trim($_POST['youtube_link']) : "";


$existing_keyboard = "";
$keyboard_name = "";
$keyboard_brand = "";
$keyboard_size = "";
$keyboard_connectivity = "";
$keyboard_brand = "";
$existing_price = "";
$existing_site = "";
$existing_color = "";
$existing_description = "";
$existing_youtube = "";


if (isset($current_id) && $current_id > 0) {
    $keyboard = keyboard_by_id($current_id);
    if ($keyboard) {
        $keyboard_name = $keyboard['name'];
        $keyboard_brand = $keyboard["brand"];
        $keyboard_size = $keyboard["size"];
        $keyboard_connectivity = $keyboard["connectivity"];


        $existing_price = $keyboard["price"];
        $existing_site = $keyboard["site"];
        $existing_description = $keyboard["description"];
        $existing_color = $keyboard["color"];
        $existing_youtube = $keyboard["youtube_link"];
    } else {
        echo "<p>No record of that</p>";
    }
}
#endregion

#region Validation


if (isset($_POST['submit'])) {


    $proceed = true;
    // DESCRIPTION
    $new_description = filter_var($new_description, FILTER_SANITIZE_STRING);
    $new_description = mysqli_real_escape_string($connection, $new_description);
    if (strlen($new_description) < 2 || strlen($new_description) > 250) {
        $proceed = false;
        $update_message .= "\n<p>Please enter a description that is either less than 250 characters or more than 2.</p>";
    }

    // PRICE
    $new_price = filter_var($new_price, FILTER_SANITIZE_STRING);
    $new_price = mysqli_real_escape_string($connection, $new_price);
    if (strlen($new_price) < 1 || strlen($new_price) > 6 || !is_numeric($new_price) || $new_price < 0) {
        $proceed = false;
        $update_message .= "\n<p>Please enter a non-negative price that is between 1 and 6 characters in length.</p>";
    }

    // COLOR(S)
    $new_color = filter_var($new_color, FILTER_SANITIZE_STRING);
    $new_color = mysqli_real_escape_string($connection, $new_color);
    if (strlen($new_color) < 2 || strlen($new_color) > 50) {
        $proceed = false;
        $update_message .= "\n<p>Please enter color(s) that are between 2 and 30 characters in length collectively.</p>";
    }

    // PURCHASE SITE LINK
    $new_site = filter_var($new_site, FILTER_SANITIZE_STRING);
    $new_site = mysqli_real_escape_string($connection, $new_site);
    if (strlen($new_site) < 2 || strlen($new_site) > 250) {
        $proceed = false;
        $update_message .= "\n<p>Please enter a site link that is between 2 and 250 characters in length.</p>";
    }

    // YOUTUBE LINK
    $new_youtube = filter_var($new_youtube, FILTER_SANITIZE_STRING);
    $new_youtube = mysqli_real_escape_string($connection, $new_youtube);
    if (strlen($new_youtube) < 2 || strlen($new_youtube) > 250) {
        $proceed = false;
        $update_message .= "\n<p>Please enter a YouTube link that is between 2 and 250 characters in length.</p>";
    }



    if ($proceed == true) {
        update_keyboard(
            $new_price,
            $new_description,
            $new_color,
            $new_site,
            $new_youtube,
            $current_id
        );

        $message .= "<p>" . $keyboard_name . " updated successfully.</p>";

        $current_id = "";
        $new_price = "";
        $new_site = "";
        $new_description = "";
        $new_color = "";
        $new_youtube = "";
    }
}
if (isset($_POST['delete'])) {
    delete_keyboard($attraction_id);
    $message = "<p>" . $existing_name . " successfully removed.</p>";
    $attraction_id = "";
}

#endregion

include("includes/header.php") ?> <!--***********************************-->


<body class="container">
    <header class="mt-5">
        <nav class="mb-5 pb-5">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" class="">
                <input type="submit" class="btn btn-dark" name="home" value="Home">
                <a href="add.php" class="btn btn-success">Add a Record</a>
                <input type="submit" class="btn btn-secondary" name="logout" value="Logout">
            </form>
        </nav>
        <div class="">
            <h1 class="fw-light text-center mt-5">Edit a Record</h1>
            <p class="text-muted text-center  mb-5">To edit a record in our database, click 'Edit' beside the row you
                would
                like to change. Next add your updated values into the form and save. If you wish to delete a record
                press edit and you will find the delete button there.</p>
            <p>Please note that there are some fields that cannot be changed, such as the name and brand of a keyboard.
            </p>
        </div>
        <?php if (isset($update_message)): ?>
            <div class="message text-danger">
                <?php echo $update_message; ?>
            </div>

        <?php endif; ?>
    </header>
    <main>
        <section>
            <?php if ($message != ""): ?>
                <div class="alert alert-info">
                    <?php echo $message ?>
                </div>
            <?php endif; ?>
            <?php
            $keyboards = get_all_keyboards();
            if (count($keyboards) > 0) {
                echo "\n<table class=\"table table-bordered table-hover\"> ";
                echo "\n\t<tr>";
                echo "\n\t\t<th scope=\"col\">Name</th>";
                echo "\n\t\t<th scope=\"col\">Brand</th>";
                echo "\n\t\t<th scope=\"col\">Price (USD)</th>";
                echo "\n\t\t<th scope=\"col\">Size</th>";
                echo "\n\t\t<th scope=\"col\">Color</th>";
                echo "\n\t\t<th scope=\"col\">Connectivity</th>";
                foreach ($keyboards as $keyboard) {
                    extract($keyboard);
                    echo "\n\t\t<tr><td>$name</td>";
                    echo "<td>$brand</td>";
                    echo "<td> $" . number_format($price, 1) . "</td>";
                    echo "<td>$size</td>";
                    echo "<td>$color</td>";
                    echo "<td>$connectivity</td>";
                    echo "<td class=\"text-center\"><a href=\"edit.php?keyboard_id=$keyboard_id\" class=\"btn-warning btn\">Edit</a></td>";
                    echo "\n\t</tr>";
                }
                echo "\n</table>";
            }
            ?>
        </section>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title fs-5" id="exampleModalLabel">
                            Edit
                            <?php echo $keyboard_name . "\n" . $keyboard_brand ?>
                        </h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- EDIT FORM -->
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="text" id="price" name="price" class="form-control" value="<?php if ($new_price != "") {
                                    echo $new_price;
                                } else {
                                    echo $existing_price;
                                } ?>">
                            </div>
                            <div class="mb-3">
                                <label for="color" class="form-label">Color(s)</label>
                                <input type="text" id="color" name="color" class="form-control" value="<?php if ($new_color != "") {
                                    echo $new_color;
                                } else {
                                    echo $existing_color;
                                } ?>">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <input type="text-area" id="description" name="description" class="form-control" value="<?php if ($new_description != "") {
                                    echo $new_description;
                                } else {
                                    echo $existing_description;
                                } ?>">
                            </div>
                            <div class="mb-3">
                                <label for="site" class="form-label">Purchase Site Link</label>
                                <input type="text" id="site" name="site" class="form-control" value="<?php if ($new_site != "") {
                                    echo $new_site;
                                } else {
                                    echo $existing_site;
                                } ?>">
                            </div>
                            <div class="mb-3">
                                <label for="youtube_link" class="form-label">YouTube Link</label>
                                <input type="text" id="youtube_link" name="youtube_link" class="form-control" value="<?php if ($new_youtube != "") {
                                    echo $new_youtube;
                                } else {
                                    echo $existing_youtube;
                                } ?>">
                            </div>
                            <!-- Hidden Values -->
                            <input type="hidden" name="keyboard_id" value="<?php echo $current_id; ?>">
                            <!-- Because we're storing our city id number in $_GET, we need to include it here again; otherwise, we may lose it when we submit the form and nothing will happen. -->

                            <!-- Submit -->
                            <input type="submit" value="Save" name="submit" class="btn btn-success">
                            <input type="submit" value="Delete" name="delete" class="btn btn-danger">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Modal -->
    </main>
    <?php include("includes/footer.php") ?>