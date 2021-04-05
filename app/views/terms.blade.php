<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $panelInit->settingsArray['siteTitle'] . " | " . $panelInit->language['schoolTerms']; ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
       	<link href="<?php echo URL::to('/'); ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo URL::to('/'); ?>/assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo URL::to('/'); ?>/assets/css/datepicker3.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo URL::to('/'); ?>/assets/css/jquery-ui.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo URL::to('/'); ?>/assets/css/jquery.gritter.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo URL::to('/'); ?>/assets/css/fullcalendar.css" rel="stylesheet" type="text/css" />        
        <link href="<?php echo URL::to('/'); ?>/assets/css/FrelancersGroup.css" rel="stylesheet" type="text/css" />
        <?php if($panelInit->language['position'] == "rtl"){ ?>
            <link href="{{URL::to('/')}}/assets/css/rtl.css" rel="stylesheet" type="text/css" />
        <?php } ?>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bg-black rtlPage">

        <div class="form-box" id="login-box" style="width:800px;">
            <div class="header"><?php echo $panelInit->language['schoolTerms']; ?></div>
                <div class="body bg-gray">
                    {{$terms}}
                </div>
                <div class="footer">                                                               
                    <p><a href="javascript:window.print()"><?php echo $panelInit->language['printPage']; ?></a></p>
                    <p><a href="<?php echo URL::to('/login'); ?>"><?php echo $panelInit->language['loginToAccount']; ?></a></p>
                </div>
            </form>
        </div>

        <script src="{{URL::to('/')}}/assets/js/jquery.min.js"></script>
        <script src="{{URL::to('/')}}/assets/js/bootstrap.min.js" type="text/javascript"></script>
    </body>
</html>