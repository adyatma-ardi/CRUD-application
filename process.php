<?php
ini_set("display_errors","1");
ini_set("display_startup_errors","1");
error_reporting(E_ALL);

include ('asset/function.php');
session_start();

// trigger to add and edit action
if (isset($_POST["action"])) {
    if ($_POST["action"] === "add") {
        if (crud_add_query($_POST) > 0) {
              $_SESSION['add-alert-s'] = "data successfully <b>added</b>";
              echo "
                <script>document.location.href = 'index.php';</script>
              ";
        } else {
              echo "
                <script>
                  document.location.href = 'index.php';
                </script>
              ";
        }
    } else if ($_POST["action"] === "edit") {
        if (crud_update_query($_POST) > 0) {
              $_SESSION['edit-alert-s'] = 'data successfully <b>updated</b>';
              echo "
                <script>document.location.href = 'index.php';
                </script>
              ";
        } else {
              echo "
              <script>
                document.location.href = 'index.php';
              </script>
              ";
        }
    }
}

// trigger to delete action
if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    if (crud_delete_query($id) > 0) {
        $_SESSION['delete-alert-s'] = 'data succesfully <b>deleted</b>';
        echo "
          <script>document.location.href = 'index.php';</script>
        ";
    } else {
        echo "
          <script>
            alert('ERROR!');
            document.location.href = 'index.php';
          </script>
        ";
    }

}

// trigger to application access
if (isset($_POST['submit-login']) || isset($_POST['submit-registration']) || !empty($_GET['about']) || !empty($_GET['refresh']) || !empty($_GET['logout']) || (isset($_COOKIE['id']) && isset($_COOKIE['un'])) ){

    if (isset($_POST['submit-registration'])) {

        if (registration_crud($_POST) == 1) {

            header("Location: registration.php");

        } else {

            echo "ERROR!";

        }


    } elseif (isset($_POST['submit-login'])) {

        if (login_crud($_POST) > 0) {

            header("Location: index.php");

        } else {

            header("Location: login.php");
            echo "ERROR!";

        }

    } elseif (isset($_GET['about'])) {

        $about = $_GET['about'];
        $_SESSION['about-application'] = $about;

        header("Location: login.php");

    } elseif (isset($_GET['refresh'])) {

        $refresh = $_GET['refresh'];

        header("refresh: 0; url = login.php");

    } elseif (isset($_GET['logout'])) {

        $_SESSION = [];
        session_unset();
        session_destroy();

        // hapus cookie
        setcookie('id','', time()-3600);
        setcookie('un','', time() - 3600);

        header("Location: login.php");
        die();

    }

}



?>
