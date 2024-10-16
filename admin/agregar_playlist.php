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
    $title = $_POST['title'];
    $title = filter_var($title, FILTER_SANITIZE_STRING);
    $description = $_POST['description'];
    $description = filter_var($description, FILTER_SANITIZE_STRING);
    $status = $_POST['status'];
    $status = filter_var($status, FILTER_SANITIZE_STRING);
 
    $thumb = $_FILES['thumb']['name'];
    $thumb = filter_var($thumb, FILTER_SANITIZE_STRING);
    $ext = pathinfo($thumb, PATHINFO_EXTENSION);
    $rename = unique_id().'.'.$ext;
    $thumb_size = $_FILES['thumb']['size'];
    $thumb_tmp_name = $_FILES['thumb']['tmp_name'];
    $thumb_folder = '../uploaded_files/'.$rename;

    $verify_playlist = $cBD->prepare("SELECT * FROM `playlist` WHERE tutor_id = ? AND title = ? AND description = ?");
    $verify_playlist->execute([$tutor_id, $title, $description]);

    if($verify_playlist->rowCount() > 0){

        $message[] = 'el video ya fue creado';

    }else{


        $add_playlist = $cBD->prepare("INSERT INTO `playlist`(id, tutor_id, title, description, thumb, status) VALUES(?,?,?,?,?,?)");
        $add_playlist->execute([$id, $tutor_id, $title, $description, $rename, $status]);
        move_uploaded_file($thumb_tmp_name, $thumb_folder);
        $message[] = 'new playlist created!'; 

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
    <title>Agregar Video</title>
</head>
<body>
    
    <!-- sidebar -->

    <?php include '../componentes/admin_header.php'; ?>


<!-- Dashboard section -->

<div class="home_content">
<div class="text">Agregar Video</div>

<section class="crud-form">

    <form action="" method="post" enctype="multipart/form-data">
    
    <p>Estado de video <span>*</span></p>
    <select name="status" required class="caja">
        <option value="activo">Activo</option>
        <option value="desactivado">Desativado</option>
    </select>
        
    <p>Titulo de video <span>*</span></p>
        <input type="text" class="caja" name="title" maxlength="100" placeholder="titulo de video" required>
        
        <p>Descripcion de video <span>*</span></p>
        <textarea name="description" class="caja" cols="30" required placeholder="Descripcion de Video" maxlength="1000" rows="10"></textarea>
    
        <p>Foto de video <span>*</span></p>
        <input type="file" name="thumb" required accept="image/*" class="caja">

        <input type="submit" value="crear video" name="submit" class="btn">
    
    
    </form>






    </section>






    <!-- footer -->

    <?php include '../componentes/footer.php'; ?>

    </div>

    <script src="../js/admin_script.js"></script>
</body>
</html>