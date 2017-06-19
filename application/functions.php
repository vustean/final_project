<?php 
    //register new user function
    function register_new_user($username,$password,$email,$first_name,$last_name) {
        require('connect.php'); //this file will be used for database connection
        // If the values are posted, insert them into the database.
        $is_active = 1;
        $level_id = 1;
        //hashing the password before storing in database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        //using prepared statement to avoid SQL injection
        $query = $con->prepare('INSERT INTO `user` (username, password, email, first_name, last_name, is_active, level_id) VALUES (?,?,?,?,?,?,?)');
        $query->bind_param('sssssss', $username, $password, $email, $first_name, $last_name, $is_active, $level_id);
        $query->execute();
        $result = $query->get_result();
        mysqli_close($con);
    }
    //function to escape code source
    function escapeCode($element) {
            //store all parameters in an array
            if (strpos($element, '<pre>') !== false) {                                  //if the element has <pre> tag
                $pre_position = strpos($element, '<pre>');                              //finding position of pre tag
                $pre_string = substr($element,$pre_position +11);                       //finding the position of <pre> tag element
                $pre_string = substr($pre_string, 0, strpos($pre_string, '</code>'));   //finding the position of </code> element
                $pre_string = addslashes($pre_string);                                  //add slashes in front of quotes
                $pre_string = htmlspecialchars($pre_string,ENT_QUOTES);                 //escaping special chars from string between <pre> and </code> tag
                $pre_string = '<pre><code>'.$pre_string.'</code></pre>';                //adding pre and code tag back to the escaped string
                $not_code = htmlspecialchars(substr($element,0,$pre_position));         //escaping not code
                $output = substr_replace($not_code,$pre_string, $pre_position);         //merging code and question
                return $output;                                       //storing the result in an array
            } else {
                $element = addslashes($element);
                $element = htmlspecialchars($element);
                return $element;
            }
    }
    //function that returns all elements from questions tabel
    function getQuestions() {
        require('connect.php'); 
        $query = "SELECT * FROM questions;";
        $result = mysqli_query($con, $query);
        return $result;
        mysqli_close($con);
    }
    //function that returns total number of questions
    function getCountQuestions() {
        require('connect.php'); 
        $query = "SELECT COUNT(*) FROM questions;";
        $result = mysqli_query($con, $query);
        while ($row = mysqli_fetch_assoc($result)) { 
            $count= $row['COUNT(*)'];
        } return $count;
        mysqli_close($con);
    }
    //function that returns all about specific question
    function getQuestionbyId($id) {
        require('connect.php'); 
        $query = "SELECT * FROM questions WHERE question_id = $id;";
        $result = mysqli_query($con, $query);
        return $result;
        mysqli_close($con);
    }
    //Returns everything filtered by level and subject
    function getQuestions_level_subject($level_id, $subject_id) {
        require('connect.php'); 
        $query = "SELECT * FROM questions WHERE level_id = $level_id AND subject_id = $subject_id;";
        $result = mysqli_query($con, $query);
        return $result;
        mysqli_close($con);
    }
    //Returns everything filtered by subject
    function getQuestions_subject($subject_id) {
        require('connect.php'); 
        $query = "SELECT * FROM questions WHERE subject_id = $subject_id;";
        $result = mysqli_query($con, $query);
        return $result;
        mysqli_close($con);
    }
    //returns everything filtered by level
    function getQuestions_level($level_id) {
        require('connect.php'); 
        $query = "SELECT * FROM questions WHERE level_id = $level_id;";
        $result = mysqli_query($con, $query);
        return $result;
        mysqli_close($con);
    }
    //returns all records from user table
    function getUserDetails() {
        require('connect.php');
        $query = "SELECT * FROM user;";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        return $result;
        mysqli_close($con);
    }
    //returns everything by username
    function getUserDetailsByUsername($username) {
        require('connect.php');
        $query = "SELECT * FROM user WHERE username = '$username';";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        return $result;
        mysqli_close($con);
    }
    //returns level name by id
    function getLevelName($level_level_id) {
        require('connect.php');
        $query = "SELECT level_name FROM level WHERE level_id = $level_level_id;";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        while ($row = mysqli_fetch_assoc($result)) { 
            return $row['level_name'];
        } 
        mysqli_close($con);
    } 
    //update user level
    function updateLevel($user,$newLevel) {
        require('connect.php');
        $query = "UPDATE user SET level_id = $newLevel WHERE user_id = $user;";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        return $result;
        mysqli_close($con);
    }
    //update user status
     function updateStatus($user, $new_status) {
        require('connect.php');
        $query = "UPDATE user SET is_active = $new_status WHERE user_id = $user;";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        return $result;
        mysqli_close($con);
    }
    //get all subjects 
    function getSubjects() {
        require('connect.php');
        $query = "SELECT * FROM subject;";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        return $result;
        mysqli_close($con);
    }
    //returns all subject ids from subject table
    function getSubjectsIds() {
        require('connect.php');
        $query = "SELECT subject_id FROM subject;";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        while ($row = mysqli_fetch_assoc($result)) { 
            $array[] .= $row['subject_id'];
        } return $array;
        mysqli_close($con);
    } 
    //returns subject name by subject id
    function getSubjectName($subject_id) {
        require('connect.php');
        $query = "SELECT subject_name FROM subject WHERE subject_id = $subject_id;";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
            while ($row = mysqli_fetch_assoc($result)) { 
                return $row['subject_name'];
        } 
        mysqli_close($con);
    } 
    //update subject table 
    function updateSubject($column, $value, $subject_id) {
        require('connect.php');
        $query = "UPDATE subject SET $column = '$value' WHERE subject_id = $subject_id";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        return $result;
        mysqli_close($con);
    } 
    //create new subject
    function createSubject($subject_name,$description,$logo,$is_active) {
        require('connect.php');
        $subject_name = addslashes($subject_name);
        $description = addslashes($description);
        $logo = addslashes($logo);
        $query = "INSERT INTO subject (subject_name, description, logo, is_active)
                  VALUES ('$subject_name','$description','$logo','$is_active');";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        return $result;
        mysqli_close($con);
    } 
    //saving test result
    function saveTest($date, $score, $user_user_id, $level_level_id, $subject_subject_id) {
        require('connect.php');
        $query = "INSERT INTO quiz (date, score, user_user_id, level_level_id, subject_subject_id) 
                  VALUES ('$date', '$score', '$user_user_id', '$level_level_id', '$subject_subject_id');";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        mysqli_close($con);
    }
    //returns all results for user
    function getResults($user_id) {
        require('connect.php');
        $query = "SELECT * FROM quiz WHERE user_user_id = $user_id;";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        return $result;
        mysqli_close($con);
    }
    //filter result by date
    function getResultsByDate($datefrom, $dateto, $user_id) {
        require('connect.php');
        $datefrom = date("Y-m-d", strtotime($datefrom));
        $dateto = date("Y-m-d", strtotime($dateto));
        $query = "SELECT * FROM quiz WHERE date BETWEEN '$datefrom' AND '$dateto' AND user_user_id = $user_id;";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        return $result;
        mysqli_close($con);
    }
    function getSubjectLevel($user_id, $subject_subject_id, $level_level_id) {
        require('connect.php');
        $query = "SELECT * FROM quiz WHERE 
        user_user_id = $user_id AND subject_subject_id = $subject_subject_id AND level_level_id = $level_level_id AND score >= 80;";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        if ($num_rows = $result->num_rows == 0) 
            return false;
        else return true;
        mysqli_close($con);
    }

    //get everything about specific subject
    function getSubjectbyId($id) {
        require('connect.php'); 
        $query = "SELECT * FROM subject WHERE subject_id = $id;";
        $result = mysqli_query($con, $query);
        return $result;
        mysqli_close($con);
    }
    //function to create question
    function createQuestion($question,$answer1,$answer2,$answer3,$answer4,$correct_answer,$level_id,$subject_id) {
        require('connect.php');
        $create_array = array($question,$answer1,$answer2,$answer3,$answer4,$correct_answer,$level_id,$subject_id);
        $processed_array = array();
        //escaping source code by calling function escapeCode() every element of the array 
        foreach($create_array as $element) 
            $processed_array[] = escapeCode($element);
        $question = $processed_array[0];
        $answer1 = $processed_array[1];
        $answer2 = $processed_array[2];
        $answer3 = $processed_array[3];
        $answer4 = $processed_array[4];
        $correct_answer = $processed_array[5];
        $query = "INSERT INTO questions (question, answer1, answer2, answer3, answer4, correct_answer, level_id, subject_id)
                  VALUES ('$question','$answer1','$answer2','$answer3','$answer4','$correct_answer',$level_id,$subject_id);";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        return $result;
        mysqli_close($con);
    }
    //updating specific column and question with code escaping
    function updateQuestion($column, $value, $question_id) {
        require('connect.php');
        $value = escapeCode($value);
        $query = "UPDATE questions SET $column = '$value' WHERE question_id = $question_id";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        return $result;
        mysqli_close($con);
    } 
    //delete specific question
    function deleteQuestion($question_id) {
        require('connect.php');
        $query = "DELETE FROM questions WHERE question_id = $question_id;";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        return $result;
        mysqli_close($con);
    }
    //update user details
    function updateUser($first_name,$last_name,$user_id) {
        require('connect.php');
        $query = "UPDATE user SET first_name = '$first_name', last_name = '$last_name' WHERE user_id = $user_id;";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        return $result;
        mysqli_close($con);
    }
    //check if user exists using secured techniques
    function checkCredentials($username, $password) {
        require('connect.php');
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); //hashing the password for verification
        //using secured way to check if username and password match
        $query = $con->prepare('SELECT * FROM user WHERE username= ? and password = ?;');
        $query->bind_param('ss', $username, $password);
        $query->execute();
        $result = $query->get_result();
        while ($row = mysqli_fetch_assoc($result)) 
            $database_password = $row['password'];
        $count = mysqli_num_rows($result);
        if(password_verify($database_password, $hashed_password)) return true;
        else return false;
    }