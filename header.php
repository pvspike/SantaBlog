<?php
include 'common.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <!-- viewport meta -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <meta name="description" content="<?=APPConfig::SITE_DESC;?>">
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?=APPConfig::SITE_NAME;?>">
    <meta property="og:description" content="<?=APPConfig::SITE_DESC;?>">
    <meta property="og:image" content="<?=APPConfig::SITE_URL;?>/assets/images/og.png">

    <!-- Twitter -->
    <meta property="twitter:title" content="<?=APPConfig::SITE_NAME;?>">
    <meta property="twitter:description" content="<?=APPConfig::SITE_DESC;?>">
    <meta property="twitter:image" content="<?=APPConfig::SITE_URL;?>/assets/images/og.png">

    <title><?=APPConfig::SITE_NAME;?></title>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="assets/css/pva.css?ver1.3"/>	
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="assets/images/favicon.png"/>

	<link rel="stylesheet" href="assets/css/AudioPlayer.css?ver1.1">
	<script src="assets/js/jquery-2.2.4.min.js"></script>
	<script type="text/javascript" src="assets/js/client-side.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/snowfall.css">

    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
    <script>
        window.OneSignal = window.OneSignal || [];
        OneSignal.push(function() {
        OneSignal.init({
         appId: '<?=APPConfig::ONESIGNAL_ID;?>',
        });
      });
    </script>

	 <?=APPConfig::ADDTHIS_CODE1;?>	

<div id="preloader">
	<div id="status"></div>
</div>

<body>

<nav class="navbar navbar-expand-lg nav-pva fixed-top">
   <a class="navbar-brand" href="<?=APPConfig::SITE_URL;?>"><?=APPConfig::SITE_NAME;?></a>
   <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
   <span class="navbar-toggler-icon"></span>
   </button>
   <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
         <li class="nav-item">
            <a class="nav-link" href="home.php" title="<?php echo $lang['HOME']; ?>"><?php echo $lang['HOME']; ?></a>
         </li>
         <li class="nav-item">
            <a class="nav-link " href="send-wishes.php" title="<?php echo $lang['SEND_WISHES']; ?>"><?php echo $lang['SEND_WISHES']; ?></a>
         </li>
         <li class="nav-item">
            <a class="nav-link " href="blog.php" title="<?php echo $lang['SANTA_BLOG']; ?>"><?php echo $lang['SANTA_BLOG']; ?></a>
         </li>
         <li class="nav-item">
            <a class="nav-link " href="contact-santa.php" title="<?php echo $lang['CONTACT']; ?>"><?php echo $lang['CONTACT']; ?></a>
         </li>
      </ul>
      <form class="form-inline my-2 my-lg-0" action="blog.php">
         <input class="form-control mr-sm-2" autofocus="" type="search" name="Search" placeholder="<?php echo $lang['SEARCH_TERM']; ?>…" value="">	  
         <button class="btn btn-outline-danger my-2 my-sm-0" type="submit"><i class="fas fa-search"></i> <?php echo $lang['SEARCH']; ?></button>
      </form>
   </div>
</nav>
	  
<snowfall>
	<snowflake><span>❄</span>️️</snowflake>
	<snowflake><span>❄</span>️️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
	<snowflake><img src="assets/images/snowflake.png">️</snowflake>
</snowfall>
	  
	  
	  