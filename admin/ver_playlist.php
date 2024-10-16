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

      $message[] = 'video deleted!';
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
    <title>Detalles</title>
</head>
<body>
    
    <!-- sidebar -->

    <?php include '../componentes/admin_header.php'; ?>


<!-- Dashboard section -->

<div class="home_content">
<div class="text">Detalles de Videos</div>


<section class="playlist-detalles">


<?php
         $select_playlist = $cBD->prepare("SELECT * FROM `playlist` WHERE id = ? LIMIT 1");
         $select_playlist->execute([$get_id]);
         if($select_playlist->rowCount() > 0){
         while($fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC)){
            $count_content = $cBD->prepare("SELECT * FROM `contenido` WHERE playlist_id = ?");
            $count_content->execute([$get_id]);
            $total_contents = $count_content->rowCount();
      ?>

      <div class="row">

      <div class="thumb">
        <span><?= $total_contents; ?></span>
        <img src="../uploaded_files/<?= $fetch_playlist['thumb'];?>" alt="">
        <div class="flex">
            <p><i class="fas fa-video"></i><span> <?= $total_contents; ?></span></p>
            <p><i class="fas fa-calendar"></i><span> <?= $fetch_playlist['date'];?></span></p>
        </div>
    </div>

      <div class="detalles">

            <h3 class="titulo"><?= $fetch_playlist['title'];?></h3>
            <p class="descripcion"><?= $fetch_playlist['description'];?></p>
            <form action="" method="post" class="flex-btn">

            <input type="hidden" name="delete_id" value="<?= $fetch_playlist['id'];?>">

            <a href="update_playlist.php?get_id=<?= $fetch_playlist['id'];?>" class="opcion-btn" >Actualizar</a>

            <input type="submit" value="eliminar" class="eliminar-btn" name="delete">

            </form>
      </div>

      </div>

<?php
      } 
   }else{
      echo '<p class="empty">¡No se encontró la lista de reproducción!</p>';
   }
   ?>

</section>

<section class="contenido">

   <h1 class="heading">Contenido</h1>

   <div class="caja-container">

   <?php
      $select_content = $cBD->prepare("SELECT * FROM `contenido` WHERE tutor_id = ? AND playlist_id = ?");
      $select_content->execute([$tutor_id, $get_id]);
      if($select_content->rowCount() > 0){
         while($fecth_content = $select_content->fetch(PDO::FETCH_ASSOC)){ 
            $video_id = $fecth_content['id'];
   ?>
      <div class="caja">
         <div class="flex">
            <div> <i class="fas fa-dot-circle" style="<?php if($fecth_content['status'] == 'activo'){echo 'color:limegreen'; }else{echo 'color:red';} ?>"></i><span style=" <?php if($fecth_content['status'] == 'activo'){echo 'color:limegreen'; }else{echo 'color:red';} ?>"> <?= $fecth_content['status']; ?></span></div>
            <div><i class="fas fa-calendar"></i><span> <?= $fecth_content['date']; ?></span></div>
         </div>
         <img src="../uploaded_files/<?= $fecth_content['thumb']; ?>" class="thumb" alt="">
         <h3 class="titulo"><?= $fecth_content['title']; ?></h3>
         <a href="ver_contenido.php?get_id=<?= $fecth_content['id']; ?>" class="btn">ver video</a>
         <form action="" method="post" class="flex-btn">
            <input type="hidden" name="content_id" value="<?= $fecth_content['id']; ?>">
            <a href="update_contenido.php?get_id=<?= $fecth_content['id']; ?>" class="opcion-btn">actualizar</a>
            <input type="submit" value="eliminar" class="eliminar-btn" onclick="return confirm('delete this playlist?');" name="delete_content">
         </form>
      </div>
   <?php
         }
      }else{
        echo '<p class="empty">¡Aún no hay videos añadidos! <a href="agregar_contenido.php" class="btn" style="margin-top: 1.5rem;">agregar videos</a></p>';
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