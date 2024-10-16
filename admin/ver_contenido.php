<?php

include '../componentes/conexion.php';

if(isset($_COOKIE['tutor_id'])){
   $tutor_id = $_COOKIE['tutor_id'];
}else{
   $tutor_id = '';
   header('location:login.php');
}

if(isset($_GET['get_id'])){
   $get_id = $_GET['get_id'];
}else{
   $get_id = '';
   header('location:contenidos.php');
}

if(isset($_POST['delete_content'])){
   $delete_id = $_POST['content_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
   $verify_content = $cBD->prepare("SELECT * FROM `contenido` WHERE id = ? LIMIT 1");
   $verify_content->execute([$delete_id]);
   if($verify_content->rowCount() > 0){
      $fecth_content = $verify_content->fetch(PDO::FETCH_ASSOC);
      unlink('../uploaded_files/'.$fecth_content['thumb']);
      unlink('../uploaded_files/'.$fecth_content['video']);

      $delete_comments = $cBD->prepare("DELETE FROM `comentario` WHERE content_id = ?");
      $delete_comments->execute([$delete_id]);

      $delete_likes = $cBD->prepare("DELETE FROM `likes` WHERE content_id = ?");
      $delete_likes->execute([$delete_id]);

      $delete_content = $cBD->prepare("DELETE FROM `contenido` WHERE id = ?");
      $delete_content->execute([$delete_id]);

      header('location:contenidos.php');
   }else{
      $message[] = 'video already deleted!';
   }

}

if(isset($_POST['delete_comment'])){

   $delete_id = $_POST['comment_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $verify_comment = $cBD->prepare("SELECT * FROM `comentario` WHERE id = ?");
   $verify_comment->execute([$delete_id]);

   if($verify_comment->rowCount() > 0){
      $delete_comment = $cBD->prepare("DELETE FROM `comentario` WHERE id = ?");
      $delete_comment->execute([$delete_id]);
      $message[] = 'comment deleted successfully!';
   }else{
      $message[] = 'comment already deleted!';
   }

}
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
    <title>Contenido</title>
</head>
<body>
    
    <!-- sidebar -->

    <?php include '../componentes/admin_header.php'; ?>


<!-- Dashboard section -->

<div class="home_content">
<div class="text">Ver Contenido</div>

<section class="ver-contenido">

   <?php
      $select_content = $cBD->prepare("SELECT * FROM `contenido` WHERE id = ? ORDER BY date DESC");
      $select_content->execute([$get_id]);
      if($select_content->rowCount() > 0){
         while($fetch_content = $select_content->fetch(PDO::FETCH_ASSOC)){
            $content_id = $fetch_content['id'];

            $count_likes = $cBD->prepare("SELECT * FROM `likes` WHERE tutor_id = ? AND content_id = ?");
            $count_likes->execute([$tutor_id, $content_id]);
            $total_likes = $count_likes->rowCount();

            $count_comentario = $cBD->prepare("SELECT * FROM `comentario` WHERE tutor_id = ? AND content_id = ?");
            $count_comentario->execute([$tutor_id, $content_id]);
            $total_comentarios = $count_comentario->rowCount();

   ?>
   <div class="container">
      <video src="../uploaded_files/<?= $fetch_content['video']; ?>" autoplay controls poster="../uploaded_files/<?= $fetch_content['thumb']; ?>" class="video"></video>
      <div class="date"><i class="fas fa-calendar"></i><span><?= $fetch_content['date']; ?></span></div>
      <h3 class="titulo"><?= $fetch_content['title']; ?></h3>
      <div class="flex">
         <div><i class="fas fa-heart"></i><span><?= $total_likes; ?></span></div>
         <div><i class="fas fa-comment"></i><span><?= $total_comentarios; ?></span></div>
      </div>
      <div class="descripcion"><?= $fetch_content['description']; ?></div>
      <form action="" method="post">
         <div class="flex-btn">
            <input type="hidden" name="content_id" value="<?= $content_id; ?>">
            <a href="update_contenido.php?get_id=<?= $content_id; ?>" class="opcion-btn">Actualizar</a>
            <input type="submit" value="Eliminar" class="eliminar-btn" onclick="return confirm('delete this contenido?');" name="delete_content">
         </div>
      </form>
   </div>
   <?php
    }
   }else{
      echo '<p class="empty">¡Aún no hay contenidos añadidos! <a href="add_content.php" class="btn" style="margin-top: 1.5rem;">add videos</a></p>';
   }
      
   ?>

</section>

<section class="comentario">

   <h1 class="heading">Comentario de Usuarios</h1>

   
   <div class="show-comentario">
      <?php
         $select_comments = $cBD->prepare("SELECT * FROM `comentario` WHERE content_id = ? AND tutor_id = ?");
         $select_comments->execute([$get_id, $tutor_id]);
         if($select_comments->rowCount() > 0){
            while($fetch_comment = $select_comments->fetch(PDO::FETCH_ASSOC)){   
               $comment_id = $fetch_comment['id'];
               $select_commentor = $cBD->prepare("SELECT * FROM `usuario` WHERE id = ?");
               $select_commentor->execute([$fetch_comment['user_id']]);
               $fetch_commentor = $select_commentor->fetch(PDO::FETCH_ASSOC);
      ?>
      <div class="caja">
         <div class="usuario">
            <img src="../uploaded_files/<?= $fetch_commentor['image']; ?>" alt="">
            <div>
               <h3><?= $fetch_commentor['name']; ?></h3>
               <span><?= $fetch_comment['date']; ?></span>
            </div>
         </div>
         <p class="texto"><?= $fetch_comment['comment']; ?></p>
         <form action="" method="post" class="flex-btn">
            <input type="hidden" name="comment_id" value="<?= $fetch_comment['id']; ?>">
            <button type="submit" name="delete_comment" class="inline-eliminar-btn">Elimnar Comentario</button>
         </form>
      </div>
      <?php
       }
      }else{
         echo '<p class="empty">¡Aún no hay comentarios añadidos!</p>';
      }
      ?>
      </div>
   
</section>






    <!-- footer -->

    <?php include '../componentes/footer.php'; ?>

    </div>

    <script src="../js/admin_script.js"></script>
</body>
</html>