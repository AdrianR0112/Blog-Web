<?php
if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
}
?>

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

      <a href="home.php" class="logo">
         <span class="color-yellow">Ch</span><span class="color-blue">ulla</span><span class="color-red">Blog</span>
      </a>

      <form action="search.php" method="POST" class="search-form">
         <input type="text" name="search_box" class="box" maxlength="100" placeholder="buscar blogs" required>
         <button type="submit" class="fas fa-search" name="search_btn"></button>
      </form>

      <div class="icons">
         <?php if (!empty($user_id)): ?>
            <a href="user/u_dashboard.php">
               <div id="post-btn" class="fa-solid fa-pen-to-square"></div>
            </a>
         <?php endif; ?>
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="search-btn" class="fas fa-search"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <nav class="navbar">
         <a href="home.php"> <i class="fas fa-home"></i> inicio</a>
         <a href="all_category.php"> <i class="fas fa-th-list"></i> Categorías</a>
         <a href="authors.php"> <i class="fas fa-user-edit"></i> Autores</a>
         <?php if (!empty($user_id)): ?>
            <a href="user_comments.php"> <i class="fa-solid fa-comments"></i> Tus comentarios</a>
            <a href="user_likes.php"> <i class="fa-solid fa-heart"></i> Tus likes</a>
         <?php endif; ?>
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
            <a href="components/user_logout.php" onclick="return confirm('¿cerrar sesión en este sitio web?');"
               class="delete-btn">cerrar sesión</a>
            <?php
         } else {
            ?>
            <p class="name">¡Inicia sesión o Registrate!</p>
            <a href="login.php" class="option-btn">iniciar sesión</a>
            <a href="register.php" class="option-btn">Registrarse</a>
            <?php
         }
         ?>
      </div>

   </section>

</header>