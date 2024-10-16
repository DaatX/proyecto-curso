<?php

include '../componentes/conexion.php';

if(isset($_COOKIE['tutor_id'])){
   $tutor_id = $_COOKIE['tutor_id'];
}else{
   $tutor_id = '';
   header('location:login.php');
}

if(isset($_POST['submit'])){

    $id = unique_id();
    $status = $_POST['status'];
    $status = filter_var($status, FILTER_SANITIZE_STRING);
    $title = $_POST['title'];
    $title = filter_var($title, FILTER_SANITIZE_STRING);
    $description = $_POST['description'];
    $description = filter_var($description, FILTER_SANITIZE_STRING);
    $playlist_id = $_POST['playlist_id'];
    $playlist_id = filter_var($playlist_id, FILTER_SANITIZE_STRING);
 
    $thumb = $_FILES['thumb']['name'];
    $thumb = filter_var($thumb, FILTER_SANITIZE_STRING);
    $thumb_ext = pathinfo($thumb, PATHINFO_EXTENSION);
    $rename_thumb = unique_id().'.'.$thumb_ext;
    $thumb_size = $_FILES['thumb']['size'];
    $thumb_tmp_name = $_FILES['thumb']['tmp_name'];
    $thumb_folder = '../uploaded_files/'.$rename_thumb;


    $video = $_FILES['video']['name'];
    $video = filter_var($video, FILTER_SANITIZE_STRING);
    $video_ext = pathinfo($video, PATHINFO_EXTENSION);
    $rename_video = unique_id().'.'.$video_ext;
    $video_tmp_name = $_FILES['video']['tmp_name'];
    $video_folder = '../uploaded_files/'.$rename_video;

     
    $verify_content = $cBD->prepare("SELECT * FROM `contenido` WHERE tutor_id = ? AND title = ? AND description = ?");
    $verify_content->execute([$tutor_id, $title, $description]);

    if($verify_content->rowCount() > 0){
        $message[] = 'contenido ya creado';

    }else{
       $add_content = $cBD->prepare("INSERT INTO `contenido` (id, tutor_id, playlist_id, title, description, video, thumb, status) VALUES(?,?,?,?,?,?,?,?)");
       $add_content->execute([$id, $tutor_id, $playlist_id, $title, $description, $rename_video, $rename_thumb, $status]);
       move_uploaded_file($thumb_tmp_name, $thumb_folder);
       move_uploaded_file($video_tmp_name, $video_folder);
       $message[] = 'new course uploaded!';
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
    <title>Agregar Contenido</title>
</head>
<body>
    
    <!-- sidebar -->

    <?php include '../componentes/admin_header.php'; ?>


<!-- Dashboard section -->

<div class="home_content">
<div class="text">Agregar Contenido</div>

<section class="crud-form">

   <form action="" method="post" enctype="multipart/form-data">
      <p>video status <span>*</span></p>
      <select name="status" class="caja" required>
         <option value="" selected disabled>-- selecionar status</option>
         <option value="activo">activo</option>
         <option value="desactivo">desactivo</option>
      </select>
      <p>Titulo Video <span>*</span></p>
      <input type="text" name="title" maxlength="100" required placeholder="enter video title" class="caja">
      <p> Descripcion video<span>*</span></p>
      <textarea name="description" class="caja" required placeholder="write description" maxlength="1000" cols="30" rows="10"></textarea>
      <p>video playlist <span>*</span></p>
      <select name="playlist_id" class="caja" required>
         <option value="" disabled selected>--select playlist</option>
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
      <p>selecionar Imagen <span>*</span></p>
      <input type="file" name="thumb" accept="image/*" required class="caja">
      <p>selecionar video <span>*</span></p>
      <input type="file" name="video" accept="video/*" required class="caja">
      <input type="submit" value="subir video" name="submit" class="btn">
   </form>

</section>




    <!-- footer -->

    <?php include '../componentes/footer.php'; ?>

    </div>

    <script src="../js/admin_script.js"></script>
</body>
</html>