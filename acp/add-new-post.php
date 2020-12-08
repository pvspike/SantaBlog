<?php require_once("../includes/DB.php"); ?>
<?php require_once("../includes/Functions.php"); ?>
<?php require_once("../includes/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
Confirm_Login(); ?>

<?php
if (isset($_POST["Submit"])) {
    $PostTitle = $_POST["PostTitle"];
    $Category  = $_POST["Category"];
    $Image     = $_FILES["Image"]["name"];
    $Target    = "../uploads/" . basename($_FILES["Image"]["name"]);
    $PostText  = $_POST["PostDescription"];
    $Admin = $_SESSION["AdminName"];
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);

    if (empty($PostTitle)) {
        $_SESSION["ErrorMessage"] = "Title Cant be empty";
        Redirect_to("add-new-post.php");
    } elseif (strlen($PostTitle) < 5) {
        $_SESSION["ErrorMessage"] = "Post Title should be greater than 5 characters";
        Redirect_to("add-new-post.php");
    } elseif (strlen($PostText) > 9999) {
        $_SESSION["ErrorMessage"] = "Post Description should be less than than 1000 characters";
        Redirect_to("add-new-post.php");
    } else {
        // Query to insert Post in DB When everything is fine
        global $ConnectingDB;
        $sql = "INSERT INTO posts(datetime,title,category,author,image,post)";
        $sql .= "VALUES(:dateTime,:postTitle,:categoryName,:adminName,:imageName,:postDescription)";
        $stmt = $ConnectingDB->prepare($sql);
        $stmt->bindValue(':dateTime', $DateTime);
        $stmt->bindValue(':postTitle', $PostTitle);
        $stmt->bindValue(':categoryName', $Category);
        $stmt->bindValue(':adminName', $Admin);
        $stmt->bindValue(':imageName', $Image);
        $stmt->bindValue(':postDescription', $PostText);
		
		function sendMessage() {
		$content      = array(
			"en" => APPConfig::SITE_NAME
		);
			$hashes_array = array();
			$heading = array(
			"en" => $_POST["PostTitle"]
			);
		$fields = array(
			'app_id' =>  APPConfig::ONESIGNAL_ID,
			'included_segments' => array(
            'All'
			),
			'data' => array(
				"foo" => "bar"
			),
			'contents' => $content,
			'headings' => $heading,
			'url' =>  APPConfig::SITE_URL . '/blog.php?Search=' . $_POST["PostTitle"],
			'chrome_web_image' => APPConfig::SITE_URL . '/uploads/' . basename($_FILES["Image"]["name"]),
			'chrome_web_icon' =>  APPConfig::SITE_URL . '/assets/images/favicon.png'		
		);
    
		$fields = json_encode($fields);
		print("\nJSON sent:\n");
		print($fields);
    
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json; charset=utf-8',
			'Authorization: Basic ' . APPConfig::ONESIGNAL_KEY . ''
		));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    
		$response = curl_exec($ch);
		curl_close($ch);
    
		return $response;
	}		
        $Execute = $stmt->execute();
        move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);

        if ($Execute) {
            $_SESSION["SuccessMessage"] = "Post with id : " . $ConnectingDB->lastInsertId() . " added Successfully";
			$response = sendMessage();
            Redirect_to("add-new-post.php");
        } else {
            $_SESSION["ErrorMessage"] = "Something went wrong. Try Again !";
            Redirect_to("add-new-post.php");
        }
    }
} 
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
                <form class="" action="add-new-post.php" method="post" enctype="multipart/form-data">
                    <div class="card bg-secondary text-light mb-3">
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="title"> <span class="FieldInfo"><?php echo $lang['POST_TITLE']; ?>: </span></label>
                                <input class="form-control" type="text" name="PostTitle" id="title" placeholder="Type title here" value="">
                            </div>
                            <div class="form-group">
                                <label for="CategoryTitle"> <span class="FieldInfo"> <?php echo $lang['CHOSE_CATEGORY']; ?> </span></label>
                                <select class="form-control" id="CategoryTitle" name="Category">
                                    <?php
                                    //Fetchinng all the categories from category table
                                    global $ConnectingDB;
                                    $sql = "SELECT * FROM category";
                                    $stmt = $ConnectingDB->query($sql);
                                    while ($DataRows = $stmt->fetch()) {
                                        $Id = $DataRows["id"];
                                        $CategoryName = $DataRows["title"];
                                    ?>
                                        <option> <?php echo $CategoryName; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="custom-file">
                                    <input class="custom-file-input" type="File" name="Image" id="imageSelect" value="">
                                    <label for="imageSelect" class="custom-file-label">Select Image </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Post"> <span class="FieldInfo"> <?php echo $lang['POST']; ?>: </span></label>
                                <textarea class="form-control" id="Post" name="PostDescription" rows="8" cols="80"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="index.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> <?php echo $lang['BACK_TO_DASHBOARD']; ?></a>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <button type="submit" name="Submit" class="btn btn-success btn-block">
                                        <i class="fas fa-check"></i> <?php echo $lang['PUBLISH']; ?>
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
