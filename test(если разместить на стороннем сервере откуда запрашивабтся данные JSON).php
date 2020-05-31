<?php
	$postdata = http_build_query(
		array(
			'var1' => 'some content',
			'var2' => 'doh'
		)
	);
	$opts = array('http' =>
		array(
			'method'  => 'POST',
			'header'  => 'Content-type: application/x-www-form-urlencoded',
			'content' => $postdata
		)
	);
	$context  = stream_context_create($opts);
	$result = file_get_contents('http://krapipl.imumk.ru:8082/api/mobilev1/update', false, $context);
	file_put_contents("json.js", "obj=".$result.";");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Тестовое задание">
    <meta name="keywords">
    <meta name="author" content="">
    <title>Тестовое задание </title>
    <link rel="stylesheet" href="https://www.imumk.ru/Content/skins/bubble/css/main.css">
    <link rel="stylesheet" href="https://www.imumk.ru/Content/skins/bubble/css/burger.css">
</head>
<script>
	var s;
	var obj;
	var script;

	window.onload = function() {
		document.getElementById("subj").value="";
		document.getElementById("genre").value="";
		document.getElementById("grade").value="";
		document.getElementById("search").value="";	
		script = document.createElement('script');
		script.src = "json.js?" + randomInteger(1, 99);
		document.head.append(script);
		script.onload = function() { start(); }
	}
	
	function start(){
		for(let i = 0; i < obj.items.length; i++){
			let grade_ = (obj.items[i].grade).replace(/;/,"-")
			if (grade_.indexOf(";") != -1){
				let grade_start = grade_.indexOf("-");
				let grade_end = grade_.lastIndexOf(";");
				let grade_del = grade_.substr(grade_start, grade_end);
				grade_ = grade_.replace(new RegExp(grade_del,'g'),"-")
			}
			if (grade_.indexOf("-") != -1) {s="ы";} else {s="";}
			let inhtml='<li id="p'+obj.items[i].courseId+'" class="courses-sci"> \
					<div class="sci-figure"> \
					    <img src="https://www.imumk.ru/svc/coursecover/'+obj.items[i].courseId+'" alt="'+obj.items[i].subject+'"> \
					</div> \
					<div class="sci-info"> \
						<p class="sci-title">'+obj.items[i].subject+'</p> \
						<p class="sci-grade">'+grade_+' класс'+s+'</p> \
						<p class="sci-genre">'+obj.items[i].genre+'</p> \
						<p class="sci-meta"><a href="'+obj.items[i].shopUrl+'" target="_blank">Подробнее</a></p> \
						<p class="sci-controls"> \
                            <a id="a'+obj.items[i].courseId+'" onclick ="next('+obj.items[i].courseId+');" class="pure-button pure-button-primary btn-fluid">'+obj.items[i].price+' &#8381;</a> \
						</p> \
					</div> \
				</li>';
			courseslist.insertAdjacentHTML("beforeend", inhtml);
		}
	}

	function randomInteger(min, max) {
		let rand = min + Math.random() * (max + 1 - min);
		return Math.floor(rand);
	}
 
	function next(txt){
		for(let i = 0; i < obj.items.length; i++){
			if (obj.items[i].courseId==String(txt)){ 
				if (obj.items[i].description != "" ) {alert (obj.items[i].description);}
				return;
			}
		}
	}
	
	function check(x){
		let rb;
		for(let i = 0; i < obj.items.length; i++){
			if (x == "rub"){ rv=obj.items[i].price+' ₽'; }
			if (x == "bonus"){ rv=obj.items[i].priceBonus+' Бонуса'; }
			document.getElementById("a"+obj.items[i].courseId).innerText=rv;			
		}
	}

	function search_(x){
		if ( x == 13 ) {subj_()}
	}
	
	function subj_(){
		let sea = (document.getElementById("search").value).toLowerCase();
		let opt = document.getElementById("subj").value;
		let gen = document.getElementById("genre").value;
		let gra = document.getElementById("grade").value;
		let displ;
		for(let i = 0; i < obj.items.length; i++){
			displ="none";
			if ( (opt == obj.items[i].subject || opt == "") && 
				(gen == obj.items[i].genre || gen == "") && 
					( klass(obj.items[i].grade, gra)  || gra == "") &&
						( compare (sea, i) || sea == ""	)	){
							displ="block";
			}
			document.getElementById("p"+obj.items[i].courseId).style.display=displ;
		}
	}
	
	function klass(g1, g2){
		let ar = g1.split(";");
		for (let i = 0; i< ar.length; i++){
			if (g2 == ar[i]) { return true; }
		}
		return false;
	}

	function compare(z, i){
		if ( obj.items[i].subject.toLowerCase().indexOf(z) != -1 ||
				obj.items[i].genre.toLowerCase().indexOf(z) != -1 ||
					obj.items[i].description.toLowerCase().indexOf(z) != -1 ||
						obj.items[i].title.toLowerCase().indexOf(z) != -1 ) {
							return true;
		} else {
			return false;
		}
	}

