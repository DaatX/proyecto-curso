<?php

include 'componentes/conexion.php';

if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
 }else{
    $user_id = '';
 }

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_user = $cBD->prepare("SELECT * FROM `usuario` WHERE email = ? AND password = ? LIMIT 1");
   $select_user->execute([$email, $pass]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);
   
   if($select_user->rowCount() > 0){
     setcookie('user_id', $row['id'], time() + 60*60*24*30, '/');
     header('location:index.php');
   }else{
      $message[] = '¡Correo electrónico o contraseña incorrectos!';
   }

}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title> login</title>
    <link rel="stylesheet" href="css/estilo.css">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<!-- header -->
<?php include 'componentes/usuario_header.php'; ?>
<!-- header final -->

    <div class="home_content">
        <div class="text">Inicio Session</div>
        

        <section class="form-container">

<form action="" method="post" enctype="multipart/form-data" class="login">
   <h3>¡bienvenido de nuevo!</h3>
   <p>tu correo electrónico <span>*</span></p>
   <input type="email" name="email" placeholder="Ingresa tu email" maxlength="100" required class="caja">
   <p>tu contraseña <span>*</span></p>
   <input type="password" name="pass" placeholder="Ingresa tu password" maxlength="20" required class="caja">
   <p class="link">¿No tienes una cuenta? <a href="registro.php">Regístrate ahora</a></p>
   <input type="submit" name="submit" value="login now" class="btn">
</form>

</section>


       
             <!-- footer section starts  -->
             <?php include 'componentes/footer.php'; ?>
    <!-- footer section ends -->

    </div>



    <script src="js/menu.js"></script>


</body>

</html>