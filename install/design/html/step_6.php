<?php
if(isset($errors)) {
    foreach($errors as $error) {
        print "<p class=\"error_block\">$error</p>";
    }
}
?>

<?php if(isset($success)) {?>
    <p class="check_true"><?=$success->title?></p>
    <form method="GET" class="clearfix">
        <input name="route" type="hidden" value="Step_7" />
        <input class="next_step_button" type="submit" value="<?=$lang->next_step?>" />
    </form>
<?php } else { ?>
    <form method="POST" class="clearfix">
        <table>
            <tr>
                <td class="form_label"><?=$lang->login?></td>
                <td>
                    <input class="form_input" type="text" name="login" required value="<?php isset($login) ? print $login : ''?>">
                </td>
            </tr>
            <tr>
                <td class="form_label"><?=$lang->password?></td>
                <td>
                    <input class="form_input" type="text" name="password" required value="<?php isset($password) ? print $password : ''?>">
                </td>
            </tr>
            <tr>
                <td class="form_label"><?=$lang->email?></td>
                <td>
                    <input class="form_input" type="text" name="email" required value="<?php isset($email) ? print $email : ''?>">
                </td>
            </tr>
            <tr>
                <td class="form_label helper_wrap">
                    <?=$lang->phone?>
                    <span class="helper_sign">?</span>
                    <div class="helper_text"><?=$lang->phone_help?></div>
                </td>
                <td>
                    <input class="form_input" type="text" name="phone" required value="<?php isset($phone) ? print $phone : ''?>">
                </td>
            </tr>
        </table>
        <input type="submit" class="next_step_button" name="admin_conf" value="<?=$lang->next_step?>">
    </form>
<?php }?>