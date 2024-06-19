<?php

include '../components/connect.php';

session_start();

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
   header('location: ../login.php');
   exit();
}

$user_id = $_SESSION['user_id'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/u_header.php' ?>


<section class="dashboard">

   <h1 class="heading">Dashboard</h1>

   <div class="box-container">

      <div class="box">
         <h3>Bienvenid@!</h3>
         <p><?= $fetch_profile['name']; ?></p>
         <a href="../update.php" class="btn">Actualizar perfil</a>
      </div>

      <div class="box">
         <?php
            $select_posts = $conn->prepare("SELECT * FROM `posts` WHERE user_id = ?");
            $select_posts->execute([$user_id]);
            $numbers_of_posts = $select_posts->rowCount();
         ?>
         <h3><?= $numbers_of_posts; ?></h3>
         <p>posts añadidos</p>
         <a href="u_add_posts.php" class="btn">Añadir nuevo post</a>
      </div>

      <div class="box">
         <?php
            $select_active_posts = $conn->prepare("SELECT * FROM `posts` WHERE user_id = ? AND status = ?");
            $select_active_posts->execute([$user_id, 'active']);
            $numbers_of_active_posts = $select_active_posts->rowCount();
         ?>
         <h3><?= $numbers_of_active_posts; ?></h3>
         <p>posts activos</p>
         <a href="u_view_posts.php" class="btn">Ver posts</a>
      </div>

      <div class="box">
         <?php
            $select_deactive_posts = $conn->prepare("SELECT * FROM `posts` WHERE user_id = ? AND status = ?");
            $select_deactive_posts->execute([$user_id, 'deactive']);
            $numbers_of_deactive_posts = $select_deactive_posts->rowCount();
         ?>
         <h3><?= $numbers_of_deactive_posts; ?></h3>
         <p>posts inactivos</p>
         <a href="u_view_posts.php" class="btn">Ver posts</a>
      </div>
       
      <div class="box">
         <?php
            $select_comments = $conn->prepare("SELECT * FROM `comments` WHERE user_id = ?");
            $select_comments->execute([$user_id]);
            $numbers_of_comments = $select_comments->rowCount();
         ?>
         <h3><?= $numbers_of_comments; ?></h3>
         <p>comentarios añadidos</p>
         <a href="u_comments.php" class="btn">Ver comentarios</a>
      </div>

      <div class="box">
         <?php
            $select_likes = $conn->prepare("SELECT * FROM `likes` WHERE user_id = ?");
            $select_likes->execute([$user_id]);
            $numbers_of_likes = $select_likes->rowCount();
         ?>
         <h3><?= $numbers_of_likes; ?></h3>
         <p>total de likes</p>
         <a href="u_view_posts.php" class="btn">Ver posts</a>
      </div>

   </div>

</section>

<script src="../js/admin_script.js"></script>

</body>
</html>
