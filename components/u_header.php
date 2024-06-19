<?php
include '../components/connect.php';

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
   header('location: ../login.php');
   exit();
}

$user_id = $_SESSION['user_id'];

$select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
$select_profile->execute([$user_id]);
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

if (isset($message) && is_array($message)) {
   foreach ($message as $msg) {
      echo '
      <div class="message">
         <span>' . $msg . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <a href="u_dashboard.php" class="logo">Panel del<span> Usuario</span></a>
   
   <div class="profile">
      <p><?= $fetch_profile['name']; ?></p>
   </div> 

   <nav class="navbar">
      <a href="../home.php"><i class="fas fa-home"></i> <span>Inicio</span></a>
      <a href="u_dashboard.php"><i class="fa-solid fa-clipboard-list"></i> <span>Dashboard</span></a>
      <a href="u_add_posts.php"><i class="fas fa-pen"></i> <span>Añadir posts</span></a>
      <a href="u_view_posts.php"><i class="fas fa-eye"></i> <span>Ver posts</span></a>
      <a href="../components/user_logout.php" style="color:var(--red);" onclick="return confirm('¿Cerrar sesión del sitio web?');"><i class="fas fa-sign-out-alt"></i><span>Cerrar sesión</span></a>
   </nav>

</header>

<div id="menu-btn" class="fas fa-bars"></div>
