<?php

include 'componentes/conexion.php';

if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
 }else{
    $user_id = '';
 }

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title> Busqueda</title>
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
        <div class="text">Resultados de la búsqueda</div>
        
<section class="curso">


<div class="caja-container">

   <?php
      if(isset($_POST['search_course']) or isset($_POST['search_course_btn'])){
      $search_course = $_POST['search_course'];
      $select_courses = $cBD->prepare("SELECT * FROM `playlist` WHERE title LIKE '%{$search_course}%' AND status = ?");
      $select_courses->execute(['activo']);
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
      echo '<p class="empty">¡No se encontraron cursos!</p>';
   }
   }else{
      echo '<p class="empty">¡Por favor busca algo!</p>';
   }
   ?>

</div>

</section>




             <!-- footer section starts  -->
     <?php include 'componentes/footer.php'; ?>
    <!-- footer section ends -->

    </div>



    <script src="js/menu.js"></script>


</body>

</html>