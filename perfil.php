<?php

include 'componentes/conexion.php';

if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
 }else{
    $user_id = '';
    header('location:login.php');
 }

 $select_likes = $cBD->prepare("SELECT * FROM `likes` WHERE user_id = ?");
$select_likes->execute([$user_id]);
$total_likes = $select_likes->rowCount();

$select_comments = $cBD->prepare("SELECT * FROM `comentario` WHERE user_id = ?");
$select_comments->execute([$user_id]);
$total_comments = $select_comments->rowCount();

$select_bookmark = $cBD->prepare("SELECT * FROM `bookmark` WHERE user_id = ?");
$select_bookmark->execute([$user_id]);
$total_bookmarked = $select_bookmark->rowCount();

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title> perfil estudiante</title>
    <link rel="stylesheet" href="css/estilo.css">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
                <!-- font awesome -->
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<!-- header -->
<?php include 'componentes/usuario_header.php'; ?>
<!-- header final -->

    <div class="home_content">
        <div class="text">Perfil</div>
        

        <!-- perfil -->

<section class="perfil">

<h1 class="heading">Detalles del perfil estudiante</h1>

<div class="detalles">

   <div class="usuario">
      <img src="uploaded_files/<?= $fetch_profile['image']; ?>" alt="">
      <h3><?= $fetch_profile['name']; ?></h3>
      <p>Estudiante</p>
      <a href="update.php" class="inline-btn">Actualizar perfil</a>
   </div>

   <div class="caja-container">

      <div class="caja">
         <div class="flex">
            <i class="fas fa-bookmark"></i>
            <div>
               <h3><?= $total_bookmarked; ?></h3>
               <span>playlists Guardadas</span>
            </div>
         </div>
         <a href="#" class="inline-btn">ver playlists</a>
      </div>

      <div class="caja">
         <div class="flex">
            <i class="fas fa-heart"></i>
            <div>
               <h3><?= $total_likes; ?></h3>
               <span>Me gustaron los tutoriales</span>
            </div>
         </div>
         <a href="#" class="inline-btn">ver me gustas</a>
      </div>

      <div class="caja">
         <div class="flex">
            <i class="fas fa-comment"></i>
            <div>
               <h3><?= $total_comments; ?></h3>
               <span>comentarios de video</span>
            </div>
         </div>
         <a href="#" class="inline-btn">ver comentarios</a>
      </div>

   </div>

</div>

</section>

        <!-- perfil final -->

             <!-- footer section starts  -->
             <?php include 'componentes/footer.php'; ?>
    <!-- footer section ends -->

    </div>



    <script src="js/menu.js"></script>


</body>

</html>