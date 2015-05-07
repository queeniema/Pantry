<?php
    require('lib/MySQLConnection.php');

if (isset($_POST['login-username']) and isset($_POST['login-password'])) {
        $username = $_POST['login-username'];
        $password = $_POST['login-password'];
        $query = "SELECT * FROM `users` WHERE username='$username' and password='$password'";

        $result = mysql_query($query) or die(mysql_error());
        $count = mysql_num_rows($result);
        if ($count == 1) {
            $_SESSION['user-id'] = $username;
            header ("Location: pantry.php");
        } else {
            $msg = "Invalid login credentials!";
        }
    }

    if (isset($_POST['signup-username']) && isset($_POST['signup-password'])) {
        $username = $_POST['signup-username'];
        $email = $_POST['signup-email'];
        $password = $_POST['signup-password'];
        $query = "INSERT INTO `users` (username, password, email) VALUES ('$username', '$password', '$email')";

        $result = mysql_query($query);
        if($result) {
            $msg = "Your account was created successfully! Redirecting you to the home page...";
            echo "<script>setTimeout(\"location.href = 'index.php';\",8000);</script>";
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
    <link rel="stylesheet" href="css/sign-up-page.css" type="text/css">
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

    <script>
        $(document).ready(function () {
            $('#login-nav').validate({
                rules: {
                    email: {
                        required: true,
                        email: true
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

            $('#sign-up-form').validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
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
                    $(element).removeClass('error')
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
                </button>
                <a class="navbar-brand " href="index.php">Pantry</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Log In <b class="caret"></b></a>
                        <ul class="dropdown-menu" style="padding: 15px;min-width: 250px;">
                            <li>
                                <div class="row">
                                    <div class="col-md-12">
                                        <form role="form" method="POST" action="pantry.php" accept-charset="UTF-8" id="login-nav">
                                            <div class="form-group">
                                                <input type="text" name="login-username" class="form-control" id="logInUsername" placeholder="Username" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="login-password" class="form-control" id="logInPassword" placeholder="Password" required>
                                            </div>
                                            <div class="form-group logInContainer">
                                                <button class="button custom-button" id="log-in-button" type="submit" name="submit">Log In</button>
                                            </div>
                                         </form>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li><a href="sign_up.html">Sign Up</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sign Up Form -->
    <a name="signup"></a>
    <div class="container sign-up-container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="sign-up-form">
                    <h1>Create a new account</h1>
                    <form role="form" method="POST" action="" accept-charset="UTF-8" id="sign-up-form" class="control-group">
                        <label id="icon" for="name"><i class="fa fa-user"></i></label>
                        <input type="text" name="signup-email" id="sign-up-email" placeholder="Email" required/>
                        <br/>
                        <label id="icon" for="name"><i class="fa fa-envelope"></i></label>
                        <input type="text" name="signup-username" id="sign-up-username" placeholder="Username" required/>
                        <br/>
                        <label id="icon" for="name"><i class="fa fa-shield"></i></label>
                        <input type="password" name="signup-password" id="sign-up-password" placeholder="Password" required/>
                        <br/>
                        <button class="button custom-button" id="sign-up-button" type="submit" name="submit">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
        if(isset($msg) & !empty($msg)) {
            echo "<span>$msg</span>";
        }
    ?>

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

</body>

</html>