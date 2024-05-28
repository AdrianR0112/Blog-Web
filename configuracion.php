<?php
  require_once 'vendor/autoload.php';

  $clientID = '60009960162-bjt1fsvscunei1th7un6el8o9f14c46m.apps.googleusercontent.com';
  $clientSecret = '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';
  $redirectUri = 'http://localhost/Blog/home.php';

  // create Client Request to access Google API
  $client = new Google_Client();
  $client->setClientId($clientID);
  $client->setClientSecret($clientSecret);
  $client->setRedirectUri($redirectUri);
  $client->addScope("email");
  $client->addScope("profile");

?>