<?php require_once("/home/rcasanova2/data/connect.php"); ?>
<?php

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
// ------------------------------------------ FILTERS *****************************************************

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
    $keyboard_by_price = $connection->prepare("SELECT * FROM keyboards WHERE price = ?");
    $price = $_GET['price'];

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }


    $keyboard_by_price->bind_param("s", $price);

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



// ------------------------------------------ INSERT *****************************************************



function insert_keyboard($keyboard_name, $brand, $cost, $address, $url, $description, $rating, $area, $friendly, $season)
{
    global $connection;
    $insert_statement = $connection->prepare("INSERT INTO rcasanova2_attractions(name, category, cost, address, url, description, rating, area_of_town, family_friendly, season) VALUES(?,?,?,?,?,?,?,?,?,?)");
    $insert_statement->bind_param("ssssssisis", $keyboard_name, $brand, $cost, $address, $url, $description, $rating, $area, $friendly, $season);
    if (!$insert_statement->execute()) {
        handle_database_error("inserting keyboard record");
    }
}

// ------------------------------------------ EDIT *****************************************************

function keyboard_by_id($keyboard_id)
{
    global $connection;
    $select_by_id_sql = $connection->prepare("SELECT * FROM rcasanova2_attractions WHERE id = ?");
    $select_by_id_sql->bind_param("i", $keyboard_id);
    if (!$select_by_id_sql->execute()) {
        handle_database_error("Selecting keyboard by id");
    }

    $result = $select_by_id_sql->get_result();
    $attraction = $result->fetch_assoc();
    return $attraction;
}

// ------------------------------------------ UPDATE *****************************************************
function update_keyboard($attraction_name, $category, $cost, $address, $url, $description, $rating, $area, $friendly, $season, $attraction_id)
{
    global $connection;
    $update_statement =
        $connection->prepare("UPDATE rcasanova2_attractions 
                      SET name = ?, category = ?, cost = ?, address = ?, url = ?, description = ?, rating = ?, area_of_town = ?, family_friendly = ?, season = ? 
                      WHERE id = ?");

    $update_statement->bind_param("ssssssisisi", $attraction_name, $category, $cost, $address, $url, $description, $rating, $area, $friendly, $season, $attraction_id);
    $update_statement->execute();
    if (!$update_statement->execute()) {
        handle_database_error("updating keyboard record");
    }
}


// ------------------------------------------ DELETE *****************************************************

function delete_keyboard($keyboard_id)
{
    global $connection;
    $delete_statement = $connection->prepare("DELETE FROM rcasanova2_attractions WHERE id = ?");
    $delete_statement->bind_param("i", $keyboard_id);
    $delete_statement->execute();
    if (!$delete_statement->execute()) {
        handle_database_error("deleting keyboard record");
    }
}

// ------------------------------------------ HELPERS *****************************************************
function handle_database_error($statement)
{
    global $connection;
    die("Error in: " . $statement . ". Error Details: " . $connection->error);
}

?>