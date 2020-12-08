<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Functions.php"); ?>
<?php require_once("includes/Sessions.php"); ?>

<?php $SearchQueryParameter = $_GET["id"]; ?>
<?php
if (isset($_POST["Submit"])) {
    $Name    = $_POST["CommenterName"];
    $Email   = $_POST["CommenterEmail"];
    $Comment = $_POST["CommenterThoughts"];
    date_default_timezone_set("Asia/Karachi");
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);

    if (empty($Name) || empty($Email) || empty($Comment)) {
        $_SESSION["ErrorMessage"] = "All fields must be filled out";
        Redirect_to("post.php?id={$SearchQueryParameter}");
    } elseif (strlen($Comment) > 500) {
        $_SESSION["ErrorMessage"] = "Comment length should be less than 500 characters";
        Redirect_to("post.php?id={$SearchQueryParameter}");
    } else {
        // Query to insert comment in DB When everything is fine
        global $ConnectingDB;
        $sql  = "INSERT INTO comments(datetime,name,email,comment,approvedby,status,post_id)";
        $sql .= "VALUES(:dateTime,:name,:email,:comment,'Pending','OFF',:postIdFromURL)";
        $stmt = $ConnectingDB->prepare($sql);
        $stmt->bindValue(':dateTime', $DateTime);
        $stmt->bindValue(':name', $Name);
        $stmt->bindValue(':email', $Email);
        $stmt->bindValue(':comment', $Comment);
        $stmt->bindValue(':postIdFromURL', $SearchQueryParameter);
        $Execute = $stmt->execute();
        //var_dump($Execute);
        if ($Execute) {
            $_SESSION["SuccessMessage"] = "Comment Submitted Successfully";
            Redirect_to("post.php?id={$SearchQueryParameter}");
        } else {
            $_SESSION["ErrorMessage"] = "Something went wrong. Try Again !";
            Redirect_to("post.php?id={$SearchQueryParameter}");
        }
    }
} //Ending of Submit Button If-Condition
?>
<?php
include 'header.php';
?>


