<?php
// keep the same order
require("../config.php");
$db = new Database();
$con = $db->getConnString();

require('../session.php');

require('../queries/types_query.php');
require "../queries/classes/InfrastructureTypes.php";


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

    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f2f2f2;
            font-family: 'Montserrat', sans-serif;
        }

        .table-container {
            margin: 40px auto 0;
        }


        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table thead {
            background-color: #035419;
        }

        .table thead tr th {
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.35px;
            color: #ffffff;
            opacity: 1;
            padding: 12px;
            vertical-align: top;
            border: 1px solid #035419;
            text-align: left;
        }

        .table tbody tr td {
            font-size: 14px;
            letter-spacing: 0.35px;
            font-weight: normal;
            color: #fff;
            background-color: #024416;
            padding: 8px;
            text-align: left;
            border: 1px solid #228765;
        }

        .table .text_open {
            font-size: 14px;
            font-weight: bold;
            letter-spacing: 0.35px;
            color: #ff1800;
        }

        .table .text_green {
            font-size: 14px;
            font-weight: bold;
            letter-spacing: 0.35px;
            color: green;
        }

        .table tbody tr td .btn {
            width: 130px;
            text-decoration: none;
            line-height: 35px;
            display: inline-block;
            background-color: #3c3f44;
            font-weight: 200;
            color: #ffffff;
            text-align: center;
            vertical-align: middle;
            user-select: none;
            border: 1px solid transparent;
            font-size: 14px;
            opacity: 1;
        }



        @media (max-width: 768px) {
            .table thead {
                display: none;
            }

            .table,
            .table tbody,
            .table tr,
            .table td {
                display: block;
                width: 100%;
            }

            .table tr {
                margin-bottom: 15px;
            }

            .table tbody tr td {
                text-align: right;
                padding-left: 50%;
                position: relative;
            }

            .table td:before {
                content: attr(data-label);
                position: absolute;
                left: 0;
                width: 50%;
                padding-left: 15px;
                font-weight: 600;
                font-size: 14px;
                text-align: left;
            }

        }
    </style>
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



                    <li class="nav-link active">
                        <a href="newType">
                            <i class='bx bx-candles  icon'></i>
                            <span class="text nav-text">Type</span>
                        </a>
                    </li>

                    <li class="nav-link">
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
                        <h3 class="sectionlable">Types</h3>
                        <h6 class="sectionlable">All Types of Infrastructure</h6>
                    </div>

                    <button class="createnewbtn btncreatenew">Add New
                    </button>

                    <div class="table-container">
                        <table class="table">
                            <?php if ($infrastructure) : ?>

                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Marker</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php
                                    $i = 1;
                                    foreach ($infrastructure as $row) :
                                    ?>

                                        <?php
                                        $infras = new InfrastructureTypes($con, $row);
                                        ?>


                                        <tr>
                                            <td data-label="Order no"><?= $i ?></td>
                                            <td data-label="Map Marker">
                                                <img width="20" height="20" src="<?= $infras->getIconpath(); ?>" alt="">
                                            </td>
                                            <td data-label="Name">

                                                <?= $infras->getName() ?>

                                            </td>

                                            <td data-label="Action">

                                                <div class="myactionbtn" style="display: flex;grid-gap: 1em;">

                                                    <div class="approvebutton_parent">
                                                        <input class="cardID" type="hidden" name="ID" value="<?= $infras->getId() ?>">
                                                        <input class="type_NAME" type="hidden" name="type_NAME" value="<?= $infras->getName() ?>">
                                                        <button class="approvebutton">Edit</button>
                                                    </div>

                                                    <div class="cancebutton_parent">
                                                        <input class="cardID" type="hidden" name="orderID" value="<?= $infras->getId() ?>">
                                                        <button class="cancelbutton">Delete</button>
                                                    </div>
                                                </div>


                                            </td>

                                        </tr>

                                    <?php
                                        $i++;
                                    endforeach ?>


                                </tbody>
                            <?php else : ?>
                                <div style="display:grid; place-content: center; text-align: center; color: #3d3a3a; align-content: center; justify-items: center; height: 300px">
                                    <h1> No Infrastructure Types </h1>
                                    <p>Create one</p>

                                </div>
                            <?php endif ?>
                        </table>
                    </div>

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
                                <input type="text" id="name" name="name" class="form-control" placeholder="Infrastructure Type">
                            </div>

                            <div class="form-group">
                                <input id="file_input_map_icon" name="file-input-name" class="form-control" type='file' accept="image/*" />
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
                            <h1>Delete Type</h1>
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
    <script src="../js/processType.js"></script>


</body>


</html>