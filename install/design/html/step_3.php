<p>
<?php
if(isset($error)){
    print "<p class=\"error_block\">" . $error . "</p>";
} else if(isset($success)){
    print "<p class=\"check_true\">" . $success . "</p>";
}
?>
    
</p>
<?php if(!isset($error)){?>
<form method="GET" class="clearfix">
    <input name="route" type="hidden" value="Step_4" />
    <input type="submit" class="next_step_button" value="<?=$lang->next_step?>" />
</form>
<?php }?>
