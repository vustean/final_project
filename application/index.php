<?php
//setting dynamic page title;
    $pageTitle = 'Home';
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
	//if session username is set require public header
    if (isset($_SESSION['username'])) {
        require 'header_private.php'; 
        session_start();
    //else require private header
    } else   
        require 'header_public.php';
    
/******************************************************************************/
?>
<div id="gradient"><p class="gradient_text">Welcome to Multiple Choice Questions website! <br>Here you can take tests for free!</p></div>
<div class="PageWrap">
    <div>
        <img id="examImage" src="/application/images/exam.jpg">
    </div>
    <div class="oneSideBorder">
        <h2>What is Multiple Choice Questions?</h2>
        <p>Multiple choice is a form of an objective assessment in which respondents are asked to select the only 
        correct answer out of the choices from a list. The multiple choice format is most frequently used in 
        educational testing, in market research, and in elections, when a person chooses between multiple candidates, 
        parties, or policies.</p>
    </div>
    <div class="oneSideBorder">
        <h2>Why Multiple Choice Questions?</h2>
        <p>Multiple choice tests often require less time to administer for a given amount of material than would tests requiring written responses. 
        This results in a more comprehensive evaluation of the candidate's extent of knowledge. Even greater efficiency can be created by the use of 
        online examination delivery software. This increase in efficiency can offset the advantages offered by free-response items. That is, if 
        free-response items provide twice as much information but take four times as long to complete, multiple-choice items present a better 
        measurement tool.<br><br>
        Multiple choice questions lend themselves to the development of objective assessment items, but without author training, questions can be 
        subjective in nature. Because this style of test does not require a teacher to interpret answers, test-takers are graded purely on their selections,
        creating a lower likelihood of teacher bias in the results. Factors irrelevant to the assessed material (such as handwriting and clarity of presentation) 
        do not come into play in a multiple-choice assessment, and so the candidate is graded purely on their knowledge of the topic. Finally, if test-takers are 
        aware of how to use answer sheets or online examination tick boxes, their responses can be relied upon with clarity. Overall, multiple choice tests are the 
        strongest predictors of overall student performance compared with other forms of evaluations, such as in-class participation, case exams, written assignments, 
        and simulation games.</p>
    </div>
    
</div>
<?php include 'footer.php'; ?>