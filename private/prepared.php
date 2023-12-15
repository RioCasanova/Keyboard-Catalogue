<?php

#region Imports

require_once("/home/rcasanova2/data/connect.php");

#endregion

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

// ------------------------------------------ HOMEPAGE *****************************************************
function get_all_keyboards() // diasplays all items in database 'keyboards'
{
    global $connection;
    $all_keyboards_sql = $connection->prepare("SELECT * FROM keyboards");

    if (!$all_keyboards_sql->execute()) { // IF fail
        handle_database_error("fetching all results for home page");
    }

    $result = $all_keyboards_sql->get_result(); // returns object
    $atts = [];
    while ($row = $result->fetch_assoc()) {

        $atts[] = $row;
    }
    return $atts; // associative array
}

#region Filters *****************************************************

function filter_by_all()
{
    global $connection;
    $keyboard_by_all = "SELECT * FROM keyboards WHERE";

    if (isset($_GET['filter_brand'])) {
        $brand_text = $connection->real_escape_string($_GET['filter_brand']);
        $keyboard_by_all .= " brand LIKE %$brand_text% ";
    }

    if (isset($_GET['filter_rgb'])) {
        if (isset($_GET['filter_brand'])) {
            $keyboard_by_all .= " AND";
        }
        $rgb = $_GET['filter_rgb'];
        $keyboard_by_all .= " rgb = $rgb";
    }

    if (isset($_GET['filter_led_type'])) {
        if (isset($_GET['filter_brand']) || isset($_GET['filter_rgb'])) {
            $keyboard_by_all .= " AND";
        }
        $led_type_text = $connection->real_escape_string($_GET['filter_led_type']);
        $keyboard_by_all .= " led_type LIKE %$led_type_text% ";
    }


    if (isset($_GET['filter_size'])) {
        if (isset($_GET['filter_brand']) || isset($_GET['filter_rgb']) || isset($_GET['filter_led_type'])) {
            $keyboard_by_all .= " AND";
        }
        $size = $_GET['filter_size'];
        $keyboard_by_all .= " size = $size";
    }

    if (isset($_GET['minPrice']) || isset($_GET['maxPrice'])) {
        $min_price = $_GET['minPrice'];
        $max_price = $_GET['maxPrice'];
        if (isset($_GET['filter_brand']) || isset($_GET['filter_rgb']) || isset($_GET['filter_led_type']) || isset($_GET['filter_size'])) {
            $keyboard_by_all .= " AND";
        }
        if (isset($_GET['minPrice']) && isset($_GET['maxPrice'])) {
            $keyboard_by_all .= " price BETWEEN $min_price AND $max_price";
        } else {
            if (isset($_GET['minPrice'])) {
                $keyboard_by_all .= " price >= $min_price";
            }
            if (isset($_GET['maxPrice'])) {
                $keyboard_by_all .= " price <= $max_price";
            }
        }
    }

    if (isset($_GET['filter_connectivity'])) {
        if (isset($_GET['filter_brand']) || isset($_GET['filter_rgb']) || isset($_GET['filter_led_type']) || isset($_GET['filter_size']) || isset($_GET['minPrice']) || isset($_GET['maxPrice'])) {
            $keyboard_by_all .= " AND";
        }
        $connectivity = $_GET['filter_connectivity'];
        $keyboard_by_all .= " connectivity = $connectivity";
    }

    if (isset($_GET['filter_color'])) {
        if (isset($_GET['filter_brand']) || isset($_GET['filter_rgb']) || isset($_GET['filter_led_type']) || isset($_GET['filter_size']) || isset($_GET['minPrice']) || isset($_GET['maxPrice']) || isset($_GET['filter_connectivity'])) {
            $keyboard_by_all .= " AND";
        }
        $color = $_GET['filter_color'];
        $keyboard_by_all .= " color LIKE %$color%";
    }


    $result = $connection->query($keyboard_by_all);
    $atts = [];
    while ($row = $result->fetch_assoc()) {

        $atts[] = $row;
    }
    return $atts;
}
// LOAD RESULTS ACCORDING TO: brand
function filter_by_brand()
{
    global $connection;
    $keyboard_by_brand = $connection->prepare("SELECT * FROM keyboards WHERE brand = ?");
    $brand = $_GET['brand'];

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }


    $keyboard_by_brand->bind_param("s", $brand);

    if (!$keyboard_by_brand->execute()) {
        handle_database_error("selecting keyboard by brand");
    }
    $result = $keyboard_by_brand->get_result();
    $atts = [];
    while ($row = $result->fetch_assoc()) {
        $atts[] = $row;
    }
    return $atts;
}


