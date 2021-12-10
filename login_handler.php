<?php
require_once("common.php");

if ($logged_in) {
  header("Location: index.php");
  die();
}

$username_or_email = $_POST["username"];
$password = $_POST["password"];

$success = false;

$failed = false;
$error = "";

if (empty($username_or_email)) {
  $error = "Du måste ange ett användarnamn eller en mejladress.";
  $failed = true;
}

if (empty($password)) {
  $error = "Du måste ange ett lösenord.";
  $failed = true;
}

$user_stmt = $conn->prepare("SELECT * FROM användare WHERE användarnamn = ? OR mejladress = ?");
// Ganska bozo sätt att göra det på.
$user_stmt->bind_param("ss", $username_or_email, $username_or_email);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user_stmt->close();

if ($user_result->num_rows > 0) {
  $user = $user_result->fetch_assoc();
  if (password_verify($password, $user["lösenordhash"])) {
    $success = true;
  } else {
    $error = "Fel användarnamn eller lösenord.";
    $failed = true;
  }
} else {
  $error = "Fel användarnamn eller lösenord.";
  $failed = true;
}

if ($failed) {
  $_SESSION["lf_error"] = $error;
  header("Location: login.php");
  die();
}

if ($success) {
  $_SESSION["uid"] = $user["uid"];
  header("Location: index.php");
} else {
  // Borde aldrig komma hit men vem vet
  header("Location: index.php");
  die();
}