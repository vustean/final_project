<?php
if ($_SESSION['username'] == 'admin') { ?>
    <!-- admin page to read update users-->
    <table class="adminTable">
            <tr>
                <th>User Id</th>
                <th>Username</th>
                <th>Email</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th class="smallColumn">Level</th>
                <th class="smallColumn">Active</th>
                <th>Action</th>
            </tr> 
                <?php 
                //get all users
                $result = getUserDetails();
                while ($row = mysqli_fetch_assoc($result)) { 
                    //generating 2 numbers from 1 to 3 excluding current level id (1-3)
                    $levels = array(1,2,3);
                    $excluded = array($row['level_id']);
                    $searchlevel = array_values(array_diff($levels,$excluded)); 
                    if($row['is_active']) $bool = 0; else $bool = 1;
              ?>
                <tr>
                    <form action="admin.php" name="userAdmin" method="POST">
                        <td><?php echo $row['user_id'];?></td>
                        <td><?php echo $row['username'];?></td>
                        <td><?php echo $row['email'];?></td>
                        <td><?php echo $row['first_name'];?></td>
                        <td><?php echo $row['last_name'];?></td>
                        <td>
                            <select class="updateField" name="new_level_id">
                                <option value="<?php echo $row['level_id'];?>"><?php echo $row['level_id'];?></option>
                                <option value="<?php echo $searchlevel[0];?>"><?php echo $searchlevel[0];?></option> 
                                <option value="<?php echo $searchlevel[1];?>"><?php echo $searchlevel[1];?></option> 
                            </select>
                        </td>
                        <td>
                            <select class="updateField" name="new_active">
                                <option value="<?php echo $row['is_active'];?>"><?php echo $row['is_active'];?></option>
                                <option value="<?php echo $bool;?>"><?php echo $bool;?></option> 
                            </select>
                        </td>
                        <td><input class="manageButton" type="submit" name="action" value="Update" onclick="return confirm('Are you sure you want to update this field?')"></td>
                        <input type="hidden" name="lineUser_id" value="<?php echo $row['user_id']; ?>">
                    
                    </form>
                </tr><br>
            <?php } ?>
    </table>
<?php
}
?>