</script>

    
 <body>
    <div class="wrapper">
        <div class="content">

 
<div class="l-container-4">
    <h1 class="u-text-center">Витрина
    </h1>

    <div class="courses u-mt-30">
        <div class="courses-form form" id="filterform" role="form">
            <div>
                <select id="subj" name="subj" onchange="subj_()">
                    <option value="">Все предметы</option>
                    <option>Алгебра</option>
                    <option>Английский язык</option>
                    <option>Биология</option>
                    <option>География</option>
                    <option>Геометрия</option>
                    <option>Демо-версия</option>
                    <option>Информатика</option>
                    <option>История</option>
                    <option>Литература</option>
                    <option>Математика</option>
                    <option>Обществознание</option>
                    <option>Окружающий мир</option>
                    <option>Робототехника</option>
                    <option>Русский язык</option>
                    <option>Физика</option>
                    <option>Химия</option>
                </select>
            </div>
            <div>
                <select id="genre" name="genre" onchange="subj_()">
                    <option value="">Все жанры</option>
                        <option>Демо</option>
                        <option>Задачник</option>
                        <option>Подготовка к ВПР</option>
                        <option>Подготовка к ЕГЭ</option>
                        <option>Рабочая тетрадь</option>
                </select>
            </div>
            <div>
                <select id="grade" name="grade" onchange="subj_()">
                    <option value="">Все классы</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                        <option>7</option>
                        <option>8</option>
                        <option>9</option>
                        <option>10</option>
                        <option>11</option>
                </select>
            </div>
            <div>
                <input class="borderFind" type="text" placeholder="Поиск" id="search" name="search" onkeydown="search_(event.keyCode);">
                <button class="courses-form-search-btn" type="submit" title="Найти" onclick="subj_()">
					<img src="https://www.imumk.ru/Content/skins/bubble/images/icons/icon-search-25.png" style="vertical-align: middle"></button>
            </div>
        </div>
		<div style="border: 1px solid grey; border-radius: 5px; width: 97%; margin-right: auto; margin-left: auto;"  align="center">
			<input name="dzen" type="radio" value="price" onclick="check('rub');" checked>
			<b>РУБЛИ или БОНУСЫ</b>
			<input name="dzen" type="radio" value="priceBonus" onclick="check('bonus');">
		</div>

    </div>
    <h1 class="u-text-center" id="InfoH1" style="display: block;">Результаты поиска:</h1>
    <ul class="courses-list" id="courseslist" style="margin: 0px 0px 20px;">
    </ul>

</div>

            
        </div>

<div class="l-footer">
    <div class="footer">
        <div class="footer-legal">
            <p>© Тестовое задание выполнил Войтеха Артем Аркадьевич</p>
        </div>
    </div>
</div>



</body></html>