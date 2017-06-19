<?php
/*******************************************************************************
 * Sessision control and check user credentials.
 * ****************************************************************************/
    session_start();
    require('functions.php');
    //Check if login details provided
    if (isset($_POST['username']) and isset($_POST['password'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $credentialsCheck = checkCredentials($username,$password);
        //If the posted values are equal to the database values, then session will be created for the user.
        if ($credentialsCheck == 1) {
            //get user details after verification by calling function
            $result = getUserDetailsByUsername($username);
                while ($row = mysqli_fetch_assoc($result)) {
                    if(!$row['is_active']) {    //if user is inactive - notify and break the while loop
                        echo "<script>alert('This username is not active, please contact administrator!');
                                  window.location.href='index.php';
                              </script>';";
                        break;
                    }
                    //if user is active set user details in session for later useage
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['initials'] = substr($row['first_name'],0,1).substr($row['last_name'],0,1);
                    $_SESSION['level_id'] = $row['level_id'];
                    $_SESSION['first_name'] = $row['first_name'];
                    $_SESSION['last_name'] = $row['last_name'];
                    $_SESSION['user_id'] = $row['user_id'];
                }   
        } else //If login credentials don't match notify the user and redirect to home page
            echo "<script>alert('Wrong username or passowrd!');</script>';";
    }
    //if username was set in the session regenerate id for security purpose and redirect to home page
    if (isset($_SESSION['username'])) {
        session_start();
        session_regenerate_id();//to prevent session fixation attacks, replace the current session ID with a new one
        header('Location: /application/index.php');
    }
    //if sign up button pressed
    if($_POST['register']) {
            if($_POST['password_new'] != $_POST['password_new1']) { 
                echo "<script type='text/javascript'>alert('Passwords don\'t match!');</script>";
            } else {
                //checking if user with this username exists
                $checkUsername = getUserDetailsByUsername($_POST['username_new']);
                $count = mysqli_num_rows($checkUsername);
                if($count == 0) {//if not exists call function register_new_user()
                    register_new_user($_POST['username_new'],$_POST['password_new'], $_POST['email'], $_POST['first_name'],$_POST['last_name']);
                    echo "<script type='text/javascript'>alert('User created, please log in!');</script>";
                } else echo "<script type='text/javascript'>alert('Username exists!');</script>"; 
            } 
    }
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style/style.css" type="text/css" />
    <script src="js/myscripts.js"></script>
    <!--The following script is called to add support to media queries, min-width, max-width, and all media types (e.g. screen) for older browsers.-->
    <script type="text/javascript" src="js/respond.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100" rel="stylesheet">
    <title><?php echo $pageTitle ?></title>
</head>
<body>
    <header>
        <div class="topnav">
            <a id="logo" href="index.php"><img id="logo_image" src="/application/images/logo.png"></a>
            <span id="formAlignment">
                <form id="loginForm" action="header_public.php" method="POST"> 
                    <input class="input_field" type="text" name="username" placeholder="Username" required/>
                    <input class="input_field" type="password" name="password" placeholder="Password" required/>
                    <input id="loginButton" class="button" type="submit" name="SignIn" value="SingIn">
                    <input id="myBtn" class="button" type="button"  name="singUp" value="SingUp">
                </form>
            </span>
                <!-- The Modal Registration Form -->
                <div id="myModal" class="modal">
                    <!-- Modal content -->
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <form action="" id="regForm" method="POST"> 
                            <input class="input_field_register" type="text" name="username_new" placeholder="Username" required>
                            <input class="input_field_register" type="password" name="password_new" placeholder="Password" required>
                            <input class="input_field_register" type="password" name="password_new1" placeholder="Repeat Password" required>
                            <input class="input_field_register" type="text" name="first_name" placeholder="First Name" required>
                            <input class="input_field_register" type="text" name="last_name" placeholder="Last Name" required>
                            <input class="input_field_register" type="email" name="email" placeholder="Email" required>
                            <br/>
                            <input class="button" type="submit" name="register" value="Register">
                        </form>
                    </div>
                </div>
        </div>
    </header>
    
       