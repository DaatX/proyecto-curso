<?php

include 'componentes/conexion.php';

if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
 }else{
    $user_id = '';
 }

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title> Nosotros</title>
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
        <div class="text">Sobre Nosotros</div>
        
<!-- about section starts  -->

<section class="sobre">

   <div class="row">

      <div class="image">
         <img src="img/online.gif" alt="">
      </div>

      <div class="contenido">
      <h3>¿Por qué elegirnos?</h3>
                    <p>“Aprende Desarrollo Web: Tu Guía para el Mundo Digital”<br>
                        En esta plataforma, encontrarás recursos esenciales para adentrarte en el emocionante mundo del desarrollo web. Desde los conceptos básicos hasta técnicas avanzadas, te acompañaremos en tu viaje de aprendizaje.</p>
                    <a href="cursos.php" class="inline-btn">Nuestros Curso</a>
      </div>

   </div>

   <div class="caja-container">

                <div class="caja">
                    <i class="fa-solid fa-code"></i>
                    <div>
                        <h3>20</h3>
                        <span>Programacion</span>
                    </div>
                </div>

                <div class="caja">
                    <i class="fa-solid fa-palette"></i>
                    <div>
                        <h3>4</h3>
                        <span>Diseño</span>
                    </div>
                </div>

                <div class="caja">
                    <i class="fa-solid fa-bullhorn"></i>
                    <div>
                        <h3>1</h3>
                        <span>Marketing</span>
                    </div>
                </div>

                <div class="caja">
                    <i class="fa-solid fa-user-secret"></i>
                    <div>
                        <h3>6</h3>
                        <span>Hacking Etico</span>
                    </div>
                </div>

   </div>

</section>

<!-- about section ends -->

<!-- reviews section starts  -->

<section class="reseña">

   <h1 class="heading">Reseñas de estudiantes</h1>

   <div class="caja-container">

      <div class="caja">
         <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Illo fugiat, quaerat voluptate odio consectetur assumenda fugit maxime unde at ex?</p>
         <div class="usuario">
            <img src="img/5.jpg" alt="">
            <div>
               <h3>daat code</h3>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
               </div>
            </div>
         </div>
      </div>

      <div class="caja">
         <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Illo fugiat, quaerat voluptate odio consectetur assumenda fugit maxime unde at ex?</p>
         <div class="usuario">
            <img src="img/5.jpg" alt="">
            <div>
               <h3>daat code</h3>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
               </div>
            </div>
         </div>
      </div>

      <div class="caja">
         <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Illo fugiat, quaerat voluptate odio consectetur assumenda fugit maxime unde at ex?</p>
         <div class="usuario">
            <img src="img/5.jpg" alt="">
            <div>
               <h3>daat code</h3>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
               </div>
            </div>
         </div>
      </div>

      <div class="caja">
         <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Illo fugiat, quaerat voluptate odio consectetur assumenda fugit maxime unde at ex?</p>
         <div class="usuario">
            <img src="img/5.jpg" alt="">
            <div>
               <h3>daat code</h3>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
               </div>
            </div>
         </div>
      </div>

      <div class="caja">
         <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Illo fugiat, quaerat voluptate odio consectetur assumenda fugit maxime unde at ex?</p>
         <div class="usuario">
            <img src="img/5.jpg" alt="">
            <div>
               <h3>daat code</h3>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
               </div>
            </div>
         </div>
      </div>

      <div class="caja">
         <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Illo fugiat, quaerat voluptate odio consectetur assumenda fugit maxime unde at ex?</p>
         <div class="usuario">
            <img src="img/5.jpg" alt="">
            <div>
               <h3>daat code</h3>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
               </div>
            </div>
         </div>
      </div>

   </div>

</section>

<!-- reviews section ends -->
         
<!-- footer section starts  -->
<?php include 'componentes/footer.php'; ?>
<!-- footer section ends -->

</div>




    <script src="js/menu.js"></script>


</body>

</html>