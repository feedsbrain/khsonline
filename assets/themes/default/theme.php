<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title><?php echo $title; ?></title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />            
        <link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo theme_url(); ?>css/reset.css?v=<?php echo $this->config->item('cjsuf'); ?>" />
        <link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo theme_url(); ?>css/main.css?v=<?php echo $this->config->item('cjsuf'); ?>" />
        <link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo theme_url(); ?>css/2col.css?v=<?php echo $this->config->item('cjsuf'); ?>" title="2col" />
        <link rel="alternate stylesheet" media="screen,projection" type="text/css" href="<?php echo theme_url(); ?>css/1col.css?v=<?php echo $this->config->item('cjsuf'); ?>" title="1col" />
        <!--[if lte IE 6]><link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo theme_url(); ?>css/main-ie6.css?v=<?php echo $this->config->item('cjsuf'); ?>" /><![endif]-->
        <link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo theme_url(); ?>css/style.css?v=<?php echo $this->config->item('cjsuf'); ?>" />
        <link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo theme_url(); ?>css/mystyle.css?v=<?php echo $this->config->item('cjsuf'); ?>" />
        <script type="text/javascript" src="<?php echo theme_url(); ?>js/jquery.js?v=<?php echo $this->config->item('cjsuf'); ?>"></script>
        <script type="text/javascript" src="<?php echo theme_url(); ?>js/switcher.js?v=<?php echo $this->config->item('cjsuf'); ?>"></script>
        <script type="text/javascript" src="<?php echo theme_url(); ?>js/toggle.js?v=<?php echo $this->config->item('cjsuf'); ?>"></script>
        <script type="text/javascript" src="<?php echo theme_url(); ?>js/ui.core.js?v=<?php echo $this->config->item('cjsuf'); ?>"></script>
        <script type="text/javascript" src="<?php echo theme_url(); ?>js/ui.tabs.js?v=<?php echo $this->config->item('cjsuf'); ?>"></script>        
        <?php foreach ($css_files as $file): ?>
            <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>?v=<?php echo $this->config->item('cjsuf'); ?>"/>        
        <?php endforeach; ?>
        <?php foreach ($js_files as $file): ?>
            <script src="<?php echo $file; ?>?v=<?php echo $this->config->item('cjsuf'); ?>"></script>
        <?php endforeach; ?>         
        <!-- Mandatory for every theme -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/fixed.css?v=<?php echo $this->config->item('cjsuf'); ?>" />
        <?php
        if (isset($includes)) {
            echo $includes;
        }
        ?>
    </head>
    <body>
        <div id="main">
            <!-- Tray -->
            <div id="tray" class="box">
                <p class="f-left box">
                    KHS Online: <strong><?php echo $page_name; ?></strong> </p>
                <?php if (!empty($username)) { ?>
                    <p class="f-right">User: <strong><a href="<?php echo base_url(); ?>informasi/" id="username"><?php echo $username; ?></a></strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong><a href="<?php echo base_url(); ?>login/do_logout" id="logout">Log out</a></strong></p>
                <?php } ?>
            </div>
            <!--  /tray -->
            <hr class="noscreen" />
            <!-- Menu -->
            <div id="menu" class="box">
                <ul class="box f-right">
                    <li><a href="http://akperdirgahayu.ac.id/" target="_blank"><span><strong>Situs Akper &raquo;</strong></span></a></li>
                </ul>
                <ul class="box">
                    <?php foreach ($main_menu as $menu_item): ?>
                        <li><?php echo $menu_item; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <!-- /header -->
            <hr class="noscreen" />
            <!-- Columns -->
            <div id="cols" class="box">
                <!-- Aside (Left Column) -->
                <div id="aside" class="box">
                    <div class="padding box">
                        <!-- Logo (Max. width = 200px) -->
                        <p id="logo"><a href="#"><img src="<?php echo theme_url(); ?>tmp/logo.png" alt="" /></a></p>
                    </div>
                    <!-- /padding -->
                    <ul class="box">
                        <?php if (!empty($side_menu)) { ?>
                            <li><a href="#"><strong>KHS Online</strong></a></li>
                            <ul>
                                <?php foreach ($side_menu as $menu_item): ?>                                                
                                    <li><?php echo $menu_item; ?></li>                                                
                                <?php endforeach; ?>           
                            </ul>
                        <?php } ?>
                    </ul>
                </div>
                <!-- /aside -->
                <hr class="noscreen" />
                <!-- Content (Right Column) -->
                <div id="content" class="box">
                    <h1><?php echo $title; ?></h1>
                    <!-- Headings -->
                    <?php if (!empty($system_messages)) echo $system_messages; ?>
                    <?php echo $content; ?>                    
                </div>                
                <!-- /content -->
            </div>
            <!-- /cols -->
            <hr class="noscreen" />
            <!-- Footer -->
            <div id="footer" class="box">
                <p class="f-left">Copyright &copy; <?php echo date('Y'); ?> <a href="http://akperdirgahayu.ac.id/">AKPER Dirgahayu</a> all rights reserved &reg;</p>
                <p class="f-right">Theme Design by <a href="http://www.adminizio.com/">Adminizio</a> - Programmed by <a href="http://www.indragunawan.com/">I.G.</a></p>
            </div>
            <!-- /footer -->
        </div>
        <!-- /main -->
    </body>
</html>
