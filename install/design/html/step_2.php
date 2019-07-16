<table id="test_server" cellspacing="0" border="0">
    <?php if(!empty($test_server['working_dir'])){?>
    <tr class="<?=$test_server['working_dir']['status']?>">
        <td class="test_param">
            <?=$lang->text_access_working_dir?>
        </td>
        <td class="test_result_message">
            <?=$test_server['working_dir']['message']?>
        </td>
        <td class="test_result_icon">
        </td>
    </tr>
    <?php }?>
    <tr class="<?=$test_server['php']['status']?>">
        <td class="test_param">
            <?=$lang->text_php_version?>
        </td>
        <td class="test_result_message">
            <?=$test_server['php']['message']?>
        </td>
        <td class="test_result_icon">
        </td>
    </tr>
    <?php foreach($test_server['extensions'] as $extension){?>
    <tr class="<?=$extension['status']?>">
        <td class="test_param">
            <?=$extension['name']?>
        </td>
        <td class="test_result_message">
            <?=$extension['message']?>
        </td>
        <td class="test_result_icon">
        </td>
    </tr>
    <?php }?>
</table>

<?php if($test_server['total_result']){?>

    <p class="check_true"><?=$lang->text_success_test?></p>
    <div class="step_info">
        <p><?=$lang->text_now_we_unzipped?></p>
        <?=dirname(dirname(dirname(__DIR__)))?>
        <p><?=$lang->text_files_will_be_deleted?></p>
        <p><?=$lang->text_important_files?></p>
    </div>

    <form method="GET" class="clearfix">
        <input name="route" type="hidden" value="Step_3" />
        <input type="submit" class="next_step_button" value="<?=$lang->next_step?>" />
    </form>
<?php } else {?>
    <form method="GET" class="clearfix">
        <input name="route" type="hidden" value="Step_2" />
        <input type="submit" class="next_step_button" value="<?=$lang->re_test?>" />
    </form>
<?php }?>
