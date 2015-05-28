<?php
    require('lib/MySQLConnection.php');
    if($_GET['food-from-cat-id']){
        $query = "SELECT * FROM foods
                  WHERE food_category = " . $_GET['food-from-cat-id'] . " AND food_id > " . $_GET['food-from-cat-id'] . "
                  ORDER BY food_id ASC";
        $food_result = $db->query($query) or die($db->error);

        // probably should send json to client, but whatever
        $html = "<select name='food-id' id='select-food-id'>";
        while($row = $food_result->fetch_assoc()){
            $html .= "<option value='".$row['food_id']."'>".$row['food_name']."</option>";
        }
        $html .= "</select>";
        echo $html;
    }
?>