<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php if (isset($systemData['systemname'])) {echo $systemData['systemname'];}?></title>
    <link href="<?php echo $this->Url->webroot('/favicon.ico')?>" rel="Shortcut Icon">
    <!-- bootstrap - css -->
    <link href="<?php echo $this->Url->webroot('/assets/BJUI/themes/css/bootstrap.min.css')?>" rel="stylesheet">
    <!-- core - css -->
    <link href="<?php echo $this->Url->webroot('/assets/BJUI/themes/css/style.css')?>" rel="stylesheet">
    <link href="<?php echo $this->Url->webroot('/assets/BJUI/themes/teal/core.css')?>" id="bjui-link-theme" rel="stylesheet">
    <link href="<?php echo $this->Url->webroot('/css/admin/home.css')?>" rel="stylesheet">
    <!-- plug - css -->
    <link href="<?php echo $this->Url->webroot('/assets/BJUI/plugins/kindeditor/themes/default/default.css')?>" rel="stylesheet">
    <link href="<?php echo $this->Url->webroot('/assets/BJUI/plugins/colorpicker/css/bootstrap-colorpicker.min.css')?>" rel="stylesheet">
    <link href="<?php echo $this->Url->webroot('/assets/BJUI/plugins/bootstrapSelect/bootstrap-select.min.css')?>" rel="stylesheet">
    <link href="<?php echo $this->Url->webroot('/assets/BJUI/themes/css/FA/css/font-awesome.min.css')?>" rel="stylesheet">
    <link href="<?php echo $this->Url->webroot('/assets/BJUI/plugins/uploadify/css/uploadify.css')?>" rel="stylesheet">
    <!-- jquery -->
    <script src="<?php echo $this->Url->webroot('/js/jquery.min.js')?>"></script>
    <script src="<?php echo $this->Url->webroot('/assets/BJUI/js/bjui-all.js')?>"></script>
    <!-- plugins -->
    <!-- kindeditor -->
    <script src="<?php echo $this->Url->webroot('/assets/BJUI/plugins/kindeditor/kindeditor-all.min.js')?>"></script>
    <script src="<?php echo $this->Url->webroot('/assets/BJUI/plugins/kindeditor/lang/zh_CN.js')?>"></script>
    <!-- colorpicker -->
    <script src="<?php echo $this->Url->webroot('/assets/BJUI/plugins/colorpicker/js/bootstrap-colorpicker.min.js')?>"></script>
    <!-- ztree -->
    <script src="<?php echo $this->Url->webroot('/assets/BJUI/plugins/ztree/jquery.ztree.all.min.js')?>"></script>
    <!-- nice validate -->
    <script src="<?php echo $this->Url->webroot('/assets/BJUI/plugins/niceValidator/jquery.validator.js?local=zh-CN')?>"></script>
    <script src="<?php echo $this->Url->webroot('/assets/BJUI/plugins/niceValidator/jquery.validator.themes.js')?>"></script>
    <!-- bootstrap plugins -->
    <script src="<?php echo $this->Url->webroot('/assets/BJUI/plugins/bootstrap.min.js')?>"></script>
    <script src="<?php echo $this->Url->webroot('/assets/BJUI/plugins/bootstrapSelect/bootstrap-select.min.js')?>"></script>
    <script src="<?php echo $this->Url->webroot('/assets/BJUI/plugins/bootstrapSelect/defaults-zh_CN.min.js')?>"></script>
    <!-- icheck -->
    <script src="<?php echo $this->Url->webroot('/assets/BJUI/plugins/icheck/icheck.min.js')?>"></script>
    <!-- other plugins -->
    <script src="<?php echo $this->Url->webroot('/assets/BJUI/plugins/other/jquery.autosize.js')?>"></script>
    <script src="<?php echo $this->Url->webroot('/assets/BJUI/plugins/uploadify/scripts/jquery.uploadify.min.js')?>"></script>
    <script src="<?php echo $this->Url->webroot('/assets/BJUI/plugins/download/jquery.fileDownload.min.js')?>"></script>
    <!-- init -->
    <script type="text/javascript">
        $(function() {
            BJUI.init({
                JSPATH       : '<?php echo $this->Url->webroot('/assets/BJUI/')?>',         //[可选]框架路径
                PLUGINPATH   : '<?php echo $this->Url->webroot('/assets/BJUI/plugins/')?>', //[可选]插件路径
                loginInfo    : {url:'<?php echo $this->Url->build(['plugin' => $this->request->params['plugin'], 'controller' => 'Users', 'action' => 'relogin']);?>', title:'超时登录', width:600, height:300}, // 会话超时后弹出登录对话框
                debug        : false,    // [可选]调试模式 [true|false，默认false]
                theme        : 'teal', // 若有Cookie['bjui_theme'],优先选择Cookie['bjui_theme']。皮肤[皮肤:default, orange, purple, blue, red, green, teal]
                dialog: {
                  mask: true
                }
            })

        })
    </script>
