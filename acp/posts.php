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
    $Admin = 'Maddie';
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
        $Execute = $stmt->execute();
        move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);
        if ($Execute) {
            $_SESSION["SuccessMessage"] = "Post with id : " . $ConnectingDB->lastInsertId() . " added Successfully";
            Redirect_to("add-new-post.php");
        } else {
            $_SESSION["ErrorMessage"] = "Something went wrong. Try Again !";
            Redirect_to("add-new-post.php");
        }
    }
} //Ending of Submit Button If-Condition
?>
<?php
include 'header.php';
?>

<!-- Main Area -->
<section class="container mb-4" style="margin-top: 90px;">
   <div class="row">
      <div class="col-lg-12">
         <?php
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
         <table class="table table-striped table-hover">
            <thead class="thead-dark">
               <tr>
                  <th>#</th>
                  <th>Title</th>
                  <th>Category</th>
                  <th>Date&Time</th>
                  <th>Author</th>
                  <th>Banner</th>
                  <th>Comments</th>
                  <th>Action</th>
                  <th>Live Preview</th>
               </tr>
               <?php
                  global $ConnectingDB;
                  $sql = "SELECT * FROM posts";
                  $stmt = $ConnectingDB->query($sql);
                  $Sr = 0;
                  while ($DataRows = $stmt->fetch()) {
                      $Id = $DataRows["id"];
                      $DateTime = $DataRows["datetime"];
                      $PostTitle = $DataRows["title"];
                      $Category = $DataRows["category"];
                      $Admin = $DataRows["author"];
                      $Image = $DataRows["image"];
                      $PostText = $DataRows["post"];
                      $Sr++;
                  
                  ?>
               <tr>
                  <td><?php echo $Sr; ?></td>
                  <td>
                     <?php if (strlen($PostTitle) > 20) {
                        $PostTitle = substr($PostTitle, 0, 20) . '..';
                        }
                        echo $PostTitle; ?>
                  </td>
                  <td>
                     <?php
                        if (strlen($Category) > 10) {
                            $Category = substr($Category, 0, 10) . '..';
                        }
                        echo $Category;
                        ?>
                  </td>
                  <td>
                     <?php
                        if (strlen($DateTime) > 11) {
                            $DateTime = substr($DateTime, 0, 11) . '..';
                        }
                        echo $DateTime;
                        ?>
                  </td>
                  <td>
                     <?php
                        if (strlen($Admin) > 6) {
                            $Admin = substr($Admin, 0, 6) . '..';
                        }
                        echo $Admin;
                        ?>
                  </td>
                  <td>
                     <img src="../uploads/<?php if(!$Image) echo 'nophoto.png'?><?php echo $Image; ?>" width="170px;" height="50px">
                  </td>
                  <td>
                     <?php $Total = ApproveCommentsAccordingtoPost($Id);
                        if ($Total > 0) {
                        ?>
                     <span class="badge badge-success">
                     <?php
                        echo $Total; ?>
                     </span>
                     <?php  }  ?>
                     <?php $Total = DisApproveCommentsAccordingtoPost($Id);
                        if ($Total > 0) {
                        ?>
                     <span class="badge badge-danger">
                     <?php
                        echo $Total;  ?>
                     </span>
                     <?php  }    ?>
                  </td>
                  <td><a href="edit-post.php?id=<?php echo $Id; ?>"><span class="btn btn-warning"><?php echo $lang['EDIT']; ?></span></a>
                     <a href="delete-post.php?id=<?php echo $Id; ?>"><span class="btn btn-danger"><?php echo $lang['DELETE']; ?></span></a>
                  </td>
                  <td> <a href="../post.php?id=<?php echo $Id; ?>" target="_blank"><span class="btn btn-primary"><?php echo $lang['LIVE_PREVIEW']; ?></span></a>
                  </td>
               </tr>
               <?php } ?>
            </thead>
         </table>
      </div>
   </div>
</section>

<?php
include 'footer.php';
?>