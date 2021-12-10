<?php
require_once("common.php");

$pageTitle = "Registrera dig";

require_once("inc/header.php");

?>
<?php
if ($logged_in) {
  header("Location: index.php");
  die();
}
?>

<div class="form-register">
  <h1>Registrera dig</h1>
  <hr>
  <?php if (isset($_SESSION["rf_error"])) { ?>
    <div class="alert alert-danger" role="alert">
      <?php echo $_SESSION["rf_error"] ?>
    </div>
  <?php } ?>
  <form action="register_handler.php" method="POST">
    <div class="mb-3">
      <label for="username" class="form-label">Användarnamn</label>
      <input type="text" class="form-control" id="username" name="username" value="<?php echo isset($_SESSION["rf_username"]) ? htmlspecialchars($_SESSION["rf_username"]) : ''; ?>" required>
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Mejladress</label>
      <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_SESSION["rf_email"]) ? htmlspecialchars($_SESSION["rf_email"]) : ''; ?>" required>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Lösenord</label>
      <input type="password" class="form-control" id="exampleInputPassword1" name="password" required>
    </div>
    <div class="mb-3">
      <label for="passwordConfirm" class="form-label">Bekräfta Lösenord</label>
      <input type="password" class="form-control" id="passwordConfirm" name="passwordconfirm" required>
    </div>
    <button type="submit" class="btn btn-lg btn-primary">Skapa konto</button>
  </form>
</div>

<?php
// Rensa upp sessionen då vi inte vill spara registration form relaterade saker 
// för evigt
session_unset();
?>
<?php require_once("inc/footer.php"); ?>