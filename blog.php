<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/Functions.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<?php
include 'header.php';
?>

<div class="pva-bg text-white shadow text-center ">
   <h1 class="mb-4 pt-5 font-weight-bold text-uppercase"><?php echo $lang['SANTA_BLOG']; ?></h1>
   <p class="font-weight-bold text-uppercase"><?php echo $lang['SANTA_BLOG_DESC']; ?></p>
</div>
<div class="container mb-5">
   <div class="row mt-4">
      <!-- START MAIN SECTION -->
      <div class="col-sm-8">
         <?php
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
         <?php
            // DB CONNECTIOM
            global $ConnectingDB;
            
            // ADD SEARCH BUTTON CONDITION
            if (isset($_GET['SearchButton'])) {
                $Search = $_GET['Search'];
                //show results according to user search
                $sql = "SELECT * FROM posts
                        WHERE datetime LIKE :search
                        OR title LIKE :search
                        OR category LIKE :search
                        OR post LIKE :search";
                $stmt = $ConnectingDB->prepare($sql);
                $stmt->bindValue(':search', '%' . $Search . '%');
                $stmt->execute();
            }  // Query When Pagination is Active i.e blog.php?page=1
            elseif (isset($_GET["page"])) {
                $Page = $_GET["page"];
                if ($Page == 0 || $Page < 1) {
                    $ShowPostFrom = 0;
                } else {
                    $ShowPostFrom = ($Page * 5) - 5;
                }
                $sql = "SELECT * FROM posts ORDER BY id desc LIMIT $ShowPostFrom,5";
                $stmt = $ConnectingDB->query($sql);
            }
            // Query When Category is active in URL Tab
            elseif (isset($_GET["category"])) {
                $Category = $_GET["category"];
                $sql = "SELECT * FROM posts WHERE category='$Category' ORDER BY id desc";
                $stmt = $ConnectingDB->query($sql);
            } else {
                // END OF SERACH BUTTON
                // GET DB CONNECTION FROM POST TO DISPLAY ON PAGE
                $sql = "SELECT * FROM posts ORDER BY id desc";
                $stmt = $ConnectingDB->query($sql);
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
               <h4 class="card-title"><?php echo htmlentities($PostTitle) ?></h4>
               <small class="text-muted"><?php echo $lang['WRITTEN_BY']; ?>
               <a href="#">
               <?php echo htmlentities($Admin) ?>
               </a>
               On <?php echo htmlentities($DateTime) ?></small>
               <span style="float: right" class="badge-dark text-light px-3"><?php echo $lang['COMMENTS']; ?>: <?php echo ApproveCommentsAccordingtoPost($PostId); ?>
               </span>
               <hr>
               <p class="card-text">
                  <?php
                     if (strlen($PostDescription) > 150) {
                         $PostDescription = substr($PostDescription, 0, 150) . "...";
                     }
                     echo htmlentities($PostDescription);
                     ?>
               </p>
               <a href="post.php?id=<?php echo $PostId ?>" style=" float: right">
               <span class="btn btn-danger"> <?php echo $lang['READ_MORE']; ?> &rang;&rang;</span>
               </a>
            </div>
         </div>
         <?php } ?>
         <!-- Pagination -->
         <nav>
            <ul class="pagination pagination-lg">
               <!-- Creating Backward Button -->
               <?php if (isset($Page)) {
                  if ($Page > 1) { ?>
               <li class="page-item">
                  <a href="blog.php?page=<?php echo $Page - 1; ?>" class="page-link">&laquo;</a>
               </li>
               <?php }
                  } ?>
               <?php
                  global $ConnectingDB;
                  $sql           = "SELECT COUNT(*) FROM posts";
                  $stmt          = $ConnectingDB->query($sql);
                  $RowPagination = $stmt->fetch();
                  $TotalPosts    = array_shift($RowPagination);
                  // echo $TotalPosts."<br>";
                  $PostPagination = $TotalPosts / 5;
                  $PostPagination = ceil($PostPagination);
                  // echo $PostPagination;
                  for ($i = 1; $i <= $PostPagination; $i++) {
                      if (isset($Page)) {
                          if ($i == $Page) {  ?>
               <li class="page-item active">
                  <a href="blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
               </li>
               <?php
                  } else {
                  ?> 
               <li class="page-item">
                  <a href="blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
               </li>
               <?php  }
                  }
                  } ?>
               <!-- Creating Forward Button -->
               <?php if (isset($Page) && !empty($Page)) {
                  if ($Page + 1 <= $PostPagination) { ?>
               <li class="page-item">
                  <a href="blog.php?page=<?php echo $Page + 1; ?>" class="page-link">&raquo;</a>
               </li>
               <?php }
                  } ?>
            </ul>
         </nav>
      </div>
      <!-- side bar -->
      <div class="col-sm-4">
         <div class="card mt-4">
            <div class="card-body">
               <?=APPConfig::SITE_ADS;?>
            </div>
         </div>
         <br>
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
      <!-- end side bar -->
   </div>
</div>

<?php
include 'footer.php';
?>