<div class="container mb-5" style="margin-top: 90px;">
   <div class="row mt-5">
      <!-- Main Area Start-->
      <div class="col-sm-8 ">
         <?php
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
         <?php
            global $ConnectingDB;
            // SQL query when Searh button is active
            if (isset($_GET["SearchButton"])) {
                $Search = $_GET["Search"];
                $sql = "SELECT * FROM posts
            WHERE datetime LIKE :search
            OR title LIKE :search
            OR category LIKE :search
            OR post LIKE :search";
                $stmt = $ConnectingDB->prepare($sql);
                $stmt->bindValue(':search', '%' . $Search . '%');
                $stmt->execute();
            }
            // The default SQL query
            else {
                $PostIdFromURL = $_GET["id"];
                if (!isset($PostIdFromURL)) {
                    $_SESSION["ErrorMessage"] = "Bad Request !";
                    Redirect_to("blog.php?page=1");
                }
                $sql  = "SELECT * FROM posts  WHERE id= '$PostIdFromURL'";
                $stmt = $ConnectingDB->query($sql);
                $Result = $stmt->rowcount();
                if ($Result != 1) {
                    $_SESSION["ErrorMessage"] = "Bad Request !";
                    Redirect_to("blog.php?page=1");
                }
            }
            while ($DataRows = $stmt->fetch()) {
                $PostId          = $DataRows["id"];
                $DateTime        = $DataRows["datetime"];
                $PostTitle       = $DataRows["title"];
                $Category        = $DataRows["category"];
                $Admin           = $DataRows["author"];
                $Image           = $DataRows["image"];
                $PostDescription = $DataRows["post"];
            ?>
         <div class="card">
            <img src="uploads/<?php if(!$Image) echo 'default.png'?><?php echo htmlentities($Image); ?>" style="max-height:450px;" class="img-fluid card-img-top" />
            <div class="card-body">
               <h4 class="card-title"><?php echo htmlentities($PostTitle); ?></h4>
               <small class="text-muted">Category: <span class="text-dark"> <a href="blog.php?category=<?php echo htmlentities($Category); ?>"> <?php echo htmlentities($Category); ?> </a></span> & <?php echo $lang['WRITTEN_BY']; ?> <span class="text-dark"> <a href="#"> <?php echo htmlentities($Admin); ?></a></span> <?php echo $lang['ON']; ?> <span class="text-dark"><?php echo htmlentities($DateTime); ?></span></small>
               <hr>
               <p class="card-text">
                  <?php echo nl2br($PostDescription); ?>
               </p>
            </div>
		<center><?=APPConfig::ADDTHIS_CODE2;?></center>	
         </div>
         <br>
         <?php   } ?>
         <!-- Comment Part Start -->
         <!-- Fetching existing comment START  -->
         <span class="FieldInfo"><?php echo $lang['COMMENTS']; ?></span>
         <br><br>
         <?php
            global $ConnectingDB;
            $sql  = "SELECT * FROM comments WHERE post_id='$SearchQueryParameter' AND status='ON'";
            $stmt = $ConnectingDB->query($sql);
            while ($DataRows = $stmt->fetch()) {
                $CommentDate   = $DataRows['datetime'];
                $CommenterName = $DataRows['name'];
                $CommentContent = $DataRows['comment'];
            ?>
         <div>
            <div class="media CommentBlock">
               <img class="d-block img-fluid align-self-start" src="assets/images/comment.png" alt="">
               <div class="media-body ml-2">
                  <h6 class="lead"><?php echo $CommenterName; ?></h6>
                  <p class="small"><?php echo $CommentDate; ?></p>
                  <p><?php echo $CommentContent; ?></p>
               </div>
            </div>
         </div>
         <hr>
         <?php } ?>
         <!--  Fetching existing comment END -->
         <div>
            <form class="" action="post.php?id=<?php echo $SearchQueryParameter ?>" method="post">
               <div class="card mb-3">
                  <div class="card-header">
                     <h5 class="FieldInfo"><?php echo $lang['SHARE_THOUGHTS']; ?></h5>
                  </div>
                  <div class="card-body">
                     <div class="form-group">
                        <div class="input-group">
                           <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-user"></i></span>
                           </div>
                           <input class="form-control" type="text" name="CommenterName" placeholder="Name" value="">
                        </div>
                     </div>
                     <div class="form-group">
                        <div class="input-group">
                           <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                           </div>
                           <input class="form-control" type="text" name="CommenterEmail" placeholder="Email" value="">
                        </div>
                     </div>
                     <div class="form-group">
                        <textarea name="CommenterThoughts" class="form-control" rows="6" cols="80"></textarea>
                     </div>
                     <div class="">
                        <button type="submit" name="Submit" class="btn btn-primary"><?php echo $lang['SEND']; ?></button>
                     </div>
                  </div>
               </div>
            </form>
         </div>
         <!-- Comment Part End -->
      </div>
      <!-- Main Area End-->
      <!-- Side Area Start -->
      <div class="col-sm-4">
         <div class="card mt-4">
            <div class="card-body">
               <?=APPConfig::SITE_ADS;?>
            </div>
         </div>
         <br>
         <div class="card">
            <div class="card-header bg-danger text-light">
               <h2 class="lead"><?php echo $lang['CATEGORIES']; ?></h2>
            </div>
            <div class="card-body">
               <?php
                  global $ConnectingDB;
                  $sql = "SELECT * FROM category ORDER BY id desc";
                  $stmt = $ConnectingDB->query($sql);
                  while ($DataRows = $stmt->fetch()) {
                      $CategoryId = $DataRows["id"];
                      $CategoryName = $DataRows["title"];
                  ?>
               <a href="blog.php?category=<?php echo $CategoryName; ?>"> <span class="heading"> <?php echo $CategoryName; ?></span> </a><br>
               <?php } ?>
            </div>
         </div>
         <br>
         <div class="card">
            <div class="card-header bg-danger text-white">
               <h2 class="lead"><?php echo $lang['RECENT_POSTS']; ?></h2>
            </div>
            <div class="card-body">
               <?php
                  global $ConnectingDB;
                  $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
                  $stmt = $ConnectingDB->query($sql);
                  while ($DataRows = $stmt->fetch()) {
                      $Id     = $DataRows['id'];
                      $Title  = $DataRows['title'];
                      $DateTime = $DataRows['datetime'];
                      $Image = $DataRows['image'];
                  ?>
               <div class="media">
                  <img src="uploads/<?php if(!$Image) echo 'default.png'?><?php echo htmlentities($Image); ?>" class="d-block img-fluid align-self-start" width="90" height="94" alt="">
                  <div class="media-body ml-2">
                     <a style="text-decoration:none;" href="post.php?id=<?php echo htmlentities($Id); ?>" target="_blank">
                        <h6 class="lead"><?php echo htmlentities($Title); ?></h6>
                     </a>
                     <p class="small"><?php echo htmlentities($DateTime); ?></p>
                  </div>
               </div>
               <hr>
               <?php } ?>
            </div>
         </div>
      </div>
      <!-- Side Area End -->
   </div>
</div>

<?php
include 'footer.php';
?>