<?php
include "db_connection.php";
?>

<?php

if (isset($_POST['add']) && $_POST['add'] == 'add_user') {

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $url = $_POST['url'];
    $status = 1;
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $baseUrl = $protocol . "://" . $_SERVER['HTTP_HOST'];
    $fullUrl = $baseUrl . '/'.$name;
    
    
     if (!preg_match("/^[a-zA-Z]+$/", $name)) {
        $my_array = array('status' => false, 'name_error' => 'Please enter letters only');
        echo json_encode($my_array);
        exit;
    }

    $sql = $conn->prepare("SELECT * FROM users where user_name =:name");
    $sql->bindParam(':name', $name);
    $sql->execute();

    $array_data_exits = $sql->fetchAll(PDO::FETCH_ASSOC);
    $usernamecount = count($array_data_exits);

    if ($usernamecount > 0) {
        $my_array = array('status' => false, 'message' => 'Name is already exists');
        echo json_encode($my_array);
        exit;
    }

    $sql = $conn->prepare("SELECT * FROM users where phone =:phone");
    $sql->bindParam(':phone', $phone);
    $sql->execute();

    $array_data_exits = $sql->fetchAll(PDO::FETCH_ASSOC);
    $phonecount = count($array_data_exits);
    if ($phonecount > 0) {
        $my_array = array('status' => false, 'message' => 'phone is already exists');
        echo json_encode($my_array);
        exit;
    }

    $sql = $conn->prepare("SELECT * FROM users where email =:email");
    $sql->bindParam(':email', $email);
    $sql->execute();

    $array_data_exits = $sql->fetchAll(PDO::FETCH_ASSOC);
    $emailcount = count($array_data_exits);
    if ($emailcount > 0) {
        $my_array = array('status' => false, 'message' => 'email is already exists');
        echo json_encode($my_array);
        exit;
    }

    $sql = $conn->prepare("SELECT * FROM users where web_url =:fullUrl");
    $sql->bindParam(':fullUrl', $fullUrl);
    $sql->execute();

    $array_data_exits = $sql->fetchAll(PDO::FETCH_ASSOC);
    $urlcount = count($array_data_exits);
    if ($urlcount > 0) {
        $my_array = array('status' => false, 'message' => 'url is already exists');
        echo json_encode($my_array);
        exit;
    }

    try {
    $username_folder = $name;
    $base_path = __DIR__ . '/' . $username_folder;

    // Check if the folder already exists
    if (file_exists($base_path)) {
        $my_array = array('status' => true, 'message' => 'User folder already exists');
        echo json_encode($my_array);
        exit;
    }

    
    // Insert user data into the database
    $sql = $conn->prepare("INSERT INTO users (user_name, phone, email,web_url,url, status) VALUES (:name, :phone, :email,:fullUrl, :url, :status)");
    $sql->bindParam(':name', $name);
    $sql->bindParam(':phone', $phone);
    $sql->bindParam(':email', $email);
    $sql->bindParam(':fullUrl', $fullUrl);
    $sql->bindParam(':url', $url);
    $sql->bindParam(':status', $status);
    $sql->execute();

    $last_id = $conn->lastInsertId();
    $encode_data = base64_encode($last_id);

    if (mkdir($base_path, 0777, true)) {
        $file_path = $base_path . '/index.php';
    
        ob_start();
    
        include "layout.php";

        $file_content = ob_get_clean();
    
        if (file_put_contents($file_path, $file_content)) {
            
           $get_url = $baseUrl . '/'.$_POST['name'];
           
            $my_array = array('status' => true, 'message' => 'User website created successfully', 'is_active' => $encode_data,'url'=>$get_url);
        } else {
            $my_array = array('status' => true, 'message' => 'User website created successfully, but failed to create the file', 'is_active' => $encode_data);
        }
    } else {
        $my_array = array('status' => true, 'message' => 'User website created successfully, but failed to create the folder', 'is_active' => $encode_data);
    }


    echo json_encode($my_array);
    } catch (PDOException $e) {
        $my_array = array('status' => false, 'message' => 'User website creation failed', 'error' => $e->getMessage());
        echo json_encode($my_array);
    }

   
}


?>