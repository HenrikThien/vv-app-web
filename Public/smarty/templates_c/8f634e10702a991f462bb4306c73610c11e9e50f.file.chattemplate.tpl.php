<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-04-29 19:22:19
         compiled from "Public/smarty/templates/adminlte/chattemplate.tpl" */ ?>
<?php /*%%SmartyHeaderCode:601384365723984b6d2bb1-63319593%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8f634e10702a991f462bb4306c73610c11e9e50f' => 
    array (
      0 => 'Public/smarty/templates/adminlte/chattemplate.tpl',
      1 => 1456775476,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '601384365723984b6d2bb1-63319593',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'url' => 0,
    'user' => 0,
    'chats' => 0,
    'chat' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5723984b7b8231_67923736',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5723984b7b8231_67923736')) {function content_5723984b7b8231_67923736($_smarty_tpl) {?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>VisVitalis | Nachrichten</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href='<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
/plugins/fullcalendar/fullcalendar.css' rel='stylesheet' />
    <link href='<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
/plugins/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <?php echo '<script'; ?>
 src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"><?php echo '</script'; ?>
>
    <![endif]-->
  </head>
  <!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
  <body class="skin-blue layout-top-nav">
    <div class="wrapper">

      <header class="main-header">
        <nav class="navbar navbar-static-top">
          <div class="container">
            <div class="navbar-header">
              <a href="/Home/" class="navbar-brand">VisVitalis Web Interface</a>
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <i class="fa fa-bars"></i>
              </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
              <ul class="nav navbar-nav">
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-menu-hamburger"></span> Optionen <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="/CreateMask/"><span class="glyphicon glyphicon-file"></span> Neue Maske erstellen.</a></li>
                    <li><a href="/FinishedMasks/"><span class="glyphicon glyphicon-export"></span> Fertige Masken exportieren. (ALT)</a></li>
                    <li><a href="/ExportMasks/"><span class="glyphicon glyphicon-export"></span> Fertige Masken exportieren. (NEU)</a></li>
                    <li role="separator" class="divider"></li>
                    <li class="active"><a href="/Chat/"><span class="glyphicon glyphicon-send"></span> Nachricht an Gerät senden.</a></li>
                  </ul>
                </li>
              </ul>
            </div>

            <!-- Navbar Right Menu -->
              <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                  <!-- User Account Menu -->
                  <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <!-- The user image in the navbar-->
                      <img src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
/dist/img/ic_launcher.png" class="user-image" alt="User Image" />
                      <!-- hidden-xs hides the username on small devices so only the image appears. -->
                      <span class="hidden-xs"><?php echo $_smarty_tpl->tpl_vars['user']->value['first_name'];?>
 <?php echo $_smarty_tpl->tpl_vars['user']->value['last_name'];?>
</span>
                    </a>
                    <ul class="dropdown-menu">
                      <!-- The user image in the menu -->
                      <li class="user-header">
                        <img src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
/dist/img/ic_launcher.png" alt="" />
                        <p>
                          <?php echo $_smarty_tpl->tpl_vars['user']->value['first_name'];?>
 <?php echo $_smarty_tpl->tpl_vars['user']->value['last_name'];?>

                          <small><?php echo $_smarty_tpl->tpl_vars['user']->value['rank_name'];?>
</small>
                        </p>
                      </li>
                      <!-- Menu Footer-->
                      <li class="user-footer">
                        <div class="pull-left">
                          <a href="/Home/Settings" class="btn btn-default btn-flat">Einstellungen</a>
                        </div>
                        <div class="pull-right">
                          <a href="/Home/Logout" class="btn btn-default btn-flat">Abmelden</a>
                        </div>
                      </li>
                    </ul>
                  </li>
                </ul>
              </div><!-- /.navbar-custom-menu -->
          </div><!-- /.container-fluid -->
        </nav>
      </header>
      <!-- Full Width Column -->
      <div class="content-wrapper">
        <div class="container">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
              <b>V</b>is<b>V</b>italis
              <small>Nachrichtendienst</small>
            </h1>
            <ol class="breadcrumb">
              <li><a href="/Home/"><i class="fa fa-dashboard"></i> Home</a></li>
              <li><a href="/Chat/">Nachrichtendienst</a></li>
            </ol>
          </section>

          <!-- Main content -->
          <section class="content">
            <div class="row">
              <div class="col-md-12">
                <div id="messageBox" class="alert alert-danger hidden" role="alert"></div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-8">
                  <!-- DIRECT CHAT -->
                  <div id="chatBox" class="box box-warning direct-chat direct-chat-warning">
                    <div class="box-header with-border">
                      <h3 class="box-title"><span class="glyphicon glyphicon-send"></span> Nachrichtendienst</h3>
                      <div class="box-tools pull-right">
                        <button id="contactsBtn" class="btn btn-box-tool" data-toggle="tooltip" title="Kontakte" data-widget="chat-pane-toggle"><i class="fa fa-comments"></i></button>
                      </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                      <!-- Conversations are loaded here -->
                      <div id="chatContent" class="direct-chat-messages">
                        
                      </div><!--/.direct-chat-messages-->

                      <!-- Contacts are loaded here -->
                      <div class="direct-chat-contacts">
                        <ul class="contacts-list">
                          <?php  $_smarty_tpl->tpl_vars['chat'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['chat']->_loop = false;
 $_smarty_tpl->tpl_vars['cid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['chats']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['chat']->key => $_smarty_tpl->tpl_vars['chat']->value) {
$_smarty_tpl->tpl_vars['chat']->_loop = true;
 $_smarty_tpl->tpl_vars['cid']->value = $_smarty_tpl->tpl_vars['chat']->key;
?>
                            <li class='chatItem' id=<?php echo $_smarty_tpl->tpl_vars['chat']->value['id'];?>
>
                              <a href="#">
                                <img class="contacts-list-img" src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
/dist/img/ic_launcher.png">
                                <div class="contacts-list-info">
                                  <span class="contacts-list-name">
                                    <?php if ($_smarty_tpl->tpl_vars['chat']->value['contact_a']=="Büro") {?>
                                      Chat mit: <?php echo $_smarty_tpl->tpl_vars['chat']->value['contact_b'];?>

                                    <?php } elseif ($_smarty_tpl->tpl_vars['chat']->value['contact_b']=="Büro") {?>
                                      Chat mit: <?php echo $_smarty_tpl->tpl_vars['chat']->value['contact_a'];?>

                                    <?php }?>
                                    <small class="contacts-list-date pull-right">Öffnen</small>
                                  </span>
                                </div><!-- /.contacts-list-info -->
                              </a>
                            </li><!-- End Contact Item -->
                          <?php } ?>
                        </ul><!-- /.contatcts-list -->
                      </div><!-- /.direct-chat-pane -->
                    </div><!-- /.box-body -->
                    <div id="chatFooter" class="box-footer hidden">
                      <form action="#" method="post">
                        <div class="input-group">
                          <input type="text" name="message" placeholder="Nachricht eingeben" class="form-control">
                          <span class="input-group-btn">
                            <button type="button" id="sendMessageBtn" class="btn btn-warning btn-flat"><span class="glyphicon glyphicon-send"></span> Senden</button>
                          </span>
                        </div>
                      </form>
                    </div><!-- /.box-footer-->
                    <div id="chatLoading" class="overlay hidden">
                      <i class="fa fa-refresh fa-spin"></i>
                    </div>
                  </div><!--/.direct-chat -->
                </div><!-- /.col -->
            </div>
          </section><!-- /.content -->
        </div><!-- /.container -->
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="container">
          <div class="pull-right hidden-xs">
            <b>Version</b> 1.0.0.0
          </div>
          <strong>Copyright &copy; 2015 <a href="#">Henrik Thien</a>.</strong> All rights reserved.
        </div><!-- /.container -->
      </footer>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
/plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"><?php echo '</script'; ?>
>
    <!-- Bootstrap 3.3.2 JS -->
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
/bootstrap/js/bootstrap.min.js" type="text/javascript"><?php echo '</script'; ?>
>
    <!-- SlimScroll -->
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
/dist/js/jquery.timeago.js" type="text/javascript"><?php echo '</script'; ?>
>
    <!-- AdminLTE App -->
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
/dist/js/app.min.js" type="text/javascript"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
/dist/js/engine.js" type="text/javascript"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
/dist/js/chat.js" type="text/javascript"><?php echo '</script'; ?>
>
  </body>
</html><?php }} ?>
