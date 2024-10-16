<?php

include 'componentes/conexion.php';

if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
 }else{
    $user_id = '';
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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Home </title>
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
<div class="text">home</div>

<!-- quick select section starts  -->

<section class="quick-select">

   <h1 class="heading">Opciones rápidas</h1>

   <div class="caja-container">

      <?php
         if($user_id != ''){
      ?>
      <div class="caja">
         <h3 class="titulo">likes y comentarios</h3>

         <p>total likes : <span><?= $total_likes; ?></span></p>
         <a href="likes.php" class="inline-btn">ver likes</a>

         <p>total comentarios : <span><?= $total_comments; ?></span></p>
         <a href="comentario.php" class="inline-btn">ver comentarios</a>

         <p>playlist guardado: <span><?= $total_bookmarked; ?></span></p>
         <a href="bookmark.php" class="inline-btn">ver bookmark</a>
      </div>
      <?php
         }else{ 
      ?>
      <div class="caja" style="text-align: center;">
         <h3 class="titulo">please login or register</h3>
          <div class="flex-btn" style="padding-top: .5rem;">
            <a href="login.php" class="opcion-btn">login</a>
            <a href="registro.php" class="opcion-btn">register</a>
         </div>
      </div>
      <?php
      }
      ?>

      

      <div class="caja">
         <h3 class="titulo">categorías principales</h3>
         <div class="flex">
            <a href="#" ><i class="fas fa-code"></i><span>Desarrolladorw</span></a>
            <a href="#" ><i class="fas fa-chart-simple"></i><span>Diseñador</span></a>
            <a href="#"><i class="fas fa-pen"></i><span>Hacking Etico</span></a>
            <a href="#" ><i class="fas fa-chart-line"></i><span>Marketing</span></a>
         </div>
      </div>

      <div class="caja">
         <h3 class="titulo">temas populares</h3>
         <div class="flex">
            <a href="#" ><i class="fa-solid fa-skull"></i><span>Kali</span></a>
            <a href="#" ><i class="fa-solid fa-pen-nib"></i><span>Photoshop</span></a>
            <a href="#" ><i class="fab fa-js"></i><span>javascript</span></a>
            <a href="#" ><i class="fab fa-react"></i><span>react</span></a>
            <a href="#" ><i class="fab fa-php"></i><span>PHP</span></a>
            <a href="#" ><i class="fab fa-laravel"></i><span>laravel</span></a>
         </div>
      </div>

      <div class="caja profesor">
         <h3 class="titulo">Conviértete en Profesor</h3>
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa, laudantium.</p>
         <a href="admin/registro.php" class="inline-btn">Empezar</a>
      </div>

   </div>

</section>

<!-- quick select section ends -->

<!-- courses section starts  -->

<section class="curso">

   <h1 class="heading">Últimos cursos</h1>

   <div class="caja-container">

      <?php
         $select_courses = $cBD->prepare("SELECT * FROM `playlist` WHERE status = ? ORDER BY date DESC LIMIT 6");
         $select_courses->execute(['activo']);
         if($select_courses->rowCount() > 0){
            while($fetch_course = $select_courses->fetch(PDO::FETCH_ASSOC)){
               $course_id = $fetch_course['id'];

               $count_course = $cBD->prepare("SELECT * FROM `contenido` WHERE playlist_id = ? AND status = ?");
               $count_course->execute([$course_id, 'activo']);
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

   <div class="more-btn">
      <a href="cursos.php" class="inline-opcion-btn">view more</a>
   </div>

</section>

<!-- courses section ends -->




<!-- footer section starts  -->
<?php include 'componentes/footer.php'; ?>
<!-- footer section ends -->

</div>
    <script src="js/menu.js"></script>


</body>

</html>