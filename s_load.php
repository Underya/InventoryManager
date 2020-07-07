<?PHP

	//Настройка файла
	$filename = 'order ';
	//Формирование даты
	$d= getdate();
	$str_data = $d['mday'] . ':' . $d['mon'] . ':' . $d['year'];
	$filename .= $str_data . '.csv';
	
    //Use Content-Disposition: attachment to specify the filename
    header('Content-Disposition: attachment; filename='.basename($filename));

    //No cache
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    
	//Получение запроса
	$s = $_GET['req'];
		
	//Подключение БД
	include 'm/database.php';	
	$conn = db_manager::GetConnect();
	
	//Запрос к БД
	$res = $conn->SpecialSelect($s);
	
	//Создания тела файла
	$body = "";
	
	//Обработка результатов запроса
	$body .='Инвентарный номер;';
	$body .='Имя;';
	$body .='Корпус;';
	$body .='Номер помещения;';
	$body .='ФИО;';
	$body .='Группа;';
	$body .='Тип;';
	$body .='Модель;';
	$body .='Комментарий;';
	$body .='Количество;';
	$body .='еденица измерения;';
	$body .= PHP_EOL;
	
	//Циклические преобразования результата запроса
	while($row = mysqli_fetch_assoc($res))
	{
		
		$body .= $row["инвентарный_номер"] . ';';
		$body .= $row["имя"] . ';';
		$body .= $row["корпус"] . ';';
		$body .= $row["номер_помещения"] . ';';
		$body .= $row["ФИО"] . ';';
		$body .= $row["группа"] . ';';
		$body .= $row["тип"] . ';';
		$body .= $row["имя_модели"] . ';';
		$body .= $row["комментарий"] . ';';
		$body .= $row["количество"] . ';';
		$body .= $row["еденица_измерений"] . ';';
		$body .= PHP_EOL;
	}
	
	//Удаление тегов
	$doby = str_replace('<br>', '', $body);
	$doby = str_replace('</br>', '', $body);
	
	$s = mb_convert_encoding($body, 'windows-1251', 'UTF-8');
	
    ob_clean();
    flush();
    echo $s;
    exit;
?>