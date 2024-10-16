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
    header('location:contents.php');
 }

 if(isset($_POST['update'])){

    $status = $_POST['status'];
    $status = filter_var($status, FILTER_SANITIZE_STRING);
    $title = $_POST['title'];
    $title = filter_var($title, FILTER_SANITIZE_STRING);
    $description = $_POST['description'];
    $description = filter_var($description, FILTER_SANITIZE_STRING);
    $playlist_id = $_POST['playlist_id'];
    $playlist_id = filter_var($playlist_id, FILTER_SANITIZE_STRING);
 
    $update_content = $cBD->prepare("UPDATE `contenido` SET title = ?, description = ?, status = ? WHERE id = ?");
    $update_content->execute([$title, $description, $status, $get_id]);
 
    if(!empty($playlist_id)){
       $update_playlist = $cBD->prepare("UPDATE `contenido` SET playlist_id = ? WHERE id = ?");
       $update_playlist->execute([$playlist_id, $get_id]);
    }
 
    $old_thumb = $_POST['old_thumb'];
    $old_thumb = filter_var($old_thumb, FILTER_SANITIZE_STRING);
    $thumb = $_FILES['thumb']['name'];
    $thumb = filter_var($thumb, FILTER_SANITIZE_STRING);
    $thumb_ext = pathinfo($thumb, PATHINFO_EXTENSION);
    $rename_thumb = unique_id().'.'.$thumb_ext;
    $thumb_size = $_FILES['thumb']['size'];
    $thumb_tmp_name = $_FILES['thumb']['tmp_name'];
    $thumb_folder = '../uploaded_files/'.$rename_thumb;
 
    if(!empty($thumb)){
       if($thumb_size > 2000000){
          $message[] = 'image size is too large!';
       }else{
          $update_thumb = $cBD->prepare("UPDATE `contenido` SET thumb = ? WHERE id = ?");
          $update_thumb->execute([$rename_thumb, $get_id]);
          move_uploaded_file($thumb_tmp_name, $thumb_folder);
          if($old_thumb != '' AND $old_thumb != $rename_thumb){
             unlink('../uploaded_files/'.$old_thumb);
          }
       }
    }
 
    $old_video = $_POST['old_video'];
    $old_video = filter_var($old_video, FILTER_SANITIZE_STRING);
    $video = $_FILES['video']['name'];
    $video = filter_var($video, FILTER_SANITIZE_STRING);
    $video_ext = pathinfo($video, PATHINFO_EXTENSION);
    $rename_video = unique_id().'.'.$video_ext;
    $video_tmp_name = $_FILES['video']['tmp_name'];
    $video_folder = '../uploaded_files/'.$rename_video;
 
    if(!empty($video)){
       $update_video = $cBD->prepare("UPDATE `contenido` SET video = ? WHERE id = ?");
       $update_video->execute([$rename_video, $get_id]);
       move_uploaded_file($video_tmp_name, $video_folder);
       if($old_video != '' AND $old_video != $rename_video){
          unlink('../uploaded_files/'.$old_video);
       }
    }
 
    $message[] = 'content updated!';
 
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
    <title>Actualizart</title>
</head>
<body>
    
    <!-- sidebar -->

    <?php include '../componentes/admin_header.php'; ?>


<!-- Dashboard section -->

<div class="home_content">
<div class="text">Actualizar Contenido</div>


<section class="crud-form">


   <?php
      $select_content = $cBD->prepare("SELECT * FROM `contenido` WHERE id = ?");
      $select_content->execute([$get_id]);
      if($select_content->rowCount() > 0){
         while($fecth_content = $select_content->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="content_id" value="<?= $fecth_content['id']; ?>">
      <input type="hidden" name="old_thumb" value="<?= $fecth_content['thumb']; ?>">
      <input type="hidden" name="old_video" value="<?= $fecth_content['video']; ?>">
      <p>actualizar status <span>*</span></p>
      <select name="status" class="caja" required>
         <option value="<?= $fecth_content['status']; ?>" selected><?= $fecth_content['status']; ?></option>
         <option value="activo">activo</option>
         <option value="desactivado">desactivado</option>
      </select>
      <p>actualizar titulo <span>*</span></p>
      <input type="text" name="title" maxlength="100" required placeholder="enter video title" class="caja" value="<?= $fecth_content['title']; ?>">
      <p>actualizar descripcion <span>*</span></p>
      <textarea name="description" class="caja" required placeholder="write description" maxlength="1000" cols="30" rows="10"><?= $fecth_content['description']; ?></textarea>
      <p>actualizar playlist</p>
      <select name="playlist_id" class="caja">
         <option value="<?= $fecth_content['playlist_id']; ?>" selected>--select playlist</option>
         <?php
         $select_playlists = $cBD->prepare("SELECT * FROM `playlist` WHERE tutor_id = ?");
         $select_playlists->execute([$tutor_id]);
         if($select_playlists->rowCount() > 0){
            while($fetch_playlist = $select_playlists->fetch(PDO::FETCH_ASSOC)){
         ?>
         <option value="<?= $fetch_playlist['id']; ?>"><?= $fetch_playlist['title']; ?></option>
         <?php
            }
         ?>
         <?php
         }else{
            echo '<option value="" disabled>¡Aún no se ha creado ninguna lista de reproducción!</option>';
         }
         ?>
      </select>
      <img src="../uploaded_files/<?= $fecth_content['thumb']; ?>" class="media" alt="">
      <p>actualizar Imagen</p>
      <input type="file" name="thumb" accept="image/*" class="caja">
      <video src="../uploaded_files/<?= $fecth_content['video']; ?>" controls class="media"></video>
      <p>actualizar video</p>
      <input type="file" name="video" accept="video/*" class="caja">
      <input type="submit" value="Actualizar" name="update" class="btn">
      <div class="flex-btn">
         <a href="ver_contenido.php?get_id=<?= $get_id; ?>" class="opcion-btn">Ver contenido</a>
         <input type="submit" value="Eliminar" name="delete_content" onclick="return confirm('delete this contenido?');" class="eliminar-btn">
      </div>
   </form>
   <?php
         }
      }else{
         echo '<p class="empty">¡Video no encontrado! <a href="add_content.php" class="btn" style="margin-top: 1.5rem;">add videos</a></p>';
      }
   ?>

</section>




    <!-- footer -->

    <?php include '../componentes/footer.php'; ?>

    </div>

    <script src="../js/admin_script.js"></script>
</body>
</html>