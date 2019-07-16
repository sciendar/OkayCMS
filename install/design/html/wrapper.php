<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Language" content="ru" />
    <link href="design/css/style.css" rel="stylesheet"/>
    <link href="design/images/favicon.png" type="image/x-icon" rel="icon"/>
    <link href="design/images/favicon.png" type="image/x-icon" rel="shortcut icon"/>
    <title><?=$lang->meta_title?></title>
</head>
<body>
    <div class="main">
        <div class="wrapper">
            <div class="content">
                <div class="head_title">
                    <img src="design/images/install_logo.png" width="300px" />
                </div>
                <div class="header_info clearfix">
                    <div class="version_block"><?=$lang->system_version . $config->version?></div>
                    <div class="h1_title"><?=$lang->title_h1?> </div>
                    <?php if(!empty($languages)) :?>
                        <div class="languages">
                            <?=$lang->install_lang .":" ?>
                            <?php foreach($languages as $l_label=>$l_param) :?>
                                <a href="<?=$l_param->url?>" class="lang_item <?=($current_language->lang_label == $l_label ? "selected" : "")?>">
                                    <img src="design/images/<?=$l_param->image?>" /> <?=$l_param->name?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <?php require $content; ?>
            </div>
            <div class="footer clearfix">
                <a class="footer_link" target="_blank" href="https://okay-cms.com"><?=$lang->project_homepage?></a>
                <a class="footer_link" target="_blank" href="http://documentation.okay-cms.com"><?=$lang->documentation?></a>
                <a class="footer_link" target="_blank" href="http://forum.okay-cms.com"><?=$lang->support_forum?></a>
            </div>

        </div>
    </div>
</body>
</html>