<?php

$connect = mysqli_connect("localhost", "root", "root", "newsboard") or die("Ошибка - подключение к БД");

?>

<!DOCTYPE html>
<html>

<head>
	<title>News</title>
	
	<link rel="stylesheet" href="css/style.css">
	<link rel="shortcut icon" href="https://e7.pngegg.com/pngimages/748/607/png-clipart-news-media-newspaper-advertising-information-news-icon-text-orange-thumbnail.png">
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script src="js/jquery-ui.js"></script>
</head>

<body>

	<main>
		
		<div class="listForAddingNewPost">
			
			<span>Заголовок</span>
			<input type="text" placeholder="Введите заголовок" id="titulLFANP">
			<span>Текст</span>
			<div id="textLFANP" contenteditable></div>
			<span>Теги</span>
			<input type="text" placeholder="Введите 3 тега через пробел" id="tagsLFANP">
		
		</div>
		<div class="addNewsButton">Добавить запись</div>
		
		<?php
		
			$dataDB = mysqli_query($connect, "SELECT * FROM `news` ORDER BY `id` DESC") or die("Ошибка - выбор новостей");
			
			if(mysqli_num_rows($dataDB) == 0){
				
				echo "<div class='notNews'>Новостей не найдено</div>";
				exit;
				
			}else{
				
				echo "<div class='amountNews'>Новости: <span>".mysqli_num_rows($dataDB)." posts</span></div>";
				
			}
			
			while($data = mysqli_fetch_assoc($dataDB)){
				
				echo '
				
					<div class="news news'.$data['id'].'">
						<div class="title"><span id="name">'.$data['title'].'</span><span id="idMes"> ['.$data['id'].']</span><img src="https://cdn3.iconfinder.com/data/icons/pyconic-icons-1-2/512/close-512.png" id="deleteNewsPost" title="Удалить"><span id="time">'.$data['time'].'</span></div>
						<div class="content">'.$data['text'].'</div>
						<div class="desc">
							<img src="https://cdn3.iconfinder.com/data/icons/unicons-vector-icons-pack/32/tags-512.png" id="icon">';
							
				$tags = mysqli_query($connect, "SELECT * FROM `tags` WHERE `idNews` = '".$data['id']."'");

				$iTag = 0;

				while($tagSet = mysqli_fetch_assoc($tags)){
					
					echo "<span id='tag".$iTag."'>".$tagSet['tag']."</span>";
					
					$iTag++;
					
				}
							
							
				echo '<div id="change">Изменить</div></div>
					</div>
				
				';
				
			}
		
		?>
		
	</main>
	
	<div class="option">
		<img src="https://www.mcicon.com/wp-content/uploads/2020/12/Abstract_Eye_1-copy-5.jpg">
	</div>
	<div class="settings">
		<div class="showID"><span>Показать id </span><div class="checker"></div></div>
		<div class="listQuery">
		
			<div class="query"><span id="commandsql">INSERT INTO </span> `news` <span id="paramsql">(`id`, `title`, `text`, `time`) <span id="commandsql">VALUES</span> ('lastIDNews', 'title', 'text', 'timeYMD в timeHM')</span><div class="desc">
				добавляет новую запись в таблицу 'news'.
			</div></div>
			
			<div class="query"><span id="commandsql">SELECT <span id="allsql">*</span> FROM</span> `news` <span id="commandsql">ORDER BY <span id="paramsql">`id`</span> DESC</span><div class="desc">
				выводит все новости, которые есть из таблице 'news' в обратном порядке.
			</div></div>
			
			<div class="query"><span id="commandsql">UPDATE </span> `news` <span id="commandsql">SET</span> <span id="paramsql">`title` = 'title', `text` = 'text'</span><span id="commandsql"> WHERE </span><span id="paramsql">`id` = 'idNews'</span><div class="desc">
				обновляет таблицу 'news', устанавливая новые значение существующей записи.
			</div></div>
			
			<div class="query"><span id="commandsql">DELETE FROM </span> `news` <span id="commandsql">WHERE</span> <span id="paramsql">`id` = 'deletePostID'</span><div class="desc">
				удаляет запись из таблицы 'news'
			</div></div>
			<!--INSERT INTO `news` (`id`, `title`, `text`, `time`) VALUES ('".$lastIDNews."', '".$title."', '".$text."', '".$timeYMD." в ".$timeHM."')
			
			UPDATE `news` SET `title` = '".$title."', `text` = '".$text."' WHERE `id` = '".$idNews."'-->
		</div>
	</div>
	
	<script>
	
	window.onload = function(){
		
		let topNewsCoord = {};
		
		let firstNewsEl = document.querySelectorAll("main .news");
		firstNewsEl = firstNewsEl[(firstNewsEl.length - 1)].classList[1].replace("news", "");
		
		//console.log(topNewsCoord);
		
		$("body").on("mouseenter", "main .news .title #time, main .amountNews span", function(){
			$(this).css("color", "#303030");
		});
		
		$("body").on("mouseleave", "main .news .title #time, main .amountNews span", function(){
			$(this).css("color", "#aeaeae");
		});
		
		$("body").on("mouseenter", "main .news .desc span", function(){
			
			$(this).css("background", "#e6e6e6");
			
		});
		
		$("body").on("mouseleave", "main .news .desc span", function(){
			
			$(this).css("background", "initial");
			
		});
		
		let clickOptionSetting = false;
		
		let rightSetting;
		
		$(".option img").click(function(){
			
			if(clickOptionSetting == false){
			
				rightSetting = $(".settings").css("right");
				
				windowWidth = document.documentElement.clientWidth;
				//console.log(windowWidth);
			
				$(".option").animate({"right": (((windowWidth/100)*40) - 80)+"px"}, 500);
				$("main").animate({"left": "20px"}, 500);
				$(".settings").animate({"right": "0px"}, 500);
				clickOptionSetting = true;
				
				
			}else{
				
				$(".option").animate({"right": "0px"}, 500);
				$("main").animate({"left": "20vw"}, 500);
				$(".settings").animate({"right": rightSetting}, 500);
				clickOptionSetting = false;
				
			}
			
		});
		
		let heightMain = document.querySelector("main").getBoundingClientRect().height;
		
		$(".settings").css("height", heightMain + "px");
		
		let checker = false;
		
		$(".checker").click(function(){
			if(checker == false){
				$(this).css("background", "green");
				$("main .news .title #idMes").css("display", "initial");
				checker = true;
			}else{
				$(this).css("background", "crimson");
				$("main .news .title #idMes").css("display", "none");
				checker = false;
			}
		
		});
		
		let changeNewsID = 0;
		
		let changeNews = false;
		
		$("body").on("click", "main .news .desc #change", function(){
			
			let IDNews = this.parentElement.parentElement.classList[1].replace("news", "");
			
			if(changeNews == false){
				
				$(this).text("Применить");
				
				changeNewsID = IDNews;
				
				$("main .news"+changeNewsID+" .title #name, main .news"+changeNewsID+" .content, main .news"+changeNewsID+" .desc span").attr("contenteditable", "true");
				$("main .news"+changeNewsID+" .title #name, main .news"+changeNewsID+" .content, main .news"+changeNewsID+" .desc span").css("background", "#e6e6e6");
				
				changeNews = true;
				
			}else if(changeNews == true && changeNewsID == IDNews){
				
				$(this).text("Изменить");
				
				$("main .news"+changeNewsID+" .title #name, main .news"+changeNewsID+" .content, main .news"+changeNewsID+" .desc span").attr("contenteditable", "false");
				$("main .news"+changeNewsID+" .title #name, main .news"+changeNewsID+" .content, main .news"+changeNewsID+" .desc span").css("background", "initial");
				
				let newTitle = $("main .news"+changeNewsID+" .title #name").text();
				let newText = $("main .news"+changeNewsID+" .content").text();
				
				let tag1 = $("main .news"+changeNewsID+" .desc span#tag"+0).text();
				let tag2 = $("main .news"+changeNewsID+" .desc span#tag"+1).text();
				let tag3 = $("main .news"+changeNewsID+" .desc span#tag"+2).text();
				
				$.ajax({
					
					url: "module/updateNews.php",
					method: "POST",
					data: {
						
						idNews: changeNewsID,
						title: newTitle,
						text: newText,
						tag1: tag1,
						tag2: tag2,
						tag3: tag3
						
					},
					success: function(data){
						
						$("main .news"+changeNewsID).remove();
						$("main .news"+(changeNewsID-1)).before(data);
						console.log(data);
						
					}
					
					
				});
				
				console.log(tag1);
				
				changeNews = false;
				
			}else{
				
				$("main .news"+changeNewsID+" .desc #change").stop();
				$("main .news"+changeNewsID+" .desc #change").css({"color": "red"});
				$("main .news"+changeNewsID+" .desc #change").animate({"color": "#4682B4"}, 1000);
				
				return false;
				
			}
			
		});
		
		$("main .news .desc #change").mouseenter(function(){
			
			$(this).css("opacity", "1");
			
		});
		
		$("main .news .desc #change").mouseleave(function(){
			
			$(this).css("opacity", "0.5");
			
		});
		
		let clickAddPost = false;
		
		$("main .addNewsButton").click(function(){
			
			let lastNewsID = document.querySelectorAll("main .news")[0].classList[1].replace("news", "");
			
			if(clickAddPost == false){
			
				$("main .listForAddingNewPost").css({"display": "block"});
				$(this).text("Опубликовать");
				clickAddPost = true;
				
			}else if(clickAddPost == true){
				
				let title = $("main .listForAddingNewPost input#titulLFANP").val();
				let text = $("main .listForAddingNewPost #textLFANP").html();
				let tags = $("main .listForAddingNewPost input#tagsLFANP").val();
				
				$("main .listForAddingNewPost input#titulLFANP").val("");
				$("main .listForAddingNewPost #textLFANP").html("");
				$("main .listForAddingNewPost input#tagsLFANP").val("");
				
				$.ajax({
				
					url: "module/createNews.php",
					method: "POST",
					data: {
					
						lastNewsID: lastNewsID,
						title: title,
						text: text,
						tags: tags,
					
					},
					success: function(data){
					
						$("main .news"+lastNewsID).before(data);
					
					}
				
				});
				
				$("main .listForAddingNewPost").css({"display": "none"});
				$(this).text("Добавить запись");
				clickAddPost = false;
				
			}
			
		});
		
		$("body").on("click", "main .news .title #deleteNewsPost", function(){
			
			let idDeletePost = this.parentElement.parentElement.classList[1].replace("news", "");
			
			$.ajax({
				
				url: "module/deletePost.php",
				method: "POST",
				data: {
					
					idDeletePost: idDeletePost
					
				},
				success: function(data){
					
					if(data == "deleted"){
						
						$("main .news"+idDeletePost).animate({"left": "-100vw"}, 500);
						
						setTimeout(function(){
							
							$("main .news"+idDeletePost).remove();
							
						}, 500);
						
					}
					
				}
				
			});
			
		});
		
	}
	
	</script>
	
</body>

</html>