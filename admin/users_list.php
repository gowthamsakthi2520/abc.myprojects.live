<!DOCTYPE html>
<html lang="en">

<head>
    <!-- heading css include -->
    <?php
    include "heading_css.php";
    ?>


    <?php
    include "database.php";
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

            <!-- table content -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="bg-light rounded h-100 p-4">

                            <h6 class="mb-4">List of Users</h6>
                            <div class="table-responsive">
                                <table class="table" id="tableid">
                                    <?php
                                    $sql = $conn->prepare('select * from users');
                                    $sql->execute();

                                    $array = $sql->fetchAll(PDO::FETCH_ASSOC);
                                    // echo print_r($array);
                                    ?>

                                    <thead>
                                        <tr>
                                            <th scope="col">S_no</th>
                                            <th scope="col">First Name</th>
                                            <th scope="col">MObile No</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">url</th>
                                            <th scope="col">Status</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $s_no = 1;
                                        foreach ($array as $key => $val) {
                                            echo '<tr>';
                                            echo '<td>' . $s_no++ . '</td>';
                                            echo '<td>' . $val['user_name'] ?? '' . '</td>';
                                            echo '<td>' . $val['phone'] ?? '' . '</td>';
                                            echo '<td>' . $val['email'] ?? '' . '</td>';
                                            echo '<td>' . $val['url'] ?? '' . '</td>';
                                            if($val['status'] == 1){
                                                echo "<td><span class='badge bg-success'>Active</span></td>";
                                            }else{
                                                echo "<td><span class='badge bg-danger'>Inactive</span></td>";
                                            }
                                            echo '</tr>';
                                        }
                                        ?>
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



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

<script>
    $(document).ready(function() {
            $('#tableid').DataTable({ });
        });
</script>

</html>