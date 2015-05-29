<?php

$path = dirname(__FILE__);
require($path . '/../lib/ObserverSubject.php');

// Obtain all the items
$items = array();

$query = "SELECT * FROM `items` WHERE expired=false";
$result =  $db->query($query) or die($db->error);
while ($row = $result->fetch_assoc()) {
	$items[] = new Item($row);
}

$shoppinglist = new ShoppingList();

foreach($items as $item) {
	$item->attach($shoppinglist);
	$item->checkExpiry();
}

?>