      <!-- Audio player container-->
	<div id='player'></div>
    <!-- Audio player js begin-->
    <script src="assets/js/AudioPlayer.js"></script>

    <script>
        // test image for web notifications
        var iconImage = null;

        AP.init({
            container:'#player',//a string containing one CSS selector
            volume   : 0.7,
            autoPlay : true,
            notification: false,
            playList: [
			    {'icon': iconImage, 'title': '<?=APPConfig::TRACK_1_NAME;?>', 'file': '<?=APPConfig::TRACK_1;?>'},
                {'icon': iconImage, 'title': '<?=APPConfig::TRACK_2_NAME;?>', 'file': '<?=APPConfig::TRACK_2;?>'},
				{'icon': iconImage, 'title': '<?=APPConfig::TRACK_3_NAME;?>', 'file': '<?=APPConfig::TRACK_3;?>'},
				{'icon': iconImage, 'title': '<?=APPConfig::TRACK_4_NAME;?>', 'file': '<?=APPConfig::TRACK_4;?>'},
                {'icon': iconImage, 'title': '<?=APPConfig::TRACK_5_NAME;?>', 'file': '<?=APPConfig::TRACK_5;?>'}
          ]
        });
    </script>
    <!-- Audio player js end-->


<!-- Footer starts here -->
<footer class="footer">
	<div class="container mt-5">
		<div class="row ">
			<div class="col-md-12 mt-5 text-center">
			    <img src="assets/images/merry-christmas.png" class="img-fluid" alt="Merry Christmas"">
			</div>
			<div class="col-md-12 text-center mt-5">
				<h6 class=""><?php echo $lang['SANTA_BLOG']; ?> 🎅 © <?php echo date("Y"); ?></a></h6>
			</div>
		</div>
	</div>
</footer>

    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>

</body>
</html>
