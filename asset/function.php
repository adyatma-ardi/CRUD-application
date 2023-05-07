<?php
ini_set("display_errors","1");
ini_set("display_startup_errors","1");
error_reporting(E_ALL);
include ('connection.php');

// query
function query($query) {
      global $conn;

      $result = mysqli_query($conn, $query);
      // siapin wadah kosong
      $rows = [];
      // isi wadah kosong pada data dari database dengan perulangan
      while ($row = mysqli_fetch_assoc($result))  {
        // menambahkan elemen baru pada array (array associative)
        $rows[] = $row;
      }
        return $rows;
    }

// ======= [end]

// add data
function crud_add_query($data) {
      global $conn;

      // keep data from $_POST method
      $nisn = htmlspecialchars($_POST['nisn']);
      $studentName = htmlspecialchars($_POST['student-name']);
      $gender = htmlspecialchars($_POST['gender']);
      $address = htmlspecialchars($_POST['address']);

      // upload an image
      $studentPicture = upload_image();

      // if no images are uploaded the upload function will be false
      if (!$studentPicture) {
          return false;
      }

      $query = "INSERT INTO
                  tb_siswa (
                      id_siswa,
                      nisn,
                      nama_siswa,
                      jenis_kelamin,
                      foto_siswa,
                      alamat
                      )
                VALUES (
                  null,
                  '$nisn',
                  '$studentName',
                  '$gender',
                  '$studentPicture',
                  '$address'
                  )";

      mysqli_query($conn, $query);
      return mysqli_affected_rows($conn);
}
// ======= [end]

// upload image
function upload_image() {
      // keep data from $_FILES with attribute enctype = "multipart/form-data"

      $fileName = $_FILES['photo']['name'];
      $tmpName = $_FILES['photo']['tmp_name'];
      $error = $_FILES['photo']['error'];
      $fileSize = $_FILES['photo']['size'];

      /*
      error message from $_FILES['file']['error']
      0 -> file is uploaded succesfully
      1 -> uploaded file cross the limit
      2 -> uploaded file cross the limit which is mentioned in the HTML form
      3 -> file is partially uploaded or there is any error in between uploading
      4 -> no file was uploaded
      6 -> missing a temporary folder
      7 -> failed to write file to disk
      8 -> a PHP extension stopped the uploading process
      */

      // check if there is no image uploaded
      if($error === 4) {

          $_SESSION['image-null'] = "Please select an image first";

          header("Location: manage.php");

          die();
      }

      // check whether the uploaded image has an allowed file extension or not
      $validPictureExtension = ['jpg', 'jpeg', 'png'];
      $pictureExtension = explode('.', $fileName);
      $pictureExtension = strtolower(end($pictureExtension));
      if (!in_array($pictureExtension, $validPictureExtension)){

          $_SESSION['image-extension'] = "You didn't upload an image";
          $_SESSION['image-extension2'] = "Require image with extension (jpg, jpeg, or png)";

          header("Location: manage.php");

          die();
      }

      // check whether the uploaded image has a file size that exceeds the size limit or not
      // example : 1 mb
      if( $fileSize > 1000000 ) {

          $_SESSION['image-size'] = "Image size is too large";
          $_SESSION['image-size2'] = "Please upload an image with size max 1 mb";

          header("Location: manage.php");

          die();
      }

      // passed the check, the image is ready to be uploaded
      // generate new image name
      $newFileName = uniqid();
      $newFileName .= '.';
      $newFileName .= $pictureExtension;

      // for linux user adding permission 'sudo chmod -R 777 path/to/project/folder'
      move_uploaded_file($tmpName, 'img/'.$newFileName);

      return $newFileName;
}
// ======= [end]

// update data
function crud_update_query($data) {
      global $conn;

      //extension image check
      $allowed = array('gif','png','jpg','jpeg');
      $fileName = $_FILES['photo']['name'];
      $ext = pathinfo($fileName, PATHINFO_EXTENSION);

      $studentId = $data["student-id"];
      $nisn = htmlspecialchars($data["nisn"]);
      $studentName = htmlspecialchars($data["student-name"]);
      $gender = htmlspecialchars($data["gender"]);
      $existingPicture = htmlspecialchars($data["existing-picture"]);
      $address = htmlspecialchars($data["address"]);

      // fetch id_siswa
      $queryId = query("SELECT * FROM tb_siswa WHERE id_siswa = '$studentId'")[0];

      $id = $queryId['id_siswa'];

      // image updated assesment
      // check whether the user uploaded the image or not
      if ($_FILES['photo']['error'] === 4 ) {

          $newPicture = $existingPicture;

      // check whether the uploaded image has a file size that exceeds the size limit or not
      } elseif ($_FILES['photo']['size'] > 1000000) {

        $_SESSION['image-size'] = "Image size is too large";
        $_SESSION['image-size2'] = "Please upload an image with size max 1 mb";

        header("Location: manage.php?change=$id");

        die();

      // check whether the uploaded image has an allowed file extension or not
      } elseif (!in_array($ext, $allowed)) {

        $_SESSION['image-extension'] = "You didn't upload an image";
        $_SESSION['image-extension2'] = "Require image with extension (jpg, jpeg, or png)";

        header("Location: manage.php?change=$id");

        die();

      // images that have passed the check, previous image source will be fetched and unlinked
      } else {

        $queryImageSource = query("SELECT * FROM tb_siswa WHERE id_siswa = $studentId")[0];

        unlink("img/" .$queryImageSource['foto_siswa']);

        $newPicture = upload_image();
      }

      $query = "UPDATE
                    tb_siswa
                  SET
                    nisn = '$nisn',
                    nama_siswa = '$studentName',
                    jenis_kelamin = '$gender',
                    foto_siswa = '$newPicture',
                    alamat = '$address'
                  WHERE id_siswa = $studentId";

      mysqli_query($conn, $query);
      return mysqli_affected_rows($conn);
}
// ======= [end]

