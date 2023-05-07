<?php
  $host = 'localhost';
  $user = 'root';
  $password = '';
  $db_name = 'db_siswa';

  $conn = mysqli_connect($host, $user, $password, $db_name);

  mysqli_select_db($conn, $db_name);
?>
