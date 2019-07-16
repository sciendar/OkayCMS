<?php
if(isset($errors)) {
    foreach($errors as $error) {
        print "<p class=\"error_block\">$error</p>";
    }
}
?>

<?php if(isset($success)) {?>
    <p class="check_true"><?=$lang->thanks_for_license?></p>
    <?php if($end_date) {?>
        <p class="step_info"><?=$lang->license_date_text?> <?=$end_date?></p>
    <?php }?>
    <form method="GET" class="clearfix">
        <input name="route" type="hidden" value="Step_6" />
        <input class="next_step_button" type="submit" value="<?=$lang->next_step?>" />
    </form>
<?php } else { ?>
    <p class="step_info"><?=$lang->for_work_okay_cms?>:</p>
    <form method="POST" name="license" class="clearfix">
        <textarea class="license_area" name="license"><?=$license?></textarea>
        <?php if(!empty($test_license)) {?>
            <input class="get_button" type="button" value="<?=$lang->get_test_license?>" onclick="document.license.license.value='<?=$test_license?>';">
        <?php } else {?>
            <a target="_blank" href="http://license.okay-cms.com/index.php?domain=<?=$_SERVER['HTTP_HOST']?>"><?=$lang->get_test_license?></a>
        <?php }?>
        <input class="next_step_button" type="submit" value="<?=$lang->next_step?>">
    </form>
<?php }?>