<?php
    session_start();
    require('lib/MySQLConnection.php');

    $userid = $_SESSION['user-id'];
    // SQL query to retrieve all items in the database associated wih the current user
    $query = "SELECT * FROM sl_items I WHERE I.user_id = " . $userid;
    $result = $db->query($query) or die($db->error);

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
    <link rel="stylesheet" href="css/shopping-list-page.css" type="text/css">
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

    <!-- Shopping List -->

    <h1 id="shopping-list-header">Shopping List</h1>
    <div id="shopping-list-container" class="container-fluid">
        <ul class="list-group">
          <!-- Populate grid dynamically based on items in the database -->
            <?php while($row = $result->fetch_assoc()) { ?>
            <li class="list-group-item">
                <ul class="media-list">
                    <li class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object" src="http://placehold.it/64x64" alt="...">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><?php echo $row['item_name']; ?></h4>
                            Quantity: <?php echo $row['quantity']; ?>
                        </div>
                        <div class="media-right">
                            <button type="button" class="btn <?php echo $row['checked'] ? 'btn-success' : 'btn-default'; ?> check-item">✓</button>
                            <button type="button" class="btn btn-danger delete-item">✖</button>
                        </div>
                    </li>
                </ul>
            </li>
            <?php } ?>
        </ul>

        <button type="button" class="btn btn-default" data-groups='["all"]' data-toggle="modal" data-target="#add-item-modal">Add Item</button>
        <button type="button" class="btn btn-default" id="finish-trip">Finish Shopping Trip</button>
    </div>

    <form class="modal multi-step add" id="add-item-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title step-1" data-step="1"><h3>Add an item</h3><h5>Step 1: Choose entry method</h5></div>
                    <div class="modal-title step-2" data-step="2"><h3>Add an item Quickly</h3><h5>Step 2: Enter item information</h5></div>
                    <div class="modal-title step-3" data-step="3"><h3>Add an item Manually</h3><h5>Step 2: Enter item information</h5></div>
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

                            <span class="form-label">Quantity:</span>
                            <input id="quantity-input" name= "quantity" class="form-control" type="number" value="1" min="1" max="10" />
                            <br/><br/><br/>

                        </div>
                    </div>
                </div>
                <div class="modal-body step-3" data-step="3">
                    <div class="container-fluid">
                        <div id="item-info-container">
                            <span class="form-label">Item Name:</span>
                            <br/>
                            <input class="form-control" type="text" name="sl-item-name" id="item-name" required/>
                            <br/>
                            <span class="form-label">Quantity:</span>
                            <input id="quantity-input" name= "quantity" class="form-control" type="number" value="1" min="1" max="10" />
                            <br/><br/><br/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-modal-footer" data-dismiss="modal">Close</button>
                    <button class="btn btn-modal-footer step step-2" type="submit" name="submit" id="btn-submit1" data-step="2" data-dismiss="modal">Submit</button>
                    <button class="btn btn-modal-footer step step-3" type="submit" name="submit" id="btn-submit2" data-step="3" data-dismiss="modal">Submit</button>
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
        handleCategoryChange = function() {
            $.post( "ajax.php?sl-food-from-cat-id="+$('#select-food-catagories')[0].value, function( data ) {
              $( "#select-food-div" ).html( data );
              $('#select-food-id').multiselect();
            });
        };
    </script>
    <!-- For Boostrap multi-select -->
    <script type="text/javascript" src="js/bootstrap-multiselect.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#select-food-catagories').multiselect();
            $('#select-food-category-id').multiselect();
            //load initial food
            handleCategoryChange();

            // Handle adding item to shopping list
            $("button#btn-submit1, button#btn-submit2").click(function(){
                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: $('form.add').serialize(),
                    success: function(response){
                        window.location.href = 'shoppinglist.php';
                    },
                    error: function(){
                        alert("failure");
                    }
                });
            });

            $(".check-item").click(function(){
                var check = $(this);
                var itemname = check.closest(".media").find(".media-heading").html();
                $.ajax({
                    type: "POST",
                    url: "shoppingprocess.php",
                    data: {
                        "action" : "check-item",
                        "item-name" : itemname
                    },
                    success: function(response){
                        check.removeClass("btn-default");
                        check.addClass("btn-success");
                        console.log(response);
                    },
                    error: function(){
                        alert("failure");
                    }
                });
            });

            $(".delete-item").click(function(){
                var del = $(this);
                var itemname = del.closest(".media").find(".media-heading").html();
                $.ajax({
                    type: "POST",
                    url: "shoppingprocess.php",
                    data: {
                        "action" : "delete-item",
                        "item-name" : itemname
                    },
                    success: function(response){
                        del.closest(".list-group-item").remove();
                    },
                    error: function(){
                        alert("failure");
                    }
                });
            });

            $("#finish-trip").click(function(){
                $.ajax({
                    type: "POST",
                    url: "shoppingprocess.php",
                    data: {
                        "action" : "finish-trip"
                    },
                    success: function(response){
                        window.location.href = 'pantry.php';
                    },
                    error: function(){
                        alert("failure");
                    }
                });
            });
        });
    </script>

</body>

</html>