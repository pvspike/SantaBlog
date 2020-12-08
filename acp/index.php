<?php require_once("../includes/DB.php"); ?>
<?php require_once("../includes/Functions.php"); ?>
<?php require_once("../includes/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
Confirm_Login();
?>

<?php
include 'header.php';
?>
<!-- Main Area -->
<section class="container mb-4" style="margin-top: 90px;">
   <div class="row">
      <!-- Left Side Area Start -->
      <div class="col-lg-2 d-none d-md-block">
         <div class="card text-center bg-primary text-white mb-3">
            <div class="card-body">
               <h1 class="lead"><?php echo $lang['POSTS']; ?></h1>
               <h4 class="display-5">
                  <i class="fab fa-readme"></i>
                  <?php TotalPosts(); ?>
               </h4>
            </div>
         </div>
         <div class="card text-center bg-primary text-white mb-3">
            <div class="card-body">
               <h1 class="lead"><?php echo $lang['CATEGORIES']; ?></h1>
               <h4 class="display-5">
                  <i class="fas fa-folder"></i>
                  <?php TotalCategories(); ?>
               </h4>
            </div>
         </div>
         <div class="card text-center bg-primary text-white mb-3">
            <div class="card-body">
               <h1 class="lead"><?php echo $lang['ADMINS']; ?></h1>
               <h4 class="display-5">
                  <i class="fas fa-users"></i>
                  <?php TotalAdmins(); ?>
               </h4>
            </div>
         </div>
         <div class="card text-center bg-primary text-white mb-3">
            <div class="card-body">
               <h1 class="lead"><?php echo $lang['COMMENTS']; ?></h1>
               <h4 class="display-5">
                  <i class="fas fa-comments"></i>
                  <?php TotalComments(); ?>
               </h4>
            </div>
         </div>
      </div>
      <!-- Left Side Area End -->
      <!-- Right Side Area Start -->
      <div class="col-lg-10">
         <?php
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
         <h1>Top Posts</h1>
         <table class="table table-striped table-hover">
            <thead class="thead-dark">
               <tr>
                  <th>No.</th>
                  <th>Title</th>
                  <th>Date&Time</th>
                  <th>Author</th>
                  <th>Comments</th>
                  <th>Details</th>
               </tr>
            </thead>
            <?php
               $SrNo = 0;
               global $ConnectingDB;
               $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,6";
               $stmt = $ConnectingDB->query($sql);
               while ($DataRows = $stmt->fetch()) {
                 $PostId = $DataRows["id"];
                 $DateTime = $DataRows["datetime"];
                 $Author  = $DataRows["author"];
                 $Title = $DataRows["title"];
                 $SrNo++;
               ?>
            <tbody>
               <tr>
                  <td><?php echo $SrNo; ?></td>
                  <td><?php echo $Title; ?></td>
                  <td><?php echo $DateTime; ?></td>
                  <td><?php echo $Author; ?></td>
                  <td>
                     <?php $Total = ApproveCommentsAccordingtoPost($PostId);
                        if ($Total > 0) {
                        ?>
                     <span class="badge badge-success">
                     <?php
                        echo $Total; ?>
                     </span>
                     <?php  }   ?>
                     <?php $Total = DisApproveCommentsAccordingtoPost($PostId);
                        if ($Total > 0) {  ?>
                     <span class="badge badge-danger">
                     <?php
                        echo $Total; ?>
                     </span>
                     <?php  }  ?>
                  </td>
                  <td> <a target="_blank" href="../post.php?id=<?php echo $PostId; ?>">
                     <span class="btn btn-outline-success"><?php echo $lang['PREVIEW']; ?></span>
                     </a>
                  </td>
               </tr>
            </tbody>
            <?php } ?>
         </table>
      </div>
      <!-- Right Side Area End -->
   </div>
</section>
<!-- Main Area End -->

<?php
include 'footer.php';
?>	  