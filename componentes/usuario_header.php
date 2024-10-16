<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<!-- header -->

<header class="header">

<section class="flex">

   <div class="icons">
      <div id="user-btn" class="fas fa-user"></div>
      <div id="toggle-btn" class="fas fa-sun"></div>
   </div>

   <div class="perfil">
    <?php
    
    $select_profile = $cBD->prepare("SELECT * FROM `usuario` WHERE id = ?");
    
    $select_profile->execute([$user_id]);
    if($select_profile->rowCount() > 0){

        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

    ?>
         <img src="uploaded_files/<?= $fetch_profile['image']; ?>" alt="">
    <h3><?= $fetch_profile['name'];?></h3>
    <span >Estudiante</span>
    <a href="perfil.php" class="btn">Ver Perfil</a>
    <div class="flex-btn">
    <!-- <a href="login.php" class="opcion-btn">Login</a>
    <a href="registro.php" class="opcion-btn">Registro</a> -->
    </div>
        <a href="componentes/usuario_logout.php" onclick="return confirm('salir de la pagina web');" class="eliminar-btn">Cerrar Session</a>

    <?php
    }else{

    ?>
    <h3 style="text-align: center; color: var(--black)">Primero Inicia Session</h3>
    <div class="flex-btn">
    <a href="login.php" class="opcion-btn">Login</a>
    <a href="registro.php" class="opcion-btn">Registro</a>
    </div>

    <?php

    }

    ?>

   </div>

</section>

</header>  

<!-- sidebar  -->

<div class="sidebar">
        <div class="logo_content">
            <div class="logo">
                <img src="img/ArcticonsDcu.png" alt="">
                <div class="logo_name">aat</div>
                <img src="img/CatppuccinCHeader.png" alt="">
                <div class="logo_name2">ode</div>
            </div>
            <i class='bx bx-menu' id="btn"></i>
        </div>
        <ul class="nav_list">
            <li>
                <form action="buscar_cursos.php" method="post" class="search-form">
                <i class='bx bx-search'></i>
                <input type="text" name="search_course" placeholder="Search..." required>
                <button type="submit" name="search_course_btn"></button>
                <!-- <span class="tooltip">Busqueda</span> -->
                </form>
            </li>
            <li>
                <a href="index.php">
                    <img src="img/AkarIconsDashboard.png" alt="">
                    <span class="links_name">Home</span>
                </a>
                <span class="tooltip">Panel</span>
            </li>
            <li>
                <a href="sobre.php">
                    <img src="img/EosIconsSystemReRegistered.png" alt="">
                    <span class="links_name">About us</span>
                </a>
                <span class="tooltip">Nosotros</span>
            </li>
            <li>
                <a href="cursos.php">
                    <img src="img/LetsIconsVideo.png" alt="">
                    <span class="links_name">Courses</span>
                </a>
                <span class="tooltip">Cursos</span>
            </li>
            <li>
                <a href="profesor.php">
                    <img src="img/FluentEmojiHighContrastTeacher.png" alt="">
                    <span class="links_name">Teachers</span>
                </a>
                <span class="tooltip">Profesores</span>
            </li>
            <li>
                <a href="contacto.php">
                    <img src="img/Fa6SolidHeadset.png" alt="">
                    <span class="links_name">Contact</span>
                </a>
                <span class="tooltip">Contacto</span>
            </li> 
            <!-- <li>
                <a href="comentario.php">
                    <img src="img/comentario.png" alt="">
                    <span class="links_name">Comment</span>
                </a>
                <span class="tooltip">Comentario</span>
            </li> -->
            <li>
                <a href="pregunta.php">
                    <img src="img/ZondiconsQuestion.png" alt="">
                    <span class="links_name">Questions</span>
                </a>
                <span class="tooltip">Preguntas</span>
            </li>

        </ul>


    </div>


