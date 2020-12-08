<?php require_once("../includes/DB.php"); ?>
<?php require_once("../includes/Functions.php"); ?>
<?php require_once("../includes/Sessions.php"); ?>
<?php $_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
Confirm_Login(); ?>
<?php
include 'header.php';
?>

    <section class="container mb-4" style="margin-top: 90px;">
        <div class="row" style="min-height:30px;">
            <div class="col-lg-12" style="min-height:400px;">
                <?php
                echo ErrorMessage();
                echo SuccessMessage();
                ?>
                <h2><?php echo $lang['UN_APPROVED_COMMENTS']; ?></h2>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No. </th>
                            <th>Date&Time</th>
                            <th>Name</th>
                            <th>Comment</th>
                            <th>Aprove</th>
                            <th>Action</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <?php
                    global $ConnectingDB;
                    $sql = "SELECT * FROM comments WHERE status='OFF' ORDER BY id desc";
                    $Execute = $ConnectingDB->query($sql);
                    $SrNo = 0;
                    while ($DataRows = $Execute->fetch()) {
                        $CommentId = $DataRows["id"];
                        $DateTimeOfComment = $DataRows["datetime"];
                        $CommenterName = $DataRows["name"];
                        $CommentContent = $DataRows["comment"];
                        $CommentPostId = $DataRows["post_id"];
                        $SrNo++;
                    ?>
                        <tbody>
                            <tr>
                                <td><?php echo htmlentities($SrNo); ?></td>
                                <td><?php echo htmlentities($DateTimeOfComment); ?></td>
                                <td><?php echo htmlentities($CommenterName); ?></td>
                                <td><?php echo htmlentities($CommentContent); ?></td>
                                <td> <a href="approve-comments.php?id=<?php echo $CommentId; ?>" class="btn btn-success"><?php echo $lang['APPROVE']; ?></a> </td>
                                <td> <a href="delete-comments.php?id=<?php echo $CommentId; ?>" class="btn btn-danger"><?php echo $lang['DELETE']; ?></a> </td>
                                <td style="min-width:140px;"> <a class="btn btn-primary" href="../post.php?id=<?php echo $CommentPostId; ?>" target="_blank"><?php echo $lang['LIVE_PREVIEW']; ?></a> </td>
                            </tr>
                        </tbody>
                    <?php } ?>
                </table>
                <h2><?php echo $lang['APPROVED_COMMENTS']; ?></h2>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No. </th>
                            <th>Date&Time</th>
                            <th>Name</th>
                            <th>Comment</th>
                            <th>Approved by</th>
                            <th>Revert</th>
                            <th>Action</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <?php
                    global $ConnectingDB;
                    $sql = "SELECT * FROM comments WHERE status='ON' ORDER BY id desc";
                    $Execute = $ConnectingDB->query($sql);
                    $SrNo = 0;
                    while ($DataRows = $Execute->fetch()) {
                        $CommentId         = $DataRows["id"];
                        $DateTimeOfComment = $DataRows["datetime"];
                        $CommenterName     = $DataRows["name"];
                        $ApprovedBy        = $DataRows["approvedby"];
                        $CommentContent    = $DataRows["comment"];
                        $CommentPostId     = $DataRows["post_id"];
                        $SrNo++;
                    ?>
                        <tbody>
                            <tr>
                                <td><?php echo htmlentities($SrNo); ?></td>
                                <td><?php echo htmlentities($DateTimeOfComment); ?></td>
                                <td><?php echo htmlentities($CommenterName); ?></td>
                                <td><?php echo htmlentities($CommentContent); ?></td>
                                <td><?php echo htmlentities($ApprovedBy); ?></td>
                                <td style="min-width:140px;"> <a href="dis-approve-comments.php?id=<?php echo $CommentId; ?>" class="btn btn-warning"><?php echo $lang['DIS_APPROVE']; ?></a> </td>
                                <td> <a href="delete-comments.php?id=<?php echo $CommentId; ?>" class="btn btn-danger"><?php echo $lang['DELETE']; ?></a> </td>
                                <td style="min-width:140px;"> <a class="btn btn-primary" href="../post.php?id=<?php echo $CommentPostId; ?>" target="_blank"><?php echo $lang['LIVE_PREVIEW']; ?></a> </td>
                            </tr>
                        </tbody>
                    <?php } ?>
                </table>
            </div>
        </div>
    </section>
	
<?php
include 'footer.php';
?>

</html>