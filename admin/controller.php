<?php
include 'database.php'

?>

<?php

?>

<?php
if (isset($_POST['login']) && $_POST['login'] == "login-form-type") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {

        $sql = $conn->prepare("SELECT * FROM admin WHERE email = :email");
        $sql->bindParam(':email', $email);
        $sql->execute();

        $user = $sql->fetch(PDO::FETCH_ASSOC);

        if ($user) {

            $usersPassword = base64_decode($user['encrypt_password']);

            if ($password === $usersPassword) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $response = array('status' => true, 'message' => 'Login successful');
                echo json_encode($response);

                exit();
            } else {
                $response = array('status' => false, 'message' => 'Login failed');
                echo json_encode($response);
               
            }

        } else {
            // If the username was not found
            $response = array('status' => false, 'message' => 'Unauthorized User.');
            echo json_encode($response);
        }
    } catch (PDOException $e) {
        $response = array('status' => false, 'message' => 'Login failed', 'error' => $e->getMessage());
        echo json_encode($response);
    }
}
?>

<?php

if (isset($_POST['log_out']) && $_POST['log_out'] == "log_out_value") {

    session_start();

    session_destroy();

    unset($_SESSION['user_id']);

    $response = ['status' => true, 'message' => 'logout successfully'];
    echo json_encode($response);
}

?>