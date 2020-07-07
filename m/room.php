<?PHP

	//Модуль содержит класс, описывающий помещение
	
	//Подключение модуля с классами для работы с БД
	if(!$include_db){
		include 'database.php';
		//Указать - что модуль включён
		$include_db = true;
	}
	
	class room{
	
		//Получение всего содержимого табилицы в виде html таблицы
		public function getTable()
		{
			//Создания класс для запросов к БД
			$conn = db_manager::GetConnect();
			
			//Получение всего содержимого таблицы
			$rows = $conn->GetAllTables("помещение");
						
			//Получение xml из ответа
			$xml = $this->getXML($rows);
			$xml_doc = new DOMDocument();
			$xml_doc->loadXML($xml);						
			
			//Использование XSLT преобразования
			$xslt = new DOMDocument();
			$xslt->load("m/room_to_table.xslt");
			
			
			//Получение указателя на процессор
			$proc = new XSLTProcessor();
			$proc->importStylesheet($xslt);
			
			//$conn->close()
			
			//Преобразование
			return $proc->transformToXML($xml_doc);
						
		}
		
		//Получение содержимого таблицы в виде массива
		public function getArray(){
			//Создания класс для запросов к БД
			$conn = db_manager::GetConnect();
			
			//Получение всего содержимого таблицы модели
			$rows_t = $conn->GetAllTables("помещение");
			
			//Переменная с текстом массива
			$arr_text = 'var arr = []; ';
			
			$i = 0;
			
			while($row = mysqli_fetch_assoc($rows_t))
			{
				$arr_text .= 'arr[' . $i++ . ']=[' . "'". $row['ID'] . "'" . ', '
				. "'" . $row['номер_помещения'] . ' '. $row['часть_здания'] . "'," 
				. "'" .  $row['часть_здания']. "'" . '] ;';
				
			}
			
			$arr_text .= 'arr';
			return $arr_text;
		}
		
		//Создание обычного XML по содержимого запроса
		private function getXML($result_q)
		{
			if($result_q == null)  echo "ПУСТАЯ ТАБЛИЦААААА";
			//Строка для сохранения XML
			$xml = '<?xml version="1.0" encoding="utf-8"?>';
			//Добавление заголовка для таблицы
			$xml .= '<помещение>';
			
			//Циклические преобразования результата запроса
			while($row = mysqli_fetch_assoc($result_q))
			{
				$xml .= "<строка>";
				$xml .= "<id>" . $row['ID'] . "</id>";
				$xml .= "<номер> " . $row["номер_помещения"] . "</номер>";
				$xml .= "<корпус> " . $row["часть_здания"] . "</корпус>";
				$xml .= "<комментарий> " . $row["комментарий"] . "</комментарий>";
				$xml .= "</строка>";				
			}
									
			//Конец xml файла
			$xml .= '</помещение>';
			
			//Вернуть содержимого
			return $xml;
		}
		
		//функция изменения элемента группы
		public function edit($id, $corp, $num, $komm){
			//создания массива с аргументами
			$arg = array(
				0 => $id,
				1 => $corp,
				2 => $num,
				3 => $komm,
			);			
			//Создания класс для запросов к БД
			$conn = db_manager::GetConnect();
			
			//Вызов соотвествующей процедуры в БД
			$res = $conn->CallProc("изменить_помещение", $arg);
		}
		
		public function delete($id){
			$arg = array(
				0 => $id,
			);
			
			//Создания класс для запросов к БД
			$conn = db_manager::GetConnect();
			
			//Вызов соотвествующей процедуры в БД
			$res = $conn->CallProc("удалить_помещение", $arg);
		}
		
		//Добавление новой записи в таблицу
		public function add($corp, $num, $comm){
			//создания массива с аргументами
			$arg = array(
				0 => $corp,
				1 => $num,
				2 => $comm,
			);			
			//Создания класс для запросов к БД
			$conn = db_manager::GetConnect();
			
			//Вызов соотвествующей процедуры в БД
			$res = $conn->CallFunc("добавить_помещение", $arg);
			$res2 = $res->fetch_row();
			echo "id". $res2[0];
		}
		
	}	
		//Обработчки вывова методов класса из браузера
	//Проверка, правильно ли адресован запрос
	if($_POST['to'] == 'room'){
		//Класс, через который взаимодействуем
		$r = new room();
	
		//Вызов соответсвующей функции
		switch($_POST['fun']){
			
			//Если функция редактирования
			case 'edit':{		
				
					//Вызов соотвествующей функции для измнения значений
					$r->edit($_POST['0'], $_POST['1'], $_POST['2'], $_POST['3']);
					echo 'ok';
				
				break;
			}
	
			//Вызов функции удаления
			case 'delet':{
					//Вызо функции удаления
					$r->delete($_POST['0']);
					echo 'ok';
					
				break;
			}
			
			//Вызов функции добавления
			case 'add':{
				
					$r->add($_POST['0'], $_POST['1'], $_POST['2']);
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