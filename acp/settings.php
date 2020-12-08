<?php require_once("../includes/DB.php"); ?>
<?php require_once("../includes/Functions.php"); ?>
<?php require_once("../includes/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
Confirm_Login(); ?>


<?php

if (isset($_POST["Submit"])) {
    $SiteName = $_POST["SiteName"];
    $SiteUrl  = $_POST["SiteUrl"];
    $SiteDesc  = $_POST["SiteDesc"];	
    $SiteADS  = $_POST["SiteADS"];		
    $Track1  = $_POST["Track1"];	
    $Track2  = $_POST["Track2"];	
    $Track3  = $_POST["Track3"];	
    $Track4  = $_POST["Track4"];	
    $Track5  = $_POST["Track5"];	
    $Track1Name  = $_POST["Track1Name"];	
    $Track2Name  = $_POST["Track2Name"];	
    $Track3Name  = $_POST["Track3Name"];	
    $Track4Name  = $_POST["Track4Name"];	
    $Track5Name  = $_POST["Track5Name"];		
    $OneSignalID  = $_POST["OneSignalID"];
    $OneSignalKEY  = $_POST["OneSignalKEY"];
    $AddThisCode1  = $_POST["AddThisCode1"];
    $AddThisCode2 = $_POST["AddThisCode2"];	
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);

    if (empty($SiteName)) {
        $_SESSION["ErrorMessage"] = "Title Cant be empty";
        Redirect_to("settings.php");
    } elseif (strlen($SiteName) < 2) {
        $_SESSION["ErrorMessage"] = "Site Name should be greater than 2 characters";
        Redirect_to("settings.php");
    } elseif (strlen($SiteUrl) < 4) {
        $_SESSION["ErrorMessage"] = "Site Url should be greater than 4 characters";
        Redirect_to("settings.php");
    } elseif (strlen($SiteDesc) < 3) {
        $_SESSION["ErrorMessage"] = "Site Desc should be greater than 3 characters";
        Redirect_to("settings.php");	
    } elseif (strlen($SiteADS) < 3) {
        $_SESSION["ErrorMessage"] = "Site ADS should be greater than 3 characters";
        Redirect_to("settings.php");	
    } elseif (strlen($Track1) < 3) {
        $_SESSION["ErrorMessage"] = "Track url should be greater than 3 characters";
        Redirect_to("settings.php");	
    } elseif (strlen($Track1Name) < 3) {
        $_SESSION["ErrorMessage"] = "Track name should be greater than 3 characters";
        Redirect_to("settings.php");	
    } elseif (strlen($Track2) < 3) {
        $_SESSION["ErrorMessage"] = "Track url should be greater than 3 characters";
        Redirect_to("settings.php");	
    } elseif (strlen($Track2Name) < 3) {
        $_SESSION["ErrorMessage"] = "Track nameshould be greater than 3 characters";
        Redirect_to("settings.php");	
    } elseif (strlen($Track3) < 3) {
        $_SESSION["ErrorMessage"] = "Track url should be greater than 3 characters";
        Redirect_to("settings.php");	
    } elseif (strlen($Track3Name) < 3) {
        $_SESSION["ErrorMessage"] = "Track name should be greater than 3 characters";
        Redirect_to("settings.php");	
    } elseif (strlen($Track4) < 3) {
        $_SESSION["ErrorMessage"] = "Track url should be greater than 3 characters";
        Redirect_to("settings.php");	
    } elseif (strlen($Track4Name) < 3) {
        $_SESSION["ErrorMessage"] = "Track name should be greater than 3 characters";
        Redirect_to("settings.php");	
    } elseif (strlen($Track5) < 3) {
        $_SESSION["ErrorMessage"] = "Track url should be greater than 3 characters";
        Redirect_to("settings.php");	
    } elseif (strlen($Track5Name) < 3) {
        $_SESSION["ErrorMessage"] = "Track name should be greater than 3 characters";
        Redirect_to("settings.php");	
    } elseif (strlen($OneSignalID) < 1) {
        $_SESSION["ErrorMessage"] = "OneSignalID cannot be empty";
        Redirect_to("settings.php");	
    } elseif (strlen($OneSignalKEY) < 1) {
        $_SESSION["ErrorMessage"] = "OneSignalKEY annot be empty";
        Redirect_to("settings.php");
    } elseif (strlen($AddThisCode1) < 1) {
        $_SESSION["ErrorMessage"] = "AddThisCode1 annot be empty";
        Redirect_to("settings.php");	
    } elseif (strlen($AddThisCode2) < 1) {
        $_SESSION["ErrorMessage"] = "AddThisCode2 annot be empty";
        Redirect_to("settings.php");			
    } else {


    $config_string = "
<?php
class APPConfig{
    const SITE_NAME = '". $SiteName. "';
    const SITE_URL = '". $SiteUrl. "';
    const SITE_DESC = '". $SiteDesc. "';
    const SITE_ADS = '". $SiteADS. "';
	const TRACK_1 = '". $Track1. "';
	const TRACK_1_NAME = '". $Track1Name. "';	
	const TRACK_2 = '". $Track2. "';
	const TRACK_2_NAME = '". $Track2Name. "';		
	const TRACK_3 = '". $Track3. "';
	const TRACK_3_NAME = '". $Track3Name. "';		
	const TRACK_4 = '". $Track4. "';
	const TRACK_4_NAME = '". $Track4Name. "';		
	const TRACK_5 = '". $Track5. "';
	const TRACK_5_NAME = '". $Track5Name. "';		
	const ONESIGNAL_ID = '". $OneSignalID. "';
	const ONESIGNAL_KEY = '". $OneSignalKEY. "';	
	const ADDTHIS_CODE1 = '". $AddThisCode1. "';
	const ADDTHIS_CODE2 = '". $AddThisCode2. "';		
}
	";


    $config_file = '../includes/configuration.php';
    $handle = fopen($config_file, 'w') or _error("Error", "cannot create the config file");
    fwrite($handle, $config_string);
    fclose($handle);	
    header('Location: index.php');

    }
} //Ending of Submit Button If-Condition
?>

