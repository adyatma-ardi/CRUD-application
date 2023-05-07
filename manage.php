<?php
// debug
ini_set("display_errors","1");
ini_set("display_startup_errors","1");
error_reporting(E_ALL);

  session_start();
  include ('asset/function.php');

  if( !isset($_SESSION["login"]) ) {
      header("Location: login.php");
      exit;
  }

?>

<!DOCTYPE html>
<!-- logic to separate add and edit data -->
<?php
  $studentId = '';
  $nisn = '';
  $studentName = '';
  $gender = '';
  $alamat = '';

  if (isset($_GET['change'])) {
      $studentId = $_GET['change'];

      //query to fill form while $_GET['change'] action activated
      $result = query("SELECT * FROM tb_siswa WHERE id_siswa = $studentId")[0];

      $nisn = $result['nisn'];
      $studentName = $result['nama_siswa'];
      $gender = $result['jenis_kelamin'];
      $photo = $result['foto_siswa'];
      $alamat = $result['alamat'];

  }
?>

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
    </style>

    <!-- font-awesome -->
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">

    <title>CRUD</title>
  </head>
  <body>
    <div class="container-fluid">
      <form action="process.php" method="post" enctype="multipart/form-data">

        <!-- navbar -->
        <nav class="navbar bg-body-tertiary mb-3">
            <a class="navbar-brand" href="#">
              CRUD - Application
            </a>
        </nav>

        <!-- alert session -->
        <?php if(isset($_SESSION['image-extension'])) : ?>
          <div class="alert alert-warning p-2" role="alert">
            <h5 class="alert-heading">Sorry!</h5>
            <p><?= $_SESSION['image-extension']; ?></p>
            <hr>
            <p class="mb-0"><?= $_SESSION['image-extension2']; ?></p>
          </div>
        <?php
            session_destroy();
            endif;
        ?>

        <?php if(isset($_SESSION['image-size'])) : ?>
          <div class="alert alert-warning p-2" role="alert">
            <h5 class="alert-heading">Sorry!</h5>
            <p><?= $_SESSION['image-size']; ?></p>
            <hr>
            <p class="mb-0"><?= $_SESSION['image-size2']; ?></p>
          </div>
        <?php
            session_destroy();
            endif;
        ?>

        <?php if(isset($_SESSION['image-null'])) : ?>
          <div class="alert alert-danger p-2" role="alert">
            <h5 class="alert-heading">Sorry!</h5>
            <hr>
            <p><?= $_SESSION['image-null']; ?></p>
          </div>
        <?php
            session_destroy();
            endif;
        ?>

        <!-- ======= [end] -->

        <!-- form -->
        <input type="hidden" name="student-id" value="<?= $studentId ?>">
        <input type="hidden" name="existing-picture" value="<?= $photo ?>">
        <div class="mb-3 row">
          <label for="nisn" class="col-sm-2 col-form-label">
            NISN :
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="nisn" placeholder="Ex. 721701" minlength="6" maxlength="6" name="nisn" required value="<?= $nisn ?>">
          </div>
        </div>

        <div class="mb-3 row">
          <label for="student-name" class="col-sm-2 col-form-label">
            Student name :
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="student-name" placeholder="Ex. Achmad Adyatma Ardi" name="student-name" required value="<?= $studentName ?>">
          </div>
        </div>

        <div class="mb-3 row">
          <label for="gender" class="col-sm-2 col-form-label">
            Gender :
          </label>
          <div class="col-sm-10">
            <select id="gender" class="form-select" name="gender" required>
              <option <?php if ($gender == 'Male') {echo "selected";} ?> value="Male">Male</option>
              <option <?php if ($gender == 'Female') {echo "selected";} ?> value="Female">Female</option>
            </select>
          </div>
        </div>

        <div class="mb-3 row">
          <label for="photo" class="col-sm-2 col-form-label">
            Student picture : <br>
            (Ext. : jpg, jpeg, png) <br>
            (max size : 1 mb)
          </label>
          <?php if (isset($_GET['change'])) :?>
            <div class="col-sm-10">
              <div class="mt-3 mb-2">
                <img src="img/<?= $photo; ?>" class="rounded mx-auto d-block img-thumbnail" style="width: 240px; height: 180px;">
              </div>
              <input class="form-control form-control-sm" id="photo" type="file" name="photo">
            </div>
          <?php else :?>
            <div class="col-sm-10">
              <input class="form-control form-control-sm" id="photo" type="file" name="photo">
            </div>
          <?php endif; ?>
        </div>

        <div class="mb-3 row">
          <label for="address" class="col-sm-2 col-form-label">
            Address :
          </label>
          <div class="col-sm-10">
            <textarea class="form-control" id="address" rows="3" placeholder="Ex. Jl. Taman Ubud Kencana" name="address" required><?= $alamat ?></textarea>
          </div>
        </div>

        <!-- submit -->
        <div class="mb-3 row mt-3">
          <div class="col">
            <a href="index.php" type="button" class="btn btn-danger float-end">
              <i class="fa fa-reply"></i>
               &nbsp;Cancel
            </a>
            <?php if (isset($_GET['change'])) :?>
              <button type="submit" name="action" value="edit" class="btn btn-dark float-end me-1">
                <i class="fa fa-floppy-o"></i>
                 &nbsp;Save changes
              </button>
            <?php else :?>
              <button type="submit" name="action" value="add" class="btn btn-dark float-end me-1">
                <i class="fa fa-floppy-o"></i>
                 &nbsp;Add
              </button>
            <?php endif;?>
            <!-- endlogic -->
          </div>
        </div>

      </form>
    </div>
  </body>
</html>

<!--Halaman-->
<!--
1. Login
2. Admin Interface
3. Add & Edit data
 -->
