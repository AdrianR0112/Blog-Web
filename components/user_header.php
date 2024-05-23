<?php
if (isset($message)) {
   foreach ($message as $message) {
      echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <section class="flex">

      <!-- <a href="home.php" class="logo">ChullaBlog</a> -->
      <a href="home.php" class="logo">
         <span class="color-yellow">Ch</span><span class="color-blue">ulla</span><span class="color-red">Blog</span>
      </a>

      <form action="search.php" method="POST" class="search-form">
         <input type="text" name="search_box" class="box" maxlength="100" placeholder="buscar blogs" required>
         <button type="submit" class="fas fa-search" name="search_btn"></button>
      </form>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="search-btn" class="fas fa-search"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <nav class="navbar">
         <a href="home.php"> <i class="fas fa-home"></i> inicio</a>
         <a href="posts.php"> <i class="fas fa-newspaper"></i> publicaciones</a>
         <a href="all_category.php"> <i class="fas fa-th-list"></i> categorías</a>
         <a href="authors.php"> <i class="fas fa-user-edit"></i> autores</a>
         <a href="login.php"> <i class="fa-solid fa-door-open"></i> iniciar sesión</a>
         <a href="register.php"> <i class="fas fa-user-plus"></i> registrarse</a>
      </nav>

      <div class="profile">
         <?php
         $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
         $select_profile->execute([$user_id]);
         if ($select_profile->rowCount() > 0) {
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
            <p class="name"><?= $fetch_profile['name']; ?></p>
            <a href="update.php" class="btn">actualizar perfil</a>
            <div class="flex-btn">
               <a href="login.php" class="option-btn">iniciar sesión</a>
               <a href="register.php" class="option-btn">registrarse</a>
            </div>
            <a href="components/user_logout.php" onclick="return confirm('¿cerrar sesión en este sitio web?');"
               class="delete-btn">cerrar sesión</a>
            <?php
         } else {
            ?>
            <p class="name">¡Por favor inicia sesión!</p>
            <a href="login.php" class="option-btn">iniciar sesión</a>
            <?php
         }
         ?>
      </div>

   </section>

</header>