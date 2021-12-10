<?php

// Se till att du bara kör den här filen en gång.

require_once("common.php");

class User {
  public $id;
  public $username;
  public $email;
  public $passwordhash;

  public function __construct($username, $email, $password) {
    $this->username = $username;
    $this->email = $email;
    $this->passwordhash = password_hash($password, PASSWORD_DEFAULT);
  }
}

// De här är alla dummy användare så ett lösenord på lösenord123 får duga.
$user1 = new User("admin", "anders@example.com", "lösenord123");
$user2 = new User("beritsvenson34", "berit@example.com", "lösenord123");
$user3 = new User("deg7", "degen4@example.com", "lösenord123");
$user4 = new User("ob23", "ove.berg@example.com", "lösenord123");
$user5 = new User("addkfdjv", "kdjddfa@example.com", "lösenord123");
$user6 = new User("adfkenv", "3akfo@example.com", "lösenord123");

$users = array($user1, $user2, $user3, $user4, $user5, $user6);

foreach ($users as $user) {
  $stmt = $conn->prepare("INSERT INTO användare (användarnamn, mejladress, lösenordhash) VALUES(?, ?, ?)");
  $stmt->bind_param("sss", $user->username, $user->email, $user->passwordhash);
  $stmt->execute();
  $stmt->close();
  $last_id = $conn->insert_id;
  $user->id = $last_id;
}

class Post {
  public $id;
  public $title;
  public $contents;
  public $author;

  function __construct($title, $contents, $author) {
    $this->title = $title;
    $this->contents = $contents;
    $this->author = $author;
  }
}

$lorem = "Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur dicta, itaque, delectus sequi animi aperiam rerum voluptatibus assumenda quasi esse dolorum optio rem tempore nostrum, perferendis repellat eos nam accusamus?
Laboriosam odit perspiciatis veniam maxime neque voluptas, quasi iste excepturi, quam aspernatur provident, earum repellendus maiores exercitationem rem velit? Facere cum quo beatae eveniet accusamus dolorem, sint fugiat sequi vero.
Officia ratione at perspiciatis sed expedita? Repellendus eius cum eum, placeat veniam, nam molestiae ab ipsum minima incidunt vero libero autem obcaecati magni iusto voluptatum laudantium esse accusantium. Voluptate, nobis.
Sequi doloribus veritatis alias commodi culpa ullam sunt, aliquid neque nihil deserunt totam quae consequuntur, iure, dolores praesentium iusto nemo esse. Aperiam esse unde dolorum laborum ratione beatae magnam eaque.
Earum, vitae! Blanditiis nulla iusto accusantium sunt dicta mollitia doloribus sequi fuga. Adipisci, facilis non sunt facere dicta sed quae sint quia pariatur veniam recusandae laboriosam optio culpa obcaecati ullam!";

$post1 = new Post("post1", $lorem, $user2->id);
$post2 = new Post("post2", $lorem, $user1->id);
$post3 = new Post("post3", $lorem, $user4->id);
$post4 = new Post("post4", $lorem, $user4->id);
$post5 = new Post("post5", $lorem, $user3->id);
$post6 = new Post("post6", $lorem, $user1->id);
$post7 = new Post("post7", $lorem, $user4->id);
$post8 = new Post("post8", $lorem, $user4->id);
$post9 = new Post("post9", $lorem, $user5->id);
$post10 = new Post("post10", $lorem, $user6->id);

$posts = array(
  $post1,
  $post2,
  $post3,
  $post4,
  $post5,
  $post6,
  $post7,
  $post8,
  $post9,
  $post10
);

foreach ($posts as $post) {
  $stmt = $conn->prepare("INSERT INTO inlägg (titel, innehåll, skapare) VALUES (?, ?, ?)");
  $stmt->bind_param("ssi", $post->title, $post->contents, $post->author);
  $stmt->execute();
  $stmt->close();
  $last_id = $conn->insert_id;
  $post->id = $last_id;
}