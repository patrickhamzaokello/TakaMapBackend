<?php
// keep the same order
require("../config.php");
$db = new Database();
$con = $db->getConnString();

require('../session.php');


?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0" /> -->
    <link rel="icon" type="image/x-icon" href="pages/assets/z_favicon.png">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="../css/main.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>


    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <title>Yugi Map</title>
</head>

<body>

    <nav class="sidebar">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="pages/assets/famlink.png" alt="">
                </span>

                <div class="text logo-text">
                    <span class="name">Yugi Map</span>
                    <span class="profession"><?= $login_session ?></span>
                </div>
            </div>

            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">

                <li class="search-box" style="display: none;">
                    <i class='bx bx-search icon'></i>
                    <input type="text" placeholder="Search...">
                </li>

                <ul class="menu-links">
                    <li class="nav-link ">
                        <a href="../index">
                            <i class='bx bx-home-alt icon'></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-link active">
                        <a href="new">
                            <i class='bx bx-bar-chart-alt-2 icon'></i>
                            <span class="text nav-text">Add New</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="manage">
                            <i class='bx bx-bell icon'></i>
                            <span class="text nav-text">Manage</span>
                        </a>
                    </li>

                </ul>
            </div>

            <div class="bottom-content">
                <li class="">
                    <a href="../logout">
                        <i class='bx bx-log-out icon'></i>
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>


            </div>
        </div>

    </nav>

    <section class="home">
        <div class="mainpanel">
            <div class="elements">
                <div class="activities">

                    <div class="container" style="padding: 0 20%">
                        <div class="sectionheading">
                            <h3 class="sectionlable">New Infrastructure</h3>
                            <h6 class="sectionlable">Add New Infrastructure</h6>
                        </div>

                        <form class="saveinfrastructure" action="" method="post">
                            <label for="aimID" class="labeltext">Aim</label>
                            <input id="aimID" type="text" name="aim" placeholder="Infrastructure Aim" required />
                            <label for="typeID" class="labeltext">Type</label>
                            <input id="typeID" type="text" name="Type" placeholder="Infrastructure Type" required />
                            <label for="longitudeID" class="labeltext">Longitude</label>
                            <input id="longitudeID" type="text" name="Longitude" placeholder="Infrastructure Longitude" required />
                            <label for="latitudeID" class="labeltext">Latitude</label>
                            <input id="latitudeID" type="text" name="Latitude" placeholder="Infrastructure Latitude" required />
                            <label for="descriptionID" class="labeltext">Description</label>
                            <textarea id="descriptionID" name="Description" placeholder="Infrastructure Description" required rows="8"></textarea>
                            <button class="inputsubmit" type="submit" value="Save">Save Infrastructure</button>
                        </form>

                    </div>



                </div>

            </div>
        </div>

    </section>

    <script>
        const body = document.querySelector('body'),
            sidebar = body.querySelector('nav'),
            toggle = body.querySelector(".toggle"),
            searchBtn = body.querySelector(".search-box"),
            // modeSwitch = body.querySelector(".toggle-switch"),
            modeText = body.querySelector(".mode-text");


        toggle.addEventListener("click", () => {
            sidebar.classList.toggle("close");
        })

        searchBtn.addEventListener("click", () => {
            sidebar.classList.remove("close");
        })
    </script>


</body>


</html>