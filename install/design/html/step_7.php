<?php
if(isset($errors)) {
    foreach($errors as $error) {
        print "<p class=\"error_block\">$error</p>";
    }
}
?>

<div class="clearfix">
    <div class="site_link"><?=$lang->front?>: <a href="<?=$url?>"><?=$url?></a></div>
    <div class="backend_link"><?=$lang->backend?>: <a href="<?=$url?>/backend"><?=$url?>/backend</a></div>
</div>

<script>
    window.onload = function() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'deleteInstall.php', false);
        xhr.send();
    }
</script>
