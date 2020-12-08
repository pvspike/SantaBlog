<?php
include '../common.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- viewport meta -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex">
	<meta name="googlebot" content="noindex">
    <title><?=APPConfig::SITE_NAME;?></title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../assets/css/media.css"/>
    <link rel="stylesheet" href="../assets/css/pva.css"/>	
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="assets/images/favicon.png"/>
    <script src="../assets/js/jquery-2.2.4.min.js"></script>

</head>


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
            <a class="nav-link" href="index.php" title="Home"><?php echo $lang['HOME']; ?></a>
         </li>
         <li class="nav-item">
            <a class="nav-link " href="add-new-post.php" title="<?php echo $lang['ADD_NEW_POST']; ?>"><?php echo $lang['ADD_NEW_POST']; ?></a>
         </li>
         <li class="nav-item">
            <a class="nav-link " href="posts.php" title="<?php echo $lang['POSTS']; ?>"><?php echo $lang['POSTS']; ?></a>
         </li>
         <li class="nav-item">
            <a class="nav-link " href="categories.php" title="<?php echo $lang['CATEGORIES']; ?>"><?php echo $lang['CATEGORIES']; ?></a>
         </li>
         <li class="nav-item">
            <a class="nav-link " href="comment.php" title="<?php echo $lang['COMMENTS']; ?>"><?php echo $lang['COMMENTS']; ?></a>
         </li>
         <li class="nav-item">
            <a class="nav-link " href="settings.php" title="Settings">Settings</a>
         </li>
      </ul>
      <ul class="navbar-nav ml-2 mr-2">
         <li class="nav-item">
            <a class="nav-link " href="logout.php" title="Page overview"><?php echo $lang['LOGOUT']; ?></a>
         </li>
      </ul>
   </div>
</nav>
	  
	  

	  