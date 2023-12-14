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
    // Create a functional back button for me 
    echo "<a href='index.php' class='btn btn-dark'>Back</a>";
    // your challenge. Loop thru the DB, and write out <img> tag for all your images. path to your thumbs200 dir
    $result = mysqli_query($connection, "SELECT * FROM keyboards WHERE keyboard_id = '$keyboard_id'");
    while ($row = mysqli_fetch_array($result)) { ?>

        <div class="row">
            <div class="col-12 col-md-6">
                <img src="_display800/<?php echo $row['image'] ?>" class="img-thumbnail">
            </div>
            <div class="col-12 col-md-6">
                <h1>
                    <?php echo $row['name']; ?>
                </h1>
                <p>
                    <?php echo $row['description']; ?>
                </p>
                <p>Price: $
                    <?php echo $row['price']; ?>
                </p>
                <p>Brand:
                    <?php echo $row['brand']; ?>
                </p>
                <p>Size:
                    <?php echo $row['size']; ?>
                </p>
                <p>RGB:
                    <?php echo $row['rgb']; ?>
                </p>
                <p>LED Type:
                    <?php echo $row['led_type']; ?>
                </p>
                <p>Connectivity:
                    <?php echo $row['connectivity']; ?>
                </p>
                <p>Case Material:
                    <?php echo $row['case_material']; ?>
                </p>
                <p>Color:
                    <?php echo $row['color']; ?>
                </p>
                <p>Site:
                    <a href="<?php echo $row['site']; ?>">Buy Here</a>
                </p>

                <!-- EMBEDDED YOUTUBE VIDEO -->
                <?php

                function getYoutubeVideoId($youtubeLink)
                {
                    $pattern = '/(?:youtube\.com\/(?:[^\/]+\/[^\/]+\/|(?:v|e(?:mbed)?)\/|[^\/]+\?v=)|youtu\.be\/)([^\"\&\?\/ ]{11})/';
                    preg_match($pattern, $youtubeLink, $matches);
                    return isset($matches[1]) ? $matches[1] : false;
                }

                if (isset($row['youtube_link']) && !empty($row['youtube_link'])) {
                    $youtubeLink = $row['youtube_link'];
                    $videoId = getYoutubeVideoId($youtubeLink);

                    if ($videoId) {
                        $embedLink = "https://www.youtube.com/embed/$videoId";
                        echo "<iframe width=\"560\" height=\"315\" class='embed-responsive-item' title=\"YouTube video player\" frameborder=\"0\" src='$embedLink'  allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>";
                    } else {
                        echo "Invalid Youtube Link";
                    }
                }

                ?>

                <form method="POST" action="delete.php"
                    onsubmit="return confirm('Are you sure you want to delete this record?');">
                    <input type="hidden" name="delete_id" value="<?php echo $row['keyboard_id']; ?>">
                    <input type="submit" value="Delete">
                </form>

            </div>
        <?php }
    ?>
    </div>
    <?php
    include("includes/footer.php");
    ?>