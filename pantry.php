<?php
    session_start();
    require('lib/MySQLConnection.php');

    $userid = $_SESSION['user-id'];
    // SQL query to retrieve all items in the database associated wih the current user
    $query = "SELECT I.item_name, I.expiration_date, I.quantity, I.categories, I.storage_env
                FROM items I
                WHERE I.user_id = " . $userid . "
                ORDER BY I.expiration_date DESC";
    $result = mysql_query($query) or die(mysql_error());
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
    <!-- Custom Fonts -->
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
                    data: $('form.modal').serialize(),
                    success: function(response){
                        // delete the add item circle
                        var $addItem = $('#add-item');
                        $('#in-pantry-grid').shuffle('remove', $addItem);

                        // append a new item and the add item circle to the grid
                        var $newItem = $("<div class=\"item green circle remove\" data-groups='[\"all\"]' data-toggle=\"modal\" data-target=\"#view-item-modal\">" + response + "</div>");
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

            /* reset the modal to step 1 and remove form data */
            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
                sendEvent('#add-item-modal', 1);
                $("form").trigger("reset");
            });

            /* populate item data when clicked */
            $('#view-item-modal').on('show.bs.modal', function(e) {
                // get data-item-XXX attributes of the clicked element
                var $itemName           = $(e.relatedTarget).data('item-name');
                var $itemExpirationDate = $(e.relatedTarget).data('item-expiration-date');
                var $itemQuantity       = $(e.relatedTarget).data('item-quantity');
                var $itemCategories     = $(e.relatedTarget).data('item-categories');
                var $itemStorageEnv     = $(e.relatedTarget).data('item-storage-env');
                // fill in the item's info
                document.getElementById("item-name").innerHTML              = $itemName;
                document.getElementById("item-expiration-date").innerHTML   = $itemExpirationDate;
                document.getElementById("item-quantity").innerHTML          = $itemQuantity;
                document.getElementById("item-categories").innerHTML        = $itemCategories;
                document.getElementById("item-storage-env").innerHTML       = $itemStorageEnv;
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
                    <li><a href="#">Shopping List</a></li>
                    <li><a href="#">Storage Environments</a></li>
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
            <li><a class="active" href="#" data-group="all">All</a></li>
            <li><a href="#" data-group="dairy">Dairy</a></li>
            <li><a href="#" data-group="fruits">Fruits</a></li>
            <li><a href="#" data-group="grains-beans">Grains &amp; Beans</a></li>
            <li><a href="#" data-group="meat-proteins">Meat &amp; Proteins</a></li>
            <li><a href="#" data-group="sweets">Sweets</a></li>
            <li><a href="#" data-group="vegetables">Vegetables</a></li>
            <li><a href="#" data-group="liquids">Liquids</a></li>
        </ul>

        <div id="grid-wrapper">
            <div id="recently-expired-grid">
                <div class="item pear"              data-groups='["all", "fruits"]'>            <span class="description">Pear</span></div>
                <div class="item raw-salmon"        data-groups='["all", "meat-proteins"]'>     <span class="description">Raw Salmon</span></div>
                <div class="item milk"              data-groups='["all", "dairy", "liquids"]'>  <span class="description">Milk</span></div>
                <div class="item carrots"           data-groups='["all", "vegetables"]'>        <span class="description">Carrots</span></div>
                <div class="item apple-pie"         data-groups='["all", "sweets"]'>            <span class="description">Apple Pie</span></div>
                <div class="item pineapple"         data-groups='["all", "fruits"]'>            <span class="description">Pineapple</span></div>
                <div class="item bread"             data-groups='["all", "grains-beans"]'>      <span class="description">Bread</span></div>
                <div class="item frozen-chicken"    data-groups='["all", "meat-proteins"]'>     <span class="description">Frozen Chicken</span></div>
                <div class="item eggplant"          data-groups='["all", "vegetables"]'>        <span class="description">Eggplant</span></div>
                <div class="item kiwi"              data-groups='["all", "fruits"]'>            <span class="description">Kiwi</span></div>
                <div class="item cooked-beefsteak"  data-groups='["all", "meat-proteins"]'>     <span class="description">Cooked Beef Steak</span></div>
                <div class="item greek-yogurt"      data-groups='["all", "dairy"]'>             <span class="description">Greek Yogurt</span></div>
                <div class="item banana"            data-groups='["all", "fruits"]'>            <span class="description">Banana</span></div>
                <div class="item orange-juice"      data-groups='["all", "liquids"]'>           <span class="description">Orange Juice</span></div>
                <div class="item spinach"           data-groups='["all", "vegetables"]'>        <span class="description">Spinach</span></div>
                <div class="item snickers"          data-groups='["all", "sweets"]'>            <span class="description">Snickers</span></div>
            </div>
        </div>
    </div>

    <hr/>

    <h1 id="in-pantry-header">In Pantry</h1>
    <div id="in-pantry-container" class="container-fluid">
        <ul id="in-pantry-filter" class="list-inline">
            <li><a class="active" href="#" data-group="all">All</a></li>
            <li><a href="#" data-group="dairy">Dairy</a></li>
            <li><a href="#" data-group="fruits">Fruits</a></li>
            <li><a href="#" data-group="grains-beans">Grains &amp; Beans</a></li>
            <li><a href="#" data-group="meat-proteins">Meat &amp; Proteins</a></li>
            <li><a href="#" data-group="sweets">Sweets</a></li>
            <li><a href="#" data-group="vegetables">Vegetables</a></li>
            <li><a href="#" data-group="liquids">Liquids</a></li>
        </ul>

        <div id="grid-wrapper">
            <div id="in-pantry-grid" class="row">
                <!-- Populate grid dynamically based on items in the database -->
                <?php while($row = mysql_fetch_assoc($result)) { ?>
                    <div class="item pear"
                        data-item-id                =   "<?php echo $row['item_id']; ?>"
                        data-item-name              =   "<?php echo $row['item_name']; ?>"
                        data-item-expiration-date   =   "<?php echo $row['expiration_date']; ?>"
                        data-item-quantity          =   "<?php echo $row['quantity']; ?>"
                        data-item-categories        =   "<?php echo $row['categories']; ?>"
                        data-item-storage-env       =   "<?php echo $row['storage_env']; ?>"
                        data-groups                 =   '["all", "meat-proteins"]'
                        data-toggle                 =   "modal"
                        data-target                 =   "#view-item-modal">
                        <span class="description"><?php echo $row['item_name']; ?></span>
                    </div>
                <?php } ?>
                <div class="item" id="add-item" data-groups='["all"]' data-toggle="modal" data-target="#add-item-modal"></div>
            </div>
        </div>
    </div>

    <!-- View item modal -->
    <div class="modal fade" id="view-item-modal" tabindex="-1" role="dialog" aria-labelledby="view-item-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="item-name"></h4>
                </div>
                <div class="modal-body">
                    <div id="view-item-container">
                        <p>Expiration Date: <span id="item-expiration-date"></span></p><br/>
                        <p>Quantity: <span id="item-quantity"></span></p><br/>
                        <p>Categories: <span id="item-categories"></span></p><br/>
                        <p>Storage Environment: <span id="item-storage-env"></span></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-modal-footer" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add item modal -->
    <form class="modal multi-step" id="add-item-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title step-1" data-step="1"><h3>Add an item</h3><h5>Step 1: Choose entry method</h5></div>
                    <div class="modal-title step-2" data-step="2"><h3>Add an item manually</h3><h5>Step 2: Enter item information</h5></div>
                    <div class="modal-title step-3" data-step="3"><h3>Add an item manually</h3><h5>Final Step: Enter more information</h5></div>
                </div>
                <div class="modal-body step-1" data-step="1">
                    <div class="entry-method-outer-container">
                        <div class="entry-method-inner-container">
                            <button type="button" class="custom-button btn-entry-method" id="btn-enter-manually" onclick="sendEvent('#add-item-modal', 2)">Enter Manually</button>
                            <div class="empty-space"></div>
                            <button type="button" class="custom-button btn-entry-method" id="btn-can-barcode">Scan Barcode</button>
                        </div>
                    </div>
                </div>
                <div class="modal-body step-2" data-step="2">
                    <div class="container-fluid">
                        <div id="item-info-container">
                            <span class="form-label">Item Name:</span>
                            <br/>
                            <input class="form-control" type="text" name="item-name" id="item-name" required/>
                            <br/>

                            <span class="form-label">Expiration Date (if any):</span>
                            <br/>
                            <input class="form-control" name="expiration-date" type="text" id="bs-datepicker">
                            <br/>
                        </div>
                    </div>
                </div>
                <div class="modal-body step-3" data-step="3">
                    <div class="container-fluid">
                        <div id="item-info-container">
                            <span class="form-label">Quantity:</span>
                            <input id="quantity-input" name= "quantity" class="form-control" type="number" value="1" min="1" max="10" />
                            <br/>

                            <span class="form-label">Categor(ies):</span>
                            <br/>
                            <div class="btn-group" style="width: 200px">
                                <select name="food-categories[]" id="select-food-catagories" multiple="multiple">
                                    <option value="dairy">Dairy</option>
                                    <option value="fruits">Fruits</option>
                                    <option value="grains-beans">Grains &amp; Beans</option>
                                    <option value="meat-proteins">Meat &amp; Proteins</option>
                                    <option value="sweets">Sweets</option>
                                    <option value="vegetables">Vegetables</option>
                                    <option value="liquids">Liquids</option>
                                </select>
                            </div>
                            <br/><br/><br/>

                            <span class="form-label">Storage Environment:</span>
                            <br/>
                            <div class="btn-group" style="width: 200px">
                                <select name="storage-env" id="select-storage-env">
                                    <option value="refrigerator">Refrigerator</option>
                                    <option value="freezer">Freezer</option>
                                    <option value="pantry">Pantry</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-modal-footer" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-modal-footer step step-2" data-step="2" onclick="sendEvent('#add-item-modal', 1)">Back</button>
                    <button type="button" class="btn btn-modal-footer step step-2" data-step="2" onclick="sendEvent('#add-item-modal', 3)">Continue</button>
                    <button type="button" class="btn btn-modal-footer step step-3" data-step="3" onclick="sendEvent('#add-item-modal', 2)">Back</button>
                    <button class="btn btn-modal-footer step step-3" type="submit" name="submit" id="btn-submit" data-step="3" data-dismiss="modal">Submit</button>
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
        }
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
        });
    </script>

</body>

</html>