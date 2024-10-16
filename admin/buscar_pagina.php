<?php

include '../componentes/conexion.php';

if(isset($_COOKIE['tutor_id'])){
   $tutor_id = $_COOKIE['tutor_id'];
}else{
   $tutor_id = '';
   header('location:login.php');
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
    <title>Busqueda</title>
</head>
<body>
    
    <!-- sidebar -->

    <?php include '../componentes/admin_header.php'; ?>


<!-- Dashboard section -->

<div class="home_content">
<div class="text">Busqueda Encontrado</div>

<section class="contenido">

    <h1 class="heading">Contenido Encontrado</h1>

   <div class="caja-container">

   <?php
  if(isset($_POST['search_box']) or isset ($_POST['search_btn'])){
    $search_box = $_POST['search_box'];
    $select_content = $cBD->prepare("SELECT * FROM `contenido` WHERE title LIKE '%{$search_box}%' AND tutor_id = ? ORDER BY date DESC");
    $select_content->execute([$tutor_id]);
    if($select_content->rowCount() > 0){
       while($fecth_content = $select_content->fetch(PDO::FETCH_ASSOC)){
   ?>
      <div class="caja">
         <div class="flex">
            <div> <i class="fas fa-dot-circle" style="<?php if($fecth_content['status'] == 'activo'){echo 'color:limegreen'; }else{echo 'color:red';} ?>"></i><span style=" <?php if($fecth_content['status'] == 'activo'){echo 'color:limegreen'; }else{echo 'color:red';} ?>"> <?= $fecth_content['status']; ?></span></div>
            <div><i class="fas fa-calendar"></i><span> <?= $fecth_content['date']; ?></span></div>
         </div>
         <img src="../uploaded_files/<?= $fecth_content['thumb']; ?>" class="thumb" alt="">
         <h3 class="titulo"><?= $fecth_content['title']; ?></h3>
         <form action="" method="post" class="flex-btn">
            <input type="hidden" name="content_id" value="<?= $fecth_content['id']; ?>">
            <a href="update_contenido.php?get_id=<?= $fecth_content['id']; ?>" class="opcion-btn">update</a>
            <input type="submit" value="delete" class="eliminar-btn" name="delete_content">
         </form>
         <a href="ver_contenido.php?get_id=<?= $fecth_content['id']; ?>" class="btn">watch video</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">¡No se encontró contenido!</p>';
      }
   }else{
      echo '<p class="empty">¡Por favor busca algo!</p>';
   }
   ?>

   </div>

</section>

<section class="playlists">

    <h1 class="heading">Lista De Reproduccion Encontrado</h1>

    <div class="caja-container">

    <?php
      if(isset($_POST['search_box']) or isset ($_POST['search_btn'])){
        $search_box = $_POST['search_box'];
         $select_playlist = $cBD->prepare("SELECT * FROM `playlist` WHERE title LIKE '%{$search_box}%' AND tutor_id = ? ORDER BY date DESC");
         $select_playlist->execute([$tutor_id]);
         if($select_playlist->rowCount() > 0){
         while($fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC)){
            $playlist_id = $fetch_playlist['id'];
            $count_videos = $cBD->prepare("SELECT * FROM `contenido` WHERE playlist_id = ?");
            $count_videos->execute([$playlist_id]);
            $total_videos = $count_videos->rowCount();


      ?>

            <div class="caja">

                <div class="flex">

                    <div><i class="fas fa-circle-dot" style="<?php if($fetch_playlist['status'] == 'activo'){echo 'color:limegreen'; }else{echo 'color:red';} ?>"></i><span style="<?php if($fetch_playlist['status'] == 'activo'){echo 'color:limegreen'; }else{echo 'color:red';} ?>"><?= $fetch_playlist['status']; ?></span></div>
                    <div><i class="fas fa-calendar"></i><span><?= $fetch_playlist['date']; ?></span></div>
                    
                </div>

                <div class="thumb">
                    <span><?= $total_videos; ?></span>
                    <img src="../uploaded_files/<?= $fetch_playlist['thumb']; ?>" alt="">
                </div>
                <h3 class="titulo"><?= $fetch_playlist['title']; ?></h3>
                <p class="descripcion"><?= $fetch_playlist['description']; ?></p>

                <form action="" method="post" class="flex-btn">

                <input type="hidden" name="delete_id" value="<?= $playlist_id; ?>">

                <a href="update_playlist.php?get_id=<?= $playlist_id; ?>" class="opcion-btn" >Actualizar</a>

                <input type="submit" value="delete" class="eliminar-btn" name="delete">

                </form>

                <a href="ver_playlist.php?get_id=<?= $playlist_id; ?>" class="btn">Ver Video</a>
            </div>

      <?php
      
            }
        }else{
            echo '<p class="empty">¡Aún no se ha añadido ninguna lista de reproducción!</p>';
        } 
    }else{
        echo '<p class="empty">¡Por favor busca algo!</p>';
     }   

      ?>

    </div>


</section>




    <!-- footer -->

    <?php include '../componentes/footer.php'; ?>

    </div>

    <script src="../js/admin_script.js"></script>

    <script>
        document.querySelectorAll('.descripcion').forEach(content => {
        if(content.innerHTML.length > 100) content.innerHTML = content.innerHTML.slice(0, 100);
        });
    </script>
</body>
</html>