<?php
/*******************************************************************************
 * Sessision control and check user credentials.
 * ****************************************************************************/
    session_start();
    require 'functions.php';
    // last request was more than 15 minutes ago
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 900)) { 
	    session_unset();     // unset $_SESSION variable for the run-time 
	    session_destroy();   // destroy session data in storage
	}
	$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
/******************************************************************************/
    if ($_SESSION['username']) {
        session_start();
?>
        <!DOCTYPE html>
        <html>
        <head>
            <link rel="stylesheet" href="style/style.css" type="text/css" />
            <script src="js/myscripts.js"></script>
            <link href="https://fonts.googleapis.com/css?family=Raleway:300" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css?family=Roboto:100" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css?family=Source+Code+Pro" rel="stylesheet">
            <script type="text/javascript" src="js/respond.min.js"></script><!--This script is called on the page (as shown above) and adds support to media queries, min-width, max-width, and all media types (e.g. screen) for older browsers.-->
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title><?php echo $pageTitle ?></title>
        </head>
        <body>
            <header>
                <div class="topnav">
                    <a id="logo" href="index.php"><img id="logo_image" src="/application/images/logo.png"></a>
                    <!-- Displaying user initials as a link to users details page-->
                    <a href="userDetails.php" id="user_initials"><?php echo strtoupper($_SESSION['initials']);?></a>
                    <a id="floatRight" href="logout.php"><img id="logoutIcon" src="/application/images/logout.png"></a>
                    <a id="floatRight" id="catalog" href="quizzes.php">Catalogue</a>
                </div>
            </header>
<?php } ?>
        
       