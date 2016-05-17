<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>VisVitalis | {$lang.title}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link href="{$url}/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{$url}/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="{$url}/plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
    <meta name="google-site-verification" content="3xyUEJDyOQUmasB1pyYrcnYTnYG5s72SBbiJSnXicEE" />
  </head>
  <body class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="/Home/"><b>V</b>is<b>V</b>italis</a>
      </div><!-- /.login-logo -->
      <div id="messageBox" class="alert alert-danger hidden" role="alert"></div>
      <div class="login-box-body">
        <p class="login-box-msg">{$lang.sign_in_title}</p>
        <form id="loginForm">
          <div class="form-group has-feedback">
            <input type="email" class="form-control" name="email" placeholder="{$lang.sign_in_email}" required />
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" name="password" placeholder="{$lang.sign_in_password}" required />
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <label>
                  <input name="rem_me" type="checkbox"> {$lang.sign_in_rememberme}
                </label>
              </div>
            </div>
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">{$lang.sign_in_button}</button>
            </div>
          </div>
        </form>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="{$url}/plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="{$url}/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="{$url}/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>

    <script src="{$url}/dist/js/engine.js" type="text/javascript"></script>
  </body>
</html>
