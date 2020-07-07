<?PHP
	//Модуль содержит класс, описывающий класс представления человек
	
	//Подключение модуля с классами для работы с БД
	if(!$include_db){
		include 'database.php';
		//Указать - что модуль включён
		$include_db = true;
	}
	//Класс для работы с представлением 'человек'
	class man
	{
		//Получение всего содержимого табилицы в виде html таблицы
		public function getTable()
		{
			//Создания класс для запросов к БД
			$conn = db_manager::GetConnect();
			
			//Получение всего содержимого таблицы
			$rows = $conn->GetAllTables("человек_п");
						
			//Получение xml из ответа
			$xml = $this->getXML($rows);
			$xml_doc = new DOMDocument();
			$xml_doc->loadXML($xml);
			
			//Использование XSLT преобразования
			$xslt = new DOMDocument();
			$xslt->load("m/man_to_table.xslt");
			
			//Получение указателя на процессор
			$proc = new XSLTProcessor();
			$proc->importStylesheet($xslt);
			
			//$conn->close();
			
			//Преобразование
			return $proc->transformToXML($xml_doc);
						
		}
		
		//Получение содержимого таблицы в виде массива
		public function getArray(){
			//Создания класс для запросов к БД
			$conn = db_manager::GetConnect();
			
			//Получение всего содержимого таблицы модели
			$rows_t = $conn->GetAllTables("человек");
			
			//Переменная с текстом массива
			$arr_text = 'var arr = []; ';
			
			$i = 0;
			
			while($row = mysqli_fetch_assoc($rows_t))
			{
				$arr_text .= 'arr[' . $i++ . ']=[' . "'". $row['ID'] . "'" . ', '
				. "'" .  $row['ФИО']. "'" . '] ;';
				
			}
			
			$arr_text .= 'arr';
			return $arr_text;
		}
		
		//Добавление новой записи в таблицу
		public function addMan($name, $work, $komm){
			//создания массива с аргументами
			$arg = array(
				0 => $name,
				1 => $work,
				2 => $komm,
			);			
			//Создания класс для запросов к БД
			$conn = db_manager::GetConnect();
			
			//Вызов соотвествующей процедуры в БД
			$res = $conn->CallFunc("добавить_человека", $arg);
			$res2 = $res->fetch_row();
			echo "id". $res2[0];
		}
		
		//Функция изменения
		public function editMan($id, $name, $work, $komm){
			//Вызов функции соотвествующей
			$conn = db_manager::GetConnect();
			//Формирование аргументов
			$arg = array(
				0 => $id,
				1 => $name,
				2 => $work,
				3 => $komm,
			);
						
			//Вызов процедуры
			$conn->CallProc('изменить_человека', $arg);
		}
		
		//функция удаления
		public function deletMan($id){
			//Вызов функции соотвествующей
			$conn = db_manager::GetConnect();
			//Формирование аргументов
			$arg = array(
				0 => $id,				
			);
						
			//Вызов процедуры
			$conn->CallProc('удалить_человека', $arg);
		}
		
		//Создание обычного XML по содержимого запроса
		private function getXML($result_q)
		{
			if($result_q == null)  echo "ПУСТАЯ ТАБЛИЦААААА";
			//Строка для сохранения XML
			$xml = '<?xml version="1.0" encoding="utf-8"?>';
			//Добавление заголовка для таблицы
			$xml .= '<человек>';
			
			//Циклические преобразования результата запроса
			while($row = mysqli_fetch_assoc($result_q))
			{
				$xml .= "<строка>";
				$xml .= "<id>" . $row['ID'] . "</id>";
				$xml .= "<фио> " . $row["ФИО"] . "</фио>";
				$xml .= "<должность> " . $row["должность"] . "</должность>";
				$xml .= "<комментарий> " . $row["комментарий"] . "</комментарий>";
				$xml .= "</строка>";				
			}
									
			//Конец xml файла
			$xml .= '</человек>';
			
			//Вернуть содержимого
			return $xml;
		}
	}
	
	//Обработчки вывова методов класса из браузера
	//Проверка, правильно ли адресован запрос
	if($_POST['to'] == 'man'){
		//Класс, через который взаимодействуем
		$m = new man();
	
		//Вызов соответсвующей функции
		switch($_POST['fun']){
			
			//Если функция редактирования
			case 'edit':{		
				
				//Вызов соотвествующей функции для измнения значений
				$m->editMan($_POST['0'], $_POST['1'], $_POST['2'], $_POST['3'] );
				echo 'ok';
				
			break;
			}
	
			//Вызов функции удаления
			case 'delet':{
					
					//Вызо функции удаления
					$m->deletMan($_POST['0']);
					echo 'ok';
					
				break;
			}
			
			//Вызов функции добавления
			case 'add':{
				
				$m->addMan($_POST['0'], $_POST['1'], $_POST['2']);
				echo 'ok';
				break;
			}
			
			//Если хз что вызвали
			default: 
				echo 'Неизвестная функция';
				break;
		}	
	}
	
?>