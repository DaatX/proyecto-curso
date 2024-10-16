<?php

include '../componentes/conexion.php';

if(isset($_COOKIE['tutor_id'])){
   $tutor_id = $_COOKIE['tutor_id'];
}else{
   $tutor_id = '';
}

if(isset($_POST['submit'])){

    if(isset($_POST['submit'])){

        $id = unique_id();
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $profession = $_POST['profession'];
        $profession = filter_var($profession, FILTER_SANITIZE_STRING);
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
        $image_folder = '../uploaded_files/'.$rename;

        $select_tutor_email = $cBD->prepare("SELECT * FROM `profesor` WHERE email = ?");
        $select_tutor_email->execute([$email]);

    if($select_tutor_email->rowCount() > 0){

        $message[] = 'email already taken!';

    }else{

        if($pass != $cpass){
            $message[] = 'contraseña no coincide';
        }else{

            if($image_size > 2000000){

                $message[] = 'imagen muy grande';

            }else{

                $insert_tutor = $cBD->prepare("INSERT INTO `profesor`(id, name, profession, email, password, image) VALUES(?,?,?,?,?,?)");
                $insert_tutor->execute([$id, $name, $profession, $email, $cpass, $rename]);
                move_uploaded_file($image_tmp_name, $image_folder);

                $verify_tutor = $cBD->prepare("SELECT * FROM `profesor` WHERE email = ? AND password = ? LIMIT 1");

                $verify_tutor->execute([$email, $cpass]);
                $row = $verify_tutor->fetch(PDO::FETCH_ASSOC);
    
                if($insert_tutor){
                    if($verify_tutor->rowCount() > 0){
                        setcookie('tutor_id', $row['id'], time() + 60*60*24*30, '/');
                        header('location:dashboard.php');
                    }else{
    
                        $message[] = 'no funciona';
    
                    }
                }


            }

        }

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
    <title>Registro</title>
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

   <form class="" action="" method="post" enctype="multipart/form-data">
      <h3>register new</h3>
      <div class="flex">
         <div class="col">
            <p>Tu Nombre <span>*</span></p>
            <input type="text" name="name" placeholder=" Ingresa tu nombre" maxlength="50" required class="caja">
            <p>Tu profession <span>*</span></p>
            <select name="profession" class="caja" required>
               <option value="" disabled selected>-- selecionar tu profession</option>
               <option value="Desarrollador"> Desarrollador</option>
               <option value="Diseñador"> Diseñador</option>
               <option value="Hacking Etico">Hacking Etico</option>
               <option value="Marketing">Marketing</option>
            </select>
            <p>tu email <span>*</span></p>
            <input type="email" name="email" placeholder="Ingresa tu email" maxlength="30" required class="caja">
         </div>
         <div class="col">
            <p>Tu password <span>*</span></p>
            <input type="password" name="pass" placeholder="Ingresa tu password" maxlength="20" required class="caja">
            <p>confirma tu password <span>*</span></p>
            <input type="password" name="cpass" placeholder="confirma tu password" maxlength="20" required class="caja">
            <p>selecionar tu foto <span>*</span></p>
            <input type="file" name="image" accept="image/*" required class="caja">
         </div>
      </div>
      <p class="link">¿Ya tienes una cuenta? <a href="login.php">login now</a></p>
      <input type="submit" name="submit" value="register now" class="btn">
   </form>

</section>


<!-- registro final -->







    <script src="../js/admin_script.js"></script>
    </body>
    </html>