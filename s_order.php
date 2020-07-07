<?PHP
	//Подключение модуля с ДБ
	if(!$include_db){
		include 'm/database.php';
		//Указать - что модуль включён
		$include_db = true;
	}
	include 'm/item.php';
	//Подключение класса для создания страниц
	include 'construct.php';
	
	//Создание запроса
	$req = 'SELECT * FROM п_предметы ';
	
	//Условия сортировки запроса
	$if ="";
	
	//Помещение
	//есть ли выбранные элементы
	if (count($_POST['room']) > 0) {
		//Если выбран элемент - всё, конец разбра
		$arr = $_POST['room'];
		if($arr[0] != -1){
			//Создание всмпогательного условия
			$vsptext = '( ';
			//Для каждого элемента добавления условия
			foreach($arr as $id_t){
				$vsptext .= "id_помещения='" . $id_t . "' or ";
			}
			//В конце закрыть
			$vsptext .= 'false) ';
			//Добавление ко всем тексту
			$if .= $vsptext;
		}			
	
	}
	
	//Типы
	//есть ли выбранные элементы
	if (count($_POST['type']) > 0) {
		//Если выбран элемент - всё, конец разбра
		$arr = $_POST['type'];
		if($arr[0] != -1){
			//Если до этого был текст, то добавление условия and
			if(strlen($if) != 0) $vsptext = ' and '; else $vsptext = '';
			//Создание всмпогательного условия
			$vsptext .= '( ';
			//Для каждого элемента добавления условия
			foreach($arr as $id_t){
				$vsptext .= "id_типа='" . $id_t . "' or ";
			}
			//В конце закрыть
			$vsptext .= 'false) ';
			//Добавление ко всем тексту
			$if .= $vsptext;
		}						
	}
	
	//Люди
	//есть ли выбранные элементы
	if (count($_POST['man']) > 0) {
		//Если выбран элемент - всё, конец разбра
		$arr = $_POST['man'];
		if($arr[0] != -1){
			//Если до этого был текст, то добавление условия and
			if(strlen($if) != 0) $vsptext = ' and '; else $vsptext = '';
			//Создание всмпогательного условия
			$vsptext .= '( ';
			//Для каждого элемента добавления условия
			foreach($arr as $id_t){
				$vsptext .= "id_человека='" . $id_t . "' or ";
			}
			//В конце закрыть
			$vsptext .= 'false) ';
			//Добавление ко всем тексту
			$if .= $vsptext;
		}						
	}
	
	//Групп
	//есть ли выбранные элементы
	if (count($_POST['group']) > 0) {
		//Если выбран элемент - всё, конец разбра
		$arr = $_POST['group'];
		if($arr[0] != -1){
			//Если до этого был текст, то добавление условия and
			if(strlen($if) != 0) $vsptext = ' and '; else $vsptext = '';
			//Создание всмпогательного условия
			$vsptext .= '( ';
			//Для каждого элемента добавления условия
			foreach($arr as $id_t){
				$vsptext .= "id_группы='" . $id_t . "' or ";
			}
			//В конце закрыть
			$vsptext .= 'false) ';
			//Добавление ко всем тексту
			$if .= $vsptext;
		}						
	}
	
	//Флаг, была ли сортировка по ивнентарному номеру
	$invent_sel = false;
	
	//Указать флаг инвентарного номера, что бы подключить другой спец блок
	if($_POST['inv_sel']) $invent_sel = true;
	
	//Инвентарный номер
	//есть ли выбранные элементы
	if (count($_POST['invent']) > 0) {
		//Если выбран элемент - всё, конец разбра
		$arr = $_POST['invent'];
		if($arr[0] != null){
			//Если до этого был текст, то добавление условия and
			if(strlen($if) != 0) $vsptext = ' and '; else $vsptext = '';
			//Создание всмпогательного условия
			$vsptext .= '( ';
			//Для каждого элемента добавления условия
			foreach($arr as $id_t){
				$vsptext .= "инвентарный_номер='" . $id_t . "' or ";
			}
			//В конце закрыть
			$vsptext .= 'false) ';
			//Добавление ко всем тексту
			$if .= $vsptext;
		}						
	}
	
	//Полнове формирование запроса
	if(strlen($if) > 0){
		//Если были выбраны фильтры, то они добавляются к запросу
		$req .= ' where ' . $if;
	}	
	
	//Создание класса БД для запроса
	$conn = db_manager::GetConnect();
	//Выполенение спец запроса
	$res = $conn->SpecialSelect($req);
	
	//Создания класса item
	$item = new item();
	//Поулчение html таблицы по результату
	$body = $item->applyXslt($res);
	
	//Создание класа для создания конечной страницы
	$cons = new construct();
	
	//Формирование страницы
	$cons->set_hat("v/hat.html");
	$cons->set_name("Предметы");
	$cons->add_body($body);
	$cons->add_function("v/table_row_editor.js");
	//Если была сортировка по инвентарному номеру, подключается спец блок
	if($invent_sel) $cons->add_r_block("v/search_table_r_block.html"); 
	else $cons->add_r_block("v/order_table_r_block.html");
	$cons->add_function("v/delete_row.js");
	$cons->add_function('v/add_row.js');
	$cons->add_function('v/model_add.js');
	
	//Получение содержимого страницы
	$list =  $cons->get_page();
	
	//Добалвение значения атрибута с запросом
	$list = str_replace('table id="main_table"', 'table id="main_table" request_create="' . $req . '"', $list);
	
	//Конец преобразований
	echo $list;
?>