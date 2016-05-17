
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>VisVitalis | Home</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link href="{$url}/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{$url}/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link href="{$url}/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <link href="{$url}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
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
                      <img src="{$url}/dist/img/ic_launcher.png" class="user-image" alt="User Image" />
                      <!-- hidden-xs hides the username on small devices so only the image appears. -->
                      <span class="hidden-xs">{$user.first_name} {$user.last_name}</span>
                    </a>
                    <ul class="dropdown-menu">
                      <!-- The user image in the menu -->
                      <li class="user-header">
                        <img src="{$url}/dist/img/ic_launcher.png" alt="" />
                        <p>
                          {$user.first_name} {$user.last_name}
                          <small>{$user.rank_name}</small>
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
              <small>Home</small>
            </h1>
            <ol class="breadcrumb">
              <li><a href="/Home/"><i class="fa fa-dashboard"></i> Home</a></li>
            </ol>
          </section>

          <!-- Main content -->
          <section class="content">
            <div class="row">
              <div class="col-md-12">
                <div class="alert alert-success alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Schließen"><span aria-hidden="true">&times;</span></button>
                  Wilkommen zur&uuml;ck im Interface.
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-8">
                <div class="panel panel-primary">
                  <div class="panel-heading">Liste aller Geräte</div>
                  <div class="panel-body">
                    <div class="table-responsive">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>Gruppe</th>
                            <th>Geräte ID</th>
                          </tr>
                        </thead>
                        <tbody>
                          {foreach key=cid item=device from=$devices}
                            <tr>
                              <td>{$device.username}</td>
                              <td>{$device.device_id|substr:5:40} ...</td>
                            </tr>
                          {/foreach}
                        </tbody>
                      </table>
                    </div>
                    <button class="btn btn-warning form-control" id="addNewDeviceBtn" data-toggle="modal" data-target="#addNewDeviceModal">Neues Ger&auml;t hinzuf&uuml;gen</button>
                  </div>
                </div>
              </div>
              
              <div class="col-md-4">
                <div class="panel panel-primary">
                  <div class="panel-heading">WebAds</div>
                  <div class="panel-body">

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
      <div class="modal fade" id="addNewDeviceModal" tabindex="-1" role="dialog" aria-labelledby="addNewDeviceModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="addNewDeviceModalLabel">Neues Ger&auml;t hinzuf&uuml;gen</h4>
            </div>
            <div class="modal-body">
              <form>
                 <div class="form-group">
                    <label for="groupname">Gruppenname:</label>
                    <input type="text" class="form-control" id="groupname" name="groupname" placeholder="Gruppenname">
                 </div>
                 <div class="form-group">
                    <label for="password">Passwort:</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Passwort">
                 </div>
                 <div class="form-group">
                    <label for="passwordRe">Passwort wiederholen:</label>
                    <input type="password" class="form-control" id="passwordRe" name="passwordRe" placeholder="Passwort wiederholen">
                 </div>
                 
                 <button class="btn btn-success form-control" id="submitBtn">Hinzuf&uuml;gen</button>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Schlie&szlig;en</button>
            </div>
          </div>
        </div>
      </div>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="{$url}/plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="{$url}/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- SlimScroll -->
    <script src="{$url}/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="{$url}/dist/js/jquery.timeago.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="{$url}/dist/js/app.min.js" type="text/javascript"></script>
  </body>
</html>
