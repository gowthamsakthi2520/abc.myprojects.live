<?php

include 'database.php';

$in_active = 0;

$active = 1;

$sql = $conn->prepare("SELECT 
u.*,
(SELECT COUNT(*) FROM users WHERE status = $in_active) AS inactive_count,
(SELECT COUNT(*) FROM users WHERE status =$active) AS active_count,
(SELECT COUNT(*) FROM users) AS all_users
FROM 
users AS u
");

$sql->execute();

$count = $sql->fetchAll();

// print_r($count_in);
// echo $count[0]['active_count'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- heading css include -->
    <?php
    include "heading_css.php";
    ?>


</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- spinner & sidebar include-->
        <?php
        include "sidebar.php";
        ?>

        <div class="content">
            <!-- navbar include -->
            <?php
            include "navbar.php";
            ?>
            <!-- Sale & Revenue Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-line fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Users</p>
                                <h6 class="mb-0"><?php echo $count[0]['all_users']; ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-bar fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Active Users</p>
                                <h6 class="mb-0"><?php echo $count[0]['active_count']; ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-area fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Inactive Users</p>
                                <h6 class="mb-0"><?php echo $count[0]['inactive_count']; ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-pie fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total</p>
                                <h6 class="mb-0"><?php echo $count[0]['all_users']; ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sale & Revenue End -->



            <!-- Footer include -->
            <?php
            include "footer.php";
            ?>

        </div>

    </div>

    <!-- bottom js include -->
    <?php
    include "bottom_js.php";
    ?>

</body>

</html>