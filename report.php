<?php
// keep the same order
require("admin/config.php");
$db = new Database();
$con = $db->getConnString();

$cases_requests = array();
$cases_new = mysqli_query($con, "SELECT * FROM cases WHERE  status = 1 ORDER BY  `cases`.`id` DESC LIMIT 8");
while ($row = mysqli_fetch_array($cases_new, MYSQLI_ASSOC)) {
    array_push($cases_requests, $row);
}

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
                    <a class="nav-link active" href="report.php">Report</a>
                </li>

            </ul>
        </div>
    </nav>


    <section class="report_page">
        <div class="container">
            <div class="cardcomponent">


                <div class="report_form">

                    <form action="" method="post">


                        <div class="form_inputgrou">
                            <label for="Name" class="labeltext">Name</label>
                            <input id="Name" type="text" name="Name" class="inputbox" placeholder="Name" required />

                        </div>
                        <div class="form_inputgrou">
                            <label for="Contact" class="labeltext">Contact</label>
                            <input id="Contact" type="text" name="Contact" class="inputbox" placeholder="Email / Phone no" required />
                        </div>

                        <div class="form_inputgrou">
                            <label for="Title" class="labeltext">Title</label>
                            <input id="Title" type="text" name="case_title" class="inputbox" placeholder="Report Title" required />

                        </div>

                        <div class="form_inputgrou">
                            <label for="Address" class="labeltext">Address</label>
                            <input id="Address" type="address" name="user_address" class="inputbox" placeholder="Address" required />

                        </div>


                        <div class="form_inputgrou">
                            <textarea id="Description" rows="4" cols="50" type="text" name="case_description" class="inputbox" placeholder="Report Description" required></textarea>

                        </div>
                        <div class="form_inputgrou">
                            <div class="inputbtton">
                            <button type="submit" value="Submit">Submit</button>
                            </div>
                        </div>

                    </form>

                </div>


                <?php if ($cases_requests) : ?>

                    <div class="case_container">


                        <?php
                        foreach ($cases_requests as $infra) :
                        ?>


                            <div class="product-card" style="color: #fff; font-size: 15px;">
                                <div class="infras_card">
                                    <div class="case_style">

                                        <div class="description">
                                            <h1 style="color: #228765; font-size: 22px;"><?= $infra['title'] ?></h1>
                                            <p style="color:#36CC7C ">
                                                <?= $infra['name'] ?>, <?= $infra['location'] ?>
                                            </p>
                                            <p style="color: #0f3c2d;"><?= $infra['description'] ?></p>

                                        </div>
                                    </div>
                                </div>
                            </div>

                    </div>

                <?php endforeach ?>

            </div>


        <?php else : ?>
            <div class="me" style="display: grid; place-content:center; text-align:center; color:#fff;">
                No Case Submitted

            </div>
        <?php endif ?>

        </div>


        </div>
    </section>



</body>

</html>