<?php

require('../lib/ObserverSubject.php');

// Obtain all the items
$items = array();

$query = "SELECT * FROM `items` WHERE expired=false";
$result = mysql_query($query) or die(mysql_error());
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	$items[] = new Item($row);
}

$shoppinglist = new ShoppingList();

foreach($items as $item) {
	$item->attach($shoppinglist);
	$item->checkExpiry();
}

?>