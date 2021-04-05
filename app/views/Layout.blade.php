<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $panelInit->settingsArray['siteTitle'] . " | " . $panelInit->language['dashboard'] ; ?></title>
        <base href="<?php echo URL::to('/'); ?>/" />
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="{{URL::to('/')}}/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="{{URL::to('/')}}/assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="{{URL::to('/')}}/assets/css/datepicker3.css" rel="stylesheet" type="text/css" />
        <link href="{{URL::to('/')}}/assets/css/jquery-ui.min.css" rel="stylesheet" type="text/css" />
        <link href="{{URL::to('/')}}/assets/css/jquery.gritter.css" rel="stylesheet" type="text/css" />
        <link href="{{URL::to('/')}}/assets/css/fullcalendar.css" rel="stylesheet" type="text/css" />        
        <link href="{{URL::to('/')}}/assets/css/FrelancersGroup.css" rel="stylesheet" type="text/css" />
        <?php if($panelInit->isRTL == 1){ ?>
            <link href="{{URL::to('/')}}/assets/css/rtl.css" rel="stylesheet" type="text/css" />
        <?php } ?>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-<?php echo $panelInit->settingsArray['layoutColor']; ?> fixed" ng-app="Frelancers Group" ng-controller="mainController">
        <header class="header">
            <a href="#" class="logo"><?php echo $panelInit->settingsArray['siteTitle']; ?></a>
            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only"><?php echo $panelInit->language['toggleDropdown']; ?></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        
                        <li class="dropdown user user-menu">
                            <a href="" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span>{{$users['fullName']}} <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#accountSettings/profile"><?php echo $panelInit->language['ChgProfileData']; ?></a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#accountSettings/email"><?php echo $panelInit->language['chgEmailAddress']; ?></a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#accountSettings/password"><?php echo $panelInit->language['chgPassword']; ?></a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown user user-menu">
                            <a href="<?php echo URL::to('/logout'); ?>">
                                <i class="fa fa-fw fa-sign-out"></i>
                                <span><?php echo $panelInit->language['logout']; ?></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <aside class="left-side sidebar-offcanvas">
                <section class="sidebar">
                    <ul class="sidebar-menu">
                        <?php
                        while (list($key, $value) = each($panelInit->panelItems)) {
                            if(isset($value['activated']) AND !strpos($panelInit->settingsArray['activatedModules'],$value['activated']) ){ continue;  }
                            if(!in_array($users->role, $value['permissions'])){
                                continue;
                            }
                            echo "<li ";
                            if(isset($value['children'])){
                                echo "class='treeview'";
                            }
                            echo ">";
                            echo "<a ";
                            if(!isset($value['children'])){
                                echo "class='aj'";
                            }
                            echo " href='".$value['url']."'>";
                            echo "<i class='".$value['icon']."'></i><span>".$panelInit->language[$value['title']]."</span>";
                            if(isset($value['children'])){
                                echo "<i class='fa fa-angle-left pull-right leftMenuExpand'></i>";
                            }
                            echo "</a>";
                            if(isset($value['children'])){
                                echo '<ul class="treeview-menu">';
                                while (list($key2, $value2) = each($value['children'])) {
                                    if(isset($value2['activated']) AND !strpos($panelInit->settingsArray['activatedModules'],$value2['activated']) ){ continue;  }
                                    if(!in_array($users->role, $value2['permissions'])){
                                        continue;
                                    }
                                    echo "<li>";
                                    echo "<a class='aj' href='".$value2['url']."'>";
                                    echo "<i class='".$value2['icon']."'></i> ";
                                    if(isset($panelInit->language[$value2['title']])){
                                        echo $panelInit->language[$value2['title']];
                                    }else{
                                        echo $value2['title'];
                                    }
                                    echo "</a>";
                                    echo "</li>";
                                }
                                echo "</ul>";
                            }
                                    
                            echo "</li>";
                        } 
                        ?>
                    </ul>
                </section>
            </aside>
            <aside id='parentDBArea' class="right-side" ng-view></aside>
            
            <div class="overlay"></div>
            <div class="loading-img"></div>

            <div class="pull-right footerCopyRight" style='margin:20px;'><?php echo $panelInit->settingsArray['footer']; ?> - <a target="_BLANK" href="{{URL::to('/terms')}}"><?php echo $panelInit->language['schoolTerms']; ?></a></div>
        </div>

        <script src="{{URL::to('/')}}/assets/js/jquery.min.js"></script>
        <script src="{{URL::to('/')}}/assets/js/jquery-ui.min.js" type="text/javascript"></script>
        <script src="{{URL::to('/')}}/assets/js/moment.js" type="text/javascript"></script>
        <script src="{{URL::to('/')}}/assets/js/fullcalendar.min.js" type="text/javascript"></script>
        <script src="{{URL::to('/')}}/assets/js/jquery.gritter.min.js" type="text/javascript"></script>
        
        <script src="{{URL::to('/')}}/assets/js/Angular/angular.min.js" type="text/javascript"></script>
        <script src="{{URL::to('/')}}/assets/js/Angular/AngularModules.js" type="text/javascript"></script>
        <script src="{{URL::to('/')}}/assets/js/Angular/app.js"></script>
        <script src="{{URL::to('/')}}/assets/js/Angular/routes.js" type="text/javascript"></script>
        
        <script src="{{URL::to('/')}}/assets/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="{{URL::to('/')}}/assets/js/bootstrap-datepicker.js" type="text/javascript"></script>
        <script src="{{URL::to('/')}}/assets/ckeditor/ckeditor.js" type="text/javascript"></script>

        <!-- FLOT CHARTS -->
        <script src="{{URL::to('/')}}/assets/js/flot/jquery.flot.min.js" type="text/javascript"></script>
        <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
        <script src="{{URL::to('/')}}/assets/js/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
        <!-- FLOT PIE PLUGIN - also used to draw donut charts -->
        <script src="{{URL::to('/')}}/assets/js/flot/jquery.flot.pie.min.js" type="text/javascript"></script>
        <!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
        <script src="{{URL::to('/')}}/assets/js/flot/jquery.flot.categories.min.js" type="text/javascript"></script>

        <script src="{{URL::to('/')}}/assets/js/Frelancers Group.js" type="text/javascript"></script>
    </body>
</html>