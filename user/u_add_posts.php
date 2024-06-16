<?php

include '../components/connect.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:../login.php');
   exit(); // Agregar exit después de redirigir para evitar que el script siga ejecutándose
}

if (isset($_POST['publish'])) {

   $name = $_POST['name'];
   $title = $_POST['title'];
   $content = $_POST['content'];
   $category = $_POST['category'];
   $status = 'active';

   // Validar y procesar la imagen subida
   $image = $_FILES['image']['name'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_img/' . $image;

   // Verificar si se ha seleccionado una imagen
   if (!empty($image)) {
      $image_size = $_FILES['image']['size'];

      // Verificar el tamaño de la imagen
      if ($image_size > 2000000) {
         $message[] = '¡El tamaño de la imagen es demasiado grande!';
      } else {
         // Mover la imagen al directorio de carga
         move_uploaded_file($image_tmp_name, $image_folder);
      }
   } else {
      $image = ''; // Si no se sube una imagen, asignar cadena vacía
   }

   // Insertar el post en la base de datos
   $insert_post = $conn->prepare("INSERT INTO `posts`(user_id, name, title, content, category, image, status) VALUES(?,?,?,?,?,?,?)");
   $insert_post->execute([$user_id, $name, $title, $content, $category, $image, $status]);

   $message[] = '¡Post publicado!';

}

if (isset($_POST['draft'])) {

   $name = $_POST['name'];
   $title = $_POST['title'];
   $content = $_POST['content'];
   $category = $_POST['category'];
   $status = 'inactive'; // Cambiar el estado del post a 'inactive' para un borrador

   // Validar y procesar la imagen subida (código similar al anterior)

   // Insertar el borrador del post en la base de datos
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

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
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
            <option value="nature">Naturaleza</option>
            <option value="education">Educación</option>
            <option value="pets and animals">Mascotas y animales</option>
            <option value="technology">Tecnología</option>
            <option value="fashion">Moda</option>
            <option value="entertainment">Entretenimiento</option>
            <option value="movies and animations">Cine y animaciones</option>
            <option value="gaming">Videojuegos</option>
            <option value="music">Música</option>
            <option value="sports">Deportes</option>
            <option value="news">Noticias</option>
            <option value="travel">Viajes</option>
            <option value="comedy">Comedia</option>
            <option value="design and development">Diseño y desarrollo</option>
            <option value="food and drinks">Comida y bebidas</option>
            <option value="lifestyle">Estilo de vida</option>
            <option value="personal">Personal</option>
            <option value="health and fitness">Salud y fitness</option>
            <option value="business">Negocios</option>
            <option value="shopping">Compras</option>
            <option value="animations">Animaciones</option>
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