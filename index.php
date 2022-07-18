<?php

session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="css/glowna.css">
<link href="css/logowanie.css" rel="stylesheet" type="text/css">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"> <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Boostnet Zamówienia CRM </title>
</head> 
<body>
<div id="panel">
    <img src="img/logo.png" width="400">
    <?php if (empty($_SESSION['user'])) : ?>
    <form action="login.php" method="post">
      <label for="username">Nazwa użytkownika:</label>
      <input type="text" id="username" name="login" /> 
      <br/> 
      <label for="password">Hasło:</label>
      <input type="password" id="password" name="password" /><br>
      <br/>
      <div id="lower">
            <input type="checkbox"><label class="check" for="checkbox">Zapamiętaj mnie!</label>
            <input type="submit" value="Login">
    </form>
    </div>
    <?php else : ?>
    <div class="container">
        <div class="box">
        <p>Witaj, <?=$_SESSION['user']?></p>
        <br>
         <a href="tabelka.php"> <img src="img/zamawiarka.png"></a><br>
            <br>
            <img src="img/serwis.png"><br>
            <br>
            <a href="logout.php"> <img src="img/wyloguj.png"></a><br>
        
    <?php endif; ?>
    </div>
        </div>
</body>
</html>