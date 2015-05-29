<?php
    session_start();
    require('lib/MySQLConnection.php');

    if ((isset($_POST['item-name']) && $_POST['item-name'] != "") || isset($_POST['food-id'])) {
        $userid = $_SESSION['user-id'];
        if((isset($_POST['item-name']) && $_POST['item-name'] != "") )
            $name = $_POST['item-name'];
        else
            $name = "";
        $quantity = $_POST['quantity'];
        $storageenv = $_POST['storage-env'];
        if(isset($_POST['item-name']) && $_POST['item-name'] != "")
            $foodid = $_POST['food-category-id']; // This because the food-category-id also is the same as the "other" related food item for the category
        else
            $foodid = $_POST['food-id'];
        if(isset($_POST['expiration-date']) && $_POST['expiration-date'] != "")
            $expirationdate = date('Y-m-d', strtotime($_POST['expiration-date']));
        else{
            $query = "SELECT *
                      FROM foods
                      WHERE food_id = ".$foodid;
            $food_result = $db->query($query) or die($db->error);
            $row = $food_result->fetch_assoc(); //need to figure out what expiration time to use based on storage env still
            $expirationdate = date('Y-m-d', strtotime('+'.$row['food_expire_fridge'].' hour'));
        }

        $query = "INSERT INTO `items`(`user_id`, `item_name`, `food_id`, `expiration_date`, `quantity`, `env_id`)
                    VALUES ('$userid', '$name', '$foodid', '$expirationdate', '$quantity', '$storageenv')";
        $result = $db->query($query) or die($db->error);

        $itemid = $db->insert_id;

        $query2 = "SELECT `env_name` FROM `environments` WHERE `env_id`=$storageenv";
        $result2 = $db->query($query2) or die($db->error);
        $row = $result2->fetch_assoc();

        echo json_encode(array(
            "id"                => $itemid,
            "name"              => $name,
            "expDate"           => $expirationdate,
            "quantity"          => $quantity,
            "foodCategories"    => $_POST['food-category-id'],
            "storageEnv"        => $row['env_name']
        ));
    }

    if (isset($_POST['remove-item-id'])) {
        $userid = $_SESSION['user-id'];
        $itemid = $_POST['remove-item-id'];

        $query = "DELETE FROM `items`
                     WHERE user_id = ".$userid." AND item_id = ".$itemid;
        $result = $db->query($query) or die($db->error);

        echo $itemid;
    }

    if (isset($_POST['storage-name'])) {
        $userid = $_SESSION['user-id'];
        $name = $_POST['storage-name'];
        $temp = $_POST['storage-temp'];

        $query = "INSERT INTO `environments`(`user_id`, `env_name`, `temperature`)
                    VALUES ('$userid', '$name', '$temp')";
        $result = $db->query($query) or die($db->error);

        $storageid = $db->insert_id;

        echo json_encode(array(
            "id"    => $storageid,
            "name"  => $name,
            "temp"  => $temp,
        ));
    }

    if (isset($_POST['remove-storage-id'])) {
        $userid = $_SESSION['user-id'];
        $envid = $_POST['remove-storage-id'];

        $query = "DELETE FROM `environments`
                     WHERE user_id = ".$userid." AND env_id = ".$envid;
        $result =  $db->query($query) or die($db->error);

        echo $envid;
    }
?>