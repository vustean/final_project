<?php 
if ($_SESSION['username'] == 'admin') { ?>
<!--admin page for managing questions
Calling this file, a table with questions is displayed and is available for read, updating, creation, deleting-->
    <table class="adminTable">
        <tr>
            <th colspan="10">Create new Question</th>
        </tr>
        <tr>
            <form action="admin.php" name="createQuestion" method="POST">
                <td class="smallColumn"></td>
                <td class="largeColumn"><textarea rows="8" cols="35" name="question" class="updateField"></textarea></td>
                <td><textarea rows="6" cols="15" name="answer1" class="updateField"></textarea></td>
                <td><textarea rows="6" cols="15" name="answer2" class="updateField"></textarea></td>
                <td><textarea rows="6" cols="15" name="answer3" class="updateField"></textarea></td>
                <td><textarea rows="6" cols="15" name="answer4" class="updateField"></textarea></td>
                <td><textarea rows="6" cols="15" name="correct_answer" class="updateField"></textarea></td>
                <td class="smallColumn">
                    <select class="updateField" name="levelSelect">
                        <option value="0">-</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </td>
                <td class="mediumColumn">
                    <select class="updateField" name="subjectSelect">
                            <option value="0">-</option>
                      <?php 
                            //displaying all subject in a dropdown list
                            $result_subjects = getSubjects();
                            while($row = mysqli_fetch_assoc($result_subjects)) { 
                                echo "<option value=".$row['subject_id'].">".$row['subject_name']."</option>";
                            } ?>
                    </select>
                </td>
                <td class="mediumColumn"><input class="manageButton" type="submit" name="action" value="Create"></td>
                <input type="hidden" name="createQuestionAction" value="createQuestion">
            </form>
        </tr>    
        <tr>
            <th class="smallColumn">Q id</th>
            <th class="largeColumn">Question</th>
            <th class="mediumColumn">Answer 1</th>
            <th class="mediumColumn">Answer 2</th>
            <th class="mediumColumn">Answer 3</th>
            <th class="mediumColumn">Answer 4</th>
            <th class="mediumColumn">Cor. Answer</th>
            <th class="smallColumn">L id</th>
            <th class="mediumColumn">Subject id</th>
            <th class="mediumColumn">Action</th>
        </tr>
     <?php  while ($row = mysqli_fetch_assoc($result)) { 
                //finding not current level 
                $levels = array(1,2,3);
                $excluded = array($row['level_id']);
                $searchlevel = array_values(array_diff($levels,$excluded)); 
                //finding remaining subjects from the current displayed one
                $subjects = getSubjectsIds();
                $excluded = array($row['subject_id']);
                $difSubject = array_values(array_diff($subjects,$excluded));
          ?>
            <tr><!-- table form that takes atributes from textarea and select inputs-->
                <form action="admin.php" name="updateQuestion" method="POST">
                    <td class="smallColumn"><?php echo $row['question_id'];?></td>
                    <td class="largeColumn"><textarea name="question" class="updateField" rows="8" cols="35"><?php echo $row['question'];?></textarea></td>
                    <td class="mediumColumn"><textarea name="answer1" class="updateField" rows="6" cols="20"><?php echo $row['answer1'];?></textarea></td>
                    <td class="mediumColumn"><textarea name="answer2" class="updateField" rows="6" cols="12"><?php echo $row['answer2'];?></textarea></td>
                    <td class="mediumColumn"><textarea name="answer3" class="updateField" rows="6" cols="12"><?php echo $row['answer3'];?></textarea></td>
                    <td class="mediumColumn"><textarea name="answer4" class="updateField" rows="6" cols="12"><?php echo $row['answer4'];?></textarea></td>
                    <td class="mediumColumn"><textarea name="correct_answer" class="updateField" rows="6" cols="12"><?php echo $row['correct_answer'];?></textarea></td>
                    <td class="smallColumn">
                        <select class="updateField" name="new_level_id">
                            <option value="<?php echo $row['level_id'];?>"><?php echo $row['level_id'];?></option>
                            <option value="<?php echo $searchlevel[0];?>"><?php echo $searchlevel[0];?></option> 
                            <option value="<?php echo $searchlevel[1];?>"><?php echo $searchlevel[1];?></option> 
                        </select>
                    </td>
                    <td class="mediumColumn">
                        <select class="updateField" name="subject_id" class="dropdown">
                          <?php echo "<option value=".$row['subject_id'].">".getSubjectName($row['subject_id'])."</option>";
                                $i=0;
                                //displaying dynamically remained subjects 
                                foreach($difSubject as $dif)
                                    echo "<option value=".$dif.">".getSubjectName($dif[$i])."</option>";
                             ?>
                        </select>
                    </td>
                    <td class="mediumColumn">
                        <input class="manageButton" type="submit" name="action" value="Update" onclick="return confirm('Are you sure you want to update this question?')">
                        <input class="manageButton" type="submit" name="action" value="Delete" onclick="return confirm('Are you sure you want to delete this question?')">
                    </td>
                    <input type="hidden" name="updateQuestion" value="<?php echo $row['question_id']; ?>">
        </tr><br>
                </form>
        <?php } ?>
    </table>
<?php 
}
?>

