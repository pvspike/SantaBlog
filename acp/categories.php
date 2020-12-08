<?php require_once("../includes/DB.php"); ?>
<?php require_once("../includes/Functions.php"); ?>
<?php require_once("../includes/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
Confirm_Login(); ?>


<?php

if (isset($_POST['Submit'])) {
    $Category = $_POST['CategoryTitle'];
    //author is the admin that is logged in
    $Admin = $_SESSION["AdminName"];
    //timedate for db
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);
    //some basic validations
    if (empty($Category)) {
        //redirect user
        $_SESSION['ErrorMessage'] = "All fields must be filled out";
        Redirect_to("categories.php");
    } else if (strlen($Category) < 3) {
        $_SESSION['ErrorMessage'] = "Category title should be more than 2 characters";
        Redirect_to("categories.php");
    } else if (strlen($Category) > 48) {
        $_SESSION['ErrorMessage'] = "Category title should not exceed 50 characters";
        Redirect_to("categories.php");
    } else {
        //query to db to add user
        $sql = "INSERT INTO category (title,author,datetime)VALUES(:categoryName, :adminName, :dateTime)";
        $stmt = $ConnectingDB->prepare($sql);
        //bind values to actual values from script
        $stmt->bindValue(':categoryName', $Category);
        $stmt->bindValue(':adminName', $Admin);
        $stmt->bindValue(':dateTime', $DateTime);
        $Execute = $stmt->execute();

        //check if data has been added to db
        if ($Execute) {
            $_SESSION['SuccessMessage'] = 'Category with id: ' . $ConnectingDB->lastInsertId() .  ' Added Successfully!';
            Redirect_to("categories.php");
        } else {
            $_SESSION['ErrorMessage'] = "Something went wrong. Try again!";
            Redirect_to("categories.php");
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
                <form class="" action="categories.php" method="post">
                    <div class="card bg-secondary text-light mb-3">
                        <div class="card-header">
                            <h1><?php echo $lang['ADD_NEW_CATEGORY']; ?></h1>
                        </div>
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="title"> <span class="FieldInfo"> <?php echo $lang['CATEGROY_TITLE']; ?>: </span></label>
                                <input class="form-control" type="text" name="CategoryTitle" id="title" placeholder="Type title here" value="">
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
                <h2><?php echo $lang['EXISTING_CATEGORIES']; ?></h2>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No. </th>
                            <th>Date&Time</th>
                            <th> Category Name</th>
                            <th>Creator Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <?php
                    global $ConnectingDB;
                    $sql = "SELECT * FROM category ORDER BY id desc";
                    $Execute = $ConnectingDB->query($sql);
                    $SrNo = 0;
                    while ($DataRows = $Execute->fetch()) {
                        $CategoryId = $DataRows["id"];
                        $CategoryDate = $DataRows["datetime"];
                        $CategoryName = $DataRows["title"];
                        $CreatorName = $DataRows["author"];
                        $SrNo++;
                    ?>
                        <tbody>
                            <tr>
                                <td><?php echo htmlentities($SrNo); ?></td>
                                <td><?php echo htmlentities($CategoryDate); ?></td>
                                <td><?php echo htmlentities($CategoryName); ?></td>
                                <td><?php echo htmlentities($CreatorName); ?></td>
                                <td> <a href="delete-category.php?id=<?php echo $CategoryId; ?>" class="btn btn-danger"><?php echo $lang['DELETE']; ?></a> </td>

                        </tbody>
                    <?php } ?>
                </table>
            </div>
        </div>

    </section>
	
<?php
include 'footer.php';
?>