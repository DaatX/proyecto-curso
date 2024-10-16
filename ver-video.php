<?php

include 'componentes/conexion.php';

if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
 }else{
    $user_id = '';
 }

 if(isset($_GET['get_id'])){
    $get_id = $_GET['get_id'];
 }else{
    $get_id = '';
    header('location:index.php');
 }

 if(isset($_POST['like_content'])){

    if($user_id != ''){
 
       $content_id = $_POST['content_id'];
       $content_id = filter_var($content_id, FILTER_SANITIZE_STRING);
 
       $select_content = $cBD->prepare("SELECT * FROM `contenido` WHERE id = ? LIMIT 1");
       $select_content->execute([$content_id]);
       $fetch_content = $select_content->fetch(PDO::FETCH_ASSOC);
 
       $tutor_id = $fetch_content['tutor_id'];
 
       $select_likes = $cBD->prepare("SELECT * FROM `likes` WHERE user_id = ? AND content_id = ?");
       $select_likes->execute([$user_id, $content_id]);
 
       if($select_likes->rowCount() > 0){
          $remove_likes = $cBD->prepare("DELETE FROM `likes` WHERE user_id = ? AND content_id = ?");
          $remove_likes->execute([$user_id, $content_id]);
          $message[] = '¡Eliminado me gusta!';
       }else{
          $insert_likes = $cBD->prepare("INSERT INTO `likes`(user_id, tutor_id, content_id) VALUES(?,?,?)");
          $insert_likes->execute([$user_id, $tutor_id, $content_id]);
          $message[] = '¡Añadido a me gusta!';
       }
 
    }else{
       $message[] = '¡Por favor inicia sesión primero!';
    }
 
 }

 if(isset($_POST['add_comment'])){

   if($user_id != ''){

      $id = unique_id();
      $comment_box = $_POST['comment_box'];
      $comment_box = filter_var($comment_box, FILTER_SANITIZE_STRING);
      $content_id = $_POST['content_id'];
      $content_id = filter_var($content_id, FILTER_SANITIZE_STRING);

      $select_content = $cBD->prepare("SELECT * FROM `contenido` WHERE id = ? LIMIT 1");
      $select_content->execute([$content_id]);
      $fetch_content = $select_content->fetch(PDO::FETCH_ASSOC);

      $tutor_id = $fetch_content['tutor_id'];

      if($select_content->rowCount() > 0){

         $select_comment = $cBD->prepare("SELECT * FROM `comentario` WHERE content_id = ? AND user_id = ? AND tutor_id = ? AND comment = ?");
         $select_comment->execute([$content_id, $user_id, $tutor_id, $comment_box]);

         if($select_comment->rowCount() > 0){
            $message[] = '¡Comentario ya añadido!';
         }else{
            $insert_comment = $cBD->prepare("INSERT INTO `comentario`(id, content_id, user_id, tutor_id, comment) VALUES(?,?,?,?,?)");
            $insert_comment->execute([$id, $content_id, $user_id, $tutor_id, $comment_box]);
            $message[] = '¡Nuevo comentario añadido!';
         }

      }else{
         $message[] = '¡Algo salió mal!';
      }

   }else{
      $message[] = '¡Por favor inicia sesión primero!';
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
      $message[] = '¡Comentario eliminado exitosamente!';
   }else{
      $message[] = '¡Comentario ya eliminado!';
   }

}

if(isset($_POST['update_now'])){

   $update_id = $_POST['update_id'];
   $update_id = filter_var($update_id, FILTER_SANITIZE_STRING);
   $update_box = $_POST['update_box'];
   $update_box = filter_var($update_box, FILTER_SANITIZE_STRING);

   $verify_comment = $cBD->prepare("SELECT * FROM `comentario` WHERE id = ? AND comment = ?");
   $verify_comment->execute([$update_id, $update_box]);

   if($verify_comment->rowCount() > 0){
      $message[] = '¡Comentario ya añadido!';
   }else{
      $update_comment = $cBD->prepare("UPDATE `comentario` SET comment = ? WHERE id = ?");
      $update_comment->execute([$update_box, $update_id]);
      $message[] = '¡Comentario editado exitosamente!';
   }

}

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title> Videos</title>
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
        <div class="text">Videos</div>

        <?php
   if(isset($_POST['edit_comment'])){
      $edit_id = $_POST['comment_id'];
      $edit_id = filter_var($edit_id, FILTER_SANITIZE_STRING);
      $verify_comment = $cBD->prepare("SELECT * FROM `comentario` WHERE id = ? LIMIT 1");
      $verify_comment->execute([$edit_id]);
      if($verify_comment->rowCount() > 0){
         $fetch_edit_comment = $verify_comment->fetch(PDO::FETCH_ASSOC);
?>
<section class="edita-comentario">
   <h1 class="heading">editar comentario</h1>
   <form action="" method="post">
      <input type="hidden" name="update_id" value="<?= $fetch_edit_comment['id']; ?>">
      <textarea name="update_box" class="caja" maxlength="100000" required placeholder="Por favor ingrese su comentario" cols="30" rows="10"><?= $fetch_edit_comment['comment']; ?></textarea>
      <div class="flex">
         <a href="ver-video.php?get_id=<?= $get_id; ?>" class="inline-opcion-btn">cancelar edición</a>
         <input type="submit" value="Actualizar" name="update_now" class="inline-btn">
      </div>
   </form>
</section>
<?php
   }else{
      $message[] = '¡No se encontró el comentario!';
   }
}
?>
        

        <!-- ver video  -->
