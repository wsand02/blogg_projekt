<?php

require_once("common.php");

$p_id = intval($_GET["pid"]);
if (empty($p_id)) {
  header("Location: index.php");
  die();
}

$post_stmt = $conn->prepare("SELECT * FROM inlägg WHERE pid = ?");
$post_stmt->bind_param("i", $p_id);
$post_stmt->execute();
$post_result = $post_stmt->get_result();

if ($post_result->num_rows > 0) {
  $post = $post_result->fetch_assoc();
} else {
  http_response_code(404);
  include("404.php");
  die();
}

$pageTitle = htmlspecialchars($post["titel"]);

require_once("inc/header.php");

$user_stmt = $conn->prepare("SELECT * FROM användare WHERE uid = ?");
$user_stmt->bind_param("i", $post["skapare"]);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user_stmt->close();
$user = $user_result->fetch_assoc();

$image_stmt = $conn->prepare("SELECT * FROM bild WHERE bid = ?");
$image_stmt->bind_param("i", $post["bild"]);
$image_stmt->execute();
$image_result = $image_stmt->get_result();
?>
<h1 class="mb-3"><?php echo(htmlspecialchars($post["titel"])) ?></h1>
<p>Skapades av <?php echo htmlspecialchars($user["användarnamn"])?> | <?php echo date("Y-m-j", strtotime($post["skapades"]))?></p>
<hr>
<?php if ($image_result->num_rows > 0) {
  $image = $image_result->fetch_assoc();
?>
<img class="img-fluid rounded mb-3" src="<?php echo(htmlspecialchars($image['bildadress'])) ?>" alt="" srcset="">
<?php } ?>
<p><?php echo htmlspecialchars($post["innehåll"]) ?></p>
<a href="index.php">Gå tillbaka</a>
<?php require_once("inc/footer.php"); ?>