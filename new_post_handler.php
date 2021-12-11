<?php

require_once("common.php");

if (!$logged_in) {
  header("Location: login.php");
  die();
}

// https://stackoverflow.com/questions/9315461/how-can-i-catch-this-error-post-content-length
if (isset($_SERVER["CONTENT_LENGTH"])) {
  if ($_SERVER["CONTENT_LENGTH"] > ((int)ini_get('post_max_size') * 1024 * 1024)) {
    $_SESSION["pf_error"] = "Filen du försökte ladda upp var ALLDELES FÖR STOR!";
    header("Location: new_post.php");
    die();
  }
}

$title = $_POST["title"];
$contents = $_POST["contents"];
$image = $_FILES["image"];

$failed = false;
$error = "";

$will_upload = false;
$image_filext = "";
$image_id = 0;
$new_id = 0;

if (empty($title)) {
  $error = "Du måste ha en titel.";
  $failed = true;
}

if (empty($contents)) {
  $error = "Du måste ha innehåll i ditt inlägg.";
  $failed = true;
}

if ($image["name"] != "") {
  $image_mime_type = mime_content_type($image["tmp_name"]);
  if ($image_mime_type === "image/png") {
    $image_filext = ".png";
    $will_upload = true;
  } elseif ($image_mime_type === "image/jpeg") {
    $image_filext = ".jpeg";
    $will_upload = true;
  } elseif ($image_mime_type === "image/gif") {
    $image_filext = ".gif";
    $will_upload = true;
  } else {
    $error = "Din bild måste vara av typen: jpeg/jpg, png eller gif.";
    $failed = true;
  }
}

if (strlen($title) > 100) {
  $error = "Din titel får inte vara längre än 100 karaktärer.";
  $failed = true;
}

if (strlen($contents) > 10000) {
  $error = "Ditt innehåll får inte vara längre än 10000 karaktärer.";
  $failed = true;
}

if ($failed) {
  $_SESSION["pf_error"] = $error;
  $_SESSION["pf_title"] = $title;
  $_SESSION["pf_contents"] = $contents;
  header("Location: new_post.php");
  die();
}

if ($will_upload) {
  $new_filename = uniqid() . $image_filext;
  $upload_dir = "media/uploads/";
  $target_file = $upload_dir . basename($new_filename);
  if (move_uploaded_file($image["tmp_name"], $target_file)) {
    $new_image_stmt = $conn->prepare("INSERT INTO bild(bildadress) VALUES (?)");
    $new_image_stmt->bind_param("s", $target_file);
    $new_image_stmt->execute();
    $new_image_stmt->close();
    $image_id = $conn->insert_id;
  }
}

if ($image_id != 0) {
  $new_post_stmt = $conn->prepare("INSERT INTO inlägg(titel, innehåll, skapare, bild) VALUES (?, ?, ?, ?)");
  $new_post_stmt->bind_param("ssii", $title, $contents, $_SESSION["uid"], $image_id);
  $new_post_stmt->execute();
  $new_post_stmt->close();
  $new_id = $conn->insert_id;
} else {
  $new_post_stmt = $conn->prepare("INSERT INTO inlägg(titel, innehåll, skapare) VALUES (?, ?, ?)");
  $new_post_stmt->bind_param("ssi", $title, $contents, $_SESSION["uid"]);
  $new_post_stmt->execute();
  $new_post_stmt->close();
  $new_id = $conn->insert_id;
}

header("Location: post.php?pid=$new_id");
