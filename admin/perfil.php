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
$total_comments = $select_comments->rowCount();
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
    <title>Perfil</title>
</head>
<body>
    
    <!-- sidebar -->

    <?php include '../componentes/admin_header.php'; ?>


<!-- Dashboard section -->

<div class="home_content">
<div class="text">Mi Perfil</div>

<section class="perfil">

    <div class="detalles">

        <div class="profesor">

        <img src="../uploaded_files/<?= $fetch_profile['image']; ?>" alt="">
        <h3><?= $fetch_profile['name']; ?></h3>
        <span><?= $fetch_profile['profession']; ?></span>
        <a href="update.php" class="inline-btn">Actualizar Perfil</a>

        </div>


        <div class="caja-container">

            <div class="caja">

            <h3><?= $total_contents; ?></h3>
            <p>total contenido</p>
            <a href="contenidos.php" class="btn">ver contenido</a>

            </div>

            <div class="caja">
            <h3><?= $total_playlists; ?></h3>
            <p>total playlist</p>
            <a href="playlists.php" class="btn">ver reproduciones</a>

            </div>

            <div class="caja">

            <h3><?= $total_likes; ?></h3>
            <p>total Me gustas</p>
            <a href="contenidos.php" class="btn">ver contenido</a>

            </div>

            <div class="caja">

            <h3><?= $total_comments; ?></h3>
            <p>total Comentario</p>
            <a href="comentario.php" class="btn">ver comentario</a>

            </div>

        </div>

    </div>


</section>




    <!-- footer -->

    <?php include '../componentes/footer.php'; ?>

    </div>

    <script src="../js/admin_script.js"></script>
</body>
</html>