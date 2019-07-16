
<p><?=$lang->enter_db_settings?></p>
<?php
if(isset($errors)) {
    foreach($errors as $error) {
        print "<p class=\"error_block\">$error</p>";
    }
}
?>

<?php
if(isset($db_configured) && $db_configured === true) {
    print "<p class=\"check_true\">" . $lang->db_configured . "</p>";
?>
<form method="GET" class="clearfix">
    <input name="route" type="hidden" value="Step_6" />
    <input type="submit" class="next_step_button" value="<?=$lang->next_step?>" />
</form>
<?php } else {?>
<form method="POST" class="clearfix">
    <table>
        <tr>
            <td class="form_label"><?=$lang->db_server?></td>
            <td>
                <input class="form_input" type="text" name="dbhost" value="<?php isset($dbhost) ? print $dbhost : ''?>" placeholder="localhost">
            </td>
        </tr>
        <tr>
            <td class="form_label"><?=$lang->db_name?></td>
            <td>
                <input class="form_input" type="text" name="dbname" value="<?php isset($dbname) ? print $dbname : ''?>">
            </td>
        </tr>
        <tr>
            <td class="form_label"><?=$lang->db_user?></td>
            <td>
                <input class="form_input" type="text" name="dbuser" value="<?php isset($dbuser) ? print $dbuser : ''?>">
            </td>
        </tr>
        <tr>
            <td class="form_label"><?=$lang->db_password?></td>
            <td>
                <input  class="form_input"type="text" name="dbpassword" value="<?php isset($dbpassword) ? print htmlentities(stripcslashes($dbpassword)) : ''?>">
            </td>
        </tr>
    </table>
    <input type="submit" class="next_step_button" name="dbconfig" value="<?=$lang->next_step?>">
</form>
<?php }?>

