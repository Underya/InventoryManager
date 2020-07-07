<?PHP

	//Модуль содержит класс, описывающий модель
	
	//Подключение модуля с классами для работы с БД
	//include 'database.php';
	include 'type.php';
	
	class model{
	
		//Получение всего содержимого табилицы в виде html таблицы
		public function getTable()
		{
			//Создания класс для запросов к БД
			$conn = db_manager::GetConnect();
			
			//Получение всего содержимого таблицы модели
			$rows_m = $conn->GetAllTables("п_модель");
			//Получение всего содержимого табилицы типов
			$rows_t = $conn->GetAllTables("тип");
						
						
			//Получение xml из ответа
			$xml = $this->getXML($rows_m);
			$xml_doc = new DOMDocument();
			$xml_doc->loadXML($xml);						
			
			//Использование XSLT преобразования
			$xslt = new DOMDocument();
			$xslt->load("m/model_to_table.xslt");
			
			
			//Получение указателя на процессор
			$proc = new XSLTProcessor();
			$proc->importStylesheet($xslt);
			
			//Получение массива с возможными типами
			$type_arr =  $this->getArray_type($rows_t);
			
						
			//Преобразование
			$xhtml =  $proc->transformToXML($xml_doc);
			$xhtml = str_replace('replace_type_arr', $type_arr, $xhtml);
			
			return $xhtml;
						
		}
		
		//Получение массива возможных моделей
		public function getArray(){
			//Создания класс для запросов к БД
			$conn = db_manager::GetConnect();
			
			//Получение всего содержимого таблицы модели
			$rows_m = $conn->GetAllTables("п_модель");
			
			//Переменная с текстом массива
			$arr_text = 'var arr = []; ';
			
			$i = 0;
			
			while($row = mysqli_fetch_assoc($rows_m))
			{
				$arr_text .= 'arr[' . $i++ . ']=[' . "'". $row['id'] . "'" . ', '
				. "'" . $row['наименование'] . "'," 
				. "'" . $row['тип'] . "', " 
				. "'" .  $row['еденица_измерений']. "'" . '] ;';
				
			}
			
			$arr_text .= 'arr';
			return $arr_text;
		}
		
		//Получение массива возможных типов по запросу
		public function getArray_type($rows_t){
			//переменаая, с текстом массива
			$arr_text = 'var arr = []; ';
			//Пеменная для индекса в массиве
			$i = 0;
			
			//Циклический проход по всем строчка ответа на запрос
			while($row = mysqli_fetch_assoc($rows_t))
			{
				$arr_text .= 'arr[' . $i++ . ']=[' . "'". $row['ID'] . "'" . ', '. "'" . $row['наименование'] . "', '" . $row['еденица_измерений']. "'" . '] ;';
				
			}
								
			$arr_text.= 'arr';
			return $arr_text;
		}
		
		//Создание обычного XML по содержимого запроса
		private function getXML($model)
		{
			if($model == null)  echo "ПУСТАЯ ТАБЛИЦААААА";
			//Строка для сохранения XML
			$xml = '<?xml version="1.0" encoding="utf-8"?>';
			//Добавление заголовка для таблицы
			
			//Первая часть - только модель
			$xml .= '<модель>';
			//Циклические преобразования результата запроса
			while($row = mysqli_fetch_assoc($model))
			{
				$xml .= "<строка>";
				$xml .= "<id>" . $row['id'] . "</id>";
				$xml .= "<наименование> " . $row["наименование"] . "</наименование>";
				$xml .= "<тип> " . $row["тип"] . "</тип>";
				$xml .= "<единица> " . $row["еденица_измерений"] . "</единица>";
				$xml .= "</строка>";				
			}
								
			$xml .= '</модель>';
											
			
			//Вернуть содержимого
			return $xml;
		}
		
		//функция изменения элемента группы
		public function edit($id, $id_type, $name){
			//создания массива с аргументами
			$arg = array(
				0 => $id,
				1 => $name,
				2 => $id_type,

			);			
			//Создания класс для запросов к БД
			$conn = db_manager::GetConnect();
			
			//Вызов соотвествующей процедуры в БД
			$res = $conn->CallProc("изменить_модель", $arg);
		}
		
		public function delete($id){
			$arg = array(
				0 => $id,
			);
			
			//Создания класс для запросов к БД
			$conn = db_manager::GetConnect();
			
			//Вызов соотвествующей процедуры в БД
			$res = $conn->CallProc("удалить_модель", $arg);
		}
		
		//Добавление новой записи в таблицу
		public function add($id_type, $name){
			//создания массива с аргументами
			$arg = array(
				0 => $name,
				1 => $id_type,
			);			
			//Создания класс для запросов к БД
			$conn = db_manager::GetConnect();
			
			//Вызов соотвествующей процедуры в БД
			$res = $conn->CallFunc("добавить_модель", $arg);
			$res2 = $res->fetch_row();
			echo "id". $res2[0];
		}
		
	}	
		//Обработчки вывова методов класса из браузера
	//Проверка, правильно ли адресован запрос
	if($_POST['to'] == 'model'){
		//Класс, через который взаимодействуем
		$m = new model();
	
		//Вызов соответсвующей функции
		switch($_POST['fun']){
			
			//Если функция редактирования
			case 'edit':{		
				
					//Вызов соотвествующей функции для измнения значений
					$m->edit($_POST['0'], $_POST['1'], $_POST['2']);
					echo 'ok';
				
				break;
			}
	
			//Вызов функции удаления
			case 'delet':{
					//Вызо функции удаления
					$m->delete($_POST['0']);
					echo 'ok';
					
				break;
			}
			
			//Вызов функции добавления
			case 'add':{
				
					$m->add($_POST['0'], $_POST['1']);
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