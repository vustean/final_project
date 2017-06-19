<?php
/*******************************************************************************
 *Session control and header request
 * ****************************************************************************/
    session_start();
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) { // last request was more than 30 minutes ago
	    session_unset();     // unset $_SESSION variable for the run-time 
	    session_destroy();   // destroy session data in storage
	}
	$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
	
    if (isset($_SESSION['username'])) {
        require 'header_private.php'; // require private header
/******************************************************************************/
        //setting variables with values taken from GET method submit
        $subject_id = $_GET['subject'];
        $level_id = $_GET['level'];
        //if Go link(Start the quiz) is not pressed, duisplay some tips before start and display general information about the quiz
        if($_GET['link'] != 'GO') {
            $_SESSION['subject_id'] = $subject_id; ?>
            <div class="PageWrap">
                <div class="takeTest">
                    <h2 class="green">You have 20 minutes for this test!</h2>
                    <?php if($_SESSION['level_id'] != 3) echo "<h2 class='green'>To unlock next level get a score of 80 or more!</h2>"; ?>
                </div>
                <div><a class="linkButton" href="takeTest.php?subject=<?php echo $subject_id ?>&level=<?php echo $level_id ?>&link=GO">Start the Quiz!</a></div>
                <div id="tipsDiv"><img id="tips" src="/application/images/tips.png"></div>
                <div class="oneSideBorder">
                    <h3>Test strategies:</h3>
                    <ul>
                        <li>Read through the test quickly and answer the easiest questions first</li>
                        <li>Know how much time is allowed (this governs your strategy)</li>
                        <li>Mark those you think you know in some way that is appropriate</li>
                        <li>Read through the test a second time and answer more difficult questions</li>
                        <li>If time allows, review both questions and answers</li>
                        <li>It is possible you mis-read questions the first time</li>
                    </ul>
                </div>
                <div class="oneSideBorder">
                    <h3>Strategies for answering difficult questions:!</h3>
                    <ul>
                        <li>Eliminate options you know to be incorrect</li>
                        <li>Give each option of a question the "true-false test:"</li>
                        <li>Question options that grammatically don't fit with the stem</li>
                        <li>Question options that are totally unfamiliar to you</li>
                        <li>Question options that contain negative or absolute words.</li>
                        <li>If you know two of three options seem correct, "all of the above" is a strong possibility</li>
                    </ul>
                </div>
            </div>
    <?php
        }
        //if submit button is pressed 
        if($_POST['submit']) { ?>
            <script>
                //automatically scroll to bottom for result
                window.onload=toBottom;
                //hide circles on radio inputs
                hideRadioCircle();
            </script>
    <?php
        }
        //if button take another test is clicked
        if($_POST['finish']) header('Location: quizzes.php');
        //if start the quiz is clicked
        if($_GET['link'] == 'GO') { ?>
            <div id="timer"></div>
            <?php
            //get all question based on user choice
            $result = getQuestions_level_subject($level_id, $subject_id); 
            $i = 0;
            //defining an array that will store correct answers
            $correct_answer = array();
            //storing all question details in array by defining question id as key
            while ($row = mysqli_fetch_assoc($result)) { 
                $id[$row['question_id']] = $i;
                $correct_answer[$row['question_id']] = $row['correct_answer'];
                $answer1[$row['question_id']] = $row['answer1'];
                $answer2[$row['question_id']] = $row['answer2'];
                $answer3[$row['question_id']] = $row['answer3'];
                $answer4[$row['question_id']] = $row['answer4'];
                $questions[$row['question_id']] = $row['question'];
                $i++;
            }   
            //while test is taking run a timer for 20 min
            if(!$_POST['submit']) { 
                unset($_SESSION['random_questions']);
               ?>
                <script type="text/javascript">
                    countdown(20);
                    setTimeout(function myFunction() { document.getElementById('submit').click();}, 20*60*1000);
                </script>
                <?php //<?php echo $_SESSION['score']; 
                $_SESSION['correct_answer'] = $correct_answer;
                //if array random questions is not set, assign 20 question ids to the array
                if(empty($_SESSION['random_questions'])) 
                    $_SESSION['random_questions'] = array_rand($id, 20);
            }
            ?>
            
            <div class="fullWidthBox">
                <h2>You are attempting <?php echo getSubjectName($subject_id)." test ".getLevelName($level_id)." level. Good Luck!";?></h2>
            </div>
                <form id="testForm" action="" method="post">
                    <?php
                    $i=1;
                    //for each question_id, display the question and related answers for this
                    foreach($_SESSION['random_questions'] as $key) { ?>
                        <div class="testFormWrap">
                            <div id="questions">
                                <input type="hidden" name="ques"/><?php echo $i.') '.$questions[$key]; $i++; ?>
                            </div>
                            <div id="answers">
                                <?php 
                                //shuffle answers so they don't appear each time at the same position
                                $array_answers = array($answer1[$key],$answer2[$key],$answer3[$key],$answer4[$key]);
                                shuffle($array_answers);
                                $shuffled_array = array();
                                //store shuffled answers in an array with deafault keys
                                foreach ($array_answers as $answers) {
                                    $shuffled_array[] = $answers;
                                }?>
                                <!--displaying shuffled answers in a input type radio tag-->
                                <input class="answers" type="radio" name="optradio[<?php echo $key ?>]" value="<?php echo $shuffled_array[0];?>">a) <?php echo $shuffled_array[0];?><br>
                                <input class="answers" type="radio" name="optradio[<?php echo $key ?>]" value="<?php echo $shuffled_array[1]?>">b) <?php echo $shuffled_array[1];?><br>
                                <input class="answers" type="radio" name="optradio[<?php echo $key ?>]" value="<?php echo $shuffled_array[2]?>">c) <?php echo $shuffled_array[2]?><br>
                                <input class="answers" type="radio" name="optradio[<?php echo $key ?>]" value="<?php echo $shuffled_array[3]?>">d) <?php echo $shuffled_array[3]?><br>
                                
                            </div>
                            <div id="results">
                                <?php
                                //if submit is pressed, compare correct answer with the one provided by user
                                if($_POST['submit']) {
                                    $correct_answer = $_SESSION['correct_answer'];
                                    $user_answer = $_POST['optradio'];
                                    $user_answer[$key] = escapeCode($user_answer[$key]);
                                    //if the answer is not answered, notify under the question
                                    if ($user_answer[$key] == NULL)
                                         echo "<p class='incorrect'>You didn't answer</p></br>";
                                    //if user answer is not equal with the correct answer, notify and display correct answer
                                    else if ($user_answer[$key] != $correct_answer[$key])
                                        echo "<p class='incorrect'>Your answer is incorect: Correct answer is ".$correct_answer[$key]."</p></br>";
                                    //if user answer is equal with correct one, notify 
                                    else if ($user_answer[$key] == $correct_answer[$key]) {
                                        echo "<p class='correct'>Your answer is correct! It is ".$correct_answer[$key]."</p></br>";
                                        //increment correct answer
                                        $score++;
                                        $_SESSION['score'] = $score;
                                    }
                                }
                                ?>
                            </div>
                        </div>
           <?php    }   //if submit button is not presse, show submit button else show take another test button
                        if(!$_POST['submit']) 
                            echo "<input type='submit' class='quizButton' id='submit' name='submit' value='Submit'>";
                        else
                            echo "<input type='submit' class='quizButton' name='finish' value='Take another test'>";
                        ?>
                </form>
                <div class="fullWidthBox">
              <?php if($_POST['submit']) {
                        //storing test result into variables
                        $score = $_SESSION['score'] / 20 * 100; 
                        $username = $_SESSION['username'];
                        $user_id = $_SESSION['user_id'];
                        $date = date("Y-m-d");
                        $subject_id = $_GET['subject'];
                        $level_id = $_GET['level'];
                        //saving the result into the database
                        saveTest($date, $score, $user_id, $level_id, $subject_id);
                        unset($_SESSION['subject_id']);
                        //displaying total score 
                        echo "<h1>Your score is: ".$score."% <br></h1>";
                        //if the score is 80 or more, unlock next level by updating user level and notify the user
                        if($score >= 80) {
                            if($level_id!=3) {
                                $level_id++;
                                echo "<h1 class='green'>You have unlocked <span class='levelName'>".getLevelName($level_id)."</span> level!</h1>";
                                updateLevel($user_id, $level_id);
                            } 
                        unset($_SESSION['score']);   
                        }
                    }
                    echo "<p><a href='http://www.sanfoundry.com/'><em>Questions Source: http://www.sanfoundry.com/</em></a></p>";
                echo "</div>";
        }  
    include 'footer.php';
    }  else 
        require 'header_public.php';  
?>
