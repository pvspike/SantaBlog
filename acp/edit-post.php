<?php require_once("../includes/DB.php"); ?>
<?php require_once("../includes/Functions.php"); ?>
<?php require_once("../includes/Sessions.php"); ?>
<?php Confirm_Login(); ?>


<?php
$SearchQueryParameter = $_GET['id'];

if (isset($_POST["Submit"])) {
    $PostTitle = $_POST["PostTitle"];
    $Category  = $_POST["Category"];
    $Image     = $_FILES["Image"]["name"];
    $Target    = "../uploads/" . basename($_FILES["Image"]["name"]);
    $PostText  = $_POST["PostDescription"];
    $Admin = 'Maddie';
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);

    if (empty($PostTitle)) {
        $_SESSION["ErrorMessage"] = "Title Cant be empty";
        Redirect_to("posts.php");
    } elseif (strlen($PostTitle) < 5) {
        $_SESSION["ErrorMessage"] = "Post Title should be greater than 5 characters";
        Redirect_to("posts.php");
    } elseif (strlen($PostText) > 9999) {
        $_SESSION["ErrorMessage"] = "Post Description should be less than than 1000 characters";
        Redirect_to("posts.php");
    } else {
        // Query to insert Post in DB When everything is fine
        global $ConnectingDB;
        if (!empty($_FILES['Image']['name'])) {
            $sql = "UPDATE posts SET title = '$PostTitle', category = '$Category',image = '$Image',post = '$PostText' WHERE id='$SearchQueryParameter'";
        } else {
            $sql = "UPDATE posts SET title = '$PostTitle', category = '$Category',post = '$PostText' WHERE id='$SearchQueryParameter'";
        }
        $Execute = $ConnectingDB->query($sql);
        move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);
        if ($Execute) {
            $_SESSION["SuccessMessage"] = "Post updated Successfully";
            Redirect_to("posts.php");
        } else {
            $_SESSION["ErrorMessage"] = "Something went wrong. Try Again !";
            Redirect_to("posts.php");
        }
    }
} //Ending of Submit Button If-Condition
?>

<?php
include 'header.php';
?>


    <!-- Main Area -->
    <section class="container mb-4" style="margin-top: 70px;">
        <div class="row">
            <div class="offset-lg-1 col-lg-10" style="min-height:400px;">
                <?php
                echo ErrorMessage();
                echo SuccessMessage();
                // connect db
                global $ConnectingDB;

                $sql = "SELECT * FROM posts WHERE id ='$SearchQueryParameter'";
                $stmtPost = $ConnectingDB->query($sql);
                while ($DataRows = $stmtPost->fetch()) {
                    $TitleToBeUpdated = $DataRows['title'];
                    $CatagoryToBeUpdated = $DataRows['category'];
                    $ImageToBeUpdated = $DataRows['image'];
                    $PostToBeUpdated = $DataRows['post'];
                }

                ?>
                <form class="" action="edit-post.php?id=<?php echo $SearchQueryParameter ?>" method="post" enctype="multipart/form-data">
                    <div class="card bg-secondary text-light mb-3">
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="title"> <span class="FieldInfo"> Post Title: </span></label>
                                <input class="form-control" type="text" name="PostTitle" id="title" placeholder="Type title here" value="<?php echo $TitleToBeUpdated ?>">
                            </div>
                            <div class="form-group">
                                <span class="FieldInfo">Exisiting Category:</span>
                                <?php echo $CatagoryToBeUpdated ?>
                                <br>
                                <label for="CategoryTitle"> <span class="FieldInfo"> Chose Category </span></label>
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
                                <span class="FieldInfo">Exisiting Image:</span>
                                <img src="../uploads/<?php echo $ImageToBeUpdated ?>" />
                                <br>
                                <div class="custom-file">
                                    <input class="custom-file-input" type="File" name="Image" id="imageSelect" value="">
                                    <label for="imageSelect" class="custom-file-label">Select Image </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Post"> <span class="FieldInfo"> Post: </span></label>
                                <textarea class="form-control" id="Post" name="PostDescription" rows="8" cols="80">
                                    <?php echo $PostToBeUpdated ?>
                                </textarea>
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
