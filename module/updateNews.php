<?php

$connect = mysqli_connect("localhost", "root", "root", "newsboard") or die("Ошибка - подключение к БД");

$idNews = $_POST['idNews'];
$title = $_POST['title'];
$text = $_POST['text'];
$text = str_replace("'", '"', $text);

$tag1 = $_POST['tag1'];
$tag2 = $_POST['tag2'];
$tag3 = $_POST['tag3'];

$tags = array($tag1, $tag2, $tag3);

mysqli_query($connect, "UPDATE `news` SET `title` = '".$title."', `text` = '".$text."' WHERE `id` = '".$idNews."'") or die("Ошибка обновления новости");

$dataTags = mysqli_query($connect, "SELECT `id` FROM `tags` WHERE `idNews` = '".$idNews."'");

$i = 0;

while($tag = mysqli_fetch_assoc($dataTags)){
	
	mysqli_query($connect, "UPDATE `tags` SET `tag` = '".$tags[$i]."' WHERE `id` = '".$tag['id']."'");
	
	$i++;
	
}

$dataDB = mysqli_query($connect, "SELECT * FROM `news` WHERE `id` = '".$idNews."'") or die("Ошибка - выбор новостей");
			
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