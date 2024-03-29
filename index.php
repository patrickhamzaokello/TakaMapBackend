<?php
// keep the same order
require("admin/config.php");
$db = new Database();
$con = $db->getConnString();


$sql = "SELECT infrastructuretypes.id,infrastructuretypes.name,infrastructuretypes.iconpath,infrastructuretypes.created_at, COUNT(infrastructure.id) AS total_ins FROM infrastructure INNER JOIN infrastructuretypes ON infrastructure.type = infrastructuretypes.id GROUP BY type ORDER BY name ASC";
$all_categories = mysqli_query($con, $sql);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="icon" type="image/x-icon" href="img/logo.png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!----===== Boxicons CSS ===== -->
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />

    <style>
        .leaflet-popup-content-wrapper,
        .leaflet-popup.tip {
            background-color: #228765;
        }

        .leaflet-popup-content-wrapper,
        .leaflet-popup-tip {
            background: #228765;
            color: #333;
            box-shadow: 0 3px 14px rgb(0 0 0 / 40%);
        }
    </style>

    <title>Taka Map</title>
</head>

<body>
    <nav class="main-nav">
        <div class="nav-content">
            <ul class="left-content">
                <li class="nav-item">
                    <a class="nav-link logo" href="#header"></a>
                </li>
                <li class="nav-item tuggle-btn">
                    <div class="tuggle-btn-content">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </li>
            </ul>
            <ul class="right-content">
                <li style="display: none" class="nav-item">
                    <a class="nav-link" href="admin/index" target="_blank">Admin</a>
                </li>
                <li style="display: none" class="nav-item">
                    <a class="nav-link registration" href="#">Logout</a>
                </li>
            </ul>
        </div>
        <div class="tuggle-content">
            <ul class="left-content">

                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pickup.php">Pickup</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="report.php">Report</a>
                </li>

            </ul>
        </div>
    </nav>

    <div class="sidebar">


        <div class="menu-bar">

            <div class="bottom-content">
                <!-- city select -->
                <div class="cityselect">
                    <select id="example-select"></select>
                </div>

                <header style="margin-top: 1em;">
                    <div class="image-text">
                        <div class="text logo-text">
                            <span class="name">Infrastructure</span>
                            <span class="profession">Select type to filter</span>
                        </div>
                    </div>
                </header>

                <div class="menu">
                    <a class="search-box" href="index.php">
                        <button>
                            Show all</button>
                    </a>


                    <ul class="menu-links">
                        <!--                        <label class="form-control">-->
                        <!--                            <input value="all" type="checkbox" name="all" checked />-->
                        <!--                            All-->
                        <!--                        </label>-->

                        <?php
                        // use a while loop to fetch data
                        // from the $all_categories variable
                        // and individually display as an option
                        while ($category = mysqli_fetch_array(
                            $all_categories,
                            MYSQLI_ASSOC
                        )) :;
                        ?>
                            <label class="form-control">


                                <input value="<?php echo $category["name"];
                                                // The value we usually set is the primary key
                                                ?>" type="checkbox" name="<?php echo $category["name"];
                                                        // The value we usually set is the primary key
                                                        ?>" />
                                <img width="20" height="20" src="admin/pages/<?php echo $category["iconpath"]; ?>" alt="">

                                <p style="font-size: 14px;"><?php echo $category["name"]; ?> <?php echo " (" . $category["total_ins"] . ") "; ?></p>
                                

                            </label>
                        <?php
                        endwhile;
                        // While loop must be terminated
                        ?>

                    </ul>

                    <div id="wrapper"></div>
                </div>

            </div>
        </div>
    </div>

    <section class="home">
        <div id="map"></div>
    </section>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>