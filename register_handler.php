<?php
require_once("common.php");

if ($logged_in) {
  header("Location: index.php");
  die();
}

$username = $_POST["username"];
$email = $_POST["email"];
$password = $_POST["password"];
$passwordconfirm = $_POST["passwordconfirm"];

$failed = false;
$error = "";
// Kommer validera det som användaren har inmatat.

// De följande är bara ifall användaren lyckas kringå de inbyggda funktionerna för
// required som existerar inom html.
if (empty($username)) {
  $error = "Du måste ha ett användarnamn.";
  $failed = true;
}

if (empty($email)) {
  $error = "Du måste ha en mejladress.";
  $failed = true;
}

if (empty($password)) {
  $error = "Du måste ha ett lösenord.";
  $failed = true;
}

if (empty($passwordconfirm)) {
  $error = "Du måste bekräfta ditt lösenord.";
  $failed = true;
}

if ($password != $passwordconfirm) {
  $error = "Dina lösenord matchade inte.";
  $failed = true;
}

$users_with_that_username_stmt = $conn->prepare("SELECT * FROM användare WHERE användarnamn = ?");
$users_with_that_username_stmt->bind_param("s", $username);
$users_with_that_username_stmt->execute();
$users_with_that_username_result = $users_with_that_username_stmt->get_result();
$users_with_that_username_stmt->close();

if ($users_with_that_username_result->num_rows > 0) {
  $error = "Det där användarnamnet används redan.";
  $failed = true;
}

$users_with_that_email_stmt = $conn->prepare("SELECT * FROM användare WHERE mejladress = ?");
$users_with_that_email_stmt->bind_param("s", $email);
$users_with_that_email_stmt->execute();
$users_with_that_email_result = $users_with_that_email_stmt->get_result();
$users_with_that_email_stmt->close();

if ($users_with_that_email_result->num_rows > 0) {
  $error = "Den där mejladressen används redan.";
  $failed = true;
}

if ($failed) {
  $_SESSION["rf_username"] = $username;
  $_SESSION["rf_email"] = $email;
  $_SESSION["rf_error"] = $error;
  header("Location: register.php");
  die();
}

$passwordhash = password_hash($password, PASSWORD_DEFAULT);
$new_user_stmt = $conn->prepare("INSERT INTO användare(användarnamn, mejladress, lösenordhash) VALUES (?, ?, ?)");
$new_user_stmt->bind_param("sss", $username, $email, $passwordhash);
$new_user_stmt->execute();
$new_user_stmt->close();
$new_id = $conn->insert_id;

$_SESSION["uid"] = $new_id;
header("Location: index.php");