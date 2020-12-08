<?php 
   $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2); 
  
   // Redirect browser  
   header("Location:" . "/home.php?lang=" . $lang);     
   exit; 
?> 