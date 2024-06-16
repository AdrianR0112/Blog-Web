<?php

if(isset($_POST['like_post'])){

   if($user_id != ''){
      
      $post_id = $_POST['post_id'];
      $post_id = filter_var($post_id, FILTER_SANITIZE_STRING);
      $user_id = $_POST['user_id'];
      $user_id = filter_var($user_id, FILTER_SANITIZE_STRING);
      
      $select_post_like = $conn->prepare("SELECT * FROM `likes` WHERE post_id = ? AND user_id = ?");
      $select_post_like->execute([$post_id, $user_id]);

      if($select_post_like->rowCount() > 0){
         $remove_like = $conn->prepare("DELETE FROM `likes` WHERE post_id = ?");
         $remove_like->execute([$post_id]);
         $message[] = 'Eliminado de tus me gusta';
      }else{
         $add_like = $conn->prepare("INSERT INTO `likes`(user_id, post_id) VALUES(?,?)");
         $add_like->execute([$user_id, $post_id]);
         $message[] = 'Añadido a tus me gusta';
      }
      
   }else{
         $message[] = 'Por favor, inicia sesión primero!';
   }
}

?>