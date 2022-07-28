<?php
// keep the same order
require("config.php");
$db = new Database();
$con = $db->getConnString();

require('session.php');

require('queries/statsquery.php');
require('queries/order_new_query.php');
require "queries/classes/Infrastructure.php";


?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0" /> -->
    <link rel="icon" type="image/x-icon" href="pages/assets/z_favicon.png">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="css/main.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>


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
                <span class="name">Famlink</span>
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
                <li class="nav-link active">
                    <a href="index">
                        <i class='bx bx-home-alt icon'></i>
                        <span class="text nav-text">Dashboard</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="pages/cases.php">
                        <i class='bx bx-bar-chart-alt-2 icon'></i>
                        <span class="text nav-text">Add New</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="pages/appointments">
                        <i class='bx bx-bell icon'></i>
                        <span class="text nav-text">Manage</span>
                    </a>
                </li>

                <!-- <li class="nav-link">
                  <a href="#">
                    <i class='bx bx-pie-chart-alt icon'></i>
                    <span class="text nav-text">Analytics</span>
                  </a>
                </li>

                <li class="nav-link">
                  <a href="#">
                    <i class='bx bx-heart icon'></i>
                    <span class="text nav-text">Likes</span>
                  </a>
                </li>

                <li class="nav-link">
                  <a href="#">
                    <i class='bx bx-wallet icon'></i>
                    <span class="text nav-text">Wallets</span>
                  </a>
                </li> -->

            </ul>
        </div>

        <div class="bottom-content">
            <li class="">
                <a href="logout.php">
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
                <div class="sectionheading">
                    <h3 class="sectionlable">Dashboard</h3>
                    <h6 class="sectionlable">Summary</h6>
                </div>
                <div class="statistics">
                    <div class="card" style="background:#1845b8">
                        <div class="illustration">
                            <img src="images/fontisto_shopping-basket.svg" alt=""/>
                        </div>
                        <div class="stats">
                            <p class="label" style="color: #fff">Active</p>
                            <p class="number" style="color: #fff"><?= $active_ins ?></p>
                        </div>
                    </div>

                    <div class="card">
                        <div class="illustration">
                            <img src="images/bxs_food-menu.svg" alt=""/>
                        </div>
                        <div class="stats">
                            <p class="label">Not Active</p>
                            <p class="number"><?= $not_active_ins ?></p>
                        </div>

                    </div>

                </div>

                <div class="sectionheading">
                    <h3 class="sectionlable">Cases</h3>
                    <h6 class="sectionlable">All New Reported Cases</h6>
                </div>

                <?php if ($infrastructure) : ?>

                    <div class="childrencontainer">


                        <?php
                        foreach ($infrastructure as $row) :
                            ?>

                            <?php
                            $infras = new Infrastructure($con, $row);
                            ?>

                            <div class="product-card" style="background-color:#228765 ; color: #fff; font-size: 15px;">
                                <div class="infras_card">
                                    <h1 style="color: #F6FFEE; font-size: 22px;"><?= $infras->getType() ?></h1>
                                    <p style="color: #CDEDCB;"><?= $infras->getDescription() ?></p>
                                    <p style="color:#36CC7C ;margin-top: 1em;"><span
                                                style="color: #CDEDCB;">Aim</span> <?= $infras->getAim() ?></p>
                                    <p><span style="color: #CDEDCB;">Contact</span> 0787250196</p>
                                    <p>
                                        <span style="color: #CDEDCB;">Install Date</span> <?= $infras->getInstallDate() ?>
                                    </p>
                                    <p style="color: #D9D055; margin-top: 1em; font-size: 12px;">This location may
                                        change based on the tracker device</p>

                                    <input type="hidden" name="artistid" value="<?= $infras->getId() ?>">

                                    <div class="product-card__actions">
                                        <a href="pages/order_detail.php?id=<?= $infras->getId() ?>"
                                           class="btn btn-primary my-2  sponsorbutton">View Details</a>
                                    </div>
                                </div>

                            </div>

                        <?php endforeach ?>

                    </div>


                <?php else : ?>
                    No infrastructure
                <?php endif ?>


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