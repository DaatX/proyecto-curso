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
    header('location:playlists.php');
 }

 if(isset($_POST['update'])){

    $title = $_POST['title'];
    $title = filter_var($title, FILTER_SANITIZE_STRING);
    $description = $_POST['description'];
    $description = filter_var($description, FILTER_SANITIZE_STRING);
    $status = $_POST['status'];
    $status = filter_var($status, FILTER_SANITIZE_STRING);
 
    $update_playlist = $cBD->prepare("UPDATE `playlist` SET title = ?, description = ?, status = ? WHERE id = ?");
    $update_playlist->execute([$title, $description, $status, $get_id]);
 
    $old_thumb = $_POST['old_thumb'];
    $old_thumb = filter_var($old_thumb, FILTER_SANITIZE_STRING);
    $thumb = $_FILES['thumb']['name'];
    $thumb = filter_var($thumb, FILTER_SANITIZE_STRING);
    $ext = pathinfo($thumb, PATHINFO_EXTENSION);
    $rename = unique_id().'.'.$ext;
    $thumb_size = $_FILES['thumb']['size'];
    $thumb_tmp_name = $_FILES['thumb']['tmp_name'];
    $thumb_folder = '../uploaded_files/'.$rename;
 
    if(!empty($thumb)){
       if($thumb_size > 2000000){
          $message[] = 'image size is too large!';
       }else{
          $update_thumb = $cBD->prepare("UPDATE `playlist` SET thumb = ? WHERE id = ?");
          $update_thumb->execute([$rename, $get_id]);
          move_uploaded_file($thumb_tmp_name, $thumb_folder);
          if($old_thumb != '' AND $old_thumb != $rename){
             unlink('../uploaded_files/'.$old_thumb);
          }
       }
    } 
 
    $message[] = 'playlist updated!';  
 
 }

 if(isset($_POST['delete'])){

    $verify_playlist = $cBD->prepare("SELECT * FROM `playlist` WHERE id = ?");
    $verify_playlist->execute([$get_id]);
 
    if($verify_playlist->rowCount() > 0){
 
    
 
    $fetch_thumb = $verify_playlist->fetch(PDO::FETCH_ASSOC);
    $prev_thumb = $fetch_thumb['thumb'];

    if($prev_thumb != ''){

    unlink('../uploaded_files/'.$prev_thumb);

    }

    $delete_bookmark = $cBD->prepare("DELETE FROM `bookmark` WHERE playlist_id = ?");
    $delete_bookmark->execute([$get_id]);
    $delete_playlist = $cBD->prepare("DELETE FROM `playlist` WHERE id = ?");
    $delete_playlist->execute([$get_id]);
    header('location:playlists.php');
    
    }else{
       $message[] = 'playlist already deleted!';
    }
 }

?>

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
    <title>Actualizacion</title>
</head>
<body>
    
    <!-- sidebar -->

    <?php include '../componentes/admin_header.php'; ?>


<!-- Dashboard section -->

<div class="home_content">
<div class="text">Actualizacion de Video</div>

    <section class="crud-form">

    <?php
         $select_playlist = $cBD->prepare("SELECT * FROM `playlist` WHERE id = ?");
         $select_playlist->execute([$get_id]);
         if($select_playlist->rowCount() > 0){
         while($fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC)){
            $playlist_id = $fetch_playlist['id'];
            $count_videos = $cBD->prepare("SELECT * FROM `content` WHERE playlist_id = ?");
            $count_videos->execute([$playlist_id]);
            $total_videos = $count_videos->rowCount();
      ?>

    <form action="" method="post" enctype="multipart/form-data">

    <input type="hidden" name="old_thumb" value="<?= $fetch_playlist['thumb']; ?>">

    <p>Estado de video </p>
    <select name="status" class="caja" required>
    <option value="<?= $fetch_playlist['status']; ?>" selected><?= $fetch_playlist['status']; ?></option>
        <option value="activo">Activo</option>
        <option value="desactivado">Desativado</option>
    </select>
        
    <p>Titulo de video </p>
        <input type="text" class="caja" name="title" maxlength="100" required placeholder="titulo de video" value="<?= $fetch_playlist['title']; ?>">
        
        <p>Descripcion de video </p>
        <textarea name="description" class="caja" cols="30" required placeholder="Descripcion de Video" maxlength="1000" rows="10"><?= $fetch_playlist['description']; ?></textarea>

        <p>Foto de video </p>
        <img src="../uploaded_files/<?= $fetch_playlist['thumb']; ?>" class="caja" alt="">
        <input type="file" name="thumb" accept="image/*" class="caja">

        <input type="submit" value="actuzalizar" name="update" class="btn">

        <div class="flex-btn">
            <input type="submit" value="eliminar" name="delete" onclick="return confirm('delete this playlist?');" class="eliminar-btn">
            <a href="ver_playlist.php?get_id=<?= $playlist_id; ?>" class="opcion-btn">ver videos</a>
        </div>

    </form>

    <?php
      } 
   }else{
      echo '<p class="empty">playlist was not found!</p>';
   }
   ?>


    </section>




    <!-- footer -->

    <?php include '../componentes/footer.php'; ?>

    </div>

    <script src="../js/admin_script.js"></script>
</body>
</html>