<?php
require_once("common.php");

$pageTitle = "Nytt inlägg";

require_once("inc/header.php");

if (!$logged_in) {
  header("Location: index.php");
  die();
}
?>

<div class="form-post">
  <h1>Skapa inlägg</h1>
  <hr>
  <?php if (isset($_SESSION["pf_error"])) { ?>
    <div class="alert alert-danger" role="alert">
      <?php echo $_SESSION["pf_error"] ?>
    </div>
  <?php } ?>
  <form action="new_post_handler.php" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="title" class="form-label">Titel</label>
      <input type="text" class="form-control" id="title" name="title" value="<?php echo isset($_SESSION["pf_title"]) ? htmlspecialchars($_SESSION["pf_title"]) : ''; ?>" required>
    </div>
    <div class="mb-3">
      <label for="contents" class="form-label">Innehåll</label>
      <textarea class="form-control" id="contents" name="contents" rows="5" required><?php 
      if(isset($_SESSION["pf_contents"])) {
        echo htmlspecialchars($_SESSION["pf_contents"]);
      } ?></textarea>
    </div>
    <div class="mb-4">
      <label for="image" class="form-label">Bild</label>
      <input class="form-control" type="file" name="image" id="image">
    </div>
    <button type="submit" class="btn btn-lg btn-primary">Skapa</button>
  </form>
</div>
<?php 
unset($_SESSION["pf_error"]); 
unset($_SESSION["pf_title"]); 
unset($_SESSION["pf_contents"]); 
?>
<?php require_once("inc/footer.php"); ?>