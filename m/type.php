<?PHP

	//Модуль содержит класс, описывающий типа
	
	//Подключение модуля с классами для работы с БД
	//Если модуль не подключен - подкулючить его
	if(!$include_db){
		include 'database.php';
		//Указать - что модуль включён
		$include_db = true;
	}
	
	class type{
	
		//Получение всего содержимого табилицы в виде html таблицы
		public function getTable()
		{
			//Создания класс для запросов к БД
			$conn = db_manager::GetConnect();
			
			//Получение всего содержимого таблицы
			$rows = $conn->GetAllTables("тип");
						
			//Получение xml из ответа
			$xml = $this->getXML($rows);
			$xml_doc = new DOMDocument();
			$xml_doc->loadXML($xml);						
			
			//Использование XSLT преобразования
			$xslt = new DOMDocument();
			$xslt->load("m/type_to_table.xslt");
			
			
			//Получение указателя на процессор
			$proc = new XSLTProcessor();
			$proc->importStylesheet($xslt);
			
			//$conn->close()
			
			//Преобразование
			return $proc->transformToXML($xml_doc);
						
		}
		
		//Создание обычного XML по содержимого запроса
		private function getXML($result_q)
		{
			if($result_q == null)  echo "ПУСТАЯ ТАБЛИЦААААА";
			//Строка для сохранения XML
			$xml = '<?xml version="1.0" encoding="utf-8"?>';
			//Добавление заголовка для таблицы
			$xml .= '<тип>';
			
			//Циклические преобразования результата запроса
			while($row = mysqli_fetch_assoc($result_q))
			{
				$xml .= "<строка>";
				$xml .= "<id>" . $row['ID'] . "</id>";
				$xml .= "<имя> " . $row["наименование"] . "</имя>";
				$xml .= "<еденица> " . $row["еденица_измерений"] . "</еденица>";
				$xml .= "</строка>";				
			}
									
			//Конец xml файла
			$xml .= '</тип>';
			
			//Вернуть содержимого
			return $xml;
		}
		
		//функция изменения элемента группы
		public function edit($id, $name, $ed){
			//создания массива с аргументами
			$arg = array(
				0 => $id,
				1 => $name,
				2 => $ed,
			);			
			//Создания класс для запросов к БД
			$conn = db_manager::GetConnect();
			
			//Вызов соотвествующей процедуры в БД
			$res = $conn->CallProc("изменить_тип", $arg);
		}
		
		public function delete($id){
			$arg = array(
				0 => $id,
			);
			
			//Создания класс для запросов к БД
			$conn = db_manager::GetConnect();
			
			//Вызов соотвествующей процедуры в БД
			$res = $conn->CallProc("удалить_тип", $arg);
		}
		
		//Добавление новой записи в таблицу
		public function add($name, $ed){
			//создания массива с аргументами
			$arg = array(
				0 => $name,
				1 => $ed,
			);			
			//Создания класс для запросов к БД
			$conn = db_manager::GetConnect();
			
			//Вызов соотвествующей процедуры в БД
			$res = $conn->CallFunc("добавить_тип", $arg);
			$res2 = $res->fetch_row();
			echo "id". $res2[0];
		}
		
	}	
		//Обработчки вывова методов класса из браузера
	//Проверка, правильно ли адресован запрос
	if($_POST['to'] == 'type'){
		//Класс, через который взаимодействуем
		$t = new type();
	
		//Вызов соответсвующей функции
		switch($_POST['fun']){
			
			//Если функция редактирования
			case 'edit':{		
				
					//Вызов соотвествующей функции для измнения значений
					$t->edit($_POST['0'], $_POST['1'], $_POST['2']);
					echo 'ok';
				
				break;
			}
	
			//Вызов функции удаления
			case 'delet':{
					//Вызо функции удаления
					$t->delete($_POST['0']);
					echo 'ok';
					
				break;
			}
			
			//Вызов функции добавления
			case 'add':{
				
					$t->add($_POST['0'], $_POST['1']);
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