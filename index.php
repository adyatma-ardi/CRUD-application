<?php
// debug
ini_set("display_errors","1");
ini_set("display_startup_errors","1");
error_reporting(E_ALL);

session_start();

  include ('asset/function.php');

  // $query = "SELECT * FROM tb_siswa;";
  // $sql = mysqli_query($conn, $query);

  $result = query("SELECT * FROM tb_siswa");
  $init_num = 0;

  if( !isset($_SESSION["login"]) ) {
      header("Location: login.php");
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

    <style media="screen">
      img {
        object-fit: cover;
      }

      .page-item.active .page-link {
          background-color: lightgrey !important;
          border: 1px solid black;
      }

      .page-link {
          color: black !important;
      }

      #logout {
        font-size: 14px;
        color: black;
      }
    </style>

    <!-- font-awesome -->
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">

    <!-- data-tables -->
    <link rel="stylesheet" href="data-tables/datatables.css">
    <script type="text/javascript" src="data-tables/datatables.js">

    </script>

    <title>CRUD</title>
  </head>

  <!-- data tables initialization -->
  <script type="text/javascript">
      $(document).ready(function () {
        $('#data-tables').DataTable();
    });
  </script>

  <body>
    <div class="container-fluid">

      <!-- navbar -->
      <nav class="navbar bg-body-tertiary">
          <a class="navbar-brand" href="#">
            CRUD - Application
          </a>
          <a id="logout" href="process.php?logout=1" type="button" class="btn btn-outline-danger mt-1">
<svg xmlns="http://www.w3.org/2000/svg" style="height:16px;" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M320 32c0-9.9-4.5-19.2-12.3-25.2S289.8-1.4 280.2 1l-179.9 45C79 51.3 64 70.5 64 92.5V448H32c-17.7 0-32 14.3-32 32s14.3 32 32 32H96 288h32V480 32zM256 256c0 17.7-10.7 32-24 32s-24-14.3-24-32s10.7-32 24-32s24 14.3 24 32zm96-128h96V480c0 17.7 14.3 32 32 32h64c17.7 0 32-14.3 32-32s-14.3-32-32-32H512V128c0-35.3-28.7-64-64-64H352v64z"/></svg>&nbsp <b>Log out</b></a>
      </nav>

      <!-- title -->
      <h2 class="mt-4">Student Data</h2>
      <figure>
        <blockquote class="blockquote">
          <p>contains data stored in a database</p>
        </blockquote>
        <figcaption class="blockquote-footer">
          CRUD <cite title="Source Title">(Create Read Update Delete)</cite>
        </figcaption>
      </figure>
      <a href="manage.php" type="button" class="btn btn-dark mt-1">
        <i class="fa fa-plus-circle"></i>
        Add Data
      </a>

      <!-- session alert -->
      <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" viewBox="0 0 16 16">
          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </symbol>
        <symbol id="info-fill" viewBox="0 0 16 16">
          <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
        </symbol>
        <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
          <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </symbol>
      </svg>

      <!-- alert session -->
      <!-- add alert session -->
      <?php if (isset($_SESSION['add-alert-s'])): ?>
        <div class="alert alert-success d-flex align-items-center mt-1 mb-1 p-2 justify-content-center" role="alert">
          <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Success:" width= 20px height=20px><use xlink:href="#check-circle-fill"/></svg>
          <div>
            <?= $_SESSION['add-alert-s']; ?>
          </div>
        </div>
      <?php
          session_destroy();
          endif;
      ?>

      <!-- edit alert session -->
      <?php if (isset($_SESSION['edit-alert-s'])): ?>
        <div class="alert alert-dark d-flex align-items-center mt-1 mb-1 p-2 justify-content-center" role="alert">
          <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Info:" width= 20px height=20px><use xlink:href="#check-circle-fill"/></svg>
          <div>
            <?= $_SESSION['edit-alert-s']; ?>
          </div>
        </div>
      <?php
          session_destroy();
          endif;
      ?>

      <!-- delete alert session -->
      <?php if (isset($_SESSION['delete-alert-s'])): ?>
        <div class="alert alert-danger d-flex align-items-center mt-1 mb-1 p-2 justify-content-center" role="alert">
          <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Info:" width= 20px height=20px><use xlink:href="#info-fill"/></svg>
          <div>
            <?= $_SESSION['delete-alert-s']; ?>
          </div>
        </div>
      <?php
          session_destroy();
          endif;
      ?>
      <!-- ======= [end] -->

      <!-- table -->
      <div class="table-responsive mt-1">
        <table class="table align-middle table-hover" id="data-tables">
          <thead class="table-dark">
            <tr>
              <th class="text-center">Num.</th>
              <th class="text-center">NISN</th>
              <th class="text-center">Student Name</th>
              <th class="text-center">Gender</th>
              <th class="text-center">Student Picture</th>
              <th class="text-center">Address</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>

          <!-- logic to fetch data from database -->
          <?php foreach($result as $row): ?>
            <tr>
              <td class="text-center">

                <?= ++$init_num; //pre auto-increment ?>

              </td>
              <td class="text-center">

                <?= $row["nisn"]; //nisn ?>

              </td>
              <td class="text-center">

                <?= $row["nama_siswa"]; //student name ?>

              </td>
              <td class="text-center">

                <?= $row["jenis_kelamin"]; //gender ?>

              </td>
              <td>

                <img src="img/<?= $row["foto_siswa"]; //student picture ?>" style="width: 160px; height: 120px;" class="mx-auto d-block img-thumbnail">

              </td>
              <td class="text-center">

                <?= $row["alamat"]; //address ?>

              </td>
              <!-- action -->
              <td class="text-center">
                <a href="manage.php?change=<?= $row["id_siswa"]; ?>" type="button" class="btn btn-success" title="edit">
                  <i class="fa fa-pencil"></i>
                </a>
                <a href="process.php?delete=<?= $row["id_siswa"]; ?>" type="button" class="btn btn-danger" title="delete" onclick="return confirm('Are you sure want to delete ?')">
                  <i class="fa fa-trash"></i>
              </td>
            </tr>
          <?php endforeach;  ?>
          <!-- endlogic  -->

          </tbody>
        </table>
      </div>
    </div>
    <div class="mt-5"></div>
  </body>
</html>

<!--Halaman-->
<!--
1. Login
2. Admin Interface
3. Add & Edit data
 -->
