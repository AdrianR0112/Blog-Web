<?php

include '../components/connect.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:../login.php');
   exit();
}

if (isset($_POST['publish'])) {

   $name = $_POST['name'];
   $title = $_POST['title'];
   $content = $_POST['content'];
   $category = $_POST['category'];
   $status = 'active';

   $image = $_FILES['image']['name'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_img/' . $image;

   if (!empty($image)) {
      $image_size = $_FILES['image']['size'];

      if ($image_size > 2000000) {
         $message[] = '¡El tamaño de la imagen es demasiado grande!';
      } else {
         move_uploaded_file($image_tmp_name, $image_folder);
      }
   } else {
      $image = '';
   }

   $insert_post = $conn->prepare("INSERT INTO `posts`(user_id, name, title, content, category, image, status) VALUES(?,?,?,?,?,?,?)");
   $insert_post->execute([$user_id, $name, $title, $content, $category, $image, $status]);

   $message[] = '¡Post publicado!';
}

if (isset($_POST['draft'])) {

   $name = $_POST['name'];
   $title = $_POST['title'];
   $content = $_POST['content'];
   $category = $_POST['category'];
   $status = 'inactive'; 

   $insert_post = $conn->prepare("INSERT INTO `posts`(user_id, name, title, content, category, image, status) VALUES(?,?,?,?,?,?,?)");
   $insert_post->execute([$user_id, $name, $title, $content, $category, $image, $status]);

   $message[] = '¡Borrador guardado!';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Posts</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>

<body>

   <?php include '../components/u_header.php' ?>

   <section class="post-editor">

      <h1 class="heading">Añadir nuevo post</h1>

      <form action="" method="post" enctype="multipart/form-data">
         <input type="hidden" name="name" value="<?= $fetch_profile['name']; ?>">
         <p>Título del post<span>*</span></p>
         <input type="text" name="title" maxlength="100" required placeholder="Agregar título del post" class="box">
         <p>Contenido del post<span>*</span></p>
         <textarea name="content" class="box" required maxlength="10000" placeholder="Escribe tu contenido..." cols="30"
            rows="10"></textarea>
         <p>Categoría del post<span>*</span></p>
         <select name="category" class="box" required>
            <option value="" selected disabled>-- Selecciona una categoría --</option>
            <option value="Naturaleza">Naturaleza</option>
            <option value="Educación">Educación</option>
            <option value="Mascotas y animales">Mascotas y animales</option>
            <option value="Tecnología">Tecnología</option>
            <option value="Moda">Moda</option>
            <option value="Entretenimiento">Entretenimiento</option>
            <option value="Cine y animaciones">Cine y animaciones</option>
            <option value="Videojuegos">Videojuegos</option>
            <option value="Música">Música</option>
            <option value="Deportes">Deportes</option>
            <option value="Noticias">Noticias</option>
            <option value="Viajes">Viajes</option>
            <option value="Comedia">Comedia</option>
            <option value="Diseño y desarrollo">Diseño y desarrollo</option>
            <option value="Comida y bebidas">Comida y bebidas</option>
            <option value="Estilo de vida">Estilo de vida</option>
            <option value="Personal">Personal</option>
            <option value="Salud y fitness">Salud y fitness</option>
            <option value="Negocios">Negocios</option>
            <option value="Compras">Compras</option>
            <option value="Animaciones">Animaciones</option>
         </select>
         <p>Imagen del post</p>
         <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
         <div class="flex-btn">
            <input type="submit" value="Publicar post" name="publish" class="btn">
            <input type="submit" value="Guardar borrador" name="draft" class="option-btn">
         </div>
      </form>

   </section>

   <script src="../js/admin_script.js"></script>

</body>
</html>