<?PHP

	//Подключение класса для создания страниц
	include 'construct.php';
	//Подключение для класса групп
	include "m/type.php";
	
	//СОздание класса для конструкции страницы
	$cons = new construct();
	
	//Создание тела
	$type = new type();
	$body = 'НЕ ВЫШЛО';
	$body =  $type->getTable();
	
	//Формирование страницы
	$cons->set_hat("v/hat.html");
	$cons->set_name("Типы");
	$cons->add_body($body);
	$cons->add_function("v/table_row_editor.js");
	$cons->add_r_block("v/table_r_block.html");
	$cons->add_function("v/delete_row.js");
	$cons->add_function('v/add_row.js');	
	
	
	echo $cons->get_page();
	

?>