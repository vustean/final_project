<?php
    //setting page title
    $pageTitle = 'Catalogue';
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
        ?>
        <div id="gradient"><p class="gradient_text">Try yourself! <br>We have <?php echo getCountQuestions();?> questions for you on different topics!</p></div>
        <!--displaying dynamically divs with subject logo title and description for all active subjects from database-->
        <div class="flex-box">
            <?php 
            //get all subjects
            $result = getSubjects();
            while($row = mysqli_fetch_assoc($result)) {  
                //if subject is not disabled
                if($row['is_active']) {
                    //finding if user have previously got a score of >=80 for subject on level 1
                    if(getSubjectLevel($_SESSION['user_id'],$row['subject_id'],1)) 
                        //setting true as user passed level 1 for specific subject
                        $access_level_2 = true; 
                    else 
                        $deny_level_2 = true;
                    //finding if user have previously got a score of >=80 for subject on level 2
                    if(getSubjectLevel($_SESSION['user_id'],$row['subject_id'],2)) 
                    //setting true as user passed level 2 for specific subject
                        $access_level_3 = true; 
                    else 
                        $deny_level_3 = true;?>
                    <div class="subjectWrap">
                        <div class="subject_logo" id="php"><img src="<?php echo $row['logo'];?>"></div>
                        <div class="subject_content" id="php">
                            <h3 class="subjectName"><?php echo getSubjectName($row['subject_id']); ?></h3>
                            <!--<p id="subjecDescription"><?php// echo $row['description'];?></p>-->
                            <span id="alignBottom">
                                <a class="levelLinks" href="takeTest.php?subject=<?php echo $row['subject_id'];?>&level=1">Beginner</a>
                                <a <?php 
                                    //if access level 2 is set to true, make the link available by setting class name
                                    if ($access_level_2) 
                                        echo "class='levelLinks'";
                                    else 
                                        //if access level 2 is not set to true, make the link unavailable by setting class name
                                        echo "class='hiddenLevelLinks'"; ?>
                                    href="takeTest.php?subject=<?php echo $row['subject_id'];?>&level=2">Intermediate
                              <?php if ($deny_level_2) echo "<img class='lock' src='/application/images/lock.png'>";//show lcok icon if level access is false?>
                                </a>
                                <a 
                              <?php if ($access_level_3) 
                                        echo "class='levelLinks'";
                                    else 
                                        echo "class='hiddenLevelLinks'"; ?>
                                    href="takeTest.php?subject=<?php echo $row['subject_id'];?>&level=3">Advanced
                              <?php if ($deny_level_3) echo "<img class='lock' src='/application/images/lock.png'>";//show lcok icon if level access is false?>
                                </a>
                            </span>
                        </div>
                    </div>  
      <?php 
                }
                $access_level_2 = false; $deny_level_2 = false; $access_level_3 = false; $deny_level_3 = false;
            } 
        echo "</div>";    
        include 'footer.php';     
    } else if (!isset($_SESSION['username'])) {  
        require 'header_public.php';
        header('Location: index.php');
    } 
?>