</head>
<body>
<div id="bjui-window">
    <header id="bjui-header">
        <div class="bjui-navbar-header">
            <button type="button" class="bjui-navbar-toggle btn-default" data-toggle="collapse" data-target="#bjui-navbar-collapse">
                <i class="fa fa-bars"></i>
            </button>
            <a class="bjui-navbar-logo" style="color: #fff" href="<?php echo $this->request->here()?>">
                <?php
                if (isset($systemData['systemlogo']) && is_file($systemData['systemlogo'])) {
                    ?>
                    <img height="30" src="<?php echo $this->request->base . DS . $systemData['systemlogo'];?>">
                    <?php
                }
                if (isset($systemData['systemnamehide']) && $systemData['systemnamehide'] != 1) {
                    echo h($systemData['systemname']);
                }
                ?>
            </a>
        </div>
        <nav id="bjui-navbar-collapse">
            <ul class="bjui-navbar-right">
                <li class="datetime"><div><span id="bjui-date"></span> <span id="bjui-clock"></span></div></li>
                <li><a href="#"><?php if (isset($userData)) {echo empty($userData['nickname']) ? $userData['username'] : $userData['nickname'];}?></a></li>
                <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">我的账户 <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="<?php echo $this->Url->build(['plugin' => $this->request->params['plugin'], 'controller' => 'Users', 'action' => 'resetpasswd']);?>" data-toggle="dialog" data-mask="true" data-width="520" data-height="360">
                                &nbsp;<span class="glyphicon glyphicon-lock"></span> 修改密码&nbsp;
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $this->Url->build(['plugin' => $this->request->params['plugin'], 'controller' => 'Users', 'action' => 'myinfo']);?>" data-toggle="dialog" data-width="650" data-height="400" data-id="dialog-mask" data-mask="true">
                                &nbsp;<span class="glyphicon glyphicon-user"></span> 我的资料
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="<?php echo $this->Url->build(['plugin' => $this->request->params['plugin'], 'controller' => 'Users', 'action' => 'logout']);?>" class="red">&nbsp;<span class="glyphicon glyphicon-off"></span> 注销登陆</a></li>
                    </ul>
                </li>
                <li class="dropdown"><a href="#" class="dropdown-toggle theme blue" data-toggle="dropdown" title="切换皮肤"><i class="fa fa-tree"></i></a>
                    <ul class="dropdown-menu" role="menu" id="bjui-themes">
                        <li><a href="javascript:;" class="theme_default" data-toggle="theme" data-theme="default">&nbsp;<i class="fa fa-tree"></i> 黑白分明&nbsp;&nbsp;</a></li>
                        <li><a href="javascript:;" class="theme_orange" data-toggle="theme" data-theme="orange">&nbsp;<i class="fa fa-tree"></i> 橘子红了</a></li>
                        <li><a href="javascript:;" class="theme_purple" data-toggle="theme" data-theme="purple">&nbsp;<i class="fa fa-tree"></i> 紫罗兰</a></li>
                        <li><a href="javascript:;" class="theme_blue" data-toggle="theme" data-theme="blue">&nbsp;<i class="fa fa-tree"></i> 天空蓝</a></li>
                        <li><a href="javascript:;" class="theme_green" data-toggle="theme" data-theme="green">&nbsp;<i class="fa fa-tree"></i> 绿草如茵</a></li>
                        <li><a href="javascript:;" class="theme_teal" data-toggle="theme" data-theme="teal">&nbsp;<i class="fa fa-tree"></i> 蓝绿色</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="bjui-hnav">
            <button type="button" class="btn-default bjui-hnav-more-left" title="导航菜单左移"><i class="fa fa-angle-double-left"></i></button>
            <div id="bjui-hnav-navbar-box">
                <ul id="bjui-hnav-navbar">
                    <?php foreach ($menuData as $key=>$item):?>
                        <li <?php if($key == 0) {echo "class=active";}?>>
                            <a href="javascript:;" data-toggle="slidebar">
                                <?php
                                    if (!empty($item->icon)) {
                                        echo '<i class="fa fa-'. h($item->icon) .'"></i>';
                                    }
                                    echo h($item->name)
                                ?>
                            </a>
                            <?php if (!empty($item->children)):?>
                            <div class="items hide" data-noinit="true">
                                <?php foreach ($item->children as $j):?>
                                <ul class="menu-items" data-tit="<?php echo h($j->name)?>" <?php echo empty($j->icon) ?: 'data-faicon="' . h($j->icon) . '"';?>>
                                    <?php foreach ($j->children as $k):?>
                                    <li>
                                        <a href="<?php echo $this->Url->build('/' . $k->target)?>" data-options="{id:'<?php echo $k->reload?>', faicon:'<?php echo h($k->icon)?>'}">
                                            <?php echo h($k->name)?>
                                        </a>
                                    </li>
                                    <?php endforeach;?>
                                </ul>
                                <?php endforeach;?>
                            </div>
                            <?php endif;?>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
            <button type="button" class="btn-default bjui-hnav-more-right" title="导航菜单右移"><i class="fa fa-angle-double-right"></i></button>
        </div>
    </header>
    <div id="bjui-container">
        <div id="bjui-leftside">
            <div id="bjui-sidebar-s">
                <div class="collapse"></div>
            </div>
            <div id="bjui-sidebar">
                <div class="toggleCollapse"><h2><i class="fa fa-bars"></i> 导航栏 <i class="fa fa-bars"></i></h2><a href="javascript:;" class="lock"><i class="fa fa-lock"></i></a></div>
                <div class="panel-group panel-main" data-toggle="accordion" id="bjui-accordionmenu" data-heightbox="#bjui-sidebar" data-offsety="26">
                </div>
            </div>
        </div>
        <div id="bjui-navtab" class="tabsPage">
            <div class="tabsPageHeader">
                <div class="tabsPageHeaderContent">
                    <ul class="navtab-tab nav nav-tabs">
                        <li data-url="<?php echo $this->Url->build(['plugin' => $this->request->params['plugin'], 'controller' => 'Home', 'action' => 'main']);?>"><a href="javascript:;"><span><i class="fa fa-home"></i> #maintab#</span></a></li>
                    </ul>
                </div>
                <div class="tabsLeft"><i class="fa fa-angle-double-left"></i></div>
                <div class="tabsRight"><i class="fa fa-angle-double-right"></i></div>
                <div class="tabsMore"><i class="fa fa-angle-double-down"></i></div>
            </div>
            <ul class="tabsMoreList">
                <li><a href="javascript:;">#maintab#</a></li>
            </ul>
            <div class="navtab-panel tabsPageContent">
                <div class="navtabPage unitBox">
                    <div class="bjui-pageContent" style="background:#FFF;">
                        Loading...
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer id="bjui-footer">
        <?php
        if (isset($systemData['systemfoot'])) {
            echo h($systemData['systemfoot']);
        }
        ?>
    </footer>
</div>
</body>
</html>