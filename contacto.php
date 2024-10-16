<?php

include 'componentes/conexion.php';

if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
 }else{
    $user_id = '';
 }

 if(isset($_POST['submit'])){

    $name = $_POST['name']; 
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email']; 
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $number = $_POST['number']; 
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $msg = $_POST['msg']; 
    $msg = filter_var($msg, FILTER_SANITIZE_STRING);
 
    $select_contact = $cBD->prepare("SELECT * FROM `contacto` WHERE name = ? AND email = ? AND number = ? AND message = ?");
    $select_contact->execute([$name, $email, $number, $msg]);
 
    if($select_contact->rowCount() > 0){
       $message[] = '¡Mensaje ya enviado!';
    }else{
       $insert_message = $cBD->prepare("INSERT INTO `contacto`(name, email, number, message) VALUES(?,?,?,?)");
       $insert_message->execute([$name, $email, $number, $msg]);
       $message[] = '¡Mensaje enviado exitosamente!';
    }
 
 }

 ?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title> Contacto</title>
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
        <div class="text">Contacto</div>
        
        <!-- contacto -->

<section class="contacto">

   <div class="row">

      <div class="image">
         <img src="img/contacto.gif" alt="">
      </div>

      <form action="" method="post">
         <h3>Ponte en contacto con nosotros</h3>
         <input type="text" placeholder="Ingresa tu nombre" required maxlength="100" name="name" class="caja">
         <input type="email" placeholder="Ingresa tu email" required maxlength="100" name="email" class="caja">
         <input type="number" min="0" max="9999999999" placeholder="Ingresa tu numero" required maxlength="10" name="number" class="caja">
         <textarea name="msg" class="caja" placeholder="Ingresa tu Mensaje" required cols="30" rows="10" maxlength="1000"></textarea>
         <input type="submit" value="enviar mensaje" class="inline-btn" name="submit">
      </form>

   </div>

            <div class="caja-container">
         
               <div class="caja">
                  <i class="fas fa-phone"></i>
                  <h3>Whatsapp y Telegram</h3>
                  <a href="#">+58 04263250137</a>
                  <a href="#">111-222-3333</a>
               </div>
               
               <div class="caja">
                  <i class="fas fa-envelope"></i>
                  <h3>Correo</h3>
                  <a href="#">daatfrontend@gmail.com</a>
                  <a href="#">daatprueba@tomorjerry.com</a>
               </div>
         
               <div class="caja">
                  <i class="fas fa-map-marker-alt"></i>
                  <h3>Ubicacion</h3>
                  <a href="#">Caracas - Venezuela</a>
                  <a href="#"> Los Simbolos</a>
               </div>
         
            </div>

</section>

        <!-- contacto final -->

     <!-- footer section starts  -->
     <?php include 'componentes/footer.php'; ?>
    <!-- footer section ends -->

    </div>



    <script src="js/menu.js"></script>


</body>

</html>