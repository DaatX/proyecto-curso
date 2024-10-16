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
      <link rel="stylesheet" href="../css/pregunta.css">
      <!-- <link rel="stylesheet" href="../css/estilo.css"> -->
    <title>Pregunta Frecuentes</title>
</head>
<body>
    
    <!-- sidebar -->

    <?php include '../componentes/admin_header.php'; ?>


<!-- Dashboard section -->

<div class="home_content">
<div class="text">Pregunta Frecuentes</div>
        


<?php include '../componentes/admin_pregunta.php'; ?>


    <!-- footer -->

    <?php include '../componentes/footer.php'; ?>

    </div>


    <script src="../js/preguntas.js"></script>
    <script src="../js/admin_script.js"></script>
    <script src="../js/categorias.js"></script>
</body>
</html>