// LOAD RESULTS ACCORDING TO: rgb (true|false)
function filter_by_rgb()
{
    global $connection;
    $keyboard_by_rgb = $connection->prepare("SELECT * FROM keyboards WHERE rgb = ?");
    $rgb = $_GET['rgb'];

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }


    $keyboard_by_rgb->bind_param("i", $rgb);

    if (!$keyboard_by_rgb->execute()) {
        handle_database_error("selecting keyboard by rgb");
    }
    $result = $keyboard_by_rgb->get_result();
    $atts = [];
    while ($row = $result->fetch_assoc()) {
        $atts[] = $row;
    }
    return $atts;
}

// LOAD RESULTS ACCORDING TO: led_type
function filter_by_led_type()
{
    global $connection;
    $keyboard_by_led_type = $connection->prepare("SELECT * FROM keyboards WHERE led_type = ?");
    $led_type = $_GET['led_type'];

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }


    $keyboard_by_led_type->bind_param("s", $led_type);

    if (!$keyboard_by_led_type->execute()) {
        handle_database_error("selecting keyboard by led_type");
    }
    $result = $keyboard_by_led_type->get_result();
    $atts = [];
    while ($row = $result->fetch_assoc()) {
        $atts[] = $row;
    }
    return $atts;
}

// LOAD RESULTS ACCORDING TO: size
function filter_by_size()
{
    global $connection;
    $keyboard_by_size = $connection->prepare("SELECT * FROM keyboards WHERE size = ?");
    $size = $_GET['size'];

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }


    $keyboard_by_size->bind_param("s", $size);

    if (!$keyboard_by_size->execute()) {
        handle_database_error("selecting keyboard by size");
    }
    $result = $keyboard_by_size->get_result();
    $atts = [];
    while ($row = $result->fetch_assoc()) {
        $atts[] = $row;
    }
    return $atts;
}

// LOAD RESULTS ACCORDING TO: price
function filter_by_price()
{
    global $connection;
    $keyboard_by_price = $connection->prepare("SELECT * FROM your_table WHERE price BETWEEN ? AND ?");
    $min_price = $_GET['minPrice'];
    $max_price = $_GET['maxPrice'];

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }


    $keyboard_by_price->bind_param("ii", $min_price, $max_price);

    if (!$keyboard_by_price->execute()) {
        handle_database_error("selecting keyboard by price");
    }
    $result = $keyboard_by_price->get_result();
    $atts = [];
    while ($row = $result->fetch_assoc()) {
        $atts[] = $row;
    }
    return $atts;
}


// LOAD RESULTS ACCORDING TO: connectivity
function filter_by_connectivity()
{
    global $connection;
    $keyboard_by_connectivity = $connection->prepare("SELECT * FROM keyboards WHERE connectivity = ?");
    $connectivity = $_GET['connectivity'];

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }


    $keyboard_by_connectivity->bind_param("s", $connectivity);

    if (!$keyboard_by_connectivity->execute()) {
        handle_database_error("selecting keyboard by connectivity");
    }
    $result = $keyboard_by_connectivity->get_result();
    $atts = [];
    while ($row = $result->fetch_assoc()) {
        $atts[] = $row;
    }
    return $atts;
}

#endregion

// ------------------------------------------ INSERT *****************************************************



