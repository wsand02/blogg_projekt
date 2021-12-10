<?php

require_once("common.php");

$pageTitle = "Inlägg";

require_once("inc/header.php");

$result = $conn->query("SELECT * FROM inlägg ORDER BY skapades DESC");

?>
<h3>Inlägg</h3><hr>
<?php if ($result->num_rows > 0) { ?>
  <div class="list-group">
    <?php
    while ($row = $result->fetch_assoc()) {
    ?>
      <?php
      $user_stmt = $conn->prepare("SELECT * FROM användare WHERE uid = ?");
      $user_stmt->bind_param("i", $row["skapare"]);
      $user_stmt->execute();
      $user_result = $user_stmt->get_result();
      $user_stmt->close();
      $user = $user_result->fetch_assoc();
      ?>
      <a href="post.php?pid=<?php echo ($row['pid']) ?>" class="list-group-item list-group-item-action">
        <div class="d-flex w-100 justify-content-between">
          <h5 class="mb-1"><?php echo htmlspecialchars($row["titel"]) ?></h5>
        </div>
        <p class="mb-1"><?php echo (substr(htmlspecialchars($row['innehåll']), 0, 50)) ?>...</p>
        <small>Skapades av <?php echo htmlspecialchars($user["användarnamn"]) ?> | <?php echo date("Y-m-j", strtotime($row["skapades"]))?></small>
      </a>
    <?php } ?>
  </div>
<?php } ?>
<?php require_once("inc/footer.php"); ?>