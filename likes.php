<?php

include 'componentes/conexion.php';

if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
 }else{
    $user_id = '';
    header('location:index.php');
 }

 if(isset($_POST['remove'])){

    if($user_id != ''){
       $content_id = $_POST['content_id'];
       $content_id = filter_var($content_id, FILTER_SANITIZE_STRING);
 
       $verify_likes = $cBD->prepare("SELECT * FROM `likes` WHERE user_id = ? AND content_id = ?");
       $verify_likes->execute([$user_id, $content_id]);
 
       if($verify_likes->rowCount() > 0){
          $remove_likes = $cBD->prepare("DELETE FROM `likes` WHERE user_id = ? AND content_id = ?");
          $remove_likes->execute([$user_id, $content_id]);
          $message[] = '¡Eliminado de me gusta!';
       }
    }else{
       $message[] = '¡Por favor inicia sesión primero!';
    }
 
 }

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title> Likes</title>
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
<div class="text">Videos que me gustaron</div>


<section class="liked-videos">



   <div class="caja-container">

   <?php
      $select_likes = $cBD->prepare("SELECT * FROM `likes` WHERE user_id = ?");
      $select_likes->execute([$user_id]);
      if($select_likes->rowCount() > 0){
         while($fetch_likes = $select_likes->fetch(PDO::FETCH_ASSOC)){

            $select_contents = $cBD->prepare("SELECT * FROM `contenido` WHERE id = ? ORDER BY date DESC");
            $select_contents->execute([$fetch_likes['content_id']]);

            if($select_contents->rowCount() > 0){
               while($fetch_contents = $select_contents->fetch(PDO::FETCH_ASSOC)){

               $select_tutors = $cBD->prepare("SELECT * FROM `profesor` WHERE id = ?");
               $select_tutors->execute([$fetch_contents['tutor_id']]);
               $fetch_tutor = $select_tutors->fetch(PDO::FETCH_ASSOC);
   ?>
   <div class="caja">
      <div class="profesor">
         <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
         <div>
            <h3><?= $fetch_tutor['name']; ?></h3>
            <span><?= $fetch_contents['date']; ?></span>
         </div>
      </div>
      <img src="uploaded_files/<?= $fetch_contents['thumb']; ?>" alt="" class="thumb">
      <h3 class="titulo"><?= $fetch_contents['title']; ?></h3>
      <form action="" method="post" class="flex-btn">
         <input type="hidden" name="content_id" value="<?= $fetch_contents['id']; ?>">
         <a href="ver-video.php?get_id=<?= $fetch_contents['id']; ?>" class="inline-btn">Ver videos</a>
         <input type="submit" value="Eliminar" class="inline-eliminar-btn" onclick="return confirm('delete this likes?');" name="remove">
      </form>
   </div>
   <?php
            }
         }else{
            echo '<p class="emtpy">content was not found!</p>';         
         }
      }
   }else{
      echo '<p class="empty">nothing added to likes yet!</p>';
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