function insert_keyboard($keyboard_name, $brand, $price, $rgb, $led_type, $description, $size, $connectivity, $case_material, $color, $fileName, $site, $youtube_link)
{
    global $connection;

    $insert_statement = $connection->prepare("INSERT INTO keyboards(name, brand, price, rgb, led_type, description, size, connectivity, case_material, color, image, site, youtube_link) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $insert_statement->bind_param("ssiisssssssss", $keyboard_name, $brand, $price, $rgb, $led_type, $description, $size, $connectivity, $case_material, $color, $fileName, $site, $youtube_link);
    if (!$insert_statement->execute()) {
        handle_database_error("inserting keyboard record");
    }
}

// ------------------------------------------ EDIT *****************************************************

function keyboard_by_id($keyboard_id)
{
    global $connection;
    $select_by_id_sql = $connection->prepare("SELECT * FROM keyboards WHERE keyboard_id = ?");
    $select_by_id_sql->bind_param("i", $keyboard_id);
    if (!$select_by_id_sql->execute()) {
        handle_database_error("Selecting keyboard by id");
    }

    $result = $select_by_id_sql->get_result();
    $attraction = $result->fetch_assoc();
    return $attraction;
}

// ------------------------------------------ UPDATE *****************************************************
function update_keyboard($price, $description, $color, $site, $youtube_link, $keyboard_id)
{
    global $connection;
    $update_statement =
        $connection->prepare("UPDATE keyboards 
                      SET price = ?, description = ?, color = ?, site = ?, youtube_link = ?
                      WHERE keyboard_id = ?");

    $update_statement->bind_param("issssi", $price, $description, $color, $site, $youtube_link, $keyboard_id);
    $update_statement->execute();
    if (!$update_statement->execute()) {
        handle_database_error("updating keyboard record");
    }
}


// ------------------------------------------ DELETE *****************************************************

function delete_keyboard($keyboard_id)
{
    global $connection;
    $delete_statement = $connection->prepare("DELETE FROM keyboards WHERE keyboard_id = ?");
    $delete_statement->bind_param("i", $keyboard_id);
    $delete_statement->execute();
    if (!$delete_statement->execute()) {
        handle_database_error("deleting keyboard record");
        $_SESSION['message'] = "Error: " . $connection->error . ".";
    } else {
        echo "Record deleted successfully";
        $_SESSION['message'] = "Record deleted successfully";

    }
}

#region Image Functions *****************************************************


// creates and stores image
function createImageCopy($file, $folder, $newWidth, $showThumb = 1)
{

    list($width, $height) = getimagesize($file);
    $imgRatio = $width / $height;
    $newHeight = $newWidth / $imgRatio;

    //echo "<p>$newWidth; $newHeight; $imgRatio</p>";
    $thumb = imagecreatetruecolor($newWidth, $newHeight);
    $source = imagecreatefromjpeg($file);

    imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    $fileName = $folder . $_FILES['myfile']['name'];

    imagejpeg($thumb, $fileName, 80); // 80 here is the JPEG quality

    imagedestroy($thumb);
    imagedestroy($source);

    // if($showThumb == 1){// just so we only show the thumbnail image once.
    //     echo "<img src=\"thumbs200/". $_FILES['myfile']['name'] ."\">";
    // }

}

// creates thumbnail
function createSquareImageCopy($file, $folder, $newWidth)
{

    //echo "$filename, $folder, $newWidth";
    //exit();

    $thumb_width = $newWidth;
    $thumb_height = $newWidth; // tweak this for ratio

    list($width, $height) = getimagesize($file);

    $original_aspect = $width / $height;
    $thumb_aspect = $thumb_width / $thumb_height;

    if ($original_aspect >= $thumb_aspect) {
        // If image is wider than thumbnail (in aspect ratio sense)
        $new_height = $thumb_height;
        $new_width = $width / ($height / $thumb_height);
    } else {
        // If the thumbnail is wider than the image
        $new_width = $thumb_width;
        $new_height = $height / ($width / $thumb_width);
    }

    $source = imagecreatefromjpeg($file);
    $thumb = imagecreatetruecolor($thumb_width, $thumb_height);

    // Resize and crop
    imagecopyresampled(
        $thumb,
        $source,
        0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
        0 - ($new_height - $thumb_height) / 2, // Center the image vertically
        0,
        0,
        $new_width,
        $new_height,
        $width,
        $height
    );

    $newFileName = $folder . "/" . basename($file);
    imagejpeg($thumb, $newFileName, 80);

    //echo "<p><img src=\"$newFileName\" /></p>"; // if you want to see the image

    // echo "<img src=\"_thumbs200/" . $_FILES['myfile']['name'] . "\">";
}


#endregion


// ------------------------------------------ HELPERS *****************************************************
function handle_database_error($statement)
{
    global $connection;
    die("Error in: " . $statement . ". Error Details: " . $connection->error);
}

?>