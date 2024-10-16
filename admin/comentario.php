<?php

include '../componentes/conexion.php';

if(isset($_COOKIE['tutor_id'])){
   $tutor_id = $_COOKIE['tutor_id'];
}else{
   $tutor_id = '';
   header('location:login.php');
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
    <title>Comentario</title>
</head>
<body>
    
    <!-- sidebar -->

    <?php include '../componentes/admin_header.php'; ?>


<!-- Dashboard section -->

<div class="home_content">
<div class="text">Comentario</div>

<section class="comentario">

   <h1 class="heading">Comentario de Usuarios</h1>

   
   <div class="show-comentario">
      <?php
         $select_comments = $cBD->prepare("SELECT * FROM `comentario` WHERE tutor_id = ?");
         $select_comments->execute([$tutor_id]);
         if($select_comments->rowCount() > 0){
            while($fetch_comment = $select_comments->fetch(PDO::FETCH_ASSOC)){   
               $comment_id = $fetch_comment['id'];

               $select_commentor = $cBD->prepare("SELECT * FROM `usuario` WHERE id = ?");
               $select_commentor->execute([$fetch_comment['user_id']]);
               $fetch_commentor = $select_commentor->fetch(PDO::FETCH_ASSOC);
      
               $select_content = $cBD->prepare("SELECT * FROM `contenido` WHERE id = ?");
               $select_content->execute([$fetch_comment['content_id']]);
               $fetch_content = $select_content->fetch(PDO::FETCH_ASSOC);
      ?>
      <div class="caja">
        <div class="comentario-contenido"><p><?= $fetch_content['title']; ?></p><a href="ver_contenido.php?get_id=<?= $fetch_content['id']; ?>">ver contenido</a></div>
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
            <button type="submit" name="delete_comment" class="inline-eliminar-btn">Elimnar comentario</button>
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