<!DOCTYPE html>
<html lang="sv">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo ($pageTitle); ?> - Blogg</title>
  <link rel="stylesheet" href="static/css/inc/bootstrap.min.css">
  <link rel="stylesheet" href="static/css/main.css">
</head>

<body>
  <nav class="navbar navbar-expand-md navbar-dark shadow-sm bg-success">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">Blogg Projekt</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Hem</a>
          </li>
          <?php if ($logged_in) { ?>
            <li class="nav-item">
              <a class="nav-link" href="new_post.php">Nytt inlägg</a>
            </li>
          <?php } ?>
        </ul>
        <?php if ($logged_in) { ?>
          <ul class="navbar-nav mb-2 mb-md-0">
            <li class="nav-item">
              <a class="nav-link" href="logout.php">Logga ut</a>
            </li>
          </ul>
        <?php } else { ?>
          <ul class="navbar-nav mb-2 mb-md-0">
            <li class="nav-item">
              <a class="nav-link" href="login.php">Logga in</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="register.php">Registrera dig</a>
            </li>
          </ul>
        <?php } ?>
      </div>
    </div>
  </nav>
  <div class="container mt-5">