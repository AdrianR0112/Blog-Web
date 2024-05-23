<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/like_post.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Categorias</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>




<section class="categories">

   <h1 class="heading">Categorías</h1>

   <div class="box-container">
      <div class="box"><span>01</span><a href="category.php?category=nature">Naturaleza</a></div>
      <div class="box"><span>02</span><a href="category.php?category=eduction">Educacion</a></div>
      <div class="box"><span>03</span><a href="category.php?category=pets and animals">Mascotas y animales</a></div>
      <div class="box"><span>04</span><a href="category.php?category=technology">Tecnologia</a></div>
      <div class="box"><span>05</span><a href="category.php?category=fashion">Moda</a></div>
      <div class="box"><span>06</span><a href="category.php?category=entertainment">Entretenimiento</a></div>
      <div class="box"><span>07</span><a href="category.php?category=movies">Peliculas</a></div>
      <div class="box"><span>08</span><a href="category.php?category=gaming">Juegos</a></div>
      <div class="box"><span>09</span><a href="category.php?category=music">Musica</a></div>
      <div class="box"><span>10</span><a href="category.php?category=sports">Deportes</a></div>
      <div class="box"><span>11</span><a href="category.php?category=news">Noticias</a></div>
      <div class="box"><span>12</span><a href="category.php?category=travel">Viajes</a></div>
      <div class="box"><span>13</span><a href="category.php?category=comedy">Comedia</a></div>
      <div class="box"><span>14</span><a href="category.php?category=design and development">Diseño y desarrollo</a></div>
      <div class="box"><span>15</span><a href="category.php?category=food and drinks">Comida y bebidas</a></div>
      <div class="box"><span>16</span><a href="category.php?category=lifestyle">Lifestyle</a></div>
      <div class="box"><span>17</span><a href="category.php?category=health and fitness">Salud y fit</a></div>
      <div class="box"><span>18</span><a href="category.php?category=business">Negocios</a></div>
      <div class="box"><span>19</span><a href="category.php?category=shopping">Compras</a></div>
      <div class="box"><span>20</span><a href="category.php?category=animations">Animaciones</a></div>
   </div>

</section>


<?php include 'components/footer.php'; ?>


<script src="js/script.js"></script>

</body>
</html>