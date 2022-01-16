<?php

$time = explode("T", explode(".", json_decode(file_get_contents("http://worldtimeapi.org/api/ip"))->datetime)[0]);
$timeYMD = $time[0];
$timeHM = explode(":", $time[1]);
unset($timeHM[2]);
$timeHM = implode(":", $timeHM);

$connect = mysqli_connect("localhost", "root", "root", "newsboard") or die("Ошибка - подключение к БД");

$lastNewsID = $_POST['lastNewsID'];

$title = $_POST['title'];
$text = $_POST['text'];
$tags = $_POST['tags'];

$lastIDNews = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `id` FROM `news` ORDER BY `id` DESC LIMIT 1"))['id'] + 1;

mysqli_query($connect, "INSERT INTO `news` (`id`, `title`, `text`, `time`) VALUES ('".$lastIDNews."', '".$title."', '".$text."', '".$timeYMD." в ".$timeHM."')") or die("error full create layer");

if($tags == "" || $tags == null || $tags == undefined){
	
	goto ech;
	
}

$tag = explode(" ", $tags);

for($i = 0; $i <= 2; $i++){
	mysqli_query($connect, "INSERT INTO `tags` (`idNews`, `tag`) VALUES ('".$lastIDNews."', '".$tag[$i]."')");
}

ech:

$dataDB = mysqli_query($connect, "SELECT * FROM `news` WHERE `id` > '".$lastNewsID."'") or die("Ошибка - выбор новостей");
			
while($data = mysqli_fetch_assoc($dataDB)){
				
	echo '
				
		<div class="news news'.$data['id'].'">
			<div class="title"><span id="name">'.$data['title'].'</span><span id="idMes"> ['.$data['id'].']</span><img src="https://cdn3.iconfinder.com/data/icons/pyconic-icons-1-2/512/close-512.png" id="deleteNewsPost" title="Удалить"><span id="time">'.$data['time'].'</span></div>
			<div class="content">'.$data['text'].'</div>
			<div class="desc">';
							
	$tags = mysqli_query($connect, "SELECT * FROM `tags` WHERE `idNews` = '".$data['id']."'");

	$iTag = 0;

	while($tagSet = mysqli_fetch_assoc($tags)){
		
		if($iTag == 0){
			
			echo '<img src="https://cdn3.iconfinder.com/data/icons/unicons-vector-icons-pack/32/tags-512.png" id="icon">';
			
		}
					
		echo "<span id='tag".$iTag."'>".$tagSet['tag']."</span>";
					
		$iTag++;
					
	}
							
							
	echo '<div id="change">Изменить</div></div>
		</div>
				
	';
				
}

?>