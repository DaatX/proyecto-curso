<?php

include '../componentes/conexion.php';

if(isset($_COOKIE['tutor_id'])){
   $tutor_id = $_COOKIE['tutor_id'];
}else{
   $tutor_id = '';
   header('location:login.php');
}

if(isset($_POST['submit'])){

   $select_tutor = $cBD->prepare("SELECT * FROM `profesor` WHERE id = ? LIMIT 1");
   $select_tutor->execute([$tutor_id]);
   $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);

   
   $prev_pass = $fetch_tutor['password'];
   $prev_image = $fetch_tutor['image'];


   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $profession = $_POST['profession'];
   $profession = filter_var($profession, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);

   if(!empty($name)){
      $update_name = $cBD->prepare("UPDATE `profesor` SET name = ? WHERE id = ?");

      $update_name->execute([$name, $tutor_id]);
      $message[] = 'nombre actualizado exitosamente';

   }

   if(!empty($profession)){
      $update_profession = $cBD->prepare("UPDATE `profesor` SET profession = ? WHERE id = ?");

      $update_profession->execute([$profession, $tutor_id]);
      $message[] = 'profesion actualizado exitosamente';

   }

   if(!empty($email)){
      $select_tutor_email = $cBD->prepare("SELECT * FROM `profesor` WHERE email = ?");
      $select_tutor_email->execute([$email]);

      if($select_tutor_email->rowCount() > 0){

         $message[] = 'email already taken';

      }else{

         
      $update_email = $cBD->prepare("UPDATE `profesor` SET email = ? WHERE id = ?");

      $update_email->execute([$email, $tutor_id]);
      $message[] = 'email actualizado exitosamente';


      }

   }


   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $ext = pathinfo($image, PATHINFO_EXTENSION);
   $rename = unique_id().'.'.$ext;
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_files/'.$rename;

   if(!empty($image)){
      if($image_size > 2000000){
         $message[] = 'image size too large!';
      }else{
         $update_image = $cBD->prepare("UPDATE `profesor` SET `image` = ? WHERE id = ?");
         $update_image->execute([$rename, $tutor_id]);
         move_uploaded_file($image_tmp_name, $image_folder);
         if($prev_image != '' AND $prev_image != $rename){
            unlink('../uploaded_files/'.$prev_image);
         }
         $message[] = 'image updated successfully!';
      }
   }


   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $old_pass = sha1($_POST['old_pass']);
   $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);


   if($old_pass != $empty_pass){
      if($old_pass != $prev_pass){
         $message[] = 'old password not matched!';
      }elseif($new_pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
         if($new_pass != $empty_pass){
            $update_pass = $cBD->prepare("UPDATE `profesor` SET password = ? WHERE id = ?");
            $update_pass->execute([$cpass, $tutor_id]);
            $message[] = 'password updated successfully!';
         }else{
            $message[] = 'please enter a new password!';
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
    <title>Actualizar</title>
</head>
<body>
    
    <!-- sidebar -->

    <?php include '../componentes/admin_header.php'; ?>


<!-- Dashboard section -->

<div class="home_content">
<div class="text">Actualizar</div>


<section class="form-container">

   <form class="" action="" method="post" enctype="multipart/form-data">
      <h3>Actualizar Datos de Perfil</h3>
      <div class="flex">
         <div class="col">
            <p>su nombre </p>
            <input type="text" name="name" placeholder="<?= $fetch_profile['name']; ?>" maxlength="50" class="caja">
            <p>su profession </p>
            <select name="profession" class="caja">
               <option value="" selected><?= $fetch_profile['profession']; ?></option>
               <option value="developer">developer</option>
               <option value="desginer">desginer</option>
               <option value="musician">musician</option>
               <option value="biologist">biologist</option>
               <option value="teacher">teacher</option>
               <option value="engineer">engineer</option>
               <option value="lawyer">lawyer</option>
               <option value="accountant">accountant</option>
               <option value="doctor">doctor</option>
               <option value="journalist">journalist</option>
               <option value="photographer">photographer</option>
            </select>
            <p>su email </p>
            <input type="email" name="email" placeholder="<?= $fetch_profile['email']; ?>" maxlength="30" class="caja">
         </div>
         <div class="col">
            <p>old password :</p>
            <input type="password" name="old_pass" placeholder="Introduce tu antiguo password" maxlength="20"  class="caja">
            <p>nueva password :</p>
            <input type="password" name="new_pass" placeholder="Ingresa tu nuevo password" maxlength="20"  class="caja">
            <p>confirma password :</p>
            <input type="password" name="cpass" placeholder="confirma tu nuevo password" maxlength="20"  class="caja">
         </div>
      </div>
      <p>seleciones su foto </p>
            <input type="file" name="image" accept="image/*" class="caja">
      <input type="submit" name="submit" value="Actualizar Perfil" class="btn">
   </form>

</section>







    <!-- footer -->

    <?php include '../componentes/footer.php'; ?>

    </div>

    <script src="../js/admin_script.js"></script>
</body>
</html>