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

        echo $name;
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
?>