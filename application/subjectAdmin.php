<?php
if ($_SESSION['username'] == 'admin') { ?>
    <!--admin page for managing subjects
    Calling this file, a table with subject is displayed and is available for read, update, create-->
    <table class="adminTable">
        <tr>
            <th colspan="6">Create new subject</th>
        </tr>
        <tr>
            <form action="admin.php" method="POST">
                <td class="mediumColumn"></td>
                <td class="largeColumn"><textarea name="subject_name" class="updateField" rows="6" cols="20"></textarea></td>
                <td class="largeColumn"><textarea name="description" class="updateField" rows="6" cols="20"> </textarea></td>
                <td class="largeColumn"><textarea name="logo" class="updateField" rows="6" cols="12"></textarea></td>
                <td>
                    <select class="updateField" name="is_active">
                        <option value="-">-</option>
                        <option value="1">1</option>
                        <option value="0">0</option>
                    </select>
                </td>
                <td class="mediumColumn"><input class="manageButton" type="submit" name="action" value="Create"></td>
                <input type="hidden" name="createSubject" value="createSubject">
            </form>
        </tr>
        <tr>
            <th class="mediumColumn">Subject Id</th>
            <th class="largeColumn">Subject Name</th>
            <th class="largeColumn">Description</th>
            <th class="largeColumn">Logo</th>
            <th colspan="2">Action</th>
        </tr> 
        <tr>
         <?php 
        while ($row = mysqli_fetch_assoc($result)) {  
            if($row['is_active']) $bool = 0; else $bool = 1;?>
        <tr>
            <form action="admin.php" method="POST">
                <td class="mediumColumn"><?php echo $row['subject_id'];?></td>
                <td class="largeColumn"><textarea name="subject_name" class="updateField" rows="6" cols="20"><?php echo $row['subject_name'];?></textarea></td>
                <td class="largeColumn"><textarea name="description" class="updateField" rows="6" cols="20"> <?php echo $row['description'];?></textarea></td>
                <td class="largeColumn"><textarea name="logo" class="updateField" rows="6" cols="12"><?php echo $row['logo'];?></textarea></td>
                <td>
                    <select class="updateField" name="new_active">
                        <option value="<?php echo $row['is_active'];?>"><?php echo $row['is_active'];?></option>
                        <option value="<?php echo $bool;?>"><?php echo $bool;?></option> 
                    </select>
                </td>
                <td class="mediumColumn"><input class="manageButton" type="submit" name="action" value="Update" onclick="return confirm('Are you sure you want to update this field?')"></td>
                <input type="hidden" name="updateSubject" value="<?php echo $row['subject_id']; ?>">
                <input type="hidden" name="current_is_active" value="<?php echo $row['is_active']; ?>">
            </form>
        </tr><br>
        <?php } ?>
    </table>
<?php
}
?>
