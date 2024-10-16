<?php

include '../componentes/conexion.php';

if(isset($_COOKIE['tutor_id'])){
   $tutor_id = $_COOKIE['tutor_id'];
}else{
   $tutor_id = '';
   header('location:login.php');
}

$count_content = $cBD->prepare("SELECT * FROM `contenido` WHERE tutor_id = ?");
$count_content->execute([$tutor_id]);
$total_contents = $count_content->rowCount();

$select_playlists = $cBD->prepare("SELECT * FROM `playlist` WHERE tutor_id = ?");
$select_playlists->execute([$tutor_id]);
$total_playlists = $select_playlists->rowCount();

$select_likes = $cBD->prepare("SELECT * FROM `likes` WHERE tutor_id = ?");
$select_likes->execute([$tutor_id]);
$total_likes = $select_likes->rowCount();

$select_comments = $cBD->prepare("SELECT * FROM `comentario` WHERE tutor_id = ?");
$select_comments->execute([$tutor_id]);
$total_comentarios = $select_comments->rowCount();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Boxicons CDN Link -->
        <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
      <!-- font awesome -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
      <link rel="stylesheet" href="../css/admin_style.css">
      <!-- <link rel="stylesheet" href="../css/estilo.css"> -->
    <title>Dashboard</title>
</head>
<body>
    
    <!-- sidebar -->

    <?php include '../componentes/admin_header.php'; ?>


<!-- Dashboard section -->

<div class="home_content">
<div class="text">Dashboard</div>

<section class="dashboard">

    <div class="caja-container">

    <div class="caja">
        <h3>Bienvenido</h3>
        <p><?= $fetch_profile['name']; ?></p>
        <a href="perfil.php" class="btn"> Ver Perfil</a>
    </div>

    <div class="caja">
         <h3><?= $total_contents; ?></h3>
         <p>contenido subido</p>
         <a href="agregar_contenido.php" class="btn">Agregar Nuevo Contenido </a>
      </div>


    <div class="caja">
        <h3><?= $total_playlists; ?></h3>
        <p>Reproduciones subido</p>
        <a href="agregar_playlist.php" class="btn">Agregar Nuevo Video </a>
    </div>

    <div class="caja">
        <h3><?= $total_likes; ?></h3>
        <p>total Me gustas</p>
        <a href="contenidos.php" class="btn">Ver Contenido </a>
    </div>

    <div class="caja">
        <h3><?= $total_comentarios; ?></h3>
        <p>total Comentarios</p>
        <a href="comentario.php" class="btn">Ver Comentario </a>
    </div>

    <!-- <div class="caja">
    <h3>enlace rápido</h3>
    <p>Login o Registro</p>
    <div class="flex-btn">
        <a href="login.php"  class="opcion-btn">Login</a>
        <a href="registro.php"  class="opcion-btn">Registro</a>
    </div>


    </div> -->

    </div>

    </section>

<!-- section final -->






    <!-- footer -->

    <?php include '../componentes/footer.php'; ?>

    </div>

    <script src="../js/admin_script.js"></script>
</body>
</html>