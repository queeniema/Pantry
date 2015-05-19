<?php
    session_start();
    require('lib/MySQLConnection.php');

    if (isset($_POST['item-name'])) {
        $userid = $_SESSION['user-id'];
        $name = $_POST['item-name'];
        $expirationdate = date('Y-m-d', strtotime($_POST['expiration-date']));
        $quantity = $_POST['quantity'];
        $storageenv = $_POST['storage-env'];
        $foodcategories = array();
        foreach($_POST['food-categories'] as $k => $v) {
            array_push($foodcategories, $v);
        }
        $foodcategories = implode(",", $foodcategories);

        $query = "INSERT INTO `items`(`user_id`, `item_name`, `expiration_date`, `quantity`, `categories`, `env_id`)
                    VALUES ('$userid', '$name', '$expirationdate', '$quantity', '$foodcategories', '$storageenv')";
        $result = mysql_query($query) or die(mysql_error());

        echo json_encode(array("name"=>$name, "id"=>mysql_insert_id()));
    }

    if (isset($_POST['remove-item-id'])) {
        $userid = $_SESSION['user-id'];
        $itemid = $_POST['remove-item-id'];

        $query = "DELETE FROM `items`
                     WHERE user_id = ".$userid." AND item_id = ".$itemid;
        $result = mysql_query($query) or die(mysql_error());

        echo $itemid;
    }

    if (isset($_POST['storage-name'])) {
        $userid = $_SESSION['user-id'];
        $name = $_POST['storage-name'];
        $temp = $_POST['storage-temp'];

        $query = "INSERT INTO `environments`(`user_id`, `env_name`, `temperature`)
                    VALUES ('$userid', '$name', '$temp')";
        $result = mysql_query($query) or die(mysql_error());

        echo $name;
    }

    if (isset($_POST['remove-storage-id'])) {
        $userid = $_SESSION['user-id'];
        $envid = $_POST['remove-storage-id'];

        $query = "DELETE FROM `environments`
                     WHERE user_id = ".$userid." AND env_id = ".$envid;
        $result = mysql_query($query) or die(mysql_error());

        echo $envid;
    }
?>