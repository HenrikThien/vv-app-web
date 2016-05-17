<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-02-26 22:46:20
         compiled from "Public/smarty/templates/adminlte/login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:59221008256d0c7ace16a16-28230538%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a4f87eb9ea8252842b4389fcf4e15fc9e4a3e960' => 
    array (
      0 => 'Public/smarty/templates/adminlte/login.tpl',
      1 => 1452619698,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '59221008256d0c7ace16a16-28230538',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lang' => 0,
    'url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_56d0c7ace85914_78459472',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56d0c7ace85914_78459472')) {function content_56d0c7ace85914_78459472($_smarty_tpl) {?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>VisVitalis | <?php echo $_smarty_tpl->tpl_vars['lang']->value['title'];?>
</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
/plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
    <meta name="google-site-verification" content="3xyUEJDyOQUmasB1pyYrcnYTnYG5s72SBbiJSnXicEE" />
  </head>
  <body class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="/Home/"><b>V</b>is<b>V</b>italis</a>
      </div><!-- /.login-logo -->
      <div id="messageBox" class="alert alert-danger hidden" role="alert"></div>
      <div class="login-box-body">
        <p class="login-box-msg"><?php echo $_smarty_tpl->tpl_vars['lang']->value['sign_in_title'];?>
</p>
        <form id="loginForm">
          <div class="form-group has-feedback">
            <input type="email" class="form-control" name="email" placeholder="<?php echo $_smarty_tpl->tpl_vars['lang']->value['sign_in_email'];?>
" required />
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" name="password" placeholder="<?php echo $_smarty_tpl->tpl_vars['lang']->value['sign_in_password'];?>
" required />
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <label>
                  <input name="rem_me" type="checkbox"> <?php echo $_smarty_tpl->tpl_vars['lang']->value['sign_in_rememberme'];?>

                </label>
              </div>
            </div>
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat"><?php echo $_smarty_tpl->tpl_vars['lang']->value['sign_in_button'];?>
</button>
            </div>
          </div>
        </form>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

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
    <!-- iCheck -->
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
/plugins/iCheck/icheck.min.js" type="text/javascript"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    <?php echo '</script'; ?>
>

    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
/dist/js/engine.js" type="text/javascript"><?php echo '</script'; ?>
>
  </body>
</html>
<?php }} ?>
