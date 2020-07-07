<?PHP

	//Подключение класса для создания страниц
	include 'construct.php';
	//Подключение для класса групп
	include 'm/database.php';
	
	//СОздание класса для конструкции страницы
	$cons = new construct();
	
	//Создание тела
	$body = file_get_contents('v/invent.html');
	
	//Запрос к БД
	$db = db_manager::GetConnect();
	
	//Формирование селектора для помещения
	$s_type = "<option value='-1' selected='true'>Все</option>";
	//Получение всех типов
	$rows = $db->GetAllTables('помещение');
	while($row = mysqli_fetch_assoc($rows))
	{
		$s_type .= '<option value="' . $row['ID'] . '">' .
			$row['номер_помещения']. ' '. $row['часть_здания'] . "</option>";
	}
	
	$body = str_replace('<option_room>', $s_type, $body);
	
	
	//Формирование селектора для тип
	$s_type = "<option value='-1' selected='true'>Все</option>";
	//Получение всех типов
	$rows = $db->GetAllTables('тип');
	while($row = mysqli_fetch_assoc($rows))
	{
		$s_type .= '<option value="' . $row['ID'] . '">' .
			$row['наименование'] . "</option>";
	}
	
	$body = str_replace('<option_type>', $s_type, $body);
	
	//Формирование селектора для ответственных
	$s_type = "<option value='-1' selected='true'>Все</option>";
	//Получение всех типов
	$rows = $db->GetAllTables('человек');
	while($row = mysqli_fetch_assoc($rows))
	{
		$s_type .= '<option value="' . $row['ID'] . '">' .
			$row['ФИО'] . "</option>";
	}
	
	$body = str_replace('<option_man>', $s_type, $body);
	
	//Формирование селектора для групп
	$s_type = "<option value='-1' selected='true'>Все</option>";
	//Получение всех типов
	$rows = $db->GetAllTables('группа');
	while($row = mysqli_fetch_assoc($rows))
	{
		$s_type .= '<option value="' . $row['ID'] . '">' .
			$row['наименование'] . "</option>";
	}
	
	$body = str_replace('<option_group>', $s_type, $body);
	
	
	
	//Формирование страницы
	$cons->set_hat("v/hat.html");
	$cons->set_name("Создание отчёта");
	$cons->add_body($body);
			
	
	echo $cons->get_page();
	

?>