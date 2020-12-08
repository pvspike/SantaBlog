<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Functions.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<?php

include 'header.php';

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.css">

<section>
   <div id="slider-animation" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <!-- The slideshow -->
      <div class="carousel-inner">
         <div class="carousel-item active">
            <img src="assets/images/bg-1.jpg" alt="" style="min-width: 100%">
            <div class="text-box">
               <h2 class="wow slideInRight" data-wow-duration="2s"><?php echo $lang['NEXT_CHRISTMAS']; ?>:</h2>
               <div id="clock-b" class="countdown-circles d-flex flex-wrap justify-content-center pt-4">
                  <div class="holder m-2">
                     <span class="h1 font-weight-bold">
                        <div id="days"></div>
                     </span>
                     <?php echo $lang['DAYS']; ?>
                  </div>
                  <div class="holder m-2">
                     <span class="h1 font-weight-bold">
                        <div id="hours"></div>
                     </span>
                     <?php echo $lang['HOURS']; ?>
                  </div>
                  <div class="holder m-2">
                     <span class="h1 font-weight-bold">
                        <div id="minutes"></div>
                     </span>
                     <?php echo $lang['MINUTES']; ?>
                  </div>
                  <div class="holder m-2">
                     <span class="h1 font-weight-bold">
                        <div id="seconds"></div>
                     </span>
                     <?php echo $lang['SECONDS']; ?>
                  </div>
               </div>
            </div>
         </div>
         <div class="carousel-item">
            <img src="assets/images/bg-2.jpg" alt="" style="min-width: 100%">
            <div class="text-box">
               <div class="row align-items-center">
                  <div class="col-md-6">
                     <h2 class="wow fadeInUp" data-wow-duration="4s"><?php echo $lang['DONT_FORGET']; ?></h2>
                     <p class="wow fadeInUp" data-wow-duration="2s"><?php echo $lang['GOD_AND_SANTA']; ?> </p>
                  </div>
                  <div class="col-md-6 wow slideInLeft" data-wow-duration="4s">
                     <img src="assets/images/sleigh.png">
                  </div>
               </div>
            </div>
         </div>
         <div class="carousel-item">
            <img src="assets/images/bg-3.jpg" alt="" style="min-width: 100%">
            <div class="text-box">
               <div class="row align-items-center">
                  <div class="col-md-6  wow slideInRight" data-wow-duration="4s">
                     <h2><?php echo $lang['AFTER_CHRISTMAS']; ?></h2>
                     <p><?php echo $lang['AFTER_CHRISTMAS_WE_CELEBRATE']; ?></p>
                  </div>
                  <div class="col-md-6  wow slideInLeft" data-wow-duration="4s">
                     <h1><?php echo $lang['HAPPY_NEW_YEAR']; ?> <?php echo date('Y', strtotime('+1 year')); ?></h1>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Left and right controls -->
      <a class="carousel-control-prev" href="#slider-animation" data-slide="prev">
      <span class="carousel-control-prev-icon"></span>
      </a>
      <a class="carousel-control-next" href="#slider-animation" data-slide="next">
      <span class="carousel-control-next-icon"></span>
      </a>
   </div>
</section>

<script>

function calculateChristmasCountdown(){
    
    //Get today's date.
    var now = new Date();
 
    //Get the current month. Add a +1 because
    //getMonth starts at 0 for January.
    var currentMonth = (now.getMonth() + 1);
 
    //Get the current day of the month.
    var currentDay = now.getDate();
 
    //Work out the year that the next Christmas
    //day will occur on.
    var nextChristmasYear = now.getFullYear();
    if(currentMonth == 12 && currentDay > 25){
        //This year's Christmas Day has already passed.
        nextChristmasYear = nextChristmasYear + 1;
    }
 
    var nextChristmasDate = nextChristmasYear + '-12-25T00:00:00.000Z';
    var christmasDay = new Date(nextChristmasDate);
 
    //Get the difference in seconds between the two days.
    var diffSeconds = Math.floor((christmasDay.getTime() - now.getTime()) / 1000);
 
    var days = 0;
    var hours = 0;
    var minutes = 0;
    var seconds = 0;
 
    //Don't calculate the time left if it is Christmas day.
    if(currentMonth != 12 || (currentMonth == 12 && currentDay != 25)){
        //Convert these seconds into days, hours, minutes, seconds.
        days = Math.floor(diffSeconds / (3600*24));
        diffSeconds  -= days * 3600 * 24;
        hours   = Math.floor(diffSeconds / 3600);
        diffSeconds  -= hours * 3600;
        minutes = Math.floor(diffSeconds / 60);
        diffSeconds  -= minutes * 60;
        seconds = diffSeconds;
    }
 
    //Add our counts to their corresponding HTML elements.
    document.getElementById('days').innerHTML = days;
    document.getElementById('hours').innerHTML =  hours;
    document.getElementById('minutes').innerHTML = minutes;
    document.getElementById('seconds').innerHTML = seconds;
 
    //Recursive call after 1 second using setTimeout
    setTimeout(calculateChristmasCountdown, 1000);
}
 
calculateChristmasCountdown();
</script>

<?php

include 'footer.php';

?>