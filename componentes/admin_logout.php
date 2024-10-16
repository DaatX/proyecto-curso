<?php

include 'conexion.php';

setcookie('tutor_id', '', time() - 1, '/');
header('location:../admin/login.php');


?>