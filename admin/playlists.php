<?php

include '../componentes/conexion.php';

if(isset($_COOKIE['tutor_id'])){
   $tutor_id = $_COOKIE['tutor_id'];
}else{
   $tutor_id = '';
   header('location:login.php');
}

if(isset($_POST['delete'])){
    $delete_id = $_POST['delete_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
 
    $verify_playlist = $cBD->prepare("SELECT * FROM `playlist` WHERE id = ?");
    $verify_playlist->execute([$delete_id]);
 
    if($verify_playlist->rowCount() > 0){
 
    
 
    $fetch_thumb = $verify_playlist->fetch(PDO::FETCH_ASSOC);
    $prev_thumb = $fetch_thumb['thumb'];

    if($prev_thumb != ''){

    unlink('../uploaded_files/'.$prev_thumb);

    }

    $delete_bookmark = $cBD->prepare("DELETE FROM `bookmark` WHERE playlist_id = ?");
    $delete_bookmark->execute([$delete_id]);
    $delete_playlist = $cBD->prepare("DELETE FROM `playlist` WHERE id = ?");
    $delete_playlist->execute([$delete_id]);
    $message[] = 'playlist deleted!';
    
    }else{
       $message[] = 'playlist already deleted!';
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
    <title>Lista</title>
</head>
<body>
    
    <!-- sidebar -->

    <?php include '../componentes/admin_header.php'; ?>


<!-- Dashboard section -->

<div class="home_content">
<div class="text">Lista de Reproducción</div>

<section class="playlists">

    <div class="caja-container">

    <div class="caja" style="text-align: center;">

    <h3 class="titulo" style="padding-bottom: .7rem;">Crear New Videos</h3>
    <a href="agregar_playlist.php" class="btn">Agregar Nuevo Video</a>

    </div>


    <?php
         $select_playlist = $cBD->prepare("SELECT * FROM `playlist` WHERE tutor_id = ? ORDER BY date DESC");
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

                <input type="submit" value="Eliminar" class="eliminar-btn" onclick="return confirm('delete this playlist?');" name="delete">

                </form>

                <a href="ver_playlist.php?get_id=<?= $playlist_id; ?>" class="btn">Ver Video</a>
            </div>

      <?php
      
            }
        }else{
            echo '<p class="empty">¡Aún no se ha añadido ninguna lista de reproducción!</p>';
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