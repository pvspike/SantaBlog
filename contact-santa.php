<?PHP require_once('includes/google.php'); ?>
<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Functions.php"); ?>
<?php require_once("includes/Sessions.php"); ?>

<?php
include 'header.php';
?>
<style>
body{
	background: #4776E6;  /* fallback for old browsers */
    background: -webkit-linear-gradient(to bottom, #8E54E9, #4776E6);  /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(to bottom, #8E54E9, #4776E6); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
}
</style>	
	<script>
	$(document).ready(function (e){
		$("#frmContact").on('submit',(function(e){
			e.preventDefault();
			$("#mail-status").hide();
			$('#send-message').hide();
			$('#loader-icon').show();
			$.ajax({
				url: "contact.php",
				type: "POST",
				dataType:'json',
				data: {
				"name":$('input[name="name"]').val(),
				"email":$('input[name="email"]').val(),
				"phone":$('input[name="phone"]').val(),
				"content":$('textarea[name="content"]').val(),
				"g-recaptcha-response":$('textarea[id="g-recaptcha-response"]').val()},				
				success: function(response){
				$("#mail-status").show();
				$('#loader-icon').hide();
				if(response.type == "error") {
					$('#send-message').show();
					$("#mail-status").attr("class","error");				
				} else if(response.type == "message"){
					$('#send-message').hide();
					$("#mail-status").attr("class","success");							
				}
				$("#mail-status").html(response.text);	
				},
				error: function(){} 
			});
		}));
	});
	</script>
<script src='https://www.google.com/recaptcha/api.js'></script>	

<div class="container contact-form">
   <div class="contact-image">
      <img src="assets/images/santa-contact.png" alt="contact santa"/>
   </div>
   <form id="frmContact" action="" method="POST" novalidate="novalidate">
      <h3><?php echo $lang['SEND_MESSAGE_TO_SANTA']; ?></h3>
      <p><?php echo $lang['WE_SEND_TO_SANTA']; ?></p>
      <div class="row">
         <div class="col-md-6">
            <div class="form-group">
               <input type="text" name="name" class="form-control" placeholder="<?php echo $lang['YOUR_NAME']; ?> *" value="" />
            </div>
            <div class="form-group">
               <input type="text" name="email" class="form-control" placeholder="<?php echo $lang['YOUR_EMAIL']; ?> *" value="" />
            </div>
            <div class="form-group">
               <input type="text" name="phone" class="form-control" placeholder="Your Phone Number *" value="" />
            </div>
            <div class="form-group">
               <input type="Submit" id="send-message" name="btnSubmit" class="btnContact" value="Send Message" />
            </div>
            <div class="g-recaptcha" data-sitekey="<?php echo SITE_KEY; ?>"></div>
            <div id="mail-status"></div>
         </div>
         <div class="col-md-6">
            <div class="form-group">
               <textarea name="content" class="form-control" placeholder="<?php echo $lang['YOUR_MESSAGE']; ?> *" style="width: 100%; height: 150px;"></textarea>
            </div>
         </div>
      </div>
   </form>
   <div id="loader-icon" style="display:none;"><img src="assets/images/loader.gif" /></div>
</div>

<?php
include 'footer.php';
?>