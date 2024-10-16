<?php

include 'componentes/conexion.php';

if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
 }else{
    $user_id = '';
 }

 
 if(isset($_POST['tutor_fetch'])){

    $tutor_email = $_POST['tutor_email'];
    $tutor_email = filter_var($tutor_email, FILTER_SANITIZE_STRING);
    $select_tutor = $cBD->prepare('SELECT * FROM `profesor` WHERE email = ?');
    $select_tutor->execute([$tutor_email]);
 
    $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
    $tutor_id = $fetch_tutor['id'];
 
    $count_playlists = $cBD->prepare("SELECT * FROM `playlist` WHERE tutor_id = ?");
    $count_playlists->execute([$tutor_id]);
    $total_playlists = $count_playlists->rowCount();
 
    $count_contents = $cBD->prepare("SELECT * FROM `contenido` WHERE tutor_id = ?");
    $count_contents->execute([$tutor_id]);
    $total_contents = $count_contents->rowCount();
 
    $count_likes = $cBD->prepare("SELECT * FROM `likes` WHERE tutor_id = ?");
    $count_likes->execute([$tutor_id]);
    $total_likes = $count_likes->rowCount();
 
    $count_comments = $cBD->prepare("SELECT * FROM `comentario` WHERE tutor_id = ?");
    $count_comments->execute([$tutor_id]);
    $total_comments = $count_comments->rowCount();
 
 }else{
    header('location:profesor.php');
 }
 
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title> Perfil Profesor</title>
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
        <div class="text">Perfil Profesor</div>
        

        <!-- perfil profesor -->
<section class="perfil">

   <h1 class="heading">Detalles del Perfil</h1>

   <div class="detalles">
      <div class="profesor">
         <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
         <h3><?= $fetch_tutor['name']; ?></h3>
         <span><?= $fetch_tutor['profession']; ?></span>
      </div>
      <div class="flex">
         <p>total playlists : <span><?= $total_playlists; ?></span></p>
         <p>total videos : <span><?= $total_contents; ?></span></p>
         <p>total likes : <span><?= $total_likes; ?></span></p>
         <p>total comments : <span><?= $total_comments; ?></span></p>
      </div>
   </div>

</section>


        <!-- perfil profesor final -->

                <!-- section curso -->
<section class="curso">

<h1 class="heading">último curso</h1>

<div class="caja-container">

   <?php
      $select_courses = $cBD->prepare("SELECT * FROM `playlist` WHERE tutor_id = ? AND status = ?");
      $select_courses->execute([$tutor_id, 'activo']);
      if($select_courses->rowCount() > 0){
         while($fetch_course = $select_courses->fetch(PDO::FETCH_ASSOC)){
            $course_id = $fetch_course['id'];

            $count_course = $cBD->prepare("SELECT * FROM `contenido` WHERE playlist_id = ?");
            $count_course->execute([$course_id]);
            $total_courses = $count_course->rowCount();

            $select_tutor = $cBD->prepare("SELECT * FROM `profesor` WHERE id = ?");
            $select_tutor->execute([$fetch_course['tutor_id']]);
            $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
   ?>
   <div class="caja">
      <div class="profesor">
         <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
         <div>
            <h3><?= $fetch_tutor['name']; ?></h3>
            <span><?= $fetch_course['date']; ?></span>
         </div>
      </div>
      <div class="thumb">
      <span><?= $total_courses ?></span>
      <img src="uploaded_files/<?= $fetch_course['thumb']; ?>" alt="">
      </div>
      <h3 class="titulo"><?= $fetch_course['title']; ?></h3>
      <a href="playlist.php?get_id=<?= $course_id; ?>" class="inline-btn">ver playlist</a>
   </div>
   <?php
      }
   }else{
      echo '<p class="empty">¡Aún no hay cursos añadidos!</p>';
   }
   ?>

</div>

</section>

                <!-- section curso final -->

     <!-- footer section starts  -->
     <?php include 'componentes/footer.php'; ?>
    <!-- footer section ends -->

    </div>



    <script src="js/menu.js"></script>


</body>

</html>