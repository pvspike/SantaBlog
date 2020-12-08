<?php require_once("../includes/DB.php"); ?>
<?php require_once("../includes/Functions.php"); ?>
<?php require_once("../includes/Sessions.php"); ?>
<?php Confirm_Login(); ?>

<?php
$SearchQueryParameter = $_GET['id'];
global $ConnectingDB;

$sql = "SELECT * FROM posts WHERE id ='$SearchQueryParameter'";
$stmtPost = $ConnectingDB->query($sql);
while ($DataRows = $stmtPost->fetch()) {
    $TitleToBeUpdated = $DataRows['title'];
    $CatagoryToBeUpdated = $DataRows['category'];
    $ImageToBeUpdated = $DataRows['image'];
    $PostToBeUpdated = $DataRows['post'];
}

if (isset($_POST["Submit"])) {
    // Query to delete Post in DB When everything is fine
    global $ConnectingDB;
    $sql = "DELETE FROM posts WHERE id='$SearchQueryParameter'";
    $Execute = $ConnectingDB->query($sql);
    if ($Execute) {
        $Target_Path_To_DELETE_Image = "../uploads/$ImageToBeDeleted";
        unlink($Target_Path_To_DELETE_Image);
        $_SESSION["SuccessMessage"] = "Post Deleted Successfully";
        Redirect_to("posts.php");
    } else {
        $_SESSION["ErrorMessage"] = "Something went wrong. Try Again !";
        Redirect_to("posts.php");
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
                // connect db
                ?>
                <form class="" action="delete-post.php?id=<?php echo $SearchQueryParameter ?>" method="post" enctype="multipart/form-data">
                    <div class="card bg-secondary text-light mb-3">
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="title"> <span class="FieldInfo"> Post Title: </span></label>
                                <input disabled class="form-control" type="text" name="PostTitle" id="title" placeholder="Type title here" value="<?php echo $TitleToBeUpdated ?>">
                            </div>
                            <div class="form-group">
                                <span class="FieldInfo">Exisiting Category:</span>
                                <?php echo $CatagoryToBeUpdated ?>
                            </div>
                            <div class="form-group">
                                <span class="FieldInfo">Exisiting Image:</span>
                                <img src="Uploads/<?php echo $ImageToBeUpdated ?>" />
                            </div>
                            <div class="form-group">
                                <label for="Post"> <span class="FieldInfo"> Post: </span></label>
                                <textarea disabled class="form-control" id="Post" name="PostDescription" rows="8" cols="80">
                                    <?php echo $PostToBeUpdated ?>
                                </textarea>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="index.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back To Dashboard</a>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <button type="submit" name="Submit" class="btn btn-danger btn-block">
                                        <i class="fas fa-trash"></i> Delete
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
