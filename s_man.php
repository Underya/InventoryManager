<?PHP
	//Подключение класса для создания страниц
	include 'construct.php';
	//СОздание класса
	$cons = new construct();
	
	//Для создания тела нужен запрос к модели
	include "m/man.php";
	$man = new man();
	$body = 'НЕ ВЫШЛО';
	$body = $man->getTable();
	
	//Формирование тела
	$cons->set_hat("v/hat.html");
	$cons->set_name("Ответственные");
	$cons->add_body($body);
	$cons->add_function("v/table_row_editor.js");
	$cons->add_r_block("v/table_r_block.html");
	$cons->add_function("v/delete_row.js");
	$cons->add_function('v/add_row.js');
	//$page = str_replace("<tимя-сайтаt>", "ответсветнные", $temp);
	//$page = str_replace("<tшапкаt>", $hat, $page);
	//$page = str_replace("<tсодержимоеt>", $body, $page);
	
	echo $cons->get_page();
?>