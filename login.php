<?php
require_once("common.php");

$pageTitle = "Logga in";

require_once("inc/header.php");
?>

<?php
if ($logged_in) {
  header("Location: index.php");
  die();
}
?>
<div class="form-login">
  <h1>Logga in</h1>
  <hr>
  <?php if (isset($_SESSION["lf_error"])) { ?>
    <div class="alert alert-danger" role="alert">
      <?php echo $_SESSION["lf_error"] ?>
    </div>
  <?php } ?>
  <form action="login_handler.php" method="POST">
    <div class="mb-3">
      <label for="username" class="form-label">Användarnamn eller mejladress</label>
      <input type="text" class="form-control" id="username" name="username" required>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Lösenord</label>
      <input type="password" class="form-control" id="exampleInputPassword1" name="password" required>
    </div>
    <button type="submit" class="btn btn-lg btn-primary">Släpp in mig!</button>
  </form>
</div>


<?php
// Rensa upp sessionen då vi inte vill spara login form relaterade saker 
// för evigt
session_unset();
?>
<?php require_once("inc/footer.php"); ?>