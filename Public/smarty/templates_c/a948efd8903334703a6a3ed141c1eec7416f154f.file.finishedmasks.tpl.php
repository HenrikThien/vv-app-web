<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-02-29 20:52:54
         compiled from "Public/smarty/templates/adminlte/finishedmasks.tpl" */ ?>
<?php /*%%SmartyHeaderCode:57509973256d0ae3fc37609-51606069%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a948efd8903334703a6a3ed141c1eec7416f154f' => 
    array (
      0 => 'Public/smarty/templates/adminlte/finishedmasks.tpl',
      1 => 1456775510,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '57509973256d0ae3fc37609-51606069',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_56d0ae3fd97f91_22833962',
  'variables' => 
  array (
    'url' => 0,
    'user' => 0,
    'device_list' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56d0ae3fd97f91_22833962')) {function content_56d0ae3fd97f91_22833962($_smarty_tpl) {?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>VisVitalis | Fertige Masken exportieren</title>
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
                    <li class="active"><a href="/FinishedMasks/"><span class="glyphicon glyphicon-export"></span> Fertige Masken exportieren. (ALT)</a></li>
                    <li><a href="/ExportMasks/"><span class="glyphicon glyphicon-export"></span> Fertige Masken exportieren. (NEU)</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="/Chat/"><span class="glyphicon glyphicon-send"></span> Nachricht an Gerät senden.</a></li>
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
              <small>Fertige Masken exportieren</small>
            </h1>
            <ol class="breadcrumb">
              <li><a href="/Home/"><i class="fa fa-dashboard"></i> Home</a></li>
              <li><a href="/FinishedMasks/">Fertige Masken exportieren</a></li>
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
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading"><span class="glyphicon glyphicon-search"></span> Auswahl suche</div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="searchQueryForm">
                                <div class="form-group">
                                    <label for="inputGroup" class="col-sm-2 control-label">Gruppenwahl:</label>
                                    <div class="col-sm-10">
                                        <select id="inputGroup" name="inputGroup" required class="form-control">
                                            <option value="-1">Bitte w&auml;hlen</option>
                                            <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['cid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['device_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['cid']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
                                                <option value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['username'];?>
</option>
                                            <?php } ?>
                                        </select> 
                                    </div>
                                </div>
                                <div id="maskOptions" class="form-group hidden">
                                    <label for="inputMaskRange" class="col-sm-2 control-label">Maske:</label>
                                    <div class="col-sm-10">
                                        <select id="inputMaskRange" name="inputMaskRange" required class="form-control">
                                            <option value="-1">Bitte w&auml;hlen</option>
                                        </select> 
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div id="exportArea" class="box box-default hidden">
                  <div class="box-header with-border">
                    <div class="box-title"><button id="exportWeekBtn" class="btn btn-success form-control disabled">Die Woche Exportieren</button></div>
                  </div>
                  <div class="box-body">
                    <div class="table-responsive">
                      <table id="patientTable" class="table table-hover table-bordered">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Datum</th>
                            <th>#</th>
                            <th>Mitarbeiter K&uuml;rzel</th>
                            <th>#</th>
                            <th>Kilometer</th>
                            <th>#</th>
                            <th>Pat. Nr.</th>
                            <th>#</th>
                            <th>Einsatz</th>
                            <th>#</th>
                            <th>Ankunft</th>
                            <th>Abfahrt</th>
                            <th>#</th>
                            <th>Leistungen</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="overlay">
                    <i class="fa fa-refresh fa-spin"></i>
                  </div>
                </div>
              </div>
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
  </body>
</html><?php }} ?>
