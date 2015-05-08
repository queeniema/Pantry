<?php
    session_start();
    require('lib/MySQLConnection.php');
    if (isset($_POST['login-username']) and isset($_POST['login-password'])) {
        $username = $_POST['login-username'];
        $password = $_POST['login-password'];
        $query = "SELECT * FROM `users` WHERE username='$username' and password='$password'";
        $result = mysql_query($query) or die(mysql_error());
        $count = mysql_num_rows($result);
        if ($count == 1) {
            $_SESSION['user-id'] =  mysql_fetch_assoc($result)['id'];

            // redirect
            header ("Location: pantry.php");
        } else {
            $msg = "Invalid login credentials!";
        }
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
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/landing-page.css" type="text/css">
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

    <script type="text/javascript">
        $(document).ready(function () {
            $('#login-nav').validate({
                rules: {
                    username: {
                        minlength: 2,
                        required: true
                    },
                    password: {
                        minlength: 2,
                        required: true
                    }
                },
                highlight: function (element) {
                    $(element).addClass('error');
                },
                success: function (element) {
                    $(element).removeClass('error');
                },
                errorPlacement: function(error, element) {},
                validClass: function(error, element) {}
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
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand " href="index.php">Pantry</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-left">
                    <li><a href="#about">About</a></li>
                    <li><a href="#features">Features</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Log In <b class="caret"></b></a>
                        <ul class="dropdown-menu" style="padding: 15px;min-width: 250px;">
                            <li>
                                <div class="row">
                                    <div class="col-md-12">
                                        <form role="form" method="POST" action="" accept-charset="UTF-8" id="login-nav">
                                            <div class="form-group">
                                                <input type="text" name="login-username" class="form-control" id="logInUsername" placeholder="Username" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="login-password" class="form-control" id="logInPassword" placeholder="Password" required>
                                            </div>
                                            <?php
                                                if(isset($msg) & !empty($msg)) {
                                                    echo "<div class=\"form-group error-msg\">$msg</div>";
                                                    echo '<script>$(document).ready(function(){ $(".dropdown-toggle")[0].click(function(){}); });</script>';
                                                }
                                            ?>
                                            <div class="form-group logInContainer">
                                                <button class="button custom-button" id="log-in-button" type="submit" name="submit">Log In</button>
                                            </div>
                                         </form>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li><a href="sign_up.php">Sign Up</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <a name="about"></a>
    <div class="intro-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="intro-message">
                        <h1>Pantry</h1>
                        <h3>Your Personal Food-Saving App</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Begin Page Content -->

    <!-- About Section -->
    <div id="about">
        <section class="container content-section text-center">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <h2>About Pantry</h2>
                    <br/>
                    <p>Pantry is designed to help you reduce food waste.</p>
                    <br/>
                    <h3>The Problem</h3>
                    <p>Oftentimes, you may find food in their refrigerator or pantry only to discover that it is expired or past the "best by" or "sell by" date on the package. Food and money go to waste, and you have less choices for your next meal. Ingredients are re­bought only to sit in storage again until remembered to be used.</p>
                    <br/>
                    <h3>The Solution</h3>
                    <p>Pantry is a mobile-friendly site that will allow you to log grocery items into a digital pantry and remind you when ingredients are about to expire.</p>
                </div>
            </div>
        </section>
    </div>

    <!-- Features Section -->
    <a name="features"></a>
    <!-- Digital Pantry -->
    <div class="content-section-a">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-sm-6">
                    <hr class="section-heading-spacer">
                    <div class="clearfix"></div>
                    <h2 class="section-heading">Digital Pantry</h2>
                    <p class="lead">Your pantry contains a grid of food items that the user owns and displays expiring items. Items can be added manually or through a barcode scan, and information for each item can be obtained by clicking on their icons.</p>
                </div>
                <div class="col-lg-5 col-lg-offset-2 col-sm-6">
                    <img class="img-responsive" src="img/Pantry.png" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Shopping List -->
    <div class="content-section-b">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-lg-offset-1 col-sm-push-6  col-sm-6">
                    <hr class="section-heading-spacer">
                    <div class="clearfix"></div>
                    <h2 class="section-heading">Shopping List</h2>
                    <p class="lead">Used or expired ingredients will be populated into your shopping list.When enough items have been added to the shopping list, you will receive a reminder to go to the market. You can even add and remove your own items to the list.</p>
                </div>
                <div class="col-lg-5 col-sm-pull-6  col-sm-6">
                    <img class="img-responsive" src="img/Shopping List.png" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Storage Environments -->
    <div class="content-section-a">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-sm-6">
                    <hr class="section-heading-spacer">
                    <div class="clearfix"></div>
                    <h2 class="section-heading">Storage Environments</h2>
                    <p class="lead">Personalize Pantry for you by saving information about where your food is stored, leading to better food quality estimates.</p>
                </div>
                <div class="col-lg-5 col-lg-offset-2 col-sm-6">
                    <img class="img-responsive" src="img/Storage Environments.png" alt="">
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Sectin -->
    <a name="contact"></a>
    <div class="banner">
        <div class="container content-section text-center">
            <div class="col-lg-8 col-lg-offset-2">
                <h2>Contact Us</h2>
                <p>Pantry was created by a group of 4 developers:</p>
                <p>
                    <ul class="list-inline">
                        <li><a href="mailto:jiexi@ucla.edu" id="email">Jiexi Luan</a></li>
                        <li><a href="mailto:queeniema@ucla.edu" id="email">Queenie Ma</a></li>
                        <li><a href="mailto:wsitu93@ucla.edu" id="email">Wesley Situ</a></li>
                        <li><a href="mailto:justin.s.yuan@gmail.com" id="email">Justin Yuan</a></li>
                    </ul>
                </p>
                <br/>
                <p>Feel free to email any of us to provide some feedback or give us suggestions!</p>
                <br/>
                <ul class="list-inline banner-social-buttons">
                    <li>
                        <a href="https://github.com/queeniema/Pantry" class="btn btn-default btn-lg"><i class="fa fa-github fa-fw"></i> <span class="network-name">Github</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="list-inline">
                        <li><a href="#">Home</a></li>
                        <li class="footer-menu-divider">&sdot;</li>
                        <li><a href="#about">About</a></li>
                        <li class="footer-menu-divider">&sdot;</li>
                        <li><a href="#features">Features</a></li>
                        <li class="footer-menu-divider">&sdot;</li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                    <p class="copyright text-muted small">&copy; 2015 Pantry. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </footer>
    </div>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>