<?php
// debuggin
ini_set("display_errors","1");
ini_set("display_startup_errors","1");
error_reporting(E_ALL);

session_start();
include ('asset/function.php');

// var_dump($_SESSION);

if( isset($_SESSION["login"]) ) {
    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <!-- bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>

    <!-- font-awesome -->
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">

    <style media="screen">
      #login-here {
        color: black;
      }
    </style>

    <title>CRUD</title>
</head>
<body>
  <div class="container min-vh-100 d-flex justify-content-center align-items-center">
    <form class="form-inline" action="process.php" method="post">

      <!-- alert session -->

      <!-- account created success -->
      <?php if(isset($_SESSION['account-success'])) : ?>
        <div class="alert alert-success p-2" role="alert">
          <h5 class="alert-heading"><b><?= $_SESSION['account-success']; ?></b>!</h5>
          <hr>
          <p class="mb-0"><?= $_SESSION["account-success2"]; ?> <br> <a id="login-here" href="login.php"><b>Login here!</b></a> </p>
        </div>
      <?php
          session_destroy();
          endif;
      ?>

      <!-- username exists -->
      <?php if(isset($_SESSION['username-exists'])) : ?>
        <div class="alert alert-danger p-2" role="alert">
          <h5 class="alert-heading">Sorry! <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="height:24px;"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M175.9 448c-35-.1-65.5-22.6-76-54.6C67.6 356.8 48 308.7 48 256C48 141.1 141.1 48 256 48s208 93.1 208 208s-93.1 208-208 208c-28.4 0-55.5-5.7-80.1-16zM0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM128 369c0 26 21.5 47 48 47s48-21 48-47c0-20-28.4-60.4-41.6-77.7c-3.2-4.4-9.6-4.4-12.8 0C156.6 308.6 128 349 128 369zm128-65c-13.3 0-24 10.7-24 24s10.7 24 24 24c30.7 0 58.7 11.5 80 30.6c9.9 8.8 25 8 33.9-1.9s8-25-1.9-33.9C338.3 320.2 299 304 256 304zm47.6-96a32 32 0 1 0 64 0 32 32 0 1 0 -64 0zm-128 32a32 32 0 1 0 0-64 32 32 0 1 0 0 64z"/></svg></h5>
          <hr>
          <p class="mb-0"><?= $_SESSION['username-exists']; ?></p>
        </div>
      <?php
          session_destroy();
          endif;
      ?>

      <!-- email exists -->
      <?php if(isset($_SESSION['email-exists'])) : ?>
        <div class="alert alert-danger p-2" role="alert">
          <h5 class="alert-heading">Sorry! <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="height:24px;"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M175.9 448c-35-.1-65.5-22.6-76-54.6C67.6 356.8 48 308.7 48 256C48 141.1 141.1 48 256 48s208 93.1 208 208s-93.1 208-208 208c-28.4 0-55.5-5.7-80.1-16zM0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM128 369c0 26 21.5 47 48 47s48-21 48-47c0-20-28.4-60.4-41.6-77.7c-3.2-4.4-9.6-4.4-12.8 0C156.6 308.6 128 349 128 369zm128-65c-13.3 0-24 10.7-24 24s10.7 24 24 24c30.7 0 58.7 11.5 80 30.6c9.9 8.8 25 8 33.9-1.9s8-25-1.9-33.9C338.3 320.2 299 304 256 304zm47.6-96a32 32 0 1 0 64 0 32 32 0 1 0 -64 0zm-128 32a32 32 0 1 0 0-64 32 32 0 1 0 0 64z"/></svg></h5>
          <hr>
          <p class="mb-0"><?= $_SESSION['email-exists']; ?></p>
        </div>
      <?php
          session_destroy();
          endif;
      ?>

      <!-- password doesn't match -->
      <?php if(isset($_SESSION['repeated-password'])) : ?>
        <div class="alert alert-danger p-2" role="alert">
          <h5 class="alert-heading">Sorry! <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="height:24px;"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M175.9 448c-35-.1-65.5-22.6-76-54.6C67.6 356.8 48 308.7 48 256C48 141.1 141.1 48 256 48s208 93.1 208 208s-93.1 208-208 208c-28.4 0-55.5-5.7-80.1-16zM0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM128 369c0 26 21.5 47 48 47s48-21 48-47c0-20-28.4-60.4-41.6-77.7c-3.2-4.4-9.6-4.4-12.8 0C156.6 308.6 128 349 128 369zm128-65c-13.3 0-24 10.7-24 24s10.7 24 24 24c30.7 0 58.7 11.5 80 30.6c9.9 8.8 25 8 33.9-1.9s8-25-1.9-33.9C338.3 320.2 299 304 256 304zm47.6-96a32 32 0 1 0 64 0 32 32 0 1 0 -64 0zm-128 32a32 32 0 1 0 0-64 32 32 0 1 0 0 64z"/></svg></h5>
          <hr>
          <p class="mb-0"><?= $_SESSION['repeated-password']; ?></p>
        </div>
      <?php
          session_destroy();
          endif;
      ?>

      <label class="sr-only" for="email">Repeat Password</label>
      <input type="text" class="form-control mb-2 mr-sm-2" id="email" placeholder="Email" name="email" required>

      <!-- Username -->
      <input type="hidden" name="user-id">
      <label class="sr-only" for="username">Username</label>
      <div class="input-group mb-2 mr-sm-2">
        <div class="input-group-prepend">
          <div class="input-group-text">@</div>
        </div>
        <input type="text" class="form-control" id="username" placeholder="Username" name="username" required>
      </div>

      <!-- Password -->
      <label class="sr-only" for="password">Password</label>
      <input type="password" class="form-control mb-2 mr-sm-2" id="password" placeholder="Password" name="password" required>

      <!-- Repeat password -->
      <label class="sr-only" for="repeat-password">Repeat Password</label>
      <input type="password" class="form-control mb-2 mr-sm-2" id="repeat-password" placeholder="Repeat password" name="repeat-password" required>

      <!-- Login  -->
      <div class="etc-login-form text-center">
        <h6 class="p-1 mb-2 bg-dark text-white" >already have an account? <a href="login.php" class="text-white">login here</a></h6>
      </div>

          <p>By creating an account you agree to our Terms & Privacy.</p>

      <!-- Submit -->
      <button type="submit" class="btn btn-warning mb-2" name="submit-registration">Create Account</button>

    </form>
  </div>
</body>
</html>
