<?php
	session_start();
	require('lib/MySQLConnection.php');

	$user_id = $_SESSION['user-id'];

	if (isset($_POST['action'])) {
		switch($_POST['action']) {
			case "check-item":
				$item_name = $_POST['item-name'];
				$query = "UPDATE `sl_items` SET checked = 1 WHERE user_id=$user_id AND item_name='$item_name'";
            	$result = $db->query($query) or die($db->error);
				break;
			case "delete-item":
				$item_name = $_POST['item-name'];
				$query = "DELETE FROM `sl_items` WHERE user_id=$user_id AND item_name='$item_name'";
				$result = $db->query($query) or die($db->error);
				break;
			case "finish-trip":
				// Get all items that were checked off to add to the pantry
				$query = "SELECT * FROM `sl_items` WHERE user_id=$user_id AND checked=1";
				$result = $db->query($query) or die($db->error);
				if ($result->num_rows) {
					while ($row = $result->fetch_assoc()) {
						$item_name = $row['item_name'];
						// Get a food id if one exists
						$query = "SELECT * FROM `foods` WHERE food_name='$item_name'";
						$food_result = $db->query($query) or die($db->error);
						if ($food_result->num_rows) {
							$food_row = $food_result->fetch_assoc();
							$food_id = $food_row['food_id'];
						}
						else {
							// Default to other
							$food_id = 1;
						}

						$quantity =  $row['quantity'];

						// Get storage environment
				        $query = "SELECT * FROM `environments`";
				        $envresult = $db->query($query) or die($db->error);
				        $storage_result = $envresult->fetch_assoc();
				        $storageenv = $storage_result['env_id'];

				        if($storage_result['temperature'] <= 32)
				            $sqlenv = 'food_expire_freezer';
				        else if($storage_result['temperature'] <= 39)
				            $sqlenv = 'food_expire_fridge';
				        else
				            $sqlenv = 'food_expire_room';

			            $query = "SELECT *
			                      FROM foods
			                      WHERE food_id = ".$food_id;
			            $food_result = $db->query($query) or die($db->error);
			            $row = $food_result->fetch_assoc(); //need to figure out what expiration time to use based on storage env still
			            $expirationdate = date('Y-m-d', strtotime('+'.$row[$sqlenv].' hour'));

				        $query = "INSERT INTO `items`(`user_id`, `item_name`, `food_id`, `expiration_date`, `quantity`, `env_id`)
				                    VALUES ('$user_id', '$item_name', '$food_id', '$expirationdate', '$quantity', '$storageenv')";
				        $insresult = $db->query($query) or die($db->error);
					}
				}

				$query = "DELETE FROM `sl_items` WHERE user_id=$user_id";
				$result = $db->query($query) or die($db->error);
				break;
		}
	}


?>