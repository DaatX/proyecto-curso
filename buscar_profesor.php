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
    <title> Busqueda Profesor</title>
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
        <div class="text">Profesores Expertos</div>
        

        <!-- profesor  -->

        <section class="profesores">



<form action="" method="post" class="buscar-profesor">
   <input type="text" name="search_tutor" maxlength="100" placeholder="search tutor..." required>
   <button type="submit" name="search_tutor_btn" class="fas fa-search"></button>
</form>

<div class="caja-container">

   <?php
      if(isset($_POST['search_tutor']) or isset($_POST['search_tutor_btn'])){
         $search_tutor = $_POST['search_tutor'];
         $select_tutors = $cBD->prepare("SELECT * FROM `profesor` WHERE name LIKE '%{$search_tutor}%'");
         $select_tutors->execute();
         if($select_tutors->rowCount() > 0){
            while($fetch_tutor = $select_tutors->fetch(PDO::FETCH_ASSOC)){

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
   ?>
   <div class="caja">
      <div class="profesor">
         <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
         <div>
            <h3><?= $fetch_tutor['name']; ?></h3>
            <span><?= $fetch_tutor['profession']; ?></span>
         </div>
      </div>
      <p>playlists : <span><?= $total_playlists; ?></span></p>
      <p>total videos : <span><?= $total_contents ?></span></p>
      <p>total likes : <span><?= $total_likes ?></span></p>
      <p>total comments : <span><?= $total_comments ?></span></p>
      <form action="perfil_profesor.php" method="post">
         <input type="hidden" name="tutor_email" value="<?= $fetch_tutor['email']; ?>">
         <input type="submit" value="Ver perfil" name="tutor_fetch" class="inline-btn">
      </form>
   </div>
   <?php
            }
         }else{
            echo '<p class="empty">¡No se encontraron resultados!</p>';
         }
      }else{
         echo '<p class="empty">¡Por favor busca algo!</p>';
      }
   ?>

</div>

</section>

        <!-- profesor final -->

     <!-- footer section starts  -->
     <?php include 'componentes/footer.php'; ?>
    <!-- footer section ends -->

    </div>



    <script src="js/menu.js"></script>


</body>

</html>