<?php
include 'header.php';
?>


<!-- Main Area -->
<section class="container mb-4" style="margin-top: 90px;">
   <div class="row">
      <div class="offset-lg-1 col-lg-10" style="min-height:400px;">
         <?php
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
         <form class="" action="settings.php" method="post" enctype="multipart/form-data">
            <div class="card bg-secondary text-light mb-3">
               <div class="card-body bg-dark">
                  <div class="form-group">
                     <label for="name"> <span class="FieldInfo"> Site Name: </span></label>
                     <input class="form-control" type="text" name="SiteName" id="name" placeholder="Type title here" value="<?=APPConfig::SITE_NAME;?>">
                  </div>
                  <div class="form-group">
                     <label for="url"> <span class="FieldInfo"> Site Url: </span></label>
                     <input class="form-control" type="text" name="SiteUrl" id="url" placeholder="Type url here" value="<?=APPConfig::SITE_URL;?>">
                  </div>
                  <div class="form-group">
                     <label for="desc"> <span class="FieldInfo"> Site Description: </span></label>
                     <input class="form-control" type="text" name="SiteDesc" id="desc" placeholder="Type description here" value="<?=APPConfig::SITE_DESC;?>">
                  </div>
                  <div class="form-group">
                     <label for="desc"> <span class="FieldInfo"> Site ADS: </span></label>
                     <input class="form-control" type="text" name="SiteADS" id="desc" placeholder="Type ads here" value="<?=APPConfig::SITE_ADS;?>">
                  </div>
                  <div class="form-row mb-2 mt-2">
                     <div class="col">
                        <input type="text" name="Track1" class="form-control" placeholder="Location or url track" value="<?=APPConfig::TRACK_1;?>">
                     </div>
                     <div class="col">
                        <input type="text" name="Track1Name" class="form-control" placeholder="Track Name" value="<?=APPConfig::TRACK_1_NAME;?>">
                     </div>
                  </div>
                  <div class="form-row mb-2 mt-2">
                     <div class="col">
                        <input type="text" name="Track2" class="form-control" placeholder="Location or url track" value="<?=APPConfig::TRACK_2;?>">
                     </div>
                     <div class="col">
                        <input type="text" name="Track2Name" class="form-control" placeholder="Track Name" value="<?=APPConfig::TRACK_2_NAME;?>">
                     </div>
                  </div>
                  <div class="form-row mb-2 mt-2">
                     <div class="col">
                        <input type="text" name="Track3" class="form-control" placeholder="Location or url track" value="<?=APPConfig::TRACK_3;?>">
                     </div>
                     <div class="col">
                        <input type="text" name="Track3Name" class="form-control" placeholder="Track Name" value="<?=APPConfig::TRACK_3_NAME;?>">
                     </div>
                  </div>
                  <div class="form-row mb-2 mt-2">
                     <div class="col">
                        <input type="text" name="Track4" class="form-control" placeholder="Location or url track" value="<?=APPConfig::TRACK_4;?>">
                     </div>
                     <div class="col">
                        <input type="text" name="Track4Name" class="form-control" placeholder="Track Name" value="<?=APPConfig::TRACK_4_NAME;?>">
                     </div>
                  </div>
                  <div class="form-row mb-2 mt-2">
                     <div class="col">
                        <input type="text" name="Track5" class="form-control" placeholder="Location or url track" value="<?=APPConfig::TRACK_5;?>">
                     </div>
                     <div class="col">
                        <input type="text" name="Track5Name" class="form-control" placeholder="Track Name" value="<?=APPConfig::TRACK_5_NAME;?>">
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="desc"> <span class="FieldInfo"> OneSignal ID: </span></label>
                     <input class="form-control" type="text" name="OneSignalID" id="desc" placeholder="Type OneSignal id here" value="<?=APPConfig::ONESIGNAL_ID;?>">
                  </div>
                  <div class="form-group">
                     <label for="desc"> <span class="FieldInfo"> OneSignal KEY: </span></label>
                     <input class="form-control" type="text" name="OneSignalKEY" id="desc" placeholder="Type OneSignal Key here" value="<?=APPConfig::ONESIGNAL_KEY;?>">
                  </div>
                  <div class="form-group">
                     <label for="AddThisCode1">AddThis Code 1</label>
                     <textarea class="form-control" id="AddThisCode1" name="AddThisCode1"  rows="3"><?=APPConfig::ADDTHIS_CODE1;?></textarea>
                  </div>
                  <div class="form-group">
                     <label for="AddThisCode2">AddThis Code 2</label>
                     <textarea class="form-control"  id="AddThisCode2" name="AddThisCode2" rows="3"><?=APPConfig::ADDTHIS_CODE2;?></textarea>
                  </div>
                  <div class="row">
                     <div class="col-lg-6 mb-2">
                        <a href="index.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back To Dashboard</a>
                     </div>
                     <div class="col-lg-6 mb-2">
                        <button type="submit" name="Submit" class="btn btn-success btn-block">
                        <i class="fas fa-check"></i> Publish
                        </button>
                     </div>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>
</section>

<?php
include 'footer.php';
?>