<?php
    //setting page title
    $pageTitle = 'User Details';
/*******************************************************************************
 *Session control and header request
 * ****************************************************************************/
    session_start();
     // last request was more than 15 minutes ago
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 900)) {
	    session_unset();     // unset $_SESSION variable for the run-time 
	    session_destroy();   // destroy session data in storage
    }
	$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
	
    if (isset($_SESSION['username'])) {
        require 'header_private.php'; // require private header
        session_start();
/******************************************************************************/
        if($_POST['updateUser']) {
            $_SESSION['first_name'] = $_POST['new_first_name'];
            $_SESSION['last_name'] = $_POST['new_last_name'];
            //updating user details by calling function updateUser()
            $result = updateUser($_POST['new_first_name'],$_POST['new_last_name'],$_SESSION['user_id']);
            if($result) 
                echo "<script>alert('User Updated');</script>"; 
            else
                echo "<script>alert('Update Failed');</script>"; 
        } ?>
        <div id="gradient">
            <p class="gradient_text">
            Welcome <?php echo $_SESSION['first_name']." ".$_SESSION['last_name'];?>! <br>
            Here you can edit your details and check your test results!</p>
        </div>
        <div class="userDetailsBody">
            <hr>
            <h2>User Details</h2>
            <form action="userDetails.php" class="userDetailsForm" method="POST">
                <p class="user">Username: <span class="green"><?php echo $_SESSION['username']; ?></span></span></p><br>
                <p class="user">First Name: <input class="userDetails" type="text" name="new_first_name" value="<?php echo $_SESSION['first_name']; ?>"></p><br>
                <p class="user">Last Name: <input class="userDetails" type="text" name="new_last_name" value="<?php echo $_SESSION['last_name']; ?>"></p><br>
                <input class="quizButton" type="submit" name="updateUser" value="Update">
            </form>
            <br>
            <hr>
            <h2>Results</h2>
            <form action="" class="userDetailsForm" method="POST">
                <!--jQuery script runs in a p tag with id="date" that provides date picker-->
                <p id="date">
                    Date From: <input class="input_field" name="datefrom" type="text" id="datefrom">  
                    Date To: <input class="input_field" name = "dateto" type="text" id="dateto">
                </p>
                <input class="quizButton" type="submit" name="selectDates" value="Filter">
            </form>
            <hr>
            <?php
            $result = 0;
            //if selected dates not filtered, get all results
            if(!$_POST['selectDates']) 
                $result = getResults($_SESSION['user_id']); 
            else //get results by calling function getResultsByDate and providing from and to dates as parameters
                $result = getResultsByDate($_POST['datefrom'],$_POST['dateto'],$_SESSION['user_id']);
            //if records exists->display
            if($num_rows = $result->num_rows != 0) { ?>
                <table id="userResults">
                    <tr>
                        <th>Date</th>
                        <th>Subject</th>
                        <th>Level</th>
                        <th>Score</th>
                    </tr>
                <?php
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['date']; ?></td>
                            <td><?php echo getSubjectName($row['subject_subject_id']); ?></td>
                            <td><?php echo getLevelName($row['level_level_id']); ?></td>
                            <td><?php echo $row['score']; ?></td>
                        </tr>
             <?php  } 
            } else echo "<h2>No records!</h2>"; ?> 
                </table>
        </div>
<?php 
        include 'footer.php'; 
   } else  
        require 'header_public.php';
?>