// delete data
function crud_delete_query($data) {
        global $conn;

        $id = $_GET['delete'];

        // fetch and unlink image source
        $queryImageSource = query("SELECT * FROM tb_siswa WHERE id_siswa = $id");

        unlink("img/" .$queryImageSource[0]['foto_siswa']);

        // delete data
        mysqli_query($conn, "DELETE FROM tb_siswa where id_siswa = '$id'");

        return mysqli_affected_rows($conn);
}
// ======= [end]

// Login
function login_crud($data) {
        global $conn;

        $username = htmlspecialchars($data["username"]);
        $password = htmlspecialchars($data["password"]);
        $remember = $data["remember-me"];

        if(empty($remember)) {
           $remember = 'unchecked';
        } elseif ($remember == '1') {
           $remember = 'checked';
        }

        // fetch username that inputed from user
        $query = "SELECT *
                  FROM tb_pengguna
                  WHERE
                    username = '$username' OR
                    email = '$username'
                 ";

        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        $usernameVerify = $row['username'];
        $passwordVerify = password_verify($password, $row['password']);

        if (isset($usernameVerify) && $passwordVerify === true) {

            // set $_SESSION
            $_SESSION['login'] = true;

            // remember me check
            if (isset($data['remember-me'])) {

                // cookie set
                setcookie('id', $row['id'], time() + 60*10);
                setcookie('un', hash('sha256', $row['username']), time() + 60*10);
            }

            header("Location: index.php");
            die();

        } else {

          $_SESSION['login-failed'] = '';
          return false;

        }
}

function registration_crud($data) {
        global $conn;

        // extract data
        $email = mysqli_real_escape_string($conn, $data["email"]);
        $username = strtolower(stripslashes($data["username"]));
        $password = mysqli_real_escape_string($conn, $data["password"]);
        $password2 = mysqli_real_escape_string($conn, $data["repeat-password"]);

        // find existing records username and email on database
        $queryFind =" SELECT *
                      FROM tb_pengguna
                      WHERE
                        username LIKE '%$username%' OR
                        email LIKE '%$email%'
                    ";

        $result = mysqli_query($conn, $queryFind);
        $row = mysqli_fetch_assoc($result);

        $findUsername = $row['username'];
        $findEmail = $row['email'];

        //  input asessment
        // check existing username
        if ($username == $findUsername) {

            $_SESSION['username-exists'] = "Username already exists";

            header("Location: registration.php");
            die();

        // check existing email
        } elseif ($email == $findEmail) {

            $_SESSION['email-exists'] = "Email already exists";

            header("Location: registration.php");
            die();

        // check password confirmation
        } elseif ($password != $password2) {

            $_SESSION['repeated-password'] = "Password confirmation does not match";

            header("Location: registration.php");
            die();

        // passed check, do query
        } else {

          $password = password_hash($password, PASSWORD_DEFAULT);

          // add new account to the database
          $queryReg = "INSERT INTO
                        tb_pengguna (
                            username,
                            password,
                            email
                            )
                      VALUES (
                        '$username',
                        '$password',
                        '$email'
                        )";

          mysqli_query($conn, $queryReg);

          // fetch the recently added username
          $queryNewAcc =" SELECT *
                          FROM tb_pengguna
                          ORDER BY id
                          DESC LIMIT 1
                        ";

          $result2 = mysqli_query($conn, $queryNewAcc);
          $row2 = mysqli_fetch_assoc($result2);
          $userName = $row2['username'];

          // var_dump($userId);
          // die();

          $_SESSION['account-success'] = 'Hello ' .$userName;

          $_SESSION['account-success2'] = "Congratulations, the new account has been created succesfully";

          header("Location: registration.php");
          exit();

        }

        return true;
}

?>
