<?php 
session_start();
require "./assets/classes.php";
require "./assets/config.php";
//обработка данных от Facebook, регистрация пользователя
if (!$_SESSION['name']) {
	if ($_GET['code']) {
		$code = $_GET['code'];
		$id = ID;
		$secret = SECRET;
		$redirect = REDIRECT;
		$auth = new authFb($id, $secret, $redirect, $code);
		$data = $auth->getData();

		$_SESSION['name'] = $data['name'];
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/
	bootstrap.min.css">
	<link rel="stylesheet" href="./assets/style/style.css">
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
          <div >
          	<h3 class="name">Вы вошли как:<?php echo $_SESSION['name'];?></h3>
          </div>
        </div>
      </div>
    </nav>
<?php 
if (!$_SESSION['name']) {
	echo "Для добавления и коментирования сообщений выполните вход <br/>";
	echo"<a href='index.php'>Регистрация</a>";
}
else{
		
	
	 echo "<form class='comment_from' action='./assets/formhandler.php' method='post'>
	 	<input class='inid' type='text' name='perentid'>Напишите номер сообщения на которое хотите ответить</input><br/><br/>
	  	<input class='inms' type='text' name='message'></input><br/>
	  	<input class='sub' type='submit' name='addmessage' value='Добавить сообщение'>
	  </form>";
  }
 ?>
  <br/>

  <div id="wrapper">
		<div id="content">
			<ul id="comments">
				<?php
					show::show_tree();
				?>
			</ul>
			<br />
		</div> 
	</div> 




	
</body>
</html>