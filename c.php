<?PHP
	//Контролер, возвращающий содержимое по запросу
	//Пока только 1 страница)
		
	$hat = file_get_contents("v/hat.html");
	echo $hat;
?>
