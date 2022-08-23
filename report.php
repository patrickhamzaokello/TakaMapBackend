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

        .app_feature_section {
            position: relative;
            top: 78px;
            display: grid;
            place-content: center;
            height: 80%;
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
                <li class="nav-item">
                    <a class="nav-link" href="admin/index" target="_blank">Admin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link registration" href="#">Logout</a>
                </li>
            </ul>
        </div>
        <div class="tuggle-content">
            <ul class="left-content">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
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


    <section class="app_feature_section">
        <div class="container">
            <div class="cardcomponent">


                <div class="loginpagesite align-self-stretch">

                    <div class="formtitle">

                        <p class="logintext">Make Report about Trash</p>

                        <p class="newtopwf">Taka Map</p>
                    </div>


                </div>

            </div>


        </div>
    </section>



</body>

</html>