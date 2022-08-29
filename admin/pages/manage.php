<?php
// keep the same order
require("../config.php");
$db = new Database();
$con = $db->getConnString();

require('../session.php');

require('../queries/statsquery.php');
require('../queries/manage_infrastructure.php');
require "../queries/classes/InfrastructureTypes.php";
require "../queries/classes/Infrastructure.php";

$sql = "SELECT * FROM `infrastructuretypes` ORDER BY `infrastructuretypes`.`name` ASC";
$all_categories = mysqli_query($con, $sql);



?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0" /> -->
    <link rel="icon" type="image/x-icon" href="assets/z_favicon.png">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="../css/main.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>


    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <title>Taka Map</title>
</head>

<body>

    <nav class="sidebar">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="assets/famlink.png" alt="">
                </span>

                <div class="text logo-text">
                    <span class="name">Taka Map</span>
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

                                     <li class="nav-link">
                        <a href="infrastructure_types">
                            <i class='bx bx-candles  icon'></i>
                            <span class="text nav-text">Type</span>
                        </a>
                    </li>

                    <li class="nav-link active">
                        <a href="manage">
                            <i class='bx bx-cabinet icon'></i>
                            <span class="text nav-text">Manage</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="pickup">
                            <i class='bx bx-trash-alt icon'></i>
                            <span class="text nav-text">Pickups</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="cases">
                            <i class='bx bx-user-voice icon'></i>
                            <span class="text nav-text">Cases</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="bottom-content">
                <li class="">
                    <a href="../logout.php">
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
                        <h3 class="sectionlable">Infrastructures</h3>
                        <h6 class="sectionlable">All Active Infrastructures</h6>
                    </div>

                    <button class="createnewbtn btncreatenew">Add New
                    </button>

                    <?php if ($infrastructure) : ?>

                        <div class="childrencontainer">


                            <?php
                            foreach ($infrastructure as $row) :
                            ?>

                                <?php
                                $infras = new Infrastructure($con, $row);
                                ?>

                                <div class="product-card" style="color: #fff; font-size: 15px;">
                                    <div class="infras_card">
                                        <h1 style="color: #228765; font-size: 22px;"><?= $infras->getType() ?></h1>
                                        <p style="color: #0f3c2d;"><?= $infras->getDescription() ?></p>
                                        <p style="color:#36CC7C ;margin-top: 1em;"><span style="color: #0f3c2d;">Aim</span> <?= $infras->getAim() ?></p>
                                        <p style="color:#36CC7C "><span style="color: #0f3c2d;">Contact</span> 0788373973</p>
                                        <p style="color:#36CC7C ">
                                            <span style="color: #0f3c2d;">Install Date</span> <?= $infras->getInstallDate() ?>
                                        </p>
                                        <p style="color: #023c1c; margin-top: 1em; font-size: 12px;">Longitude : <?= $infras->getLongitude() ?> -- Latitude: <?= $infras->getLatitude() ?></p>

                                        <input type="hidden" name="artistid" value="<?= $infras->getId() ?>">

                                        <div class="myactionbtn" style="margin-top: 1em; display: flex;grid-gap: 1em;">

                                            <div class="approvebutton_parent">
                                                <input class="cardID" type="hidden" name="ID" value="<?= $infras->getId() ?>">
                                                <input class="cardAIM" type="hidden" name="AIM_VAL" value="<?= $infras->getAim() ?>">
                                                <input class="typeID" type="hidden" name="typeID_VAL" value="<?= $infras->getTypeID() ?>">
                                                <input class="longVAL" type="hidden" name="longVAL" value="<?= $infras->getLongitude() ?>">
                                                <input class="latVAL" type="hidden" name="latVAL" value="<?= $infras->getLatitude() ?>">
                                                <input class="desVAL" type="hidden" name="desVAL" value="<?= $infras->getDescription() ?>">
                                                <button class="approvebutton">Edit</button>
                                            </div>

                                            <div class="cancebutton_parent">
                                                <input class="cardID" type="hidden" name="orderID" value="<?= $infras->getId() ?>">
                                                <button class="cancelbutton">Delete</button>
                                            </div>
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


            <!--        loader-->
            <div class="loaderdiv">
                <div class="loader-container">
                    <div class="lds-ripple">
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>

            <div class="sponserdiv">
                <div class="sponsorshipform">
                    <div class="sponsormessagediv">

                    </div>
                    <form id="approveform" action="" method="POST" enctype="multipart/form-data">

                        <div class="form-group">
                            <input id="ins_type_id" type="hidden" name="childname" class="form-control" placeholder="order_id" disabled>
                        </div>

                        <div class="approveorderform">
                            <h1>Infrastructure Details</h1>
                            <p>Provide New Infrastructure Details</p>

                            <div id="error"></div>

                            <div class="form-group">
                                <input class="form-control" id="aimID" type="text" name="aim" placeholder="Infrastructure Aim"  />
                            </div>

                            <div class="form-group">
                                <select class="form-control" id="typeID" name="Type">
                                    <option value="0">Choose Type</option>
                                    <?php
                                    // use a while loop to fetch data
                                    // from the $all_categories variable
                                    // and individually display as an option
                                    while ($category = mysqli_fetch_array(
                                        $all_categories,
                                        MYSQLI_ASSOC
                                    )) :;
                                    ?>
                                        <option value="<?php echo $category["id"];
                                                        // The value we usually set is the primary key
                                                        ?>">
                                            <?php echo $category["name"];
                                            // To show the category name to the user
                                            ?>
                                        </option>
                                    <?php
                                    endwhile;
                                    // While loop must be terminated
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <input class="form-control" id="longitudeID" type="text" name="Longitude" placeholder="Infrastructure Longitude"  />
                            </div>

                            <div class="form-group">

                                <input class="form-control" id="latitudeID" type="text" name="Latitude" placeholder="Infrastructure Latitude" />
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" id="descriptionID" name="Description" placeholder="Infrastructure Description"  rows="8"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Approve" style="width: 100% !important;" class="sponsorchildnowbtn">
                            </div>
                            <div class="form-group">
                                <button type="reset" id="cancelbtn" style="background: #fff;border: 1px solid #000;padding: 10px 20px;width: 100%;color: #000; border-radius: 5px;" onclick="cancelsponsohip()">Cancel
                                </button>
                            </div>
                        </div>

                        <div class="deleteorder" style="display: none;">
                            <h1>Delete Infrastructure</h1>
                            <p>This action can not be reversed when done! </p>


                            <div class="form-group">
                                <input type="submit" value="Delete" style="width: 100% !important;" class="sponsorchildnowbtn">
                            </div>
                            <div class="form-group">
                                <button type="reset" id="cancelbtn" style="background: #fff;border: 1px solid #000;padding: 10px 20px;width: 100%;color: #000; border-radius: 5px;" onclick="cancelsponsohip()">Cancel
                                </button>
                            </div>
                        </div>


                    </form>

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
    <script src="../js/addInsfrastructure.js"></script>


</body>


</html>