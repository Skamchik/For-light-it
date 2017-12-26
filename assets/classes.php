<?php 
require "config.php";
class authFb{
	public $id;
	public $secret;
	public $redirect;
	public $code;

	function __construct($id, $secret, $redirect, $code){
		$this->id=$id;
		$this->secret=$secret;
		$this->redirect=$redirect;
		$this->code=$code;
	}
	//полученния данных пользователя авторизировавшегося через facebooc
	function getData(){

		$token = json_decode(file_get_contents('https://graph.facebook.com/v2.11/oauth/access_token?client_id='.$this->id.'&redirect_uri='.$this->redirect.'&client_secret='.$this->secret.'&code='.$this->code), true);
		

		$data = json_decode(file_get_contents('https://graph.facebook.com/v2.11/me?client_id='.$this->id.'&redirect_uri='.$this->redirect.'&client_secret='.$this->secret.'&code='.$this->code.'&access_token='.$token['access_token'].'&fields=name'), true);
		if (!$data) {
			exit('error data');
		}

		return $data;
	}
} 

class managerDb{
	private $host = HOST;
	private $user = USER;
	private $pass = PASS;
	private $dbname = DBNAME;


	function connect(){
		$dsn='mysql:host='.$this->host.';dbname='.$this->dbname.';charset=utf8;';
		$options=array(
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
			PDO::MYSQL_ATTR_INIT_COMMAND=>'set names utf8'

		); 
		$pdo=new PDO($dsn, $this->user, $this->pass, $options);
		return $pdo;
	}
}

class message{
	
	public $username;
	public $text;
	public $perentid;

	function __construct($username, $text, $perentid){
		
		$this->username=$username;
		$this->text=$text;
		$this->perentid=$perentid;
	}
	function intoDB(){
		$db=new managerDb;
		$pdo=$db->connect();
		$date=@date('Y-m-d H:i:s');
		$ins='insert into messages (date,username,text,perentid)values(?,?,?,?)';
		$ps=$pdo->prepare($ins);
		$ps->execute(array($date,$this->username,$this->text,$this->perentid));
	}

	static function fromDB($perentid){
		$db=new managerDb;
		$pdo=$db->connect();
		if ($perentid == 0) {
			$sel='select * from messages where perentid = ?';
		}
		else{
			$sel='select * from messages where perentid = ? ORDER BY id DESC';
		}
		$ps=$pdo->prepare($sel);
		$ps->execute(array($perentid));
		return $ps;
	}
}

class show{
	function getMessage($res1){
		// echo "<li class='click'id=\"".$res1['id']."\">";
		echo "<div class='author'>".$res1['username']."</div>";
		echo "<div class='date'>".$res1['date']."</div>";
		echo "<div class='id'>Сообщение №".$res1['id']."</div>";
		echo "<div class='text'>".$res1['text']."</div>";
		// echo "<a href=\"#comment_from\" class=\"reaply\" id=\"".$res1['id']."\">Ответить</a>";

		$perentid2 = $res1['id'];
		$res2 = message::fromDB($perentid2);
		if ($res2 > 0) {
			echo "<ul class='rg'>";
			while($row1 = $res2->fetch(PDO::FETCH_LAZY)){
				$show = new show;
				$show->getMessage($row1);
		}


			echo "</ul>";	
		}
		
		echo "</li>";
	}
	

	static function show_tree(){
		$perentid = 0;
		$res = message::fromDB($perentid);

		while($row = $res->fetch(PDO::FETCH_LAZY)){
			$show = new show;
			$show->getMessage($row);
		}

		
	}
}

?>