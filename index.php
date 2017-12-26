<?php 
session_start();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav">
            <li>
            <a href="index.php">Регистрация</a>
            </li>
            <li>
              <a href="fb.php">Сообщения</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <?php 
    	require "./assets/classes.php";
		require "./assets/config.php";
    
     ?>
     <!-- Кнопка Facebook -->
 <h4 style="text-align:center;">Войти через социальные сети</h4>
<p style="text-align:center;"><a href="https://www.facebook.com/v2.11/dialog/oauth?
  client_id=<?=ID?>
  &redirect_uri=<?=REDIRECT?>&response_type=code&scope=public_profile"><img class="img" src="./assets/images/FacebookButton.jpg" alt="Авторизация Facebook"></a></p>
  
</body>
</html>