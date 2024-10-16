<?php 

if (isset($message)) {
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
    
    $select_profile = $cBD->prepare("SELECT * FROM `profesor` WHERE id = ?");
    
    $select_profile->execute([$tutor_id]);
    if($select_profile->rowCount() > 0){

        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

    ?>
         <img src="../uploaded_files/<?= $fetch_profile['image']; ?>" alt="">
    <h3><?= $fetch_profile['name'];?></h3>
    <span><?= $fetch_profile['profession']; ?></span>
    <a href="perfil.php" class="btn">Ver Perfil</a>
    <div class="flex-btn">
    <!-- <a href="login.php" class="opcion-btn">Login</a>
    <a href="registro.php" class="opcion-btn">Registro</a> -->
    </div>
        <a href="../componentes/admin_logout.php" onclick="return confirm('salir de la pagina web');" class="eliminar-btn">Cerrar Session</a>

    <?php
    }else{

    ?>
    <h3 style="text-align: center;">Prmero Inicia Session</h3>
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
                <img src="../img/ArcticonsDcu.png" alt="">
                <div class="logo_name">aat</div>
                <img src="../img/CatppuccinCHeader.png" alt="">
                <div class="logo_name2">ode</div>
            </div>
            <i class='bx bx-menu' id="btn"></i>
        </div>
        <ul class="nav_list">
            <li>
                <form action="buscar_pagina.php" method="post" class="search-form">
                <i class='bx bx-search'></i>
                <input type="text" name="search_box" placeholder="Search..." required>
                <button type="submit" name="search_btn"></button>
                <!-- <span class="tooltip">Busqueda</span> -->
                </form>
            </li>
            <li>
                <a href="dashboard.php">
                    <img src="../img/AkarIconsDashboard.png" alt="">
                    <span class="links_name">Dashboard</span>
                </a>
                <span class="tooltip">Panel</span>
            </li>
            <li>
                <a href="perfil.php">
                    <img src="../img/HugeiconsUserAccount.png" alt="">
                    <span class="links_name">User</span>
                </a>
                <span class="tooltip">Usuario</span>
            </li>
            <li>
                <a href="playlists.php">
                    <img src="../img/EosIconsSystemReRegistered.png" alt="">
                    <span class="links_name">Playlists</span>
                </a>
                <span class="tooltip">Listas de reproducción</span>
            </li>
            <li>
                <a href="contenidos.php">
                    <img src="../img/LetsIconsVideo.png" alt="">
                    <span class="links_name">Content</span>
                </a>
                <span class="tooltip">Contenido</span>
            </li>
            <!-- <li>
                <a href="profesor.html">
                    <img src="../img/FluentEmojiHighContrastTeacher.png" alt="">
                    <span class="links_name">Teachers</span>
                </a>
                <span class="tooltip">Profesores</span>
            </li> -->
            <li>
                <a href="comentario.php">
                    <img src="../img/comentario.png" alt="">
                    <span class="links_name">Comment</span>
                </a>
                <span class="tooltip">Comentario</span>
            </li>
            <li>
                <a href="pregunta.php">
                    <img src="../img/ZondiconsQuestion.png" alt="">
                    <span class="links_name">Questions</span>
                </a>
                <span class="tooltip">Preguntas</span>
            </li>

        </ul>


    </div>


