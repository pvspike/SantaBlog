<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Functions.php"); ?>
<?php require_once("includes/Sessions.php"); ?>

<?php
include 'header.php';
?>

<style>
#myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 9000; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

/* Caption of Modal Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation */
.modal-content, #caption {  
  -webkit-animation-name: zoom;
  -webkit-animation-duration: 0.6s;
  animation-name: zoom;
  animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
  from {-webkit-transform:scale(0)} 
  to {-webkit-transform:scale(1)}
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}

/* The Close Button */
.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
}
</style>


<div class="pva-bg text-white shadow text-center ">
	<h1 class="mb-4 pt-5 font-weight-bold text-uppercase"><?php echo $lang['SEND_WISHES_LOVED_ONES']; ?></h1>
	<p class="font-weight-bold text-uppercase"><?php echo $lang['YOUR_MESSAGE_IN_CHRISTMAS']; ?></p>					
</div>



<div class="container py-5 mb-2">
   <div class="row">
      <div class="col-md-6">
         <div class="preview">
            <p><?php echo $lang['TOUCH_THE_PICTURE']; ?></p>
            <img id="myImg" src="<?=APPConfig::SITE_URL;?>/scripts/server-side.php" alt="Snow" style="width:150%;max-width:300px">
         </div>
      </div>
      <div class="px-4 order-1 order-md-2 col-lg-6">
         <form id="realtime-form" action="#" method="post">
            <div class="input-group mb-2 mr-sm-2">
               <div class="input-group-prepend">
                  <div class="input-group-text"><?php echo $lang['YOUR_FRIENDS_NAME']; ?></div>
               </div>
               <input type="text" id="friend-name" name="friendName" class="form-control" placeholder="<?php echo $lang['YOUR_NAME']; ?>">
            </div>
            <div class="input-group mb-2 mr-sm-2">
               <div class="input-group-prepend">
                  <div class="input-group-text"><?php echo $lang['WISH']; ?></div>
               </div>
               <textarea class="form-control" id="full-text" name="fullText" placeholder="<?php echo $lang['TYPE_WISH']; ?>"></textarea>
            </div>
            <div class="input-group mb-2 mr-sm-2">
               <div class="input-group-prepend">
                  <div class="input-group-text"><?php echo $lang['YOUR_NAME']; ?></div>
               </div>
               <input type="text" id="full-name" name="fullName" class="form-control" placeholder="<?php echo $lang['YOUR_NAME']; ?>">
            </div>
            <a class="btn btn-outline-danger mb-2" href="#" title="template.png" onclick="updateValue('template.png', event);">Template Vintage</a>
            <a class="btn btn-outline-danger mb-2"  href="#" title="template2.png" onclick="updateValue('template2.png', event);">Template Classic</a>
            <a class="btn btn-outline-danger mb-2"  href="#" title="template3.png" onclick="updateValue('template3.png', event);">Template Snowman</a>
            <a class="btn btn-outline-danger mb-2"  href="#" title="template4.png" onclick="updateValue('template4.png', event);">Template Gifts</a>
            <a class="btn btn-outline-danger mb-2"  href="#" title="template5.png" onclick="updateValue('template5.png', event);">Template Gifts 2</a>
            <a class="btn btn-outline-danger mb-2"  href="#" title="template6.png" onclick="updateValue('template6.png', event);">Template Tree</a>
            <a class="btn btn-outline-danger mb-2"  href="#" title="template7.png" onclick="updateValue('template7.png', event);">Template New Year</a>
            <input hidden type="text" id="template" name="template" value="template6.png" />
            <br><br>
         </form>
         <div class="input-group mb-2 mt-4 mr-sm-2">
            <div id="link" class="form-group mx-sm-3 mb-2">
               <input type="text" class="form-control" id="resultsUrl" >
            </div>
            <button type="submit" class="btn btn-primary mb-2" id="getResults">Give me my url!</button>		
         </div>
         <br> <br> <br>
      </div>
   </div>
</div>


<!-- The Modal -->
<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
      <div class="modal-footer">
		<?=APPConfig::ADDTHIS_CODE2;?>	
      </div>  
</div>

<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById("myImg");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
  captionText.innerHTML = this.alt;
  
  addthis_share = {
  title: '<?php echo $lang['FOR_YOU']; ?>',	  
  url: modalImg.src
}  


}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
  modal.style.display = "none";
}
</script>


<script>
function updateValue(val, event) {
    document.getElementById("template").value = val;
    event.preventDefault();
	var base = $(".preview img").attr("src");
	
	//GATHER IMAGE FOR FIRST TIME
	$(".preview img").attr("src",base+'?'+$("#realtime-form").serialize());
}
</script>

<?php
include 'footer.php';
?>