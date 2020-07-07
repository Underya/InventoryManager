<?PHP

	//Подключение класса для создания страниц
	include 'construct.php';
	//Подключение для класса групп
	include "m/item.php";
	
	//СОздание класса для конструкции страницы
	$cons = new construct();
	
	//Создание тела
	$item = new item();
	$body = 'НЕ ВЫШЛО';
	$body =  $item->getTable();
	
	//Формирование страницы
	$cons->set_hat("v/hat.html");
	$cons->set_name("Предметы");
	$cons->add_body($body);
	$cons->add_function("v/table_row_editor.js");
	$cons->add_r_block("v/item_table_r_block.html");
	$cons->add_function("v/delete_row.js");
	$cons->add_function('v/add_row.js');
	$cons->add_function('v/model_add.js');
	
	echo $cons->get_page();
	

?>