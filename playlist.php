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

 if(isset($_POST['save_list'])){

    if($user_id != ''){
       
       $list_id = $_POST['list_id'];
       $list_id = filter_var($list_id, FILTER_SANITIZE_STRING);
 
       $select_list = $cBD->prepare("SELECT * FROM `bookmark` WHERE user_id = ? AND playlist_id = ?");
       $select_list->execute([$user_id, $list_id]);
 
       if($select_list->rowCount() > 0){
          $remove_bookmark = $cBD->prepare("DELETE FROM `bookmark` WHERE user_id = ? AND playlist_id = ?");
          $remove_bookmark->execute([$user_id, $list_id]);
          $message[] = 'playlist eliminado!';
       }else{
          $insert_bookmark = $cBD->prepare("INSERT INTO `bookmark`(user_id, playlist_id) VALUES(?,?)");
          $insert_bookmark->execute([$user_id, $list_id]);
          $message[] = 'playlist Guardado!';
       }
 
    }else{
       $message[] = 'Por favor, inicie sesión primero!';
    }
 
 }

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title> Playlist</title>
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
        <div class="text">Lista de Reproducción</div>
        
<!-- lista reproduccion -->
<section class="playlist">

<h1 class="heading">detalles playlist</h1>

<div class="row">

   <?php
      $select_playlist = $cBD->prepare("SELECT * FROM `playlist` WHERE id = ? and status = ? LIMIT 1");
      $select_playlist->execute([$get_id, 'activo']);
      if($select_playlist->rowCount() > 0){
         $fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC);

         $playlist_id = $fetch_playlist['id'];

         $count_videos = $cBD->prepare("SELECT * FROM `contenido` WHERE playlist_id = ?");
         $count_videos->execute([$playlist_id]);
         $total_videos = $count_videos->rowCount();

         $select_tutor = $cBD->prepare("SELECT * FROM `profesor` WHERE id = ? LIMIT 1");
         $select_tutor->execute([$fetch_playlist['tutor_id']]);
         $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);

         $select_bookmark = $cBD->prepare("SELECT * FROM `bookmark` WHERE user_id = ? AND playlist_id = ?");
         $select_bookmark->execute([$user_id, $playlist_id]);

   ?>

   <div class="col">
      <form action="" method="post" class="save-list">
         <input type="hidden" name="list_id" value="<?= $playlist_id; ?>">
         <?php
            if($select_bookmark->rowCount() > 0){
         ?>
         <button type="submit" name="save_list"><i class="fas fa-bookmark"></i><span>saved</span></button>
         <?php
            }else{
         ?>
            <button type="submit" name="save_list"><i class="far fa-bookmark"></i><span>save playlist</span></button>
         <?php
            }
         ?>
      </form>
      <div class="thumb">
         <span><?= $total_videos; ?> videos</span>
         <img src="uploaded_files/<?= $fetch_playlist['thumb']; ?>" alt="">
      </div>
   </div>

   <div class="col">
      <div class="profesor">
         <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
         <div>
            <h3><?= $fetch_tutor['name']; ?></h3>
            <span><?= $fetch_tutor['profession']; ?></span>
         </div>
      </div>
      <div class="detalles">
         <h3><?= $fetch_playlist['title']; ?></h3>
         <p><?= $fetch_playlist['description']; ?></p>
         <div class="date"><i class="fas fa-calendar"></i><span><?= $fetch_playlist['date']; ?></span></div>
      </div>
   </div>

   <?php
      }else{
         echo '<p class="empty">¡Esta lista de reproducción no fue encontrada!</p>';
      }  
   ?>

</div>

</section>

<!-- lsita reproduccion final -->

        <!-- section video contenido  -->
<section class="videos-container">

<h1 class="heading">playlist videos</h1>

<div class="caja-container">

   <?php
      $select_content = $cBD->prepare("SELECT * FROM `contenido` WHERE playlist_id = ? AND status = ? ORDER BY date DESC");
      $select_content->execute([$get_id, 'activo']);
      if($select_content->rowCount() > 0){
         while($fetch_content = $select_content->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <a href="ver-video.php?get_id=<?= $fetch_content['id']; ?>" class="caja">
      <i class="fas fa-play"></i>
      <img src="uploaded_files/<?= $fetch_content['thumb']; ?>" alt="">
      <h3><?= $fetch_content['title']; ?></h3>
   </a>
   <?php
         }
      }else{
         echo '<p class="empty">¡Aún no hay videos añadidos!</p>';
      }
   ?>

</div>

</section>


        <!-- video contenido final -->

    <!-- footer section starts  -->
    <?php include 'componentes/footer.php'; ?>
    <!-- footer section ends -->

    </div>



    <script src="js/menu.js"></script>


</body>

</html>