<?php

include '../componentes/conexion.php';

if(isset($_COOKIE['tutor_id'])){
   $tutor_id = $_COOKIE['tutor_id'];
}else{
   $tutor_id = '';
}

if(isset($_POST['submit'])){

    if(isset($_POST['submit'])){

        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        $pass = sha1($_POST['pass']);
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);


        $verify_tutor = $cBD->prepare("SELECT * FROM `profesor` WHERE email = ? AND password = ? LIMIT 1");

        $verify_tutor->execute([$email, $pass]);
        $row = $verify_tutor->fetch(PDO::FETCH_ASSOC);


            if($verify_tutor->rowCount() > 0){
                setcookie('tutor_id', $row['id'], time() + 60*60*24*30, '/');
                header('location:dashboard.php');
            }else{

                $message[] = 'correo incorrecto o contraseña';

            }
        

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
    <title>Inicio</title>
</head>
<body style="padding-left: 0;">


<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message form">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
    


<!-- registro section -->

<section class="form-container">

   <form class="login" action="" method="post" enctype="multipart/form-data">
      <h3>Bienvenido</h3>

         <p>Tu email <span>*</span></p>
            <input type="email" name="email" placeholder="Ingresa tu email" maxlength="30" required class="caja">
            </div>
            <p>Tu password <span>*</span></p>
            <input type="password" name="pass" placeholder="Ingresa tu password" maxlength="20" required class="caja">





      <p class="link">¿No tienes una cuenta? <a href="registro.php">Registarte</a></p>
      <input type="submit" name="submit" value="Iniciar" class="btn">
   </form>

</section>


<!-- registro final -->







    <script src="../js/admin_script.js"></script>
    </body>
    </html>