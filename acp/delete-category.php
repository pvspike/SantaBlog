<?php require_once("../includes/DB.php"); ?>
<?php require_once("../includes/Functions.php"); ?>
<?php require_once("../includes/Sessions.php"); ?>

<?php
if (isset($_GET['id'])) {
    $SearchQueryParameter = $_GET["id"];
    global $ConnectingDB;
    $Admin = $_SESSION["AdminName"];
    $sql = "DELETE FROM category WHERE id='$SearchQueryParameter'";
    $Execute = $ConnectingDB->query($sql);
    if ($Execute) {
        $_SESSION["SuccessMessage"] = "Category Successfully Deleted! ";
        Redirect_to("categories.php");
        // code...
    } else {
        $_SESSION["ErrorMessage"] = "Something Went Wrong. Try Again !";
        Redirect_to("categories.php");
    }
}

?>