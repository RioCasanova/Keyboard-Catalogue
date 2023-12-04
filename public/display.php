<!-- For individual display of keyboard information and photos -->
<?php

#region Imports

require_once("/home/rcasanova2/data/connect.php");
require_once("../private/prepared.php");
include("includes/header.php");

#endregion

#region Variables

$keyboard_id = isset($_GET['keyboard_id']) ? $_GET['keyboard_id'] : 0;


#endregion


?>


<div class="mt-5">
    <?php
    // your challenge. Loop thru the DB, and write out <img> tag for all your images. path to your thumbs200 dir
    $result = mysqli_query($connection, "SELECT * FROM keyboards WHERE keyboard_id = '$keyboard_id'");
    while ($row = mysqli_fetch_array($result)) {
        $name = $row['name'];
        $filename = $row['image'];


        echo "\n<div>";
        echo "<h2>$name</h2>";
        echo "\n<img src=\"_display800/$filename\" class=\"img-thumbnail\">";

        echo "\n</div>";
    }
    ?>
</div>
<?php
include("includes/footer.php");
?>