<?php

include 'componentes/conexion.php';

if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
 }else{
    $user_id = '';
 }

 if(isset($_POST['submit'])){

    $id = unique_id();
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = sha1($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
 
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename = unique_id().'.'.$ext;
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_files/'.$rename;
 
    $select_user = $cBD->prepare("SELECT * FROM `usuario` WHERE email = ?");
    $select_user->execute([$email]);
    
    if($select_user->rowCount() > 0){
       $message[] = 'email already taken!';
    }else{
       if($pass != $cpass){
          $message[] = 'confirm passowrd not matched!';
       }else{
          $insert_user = $cBD->prepare("INSERT INTO `usuario`(id, name, email, password, image) VALUES(?,?,?,?,?)");
          $insert_user->execute([$id, $name, $email, $cpass, $rename]);
          move_uploaded_file($image_tmp_name, $image_folder);
          
          $verify_user = $cBD->prepare("SELECT * FROM `usuario` WHERE email = ? AND password = ? LIMIT 1");
          $verify_user->execute([$email, $pass]);
          $row = $verify_user->fetch(PDO::FETCH_ASSOC);
          
          if($verify_user->rowCount() > 0){
             setcookie('user_id', $row['id'], time() + 60*60*24*30, '/');
             header('location:index.php');
          }
       }
    }
 
 }

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title> Registro</title>
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
        <div class="text">Registrarse</div>
        

        <section class="form-container">

<form class="registro" action="" method="post" enctype="multipart/form-data">
   <h3>crear una cuenta</h3>
   <div class="flex">
      <div class="col">
         <p>Su nombre <span>*</span></p>
         <input type="text" name="name" placeholder="Ingresa tu nombre" maxlength="50" required class="caja">
         <p>tu correo electrónico <span>*</span></p>
         <input type="email" name="email" placeholder="Ingresa tu email" maxlength="30" required class="caja">
      </div>
      <div class="col">
         <p>tu contraseña <span>*</span></p>
         <input type="password" name="pass" placeholder="Ingresa tu password" maxlength="20" required class="caja">
         <p>confirmar password <span>*</span></p>
         <input type="password" name="cpass" placeholder="Confirmar tu password" maxlength="20" required class="caja">
      </div>
   </div>
   <p>seleccionar Foto <span>*</span></p>
   <input type="file" name="image" accept="image/*" required class="caja">
   <p class="link">¿Ya tienes una cuenta? <a href="login.php">login ahora</a></p>
   <input type="submit" name="submit" value="Regístrate ahora" class="btn">
</form>

</section>
         

       
       
             <!-- footer section starts  -->
             <?php include 'componentes/footer.php'; ?>
    <!-- footer section ends -->

    </div>



    <script src="js/menu.js"></script>


</body>

</html>