<?php
//setting dynamic page title
$pageTitle = 'Admin';
/***************************************************************************************
 *Session control and header request
***************************************************************************************/
    session_start();
    // last request was more than 15 minutes ago
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 900)) { 
	    session_unset();     // unset $_SESSION variable for the run-time 
	    session_destroy();   // destroy session data in storage
	}
	$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
	//Checking if username is admin display all following
    if ($_SESSION['username'] == 'admin') {
        require 'header_private.php'; // require private header
        session_start();
/***************************************************************************************/
        ?>
        <div class="adminBody"> <!--wrapping all content in adminBody div-->
            <!--Form for dropdown list-->
            <form action="" class="selectForm" method="POST">
                    <select name="table" id="selectTable" class="dropdown" onchange="showOption()">
                        <option value="0">--Select Table--</option>
                        <option value="user">User</option>
                        <option value="question">Question</option>
                        <option value="subject">Subject</option>
                    </select>
                    <select name="subject" id="subjectFilter" class="dropdown">
                            <option value="0">--Select Subject--</option>
                      <?php 
                            //Displaying all subjects in dropdown list for subject select
                            $result_subjects = getSubjects();
                             while($row = mysqli_fetch_assoc($result_subjects)) {
                            echo "<option value=".$row['subject_id'].">".$row['subject_name']."</option>";
                        } ?>
                    </select>
                    <select name="level" id="level" class="dropdown">
                        <option value="0">--Select Level--</option>
                        <option value="1">Beginner</option>
                        <option value="2">Intermediate</option>
                        <option value="3">Advanced</option>
                    </select>
                    <input class="filter_button" type="submit" name="select" value="Select">
            </form>
        <?php 
/***************************************************************************************
         * Displaying Table by filtering pages
/***************************************************************************************/
            //if user table is selected, require userAdmin page to display all details
            if($_POST['table'] == 'user') {
            require 'userAdmin.php';
            }
            //if question page is selected along with suject and level
            if($_POST['table'] == 'question' && $_POST['subject'] != 0 && $_POST['level'] != 0) {
                //call function to get al questions filtered by level and subject
                $result = getQuestions_level_subject($_POST['level'],$_POST['subject']);
                require 'questionsAdmin.php';
                echo "<script type='text/javascript'>forceShowOption('selectTable','question');</script>"; 
                echo "<script type='text/javascript'>forceShowOption('subjectFilter',".$_POST['subject'].");</script>";
                echo "<script type='text/javascript'>forceShowOption('level',".$_POST['level'].");</script>";
                //if only question and subject were selected
            } else if($_POST['table'] == 'question' && $_POST['subject'] != 0) {
                //call function to get questions filtered by subject name
                $result = getQuestions_subject($_POST['subject']);
                require 'questionsAdmin.php';
                echo "<script type='text/javascript'>forceShowOption('selectTable','question');</script>"; 
                echo "<script type='text/javascript'>forceShowOption('subjectFilter',".$_POST['subject'].");</script>"; 
                //if only question and level were selected
            } else if($_POST['table'] == 'question' && $_POST['level'] != 0) {
                //call function to get questions filtered by level
                $result = getQuestions_level($_POST['level']);
                require 'questionsAdmin.php';
                echo "<script type='text/javascript'>forceShowOption('selectTable','question');</script>"; 
                echo "<script type='text/javascript'>forceShowOption('level',".$_POST['level'].");</script>"; 
                //if only question is selected, display all questions
            } else if($_POST['table'] == 'question') {
                $result = getQuestions();
                require 'questionsAdmin.php'; 
                echo "<script type='text/javascript'>forceShowOption('selectTable','question');</script>"; 
            }
            
            //if subject table is selected, call function to display all subjects
            if($_POST['table'] == 'subject') {
                $result = getSubjects();
                require 'subjectAdmin.php';
            }
/**************************************************************************************/
            //Checking if action button is pressed
            if($_POST['action']) {
/***************************************************************************************/
                //If Update button pressed
                if($_POST['action'] == 'Update') {
/***************************************************************************************/
                    //If update button for user table pressed
                    if($_POST['new_level_id'] && $_POST['lineUser_id']) {
                            $user = $_POST['lineUser_id'];
                            $newlevel = $_POST['new_level_id'];
                            $new_status = $_POST['new_active'];
                            $result = updateLevel($user,$newlevel);
                            $result1 = updateStatus($user,$new_status);
                                if ($result && $result1) 
                                    echo "<script type='text/javascript'>alert('User Updated!');</script>"; 
                                else 
                                    echo "<script type='text/javascript'>alert('Update Failed!');</script>"; 
                            require 'userAdmin.php';
                    }
/***************************************************************************************/
                    //If Update button for question pressed
                    if($_POST['updateQuestion']) {
                        //storing all fields in an array
                        $updatedFields = array( "question" => $_POST['question'],
                                                "answer1" => $_POST['answer1'],
                                                "answer2" => $_POST['answer2'],
                                                "answer3" => $_POST['answer3'],
                                                "answer4" => $_POST['answer4'],
                                                "correct_answer" => $_POST['correct_answer'],
                                                "level_id" => $_POST['new_level_id'],
                                                "subject_id" => $_POST['subject_id']);
                        $result = 0;
                        //updating each field by parsing the array
                        foreach($updatedFields as $column => $value) {
                                $result = updateQuestion($column, $value, $_POST['updateQuestion']);
                            }
                        if ($result) 
                            echo "<script type='text/javascript'>alert('Question Updated!');</script>"; 
                        else 
                            echo "<script type='text/javascript'>alert('Question Update Failed!');</script>"; 
                        $result = getQuestions();
                        require 'questionsAdmin.php';
                        echo "<script type='text/javascript'>forceShowOption('selectTable','question');</script>"; 
                    } 
/***************************************************************************************/
                    //If Update button for Subjects pressed
                    if($_POST['updateSubject']) {
                        //storing all editable fields in an array
                        $updatedFields = array( "subject_name" => $_POST['subject_name'],
                                                "description" => $_POST['description'],
                                                "logo" => $_POST['logo'],
                                                "is_active" => $_POST['new_active']);
                        $result = 0;
                        //updating each field by parsing the array
                        foreach($updatedFields as $column => $value) {
                                $result = updateSubject($column, $value, $_POST['updateSubject']);
                        }
                        if ($result) 
                            echo "<script type='text/javascript'>alert('Subject Updated!');</script>"; 
                        else 
                            echo "<script type='text/javascript'>alert('Subject Update Failed!');</script>"; 
                        $result = getSubjects();
                        require 'subjectAdmin.php';
                    } 
                } 
/***************************************************************************************/
                //If Delete button pressed
                if($_POST['action'] == 'Delete') {
/***************************************************************************************/
                    //if question id is set detele question for specific question_id line
                    if($_POST['updateQuestion']) {
                        $result = deleteQuestion($_POST['updateQuestion']);
                        if ($result) 
                            echo "<script type='text/javascript'>alert('Question Deleted!');</script>"; 
                        else 
                            echo "<script type='text/javascript'>alert('Deletion Failed!');</script>"; 
                        $result = getQuestions();
                        require 'questionsAdmin.php';
                        echo "<script type='text/javascript'>forceShowOption('selectTable','question');</script>"; 
                    }
                }
/***************************************************************************************/
                //If Create button pressed
                if($_POST['action'] == 'Create') {
/***************************************************************************************/
                    //If create question button pressed
                    if($_POST['createQuestionAction']) {
                        //storing all inputs in an array to check if all fields were filled
                        $required = array(  $_POST['question'],
                                            $_POST['answer1'],
                                            $_POST['answer2'],
                                            $_POST['answer3'],
                                            $_POST['answer4'],
                                            $_POST['correct_answer'],
                                            $_POST['levelSelect'],
                                            $_POST['subjectSelect']);
                        $error = false;
                        //checking each element if is empty
                        foreach($required as $field) {
                            if ($field == "") {
                                $error = true;
                            }
                        }
                        //if any of fields are empty or dropdown lists are not selected echo alert
                        if($error || $_POST['levelSelect'] == 0 || $_POST['subjectSelect'] == 0) {
                            echo "<script type='text/javascript'>alert('Please fill all fields!');</script>"; 
                        } else {
                            //if all fields are filled create the question by calling createQuestion function
                            $result = createQuestion(   $_POST['question'],
                                                        $_POST['answer1'],
                                                        $_POST['answer2'],
                                                        $_POST['answer3'],
                                                        $_POST['answer4'],
                                                        $_POST['correct_answer'],
                                                        $_POST['levelSelect'],
                                                        $_POST['subjectSelect']);
                            if($result) {
                                echo "<script>alert('Question Succesfully Created!');</script>";
                            } else echo "<script type='text/javascript'>alert('Creation Failed!');</script>";
                        } 
                        $result = getQuestions();
                        require 'questionsAdmin.php';
                        echo "<script type='text/javascript'>forceShowOption('selectTable','question');</script>"; 
                    }
/***************************************************************************************/
                    //If create subject button pressed
                    if($_POST['createSubject']) {
                        //storing all inputs in an array to check if all fields were filled
                        $required = array(  $_POST['subject_name'],
                                            $_POST['description'],
                                            $_POST['logo'],
                                            $_POST['is_active']);
                        $error = false;
                        //checking each element if is empty
                        foreach($required as $field) {
                            if (empty($field)) {
                                $error = true;
                            }
                        }
                        //if any of fields are empty or dropdown list is not selected echo alert
                        if($error || $_POST['is_active'] == '-') {
                            echo "<script type='text/javascript'>alert('Please fill all fields!');</script>"; 
                        } else {
                            //if all fields are filled, create subject
                            $result = createSubject(    $_POST['subject_name'],
                                                        $_POST['description'],
                                                        $_POST['logo'],
                                                        $_POST['is_active']);
                            if($result) 
                                echo "<script type='text/javascript'>alert('Subject Succesfully Created!');</script>";
                            else 
                                echo "<script type='text/javascript'>alert('Creation Failed!');</script>";
                        } 
                    }
                }
            }
        echo "</div>";
    } else {  //if not admin redirect to home page with public header
        require 'header_public.php';
        header('Location: index.php');
    }
/******************************************************************************/
?>