<section class="ver-video">

<?php
   $select_content = $cBD->prepare("SELECT * FROM `contenido` WHERE id = ? AND status = ?");
   $select_content->execute([$get_id, 'activo']);
   if($select_content->rowCount() > 0){
      while($fetch_content = $select_content->fetch(PDO::FETCH_ASSOC)){
         $content_id = $fetch_content['id'];

         $select_likes = $cBD->prepare("SELECT * FROM `likes` WHERE content_id = ?");
         $select_likes->execute([$content_id]);
         $total_likes = $select_likes->rowCount();  

         $verify_likes = $cBD->prepare("SELECT * FROM `likes` WHERE user_id = ? AND content_id = ?");
         $verify_likes->execute([$user_id, $content_id]);

         $select_tutor = $cBD->prepare("SELECT * FROM `profesor` WHERE id = ? LIMIT 1");
         $select_tutor->execute([$fetch_content['tutor_id']]);
         $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
?>
<div class="video-detalles">
   <video src="uploaded_files/<?= $fetch_content['video']; ?>" class="video" poster="uploaded_files/<?= $fetch_content['thumb']; ?>" controls autoplay></video>
   <h3 class="titulo"><?= $fetch_content['title']; ?></h3>
   <div class="informacion">
      <p><i class="fas fa-calendar"></i><span><?= $fetch_content['date']; ?></span></p>
      <p><i class="fas fa-heart"></i><span><?= $total_likes; ?> likes</span></p>
   </div>
   <div class="profesor">
      <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
      <div>
         <h3><?= $fetch_tutor['name']; ?></h3>
         <span><?= $fetch_tutor['profession']; ?></span>
      </div>
   </div>
   <form action="" method="post" class="flex">
      <input type="hidden" name="content_id" value="<?= $content_id; ?>">
      <a href="playlist.php?get_id=<?= $fetch_content['playlist_id']; ?>" class="inline-btn">ver playlist</a>
      <?php
         if($verify_likes->rowCount() > 0){
      ?>
      <button type="submit" name="like_content"><i class="fas fa-heart"></i><span>liked</span></button>
      <?php
      }else{
      ?>
      <button type="submit" name="like_content"><i class="far fa-heart"></i><span>like</span></button>
      <?php
         }
      ?>
   </form>
   <div class="descripcion"><p><?= $fetch_content['description']; ?></p></div>
</div>
<?php
      }
   }else{
      echo '<p class="empty">¡Aún no hay videos añadidos!</p>';
   }
?>

</section>


        <!-- ver video final -->

        <!-- comentario -->
<section class="comentario">

<h1 class="heading">añadir un comentario</h1>

<form action="" method="post" class="add-comentario">
   <input type="hidden" name="content_id" value="<?= $get_id; ?>">
   <textarea name="comment_box" required placeholder="Escribe tu comentario..." maxlength="1000" cols="30" rows="10"></textarea>
   <input type="submit" value="add comment" name="add_comment" class="inline-btn">
</form>

<h1 class="heading">comentarios de usuarios</h1>


<div class="ver-comentario">
   <?php
      $select_comments = $cBD->prepare("SELECT * FROM `comentario` WHERE content_id = ?");
      $select_comments->execute([$get_id]);
      if($select_comments->rowCount() > 0){
         while($fetch_comment = $select_comments->fetch(PDO::FETCH_ASSOC)){   
            $select_commentor = $cBD->prepare("SELECT * FROM `usuario` WHERE id = ?");
            $select_commentor->execute([$fetch_comment['user_id']]);
            $fetch_commentor = $select_commentor->fetch(PDO::FETCH_ASSOC);
   ?>
   <div class="caja" style="<?php if($fetch_comment['user_id'] == $user_id){echo 'order:-1;';} ?>">
      <div class="usuario">
         <img src="uploaded_files/<?= $fetch_commentor['image']; ?>" alt="">
         <div>
            <h3><?= $fetch_commentor['name']; ?></h3>
            <span><?= $fetch_comment['date']; ?></span>
         </div>
      </div>
      <p class="texto"><?= $fetch_comment['comment']; ?></p>
      <?php
         if($fetch_comment['user_id'] == $user_id){ 
      ?>
      <form action="" method="post" class="flex-btn">
         <input type="hidden" name="comment_id" value="<?= $fetch_comment['id']; ?>">
         <button type="submit" name="edit_comment" class="inline-opcion-btn">editar comentario</button>
         <button type="submit" name="delete_comment" class="inline-eliminar-btn" onclick="return confirm('delete this comment?');">eliminar comentario</button>
      </form>
      <?php
      }
      ?>
   </div>
   <?php
    }
   }else{
      echo '<p class="empty">¡Aún no hay comentarios añadidos!</p>';
   }
   ?>
   </div>

</section>

        <!-- comentario final -->


    <!-- footer section starts  -->
    <?php include 'componentes/footer.php'; ?>
    <!-- footer section ends -->
    </div>



    <script src="js/menu.js"></script>


</body>

</html>