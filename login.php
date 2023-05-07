<?php
// debuggin
ini_set("display_errors","1");
ini_set("display_startup_errors","1");
error_reporting(E_ALL);

session_start();
include ('asset/function.php');

// var_dump($_SESSION);

if( isset($_COOKIE['id']) && isset($_COOKIE['un']) ) {
    $id = $_COOKIE['id'];
    $username = $_COOKIE['un'];

    // ambil username berdasarkan id
    $query = "SELECT username
              FROM tb_pengguna
              WHERE id = $id";

    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    // cek cookie dan username
    if( $username === hash('sha256', $row['username']) ) {
        $_SESSION['login'] = true;
    }
}

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

    <!-- font Mfizz -->
    <link rel="stylesheet" href="font-mfizz/font-mfizz.css">

    <style media="screen">
      #child {
          position: absolute;
          top:50%;
          left: 0;
          right: 0;
          margin: auto;
          transform: translateY(-50%);
          z-index: 2;
          text-align: justify;
      }
      #parent {
         position: relative;
         width: 100vw;
         height: 100vh;
         z-index: 1;
      }

    </style>

    <title>CRUD</title>
</head>
<body>

<?php if (isset($_SESSION['about-application']) === true): ?>
  <div id="child" class="container min-vh-100 d-flex justify-content-center align-items-center child">
    <div class="alert alert-light alert-dismissable fade show" role="alert">
      <?php //if (condition): ?>
        <a onClick="location.href='process.php?refresh=1'" type="button" class="btn-close pull-right" data-bs-dismiss="alert" aria-label="Close"></a>
      <?php //endif; ?>
        <h5 class="alert-heading text-center">About Developer</h5><br>
      <p><b>Name : </b><br>
         Achmad Adyatma Ardi <br><br>
         <b>Contact :</b><br>
         <i class="fa fa-envelope" style="font-size:24px">
         </i>&nbsp adyatmaardi@gmail.com <br>
         <i class="fa fa-github" style="font-size:24px">
         </i>&nbsp&nbsp adyatma-ardi <br>
         <i class="fa fa-instagram" style="font-size:24px">
         </i>&nbsp&nbsp adyatma_ardi <br>
      </p>
      <hr>
      <h5 class="alert-heading text-center">About Application</h5><br>
      <p class="mb-0">
        <b>Objectives :</b><br>
        The primary objective of the application is to allow a user to perform create, read, update, and delete (CRUD) operations on the underlying data. The underlying data itself could be stored in some persistent store such as a relational database.<br><br>
        <b>Technology used:</b><br>
        <svg xmlns="http://www.w3.org/2000/svg" style="height:24px" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M220.8 123.3c1 .5 1.8 1.7 3 1.7 1.1 0 2.8-.4 2.9-1.5.2-1.4-1.9-2.3-3.2-2.9-1.7-.7-3.9-1-5.5-.1-.4.2-.8.7-.6 1.1.3 1.3 2.3 1.1 3.4 1.7zm-21.9 1.7c1.2 0 2-1.2 3-1.7 1.1-.6 3.1-.4 3.5-1.6.2-.4-.2-.9-.6-1.1-1.6-.9-3.8-.6-5.5.1-1.3.6-3.4 1.5-3.2 2.9.1 1 1.8 1.5 2.8 1.4zM420 403.8c-3.6-4-5.3-11.6-7.2-19.7-1.8-8.1-3.9-16.8-10.5-22.4-1.3-1.1-2.6-2.1-4-2.9-1.3-.8-2.7-1.5-4.1-2 9.2-27.3 5.6-54.5-3.7-79.1-11.4-30.1-31.3-56.4-46.5-74.4-17.1-21.5-33.7-41.9-33.4-72C311.1 85.4 315.7.1 234.8 0 132.4-.2 158 103.4 156.9 135.2c-1.7 23.4-6.4 41.8-22.5 64.7-18.9 22.5-45.5 58.8-58.1 96.7-6 17.9-8.8 36.1-6.2 53.3-6.5 5.8-11.4 14.7-16.6 20.2-4.2 4.3-10.3 5.9-17 8.3s-14 6-18.5 14.5c-2.1 3.9-2.8 8.1-2.8 12.4 0 3.9.6 7.9 1.2 11.8 1.2 8.1 2.5 15.7.8 20.8-5.2 14.4-5.9 24.4-2.2 31.7 3.8 7.3 11.4 10.5 20.1 12.3 17.3 3.6 40.8 2.7 59.3 12.5 19.8 10.4 39.9 14.1 55.9 10.4 11.6-2.6 21.1-9.6 25.9-20.2 12.5-.1 26.3-5.4 48.3-6.6 14.9-1.2 33.6 5.3 55.1 4.1.6 2.3 1.4 4.6 2.5 6.7v.1c8.3 16.7 23.8 24.3 40.3 23 16.6-1.3 34.1-11 48.3-27.9 13.6-16.4 36-23.2 50.9-32.2 7.4-4.5 13.4-10.1 13.9-18.3.4-8.2-4.4-17.3-15.5-29.7zM223.7 87.3c9.8-22.2 34.2-21.8 44-.4 6.5 14.2 3.6 30.9-4.3 40.4-1.6-.8-5.9-2.6-12.6-4.9 1.1-1.2 3.1-2.7 3.9-4.6 4.8-11.8-.2-27-9.1-27.3-7.3-.5-13.9 10.8-11.8 23-4.1-2-9.4-3.5-13-4.4-1-6.9-.3-14.6 2.9-21.8zM183 75.8c10.1 0 20.8 14.2 19.1 33.5-3.5 1-7.1 2.5-10.2 4.6 1.2-8.9-3.3-20.1-9.6-19.6-8.4.7-9.8 21.2-1.8 28.1 1 .8 1.9-.2-5.9 5.5-15.6-14.6-10.5-52.1 8.4-52.1zm-13.6 60.7c6.2-4.6 13.6-10 14.1-10.5 4.7-4.4 13.5-14.2 27.9-14.2 7.1 0 15.6 2.3 25.9 8.9 6.3 4.1 11.3 4.4 22.6 9.3 8.4 3.5 13.7 9.7 10.5 18.2-2.6 7.1-11 14.4-22.7 18.1-11.1 3.6-19.8 16-38.2 14.9-3.9-.2-7-1-9.6-2.1-8-3.5-12.2-10.4-20-15-8.6-4.8-13.2-10.4-14.7-15.3-1.4-4.9 0-9 4.2-12.3zm3.3 334c-2.7 35.1-43.9 34.4-75.3 18-29.9-15.8-68.6-6.5-76.5-21.9-2.4-4.7-2.4-12.7 2.6-26.4v-.2c2.4-7.6.6-16-.6-23.9-1.2-7.8-1.8-15 .9-20 3.5-6.7 8.5-9.1 14.8-11.3 10.3-3.7 11.8-3.4 19.6-9.9 5.5-5.7 9.5-12.9 14.3-18 5.1-5.5 10-8.1 17.7-6.9 8.1 1.2 15.1 6.8 21.9 16l19.6 35.6c9.5 19.9 43.1 48.4 41 68.9zm-1.4-25.9c-4.1-6.6-9.6-13.6-14.4-19.6 7.1 0 14.2-2.2 16.7-8.9 2.3-6.2 0-14.9-7.4-24.9-13.5-18.2-38.3-32.5-38.3-32.5-13.5-8.4-21.1-18.7-24.6-29.9s-3-23.3-.3-35.2c5.2-22.9 18.6-45.2 27.2-59.2 2.3-1.7.8 3.2-8.7 20.8-8.5 16.1-24.4 53.3-2.6 82.4.6-20.7 5.5-41.8 13.8-61.5 12-27.4 37.3-74.9 39.3-112.7 1.1.8 4.6 3.2 6.2 4.1 4.6 2.7 8.1 6.7 12.6 10.3 12.4 10 28.5 9.2 42.4 1.2 6.2-3.5 11.2-7.5 15.9-9 9.9-3.1 17.8-8.6 22.3-15 7.7 30.4 25.7 74.3 37.2 95.7 6.1 11.4 18.3 35.5 23.6 64.6 3.3-.1 7 .4 10.9 1.4 13.8-35.7-11.7-74.2-23.3-84.9-4.7-4.6-4.9-6.6-2.6-6.5 12.6 11.2 29.2 33.7 35.2 59 2.8 11.6 3.3 23.7.4 35.7 16.4 6.8 35.9 17.9 30.7 34.8-2.2-.1-3.2 0-4.2 0 3.2-10.1-3.9-17.6-22.8-26.1-19.6-8.6-36-8.6-38.3 12.5-12.1 4.2-18.3 14.7-21.4 27.3-2.8 11.2-3.6 24.7-4.4 39.9-.5 7.7-3.6 18-6.8 29-32.1 22.9-76.7 32.9-114.3 7.2zm257.4-11.5c-.9 16.8-41.2 19.9-63.2 46.5-13.2 15.7-29.4 24.4-43.6 25.5s-26.5-4.8-33.7-19.3c-4.7-11.1-2.4-23.1 1.1-36.3 3.7-14.2 9.2-28.8 9.9-40.6.8-15.2 1.7-28.5 4.2-38.7 2.6-10.3 6.6-17.2 13.7-21.1.3-.2.7-.3 1-.5.8 13.2 7.3 26.6 18.8 29.5 12.6 3.3 30.7-7.5 38.4-16.3 9-.3 15.7-.9 22.6 5.1 9.9 8.5 7.1 30.3 17.1 41.6 10.6 11.6 14 19.5 13.7 24.6zM173.3 148.7c2 1.9 4.7 4.5 8 7.1 6.6 5.2 15.8 10.6 27.3 10.6 11.6 0 22.5-5.9 31.8-10.8 4.9-2.6 10.9-7 14.8-10.4s5.9-6.3 3.1-6.6-2.6 2.6-6 5.1c-4.4 3.2-9.7 7.4-13.9 9.8-7.4 4.2-19.5 10.2-29.9 10.2s-18.7-4.8-24.9-9.7c-3.1-2.5-5.7-5-7.7-6.9-1.5-1.4-1.9-4.6-4.3-4.9-1.4-.1-1.8 3.7 1.7 6.5z"/></svg>&nbsp
        Ubuntu v22.04.2 LTS (OS),&nbsp
        <svg xmlns="http://www.w3.org/2000/svg" style="height:24px" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M320 104.5c171.4 0 303.2 72.2 303.2 151.5S491.3 407.5 320 407.5c-171.4 0-303.2-72.2-303.2-151.5S148.7 104.5 320 104.5m0-16.8C143.3 87.7 0 163 0 256s143.3 168.3 320 168.3S640 349 640 256 496.7 87.7 320 87.7zM218.2 242.5c-7.9 40.5-35.8 36.3-70.1 36.3l13.7-70.6c38 0 63.8-4.1 56.4 34.3zM97.4 350.3h36.7l8.7-44.8c41.1 0 66.6 3 90.2-19.1 26.1-24 32.9-66.7 14.3-88.1-9.7-11.2-25.3-16.7-46.5-16.7h-70.7L97.4 350.3zm185.7-213.6h36.5l-8.7 44.8c31.5 0 60.7-2.3 74.8 10.7 14.8 13.6 7.7 31-8.3 113.1h-37c15.4-79.4 18.3-86 12.7-92-5.4-5.8-17.7-4.6-47.4-4.6l-18.8 96.6h-36.5l32.7-168.6zM505 242.5c-8 41.1-36.7 36.3-70.1 36.3l13.7-70.6c38.2 0 63.8-4.1 56.4 34.3zM384.2 350.3H421l8.7-44.8c43.2 0 67.1 2.5 90.2-19.1 26.1-24 32.9-66.7 14.3-88.1-9.7-11.2-25.3-16.7-46.5-16.7H417l-32.8 168.7z"/></svg>&nbsp;
        PHP v8.1.2-1ubuntu2.11, <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" style="height:24px"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) --><path d="M0 32l34.9 395.8L191.5 480l157.6-52.2L384 32H0zm308.2 127.9H124.4l4.1 49.4h175.6l-13.6 148.4-97.9 27v.3h-1.1l-98.7-27.3-6-75.8h47.7L138 320l53.5 14.5 53.7-14.5 6-62.2H84.3L71.5 112.2h241.1l-4.4 47.7z"/></svg>&nbsp
        HTML5, &nbsp
        <svg xmlns="http://www.w3.org/2000/svg" style="height:24px" viewBox="0 0 512 512"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) --><path d="M480 32l-64 368-223.3 80L0 400l19.6-94.8h82l-8 40.6L210 390.2l134.1-44.4 18.8-97.1H29.5l16-82h333.7l10.5-52.7H56.3l16.3-82H480z"/></svg>&nbsp
        CSS3, &nbsp
        <i class="fab fa-js"></i>
        <svg xmlns="http://www.w3.org/2000/svg" style="height:24px" viewBox="0 0 448 512"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) --><path d="M0 32v448h448V32H0zm243.8 349.4c0 43.6-25.6 63.5-62.9 63.5-33.7 0-53.2-17.4-63.2-38.5l34.3-20.7c6.6 11.7 12.6 21.6 27.1 21.6 13.8 0 22.6-5.4 22.6-26.5V237.7h42.1v143.7zm99.6 63.5c-39.1 0-64.4-18.6-76.7-43l34.3-19.8c9 14.7 20.8 25.6 41.5 25.6 17.4 0 28.6-8.7 28.6-20.8 0-14.4-11.4-19.5-30.7-28l-10.5-4.5c-30.4-12.9-50.5-29.2-50.5-63.5 0-31.6 24.1-55.6 61.6-55.6 26.8 0 46 9.3 59.8 33.7L368 290c-7.2-12.9-15-18-27.1-18-12.3 0-20.1 7.8-20.1 18 0 12.6 7.8 17.7 25.9 25.6l10.5 4.5c35.8 15.3 55.9 31 55.9 66.2 0 37.8-29.8 58.6-69.7 58.6z"/></svg>
        JavaScript, &nbsp
        <svg xmlns="http://www.w3.org/2000/svg" style="height:24px" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M333.5,201.4c0-22.1-15.6-34.3-43-34.3h-50.4v71.2h42.5C315.4,238.2,333.5,225,333.5,201.4z M517,188.6 c-9.5-30.9-10.9-68.8-9.8-98.1c1.1-30.5-22.7-58.5-54.7-58.5H123.7c-32.1,0-55.8,28.1-54.7,58.5c1,29.3-0.3,67.2-9.8,98.1 c-9.6,31-25.7,50.6-52.2,53.1v28.5c26.4,2.5,42.6,22.1,52.2,53.1c9.5,30.9,10.9,68.8,9.8,98.1c-1.1,30.5,22.7,58.5,54.7,58.5h328.7 c32.1,0,55.8-28.1,54.7-58.5c-1-29.3,0.3-67.2,9.8-98.1c9.6-31,25.7-50.6,52.1-53.1v-28.5C542.7,239.2,526.5,219.6,517,188.6z M300.2,375.1h-97.9V136.8h97.4c43.3,0,71.7,23.4,71.7,59.4c0,25.3-19.1,47.9-43.5,51.8v1.3c33.2,3.6,55.5,26.6,55.5,58.3 C383.4,349.7,352.1,375.1,300.2,375.1z M290.2,266.4h-50.1v78.4h52.3c34.2,0,52.3-13.7,52.3-39.5 C344.7,279.6,326.1,266.4,290.2,266.4z"/></svg>
        Bootstrap v5.3, &nbsp
        <i class="icon-mysql" style="height:45px;"></i>
        mysql v8.0.32-0ubuntu0.22.04.2, &nbsp
        <i class="icon-apache"></i>
        apache v2.4.52-1ubuntu4.5 <br><br>
        For demo purposes, you can access this application by using : <br><br>
        <b>username :</b> admin<br>
        <b>email :</b> admin@gmail.com<br>
        <b>password :</b> 123456 <br><br>
        Or you can also create a new account first.
      </p>
    </div>
  </div>
