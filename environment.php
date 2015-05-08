<?php
    session_start();
    require('lib/MySQLConnection.php');

    $userid = $_SESSION['user-id'];
    // SQL query to retrieve all storange environments in the database associated wih the current user
    $query = "SELECT * FROM environments WHERE user_id = ". $userid;
    $envs_result = mysql_query($query) or die(mysql_error());
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
            var $storage_env = $('#storage-env-grid');

            $storage_env.shuffle({
                itemSelector: '.item' // the selector for the  in the grid
            });

            /* handle adding a new env */
            $("button#btn-submit").click(function(){
                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: $('form.add').serialize(),
                    success: function(response){
                        // delete the add item circle
                        var $addItem = $('#add-item');
                        $('#storage-env-grid').shuffle('remove', $addItem);

                        // append a new item and the add item circle to the grid
                        var $newItem = $("<div class=\"item green circle remove\" data-groups='[\"all\"]' data-toggle=\"modal\" data-target=\"#view-item-modal\">" + response + "</div>");
                        var $addItem = $("<div class=\"item circle remove\" id=\"add-item\" data-groups='[\"all\"]' data-toggle=\"modal\" data-target=\"#add-item-modal\"></div>");
                        $items = $newItem.add($addItem);
                        $('#storage-env-grid').append($items);
                        $('#storage-env-grid').shuffle('appended', $items);
                    },
                    error: function(){
                        alert("failure");
                    }
                });
            });

            /* handle removing an env */
            $("button#btn-remove").click(function(){
                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: $('form.remove').serialize(),
                    success: function(response){
                        // delete the storage item
                        var id = $('form.remove input')[0].value;
                        var $storage = $('#storage-'+id);
                        $('#storage-env-grid').shuffle('remove', $storage);
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
            $('#view-storage-modal').on('show.bs.modal', function(e) {
                // get data-item-XXX attributes of the clicked element
                var $storageID           = $(e.relatedTarget).data('storage-id');
                var $storageName           = $(e.relatedTarget).data('storage-name');
                var $storageTemp     = $(e.relatedTarget).data('storage-temp');
                // fill in the item's info
                document.getElementById("storage-name").innerHTML       = $storageName;
                document.getElementById("storage-temp").innerHTML       = $storageTemp;
                document.getElementById("remove-storage-id").value      = $storageID;

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
                    <li><a href="environment.php">Storage Environments</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="pantry-logout.php">Log Out</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Pantry -->


    <h1 id="storage-env-header">Storage Environemnts</h1>
    <div id="storage-env-container" class="container-fluid">

        <div id="grid-wrapper">
            <div id="storage-env-grid" class="row">
                <!-- Populate grid dynamically based on items in the database -->
                <?php  while($row = mysql_fetch_assoc($envs_result)) { ?>
                    <div class="item storage" id="storage-<?php echo $row['env_id']; ?>"
                        data-storage-id                =   "<?php echo $row['env_id']; ?>"
                        data-storage-name              =   "<?php echo $row['env_name']; ?>"
                        data-storage-temp              =   "<?php echo $row['temperature']; ?>"
                        data-groups                 =   '["all",]'
                        data-toggle                 =   "modal"
                        data-target                 =   "#view-storage-modal">
                        <span class="description"><?php echo $row['env_name']; ?></span>
                    </div>
                <?php } ?>
                <div class="item" id="add-item" data-groups='["all"]' data-toggle="modal" data-target="#add-item-modal"></div>
            </div>
        </div>
    </div>

    <!-- View item modal -->
    <div class="modal fade" id="view-storage-modal" tabindex="-1" role="dialog" aria-labelledby="view-storage-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="item-name"></h4>
                </div>
                <div class="modal-body">
                    <div id="view-storage-container">
                        <p>Temperature (F): <span id="storage-temp"></span></p>
                    <form class="modal remove">
                        <input class="form-control" type="hidden" name="remove-storage-id" id="remove-storage-id"/>
                    </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-modal-footer" type="submit" name="submit" id="btn-remove" data-dismiss="modal">Remove</button>
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
                    <div class="modal-title step-1" data-step="1"><h3>Add Storage Environment</h3><h5>Step 1: Enter storage information</h5></div>
                </div>
                <div class="modal-body step-1" data-step="1">
                    <div class="container-fluid">
                        <div id="item-info-container">
                           <span class="form-label">Storage Name:</span>
                            <br/>
                            <input class="form-control" type="text" name="storage-name" id="storage-name" required/>
                            <br/>

                           <span class="form-label">Temperature (F):</span>
                            <br/>
                            <input class="form-control" type="text" name="storage-temp" id="storage-temp" required value="32"/>
                            <br/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-modal-footer" data-dismiss="modal">Close</button>
                    <button class="btn btn-modal-footer step step-1" type="submit" name="submit" id="btn-submit" data-step="1" data-dismiss="modal">Submit</button>
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