<?php

require('MySQLConnection.php');

abstract class AbstractObserver {
	abstract function update(AbstractSubject $subject);
}

abstract class AbstractSubject {
	abstract function attach(AbstractObserver $observer);
	abstract function detach(AbstractObserver $observer);
	abstract function notify();
}

class ShoppingList extends AbstractObserver {
	public function __construct() {
	}

	public function update(AbstractSubject $subject) {
		// Add item to shopping list when it expires
		if (!$subject->expired && time() > strtotime($subject->expiration_date)) {
			$user_id = $subject->user_id;
			$item_name = $subject->item_name;

			// See if item is already in the list
			$query = "SELECT * FROM `sl_items` WHERE user_id='$user_id' AND item_name='$item_name'";
			$result = $db->query($query) or die($db->error);
	        if ($result->num_rows) {
	            $row = $result->fetch_assoc();
	            // If so, increment the quantity to buy
	            $query = "UPDATE `sl_items` SET quantity = quantity + $subject->quantity";
				$result = $db->query($query) or die($db->error);
	        }
	        // If none of that item is in the list, add it to the list
	        else {
	        	$query = "INSERT INTO `sl_items` VALUES ($subject->user_id, '$subject->item_name', $subject->quantity)";
	        	$result = $db->query($query) or die($db->error);
	        }

	        // Update the item status
	        $query = "UPDATE `items` SET expired = TRUE WHERE item_id='$subject->item_id'";
	        $result = $db->query($query) or die($db->error);
		}
	}
}

class Item extends AbstractSubject {
	private $observers = array();

	public $item_id;

	public $user_id;

	public $item_name;

	public $expiration_date;

	public $expired;

	public $quantity;

	public $categories;

	public $storage_env;

	public function __construct($args) {
		foreach($args as $key => $value) {
			$this->$key = $value;
		}
	}

	public function attach(AbstractObserver $observer) {
		$this->observers[] = $observer;
	}

	public function detach(AbstractObserver $observer) {
		foreach($this->observers as $obskey => $obsval) {
			if ($obsval == $observer) {
				unset($this->observers[$obskey]);
			}
		}
	}

	public function notify() {
		foreach($this->observers as $observer) {
			$observer->update($this);
		}
	}

	// Notify all observers when the item first expires
	public function checkExpiry() {
		// Only check if item hasn't already expired
		if (!$expired) {
			$this->notify();
		}
	}

	// Notify all observers whenever the item is moved to another location
	public function changeEnvironment($env) {
		$storage_env = $env;
		$this->notify();
	}
}

?>