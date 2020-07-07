<?PHP

	//Подключение класса для создания страниц
	include 'construct.php';
	//Подключение для класса групп
	include "m/model.php";
	
	//СОздание класса для конструкции страницы
	$cons = new construct();
	
	//Создание тела
	$model = new model();
	$body = 'НЕ ВЫШЛО';
	$body =  $model->getTable();
	
	//Формирование страницы
	$cons->set_hat("v/hat.html");
	$cons->set_name("Модели");
	$cons->add_body($body);
	$cons->add_function("v/table_row_editor.js");
	$cons->add_r_block("v/table_r_block.html");
	$cons->add_function("v/delete_row.js");
	$cons->add_function('v/add_row.js');
	
	
	echo $cons->get_page();
	

?>