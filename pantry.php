<?php
    session_start();
    require('lib/MySQLConnection.php');

    $userid = $_SESSION['user-id'];
    if(!isset($userid))
        header("Location: index.php");
    // SQL query to retrieve all items in the database associated wih the current user
    $query = "SELECT I.item_id, I.item_name, I.expiration_date, I.expired, I.quantity, E.env_name, F.food_name, F.food_class, C.cat_name
                FROM items I, environments E, foods F, categories C
                WHERE I.user_id = " . $userid . " AND I.env_id = E.env_id AND F.food_id = I.food_id AND F.food_category = C.cat_id and I.expired = false
                ORDER BY I.expiration_date DESC";
    $items_result = $db->query($query) or die($db->error);

    $query = "SELECT I.item_id, I.item_name, I.expiration_date, I.expired, I.quantity, E.env_name, F.food_name, F.food_class, C.cat_name
                FROM items I, environments E, foods F, categories C
                WHERE I.user_id = " . $userid . " AND I.env_id = E.env_id AND F.food_id = I.food_id AND F.food_category = C.cat_id AND I.expired = true
                ORDER BY I.expiration_date DESC";
    $expired_result = $db->query($query) or die($db->error);

    // SQL query to retrieve all storange environments in the database associated wih the current user
    $query = "SELECT * FROM environments WHERE user_id = ". $userid;
    $envs_result = $db->query($query) or die($db->error);

    // SQL query to retrieve all categories
    $query = "SELECT * FROM categories ORDER BY cat_id ASC";
    $cat_result = $db->query($query) or die($db->error);
    $cat_form_html = "";
    $cat_sort_html = '<li><a class="active" href="#" data-group="all">All</a></li>';
    while($row = $cat_result->fetch_assoc()){
        $cat_form_html .= "<option value='".$row['cat_id']."'>".$row['cat_name']."</option>";
        $cat_sort_html .= '<li><a href="#" data-group="'.$row['cat_name'].'">'.$row['cat_name'].'</a></li>';
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Pantry</title>
    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css" type="text/css">
    <link rel="stylesheet" href="css/bootstrap-multiselect.css" type="text/css"/>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/landing-page.css" type="text/css">
    <link rel="stylesheet" href="css/pantry-page.css" type="text/css">
    <link rel="stylesheet" href="css/icons.css" type="text/css">
    <!-- Custom Fonts --t
    <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:100,300,500,700" type="text/css">
    <!-- jQuery libraries -->
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/additional-methods.min.js"></script>
    <!-- JavaScript -->
    <!-- <script type="text/javascript" src="js/main.js"></script> -->
</head>

<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/jquery.shuffle.min.js"></script>
    <script>
        $(document).ready(function() {
            /* initialize shuffle plugin */
            var $recently_expired_grid = $('#recently-expired-grid');

            $recently_expired_grid.shuffle({
                itemSelector: '.item' // the selector for the items in the grid
            });

            /* reshuffle when user clicks a filter item */
            $('#recently-expired-filter a').click(function (e) {
                e.preventDefault();

                // set active class
                $('#recently-expired-filter a').removeClass('active');
                $(this).addClass('active');

                // get group name from clicked item
                var groupName = $(this).attr('data-group');

                // reshuffle grid
                $recently_expired_grid.shuffle('shuffle', groupName );
            });

            /* initialize shuffle plugin */
            var $in_pantry_grid = $('#in-pantry-grid');

            $in_pantry_grid.shuffle({
                itemSelector: '.item' // the selector for the items in the grid
            });

            /* reshuffle when user clicks a filter item */
            $('#in-pantry-filter a').click(function (e) {
                e.preventDefault();

                // set active class
                $('#in-pantry-filter a').removeClass('active');
                $(this).addClass('active');

                // get group name from clicked item
                var groupName = $(this).attr('data-group');

                // reshuffle grid
                $in_pantry_grid.shuffle('shuffle', groupName );
            });

            /* handle adding a new item */
            $("button#btn-submit").click(function(){
                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: $('form.add').serialize(),
                    success: function(response){
                        var data = JSON.parse(response);
                        // delete the add item circle
                        var $addItem = $('#add-item');
                        $('#in-pantry-grid').shuffle('remove', $addItem);

                        var $newItem = $("<div class=\"item green circle remove " + data.itemClass + "\" id=\"item-" + data.id +
                            "\" data-item-id=\"" + data.id +
                            "\" data-item-name=\"" + data.name +
                            "\" data-item-expiration-date=\"" + data.expDate +
                            "\" data-item-quantity=\"" + data.quantity +
                            "\" data-item-categories=\"" + data.foodCategories +
                            "\" data-item-storage-env=\"" + data.storageEnv +
                            "\" data-groups='[\"all\", \""+data.foodCategories+"\"]'" +
                            "\" data-toggle=\"modal\"" +
                            "\" data-target=\"#view-item-modal\">");

                        // for manually entered items, just show the name of the item instead of an image
                        if (data.itemClass == "other") {
                            var $newItem = $("<div class=\"item green circle remove " + data.itemClass + "\" id=\"item-" + data.id +
                            "\" data-item-id=\"" + data.id +
                            "\" data-item-name=\"" + data.name +
                            "\" data-item-expiration-date=\"" + data.expDate +
                            "\" data-item-quantity=\"" + data.quantity +
                            "\" data-item-categories=\"" + data.foodCategories +
                            "\" data-item-storage-env=\"" + data.storageEnv +
                            "\" data-groups='[\"all\", \""+data.foodCategories+"\"]'" +
                            "\" data-toggle=\"modal\"" +
                            "\" data-target=\"#view-item-modal\">" +
                            "<span class=\"description\">" + data.name + "</span></div>");
                        }

                        var $addItem = $("<div class=\"item circle remove\" id=\"add-item\" data-groups='[\"all\"]' data-toggle=\"modal\" data-target=\"#add-item-modal\"></div>");
                        $items = $newItem.add($addItem);
                        $('#in-pantry-grid').append($items);
                        $('#in-pantry-grid').shuffle('appended', $items);
                    },
                    error: function(){
                        alert("failure");
                    }
                });
            });

            /* handle removing an item */
            $("button#btn-remove").click(function(){
                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: $('form.remove').serialize(),
                    success: function(response){
                        // delete the item
                        var id = $('form.remove input')[0].value;
                        var $item = $('#item-'+id);
                        $('#in-pantry-grid').shuffle('remove', $item);
                    },
                    error: function(){
                        alert("failure");
                    }
                });
            });

            /* reset the modal to step 1 and remove form data */
            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
                sendEvent('#add-item-modal', 1);
                $("form").trigger("reset");
            });

            /* populate item data when clicked */
            $('#view-item-modal').on('show.bs.modal', function(e) {
                // get data-item-XXX attributes of the clicked element
                var $itemID             = $(e.relatedTarget).data('item-id');
                var $itemName           = $(e.relatedTarget).data('item-name');
                var $itemExpirationDate = $(e.relatedTarget).data('item-expiration-date');
                var $itemQuantity       = $(e.relatedTarget).data('item-quantity');
                var $itemCategories     = $(e.relatedTarget).data('item-categories');
                var $itemStorageEnv     = $(e.relatedTarget).data('item-storage-env');
                // fill in the item's info
                document.getElementById("item-name-view").innerHTML              = $itemName;
                document.getElementById("item-expiration-date-view").innerHTML   = $itemExpirationDate;
                document.getElementById("item-quantity-view").innerHTML          = $itemQuantity;
                document.getElementById("item-categories-view").innerHTML        = $itemCategories;
                document.getElementById("item-storage-env-view").innerHTML       = $itemStorageEnv;
                document.getElementById("remove-item-id").value                  = $itemID;
            });
        });

    </script>

    <div id="wrapper">
    <!-- Navigation Bar -->
    <nav class="navbar navbar-default navbar-fixed-top topnav" role="navigation">
        <div class="container topnav">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand " href="pantry.php">Pantry</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-left">
                    <li><a href="pantry.php">Pantry</a></li>
                    <li><a href="shoppinglist.php">Shopping List</a></li>
                    <li><a href="environment.php">Storage Environments</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="pantry-logout.php">Log Out</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Pantry -->

    <!-- Recently Expired -->
    <h1 id="recently-expired-header">Recently Expired</h1>
    <div id="recently-expired-container" class="container-fluid">
        <ul id="recently-expired-filter" class="list-inline">
            <?php echo $cat_sort_html; ?>
        </ul>

        <div id="grid-wrapper">
            <div id="recently-expired-grid">
                <?php while($row = $expired_result->fetch_assoc()) : ?>
                    <?php if ((time() - strtotime($row['expiration_date'])) < (3600 * 24 * 7)) : ?>
                        <?php
                            if($row['item_name'] == "") $row['item_name'] = $row['food_name'];
                        ?>
                    <div class="item <?php echo $row['item_name']; ?> <?php echo $row['food_class']; ?>" id="item-<?php echo $row['item_id']; ?>"
                        data-item-id                =   "<?php echo $row['item_id']; ?>"
                        data-item-name              =   "<?php echo $row['item_name']; ?>"
                        data-item-expiration-date   =   "<?php echo $row['expiration_date']; ?>"
                        data-item-quantity          =   "<?php echo $row['quantity']; ?>"
                        data-item-categories        =   "<?php echo $row['cat_name']; ?>"
                        data-item-storage-env       =   "<?php echo $row['env_name']; ?>"
                        data-groups                 =   '["all", "<?php echo $row['cat_name']; ?>"]'
                        data-toggle                 =   "modal"
                        data-target                 =   "#view-item-modal">
                        <?php
                            // check if item was manually entered so we can decide to show item name or not
                            if ($row['food_class'] == 'other') {
                                echo "<span class=\"description\">" . $row['item_name'] . "</span>";
                            }
                        ?>
                    </div>
                    <?php endif; ?>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <hr/>

    <h1 id="in-pantry-header">In Pantry</h1>
    <div id="in-pantry-container" class="container-fluid">
        <ul id="in-pantry-filter" class="list-inline">
            <?php echo $cat_sort_html; ?>
        </ul>

        <div id="grid-wrapper">
            <div id="in-pantry-grid" class="row">
                <!-- Populate grid dynamically based on items in the database -->
                <?php while($row = $items_result->fetch_assoc()) : ?>
                        <?php
                            if($row['item_name'] == "") $row['item_name'] = $row['food_name'];
                        ?>
                    <div class="item <?php echo $row['item_name']; ?> <?php echo $row['food_class']; ?>" id="item-<?php echo $row['item_id']; ?>"
                        data-item-id                =   "<?php echo $row['item_id']; ?>"
                        data-item-name              =   "<?php echo $row['item_name']; ?>"
                        data-item-expiration-date   =   "<?php echo $row['expiration_date']; ?>"
                        data-item-quantity          =   "<?php echo $row['quantity']; ?>"
                        data-item-categories        =   "<?php echo $row['cat_name']; ?>"
                        data-item-storage-env       =   "<?php echo $row['env_name']; ?>"
                        data-groups                 =   '["all", "<?php echo $row['cat_name']; ?>"]'
                        data-toggle                 =   "modal"
                        data-target                 =   "#view-item-modal">
                        <?php
                            // check if item was manually entered so we can decide to show item name or not
                            if ($row['food_class'] == 'other') {
                                echo "<span class=\"description\">" . $row['item_name'] . "</span>";
                            }
                        ?>
                    </div>
                <?php endwhile; ?>
                <div class="item" id="add-item" data-groups='["all"]' data-toggle="modal" data-target="#add-item-modal"></div>
            </div>
        </div>
    </div>

    <!-- View item modal -->
    <div class="modal fade" id="view-item-modal" tabindex="-1" role="dialog" aria-labelledby="view-item-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="item-name-view"></h4>
                </div>
                <div class="modal-body">
                    <div id="view-item-container">
                        <p>Expiration Date: <span id="item-expiration-date-view"></span></p><br/>
                        <p>Quantity: <span id="item-quantity-view"></span></p><br/>
                        <p>Category: <span id="item-categories-view"></span></p><br/>
                        <p>Storage Environment: <span id="item-storage-env-view"></span></p>
                        <form class="modal remove">
                            <input class="form-control" type="hidden" name="remove-item-id" id="remove-item-id"/>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-modal-footer" type="submit" name="submit" id="btn-remove" data-dismiss="modal">Remove</button>
                    <button type="button" class="btn btn-modal-footer" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add item modal -->
    <form class="modal multi-step add" id="add-item-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title step-1" data-step="1"><h3>Add an item</h3><h5>Step 1: Choose entry method</h5></div>
                    <div class="modal-title step-2" data-step="2"><h3>Add an item Quickly</h3><h5>Step 2: Enter item information</h5></div>
                    <div class="modal-title step-3" data-step="3"><h3>Add an item Manually</h3><h5>Step 2: Enter item information</h5></div>
                    <div class="modal-title step-4" data-step="4"><h3>Add an item</h3><h5>Final Step: Enter expire information</h5></div>
                </div>
                <div class="modal-body step-1" data-step="1">
                    <div class="entry-method-outer-container">
                        <div class="entry-method-inner-container">
                            <button type="button" class="custom-button btn-entry-method" id="btn-enter-common" onclick="sendEvent('#add-item-modal', 2)">Enter Quickly</button>
                            <br\> <br\> <br\>
                            <button type="button" class="custom-button btn-entry-method" id="btn-enter-manually" onclick="sendEvent('#add-item-modal', 3)">Enter Manually</button>
                        </div>
                    </div>
                </div>
                <div class="modal-body step-2" data-step="2">
                    <div class="container-fluid">
                        <div id="item-info-container">
                            <span class="form-label">Category:</span>
                            <br/>
                            <div class="btn-group" style="width: 200px">
                                <select id="select-food-catagories" onChange="handleCategoryChange(this);">
                                    <?php echo $cat_form_html; ?>
                                </select>
                            </div>
                            <br/><br/><br/>

                            <div class="btn-group" style="width: 200px" id="select-food-div">
                            </div>
                            <br/><br/><br/>

                        </div>
                    </div>
                </div>
                <div class="modal-body step-3" data-step="3">
                    <div class="container-fluid">
                        <div id="item-info-container">
                            <span class="form-label">Item Name:</span>
                            <br/>
                            <input class="form-control" type="text" name="item-name" id="item-name" required/>
                            <br/>

                            <div class="btn-group" style="width: 200px">
                                <select name="food-category-id" id="select-food-category-id">
                                    <?php echo $cat_form_html; ?>
                                </select>
                            </div>
                            <br/><br/><br/>
                        </div>
                    </div>
                </div>
                <div class="modal-body step-4" data-step="4">
                    <div class="container-fluid">
                        <div id="item-info-container">
                            <span class="form-label">Quantity:</span>
                            <input id="quantity-input" name= "quantity" class="form-control" type="number" value="1" min="1" max="10" />
                            <br/>
                            <span class="form-label">Expiration Date (if any):</span>
                            <br/>
                            <input class="form-control" name="expiration-date" type="text" id="bs-datepicker">
                            <br/>

                            <span class="form-label">Storage Environment:</span>
                            <br/>
                            <div class="btn-group" style="width: 200px">
                                <select name="storage-env" id="select-storage-env">
                                <?php while($row = $envs_result->fetch_assoc()) { ?>
                                    <option value="<?php echo $row['env_id']; ?>"><?php echo $row['env_name'] ?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-modal-footer" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-modal-footer step step-2" data-step="2" onclick="sendEvent('#add-item-modal', 4)">Continue</button>
                    <button type="button" class="btn btn-modal-footer step step-3" data-step="3" onclick="sendEvent('#add-item-modal', 4)">Continue</button>
                    <button class="btn btn-modal-footer step step-4" type="submit" name="submit" id="btn-submit" data-step="4" data-dismiss="modal">Submit</button>
                </div>
            </div>
        </div>
    </form>

    <!-- Footer -->
    <footer class="small-footer">
        <div class="container text-center">
            <div class="row">
                <div class="col-lg-12">
                    <p class="copyright text-muted small">&copy; 2015 Pantry. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </footer>
    </div>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <!-- For Bootstrap multi-step modal -->
    <script src="js/bootstrap-multi-step-modal.js"></script>
    <script>
        sendEvent = function(sel, step) {
            $(sel).trigger('next.m.' + step);
        };
        handleCategoryChange = function() {
            $.post( "ajax.php?food-from-cat-id="+$('#select-food-catagories')[0].value, function( data ) {
              $( "#select-food-div" ).html( data );
              $('#select-food-id').multiselect();
            });
        };
    </script>
    <!-- For Bootstrap datepicker -->
    <script src="js/bootstrap-datepicker.js"></script>
    <script type="text/javascript">
        // When the document is ready
        $(document).ready(function () {
            $('#bs-datepicker').datepicker({
                format: "mm/dd/yyyy"
            });
        });
    </script>
    <!-- For Boostrap multi-select -->
    <script type="text/javascript" src="js/bootstrap-multiselect.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#select-food-catagories').multiselect();
            $('#select-storage-env').multiselect();
            $('#select-food-category-id').multiselect();
            //load initial food
            handleCategoryChange();
        });
    </script>

</body>

</html>