<?php
session_destroy();
endif;
?>

<!-- about application -->
  <div class="container-fluid mt-2 text-end">
    <a href="process.php?about=1" type="button" class="btn btn-outline-dark">About Application</a>
  </div>

<!-- login form -->
  <div id="parent" class="container min-vh-100 d-flex justify-content-center align-items-center">
    <form class="form-inline" action="process.php" method="post">

      <?php if (isset($_SESSION['login-failed'])) : ?>
          <p style="color: red; font-style:italic">username / password salah</p>
      <?php
          session_destroy();
          endif;
      ?>

      <!-- Username -->
      <label class="sr-only" for="username">Username</label>
      <div class="input-group mb-2 mr-sm-2">
        <div class="input-group-prepend">
          <div class="input-group-text">@</div>
        </div>
        <input type="text" class="form-control" id="username" placeholder="Username or Email" name="username">
      </div>

      <!-- Password -->
      <label class="sr-only" for="password">Name</label>
      <input type="password" class="form-control mb-2 mr-sm-2" id="password" placeholder="Password" name="password">

      <!-- Remember me -->
      <div class="form-check mb-2 mr-sm-2">
        <input class="form-check-input" type="checkbox" id="remember-me" name="remember-me" value="1">
        <label class="form-check-label" for="remember-me">
          Remember me
        </label>
      </div>

      <!-- registration form -->
      <div class="etc-login-form text-center">
        <h6 class="p-1 mb-2 bg-dark text-white">new user ? <a href="registration.php" class="text-white">create new account</a></h6>
      </div>

      <!-- Submit -->
      <button type="submit" class="btn btn-warning mb-2" name="submit-login">Login</button>

    </form>
  </div>
</body>
</html>
