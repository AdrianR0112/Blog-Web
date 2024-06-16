<?php
include '../components/connect.php';

session_start();

$user_id = $_SESSION['user_id'] ?? null;

if (!isset($user_id)) {
   header('location:../login.php');
   exit;
}

if (isset($_POST['delete'])) {
   $p_id = $_POST['post_id'];
   $p_id = filter_var($p_id, FILTER_SANITIZE_NUMBER_INT); // Sanitizar como número entero

   // Obtener información del post para eliminar la imagen si existe
   $delete_image = $conn->prepare("SELECT * FROM `posts` WHERE id = ? AND user_id = ?");
   $delete_image->execute([$p_id, $user_id]);
   $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);

   if ($fetch_delete_image && !empty($fetch_delete_image['image'])) {
      // Eliminar la imagen física del servidor
      $image_path = '../uploaded_img/' . $fetch_delete_image['image'];
      if (file_exists($image_path)) {
         unlink($image_path);
      }
   }

   // Eliminar el post y sus comentarios asociados
   $delete_post = $conn->prepare("DELETE FROM `posts` WHERE id = ? AND user_id = ?");
   $delete_post->execute([$p_id, $user_id]);

   $delete_comments = $conn->prepare("DELETE FROM `comments` WHERE post_id = ?");
   $delete_comments->execute([$p_id]);

   $message[] = '¡Post eliminado exitosamente!';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Posts</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>

   <?php include '../components/u_header.php' ?>

   <section class="show-posts">

      <h1 class="heading">Tus Posts</h1>

      <div class="box-container">

         <?php
         $select_posts = $conn->prepare("SELECT * FROM `posts` WHERE user_id = ?");
         $select_posts->execute([$user_id]);
         if ($select_posts->rowCount() > 0) {
            while ($fetch_posts = $select_posts->fetch(PDO::FETCH_ASSOC)) {
               $post_id = $fetch_posts['id'];

               // Contar comentarios del post
               $count_post_comments = $conn->prepare("SELECT * FROM `comments` WHERE post_id = ?");
               $count_post_comments->execute([$post_id]);
               $total_post_comments = $count_post_comments->rowCount();

               // Contar likes del post
               $count_post_likes = $conn->prepare("SELECT * FROM `likes` WHERE post_id = ?");
               $count_post_likes->execute([$post_id]);
               $total_post_likes = $count_post_likes->rowCount();
         ?>
               <form method="post" class="box">
                  <input type="hidden" name="post_id" value="<?= $post_id; ?>">
                  <?php if (!empty($fetch_posts['image'])) { ?>
                     <img src="../uploaded_img/<?= $fetch_posts['image']; ?>" class="image" alt="">
                  <?php } ?>
                  <div class="status" style="background-color: <?= $fetch_posts['status'] == 'active' ? 'limegreen' : 'coral'; ?>;">
                     <?= $fetch_posts['status']; ?>
                  </div>
                  <div class="title"><?= $fetch_posts['title']; ?></div>
                  <div class="posts-content"><?= $fetch_posts['content']; ?></div>
                  <div class="icons">
                     <div class="likes"><i class="fas fa-heart"></i><span><?= $total_post_likes; ?></span></div>
                     <div class="comments"><i class="fas fa-comment"></i><span><?= $total_post_comments; ?></span></div>
                  </div>
                  <div class="flex-btn">
                     <a href="u_edit_post.php?id=<?= $post_id; ?>" class="option-btn">Editar</a>
                     <button type="submit" name="delete" class="delete-btn" onclick="return confirm('¿Eliminar este post?');">Eliminar</button>
                  </div>
                  <a href="u_read_post.php?post_id=<?= $post_id; ?>" class="btn">Ver Post</a>
               </form>
         <?php
            }
         } else {
            echo '<p class="empty">¡Aún no se han añadido posts! <a href="add_posts.php" class="btn" style="margin-top:1.5rem;">Añadir Post</a></p>';
         }
         ?>

      </div>

   </section>

   <script src="../js/admin_script.js"></script>

</body>

</html>
