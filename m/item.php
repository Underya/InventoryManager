<?PHP

	//Модуль содержит класс, описывающий предметы
	
	//Подключение других модулей
	include 'model.php';
	include 'man.php';
	include 'group.php';
	include 'room.php';
	//Нет смысла подключать модуль db_, так ак он подключён
	
	class item{
	
		//Получение всего содержимого табилицы в виде html таблицы
		public function getTable()
		{	
			//Создания класс для запросов к БД
			$conn = db_manager::GetConnect();
			
			//Получение всего содержимого таблицы модели
			$rows_m = $conn->GetAllTables("п_предметы");
			//Получение всего содержимого табилицы типов
												
			//Получение xml из ответа
			$xml = $this->getXML($rows_m);
			$xml_doc = new DOMDocument();
			$xml_doc->loadXML($xml);						
			
			//Использование XSLT преобразования
			$xslt = new DOMDocument();
			$xslt->load("m/item_to_table.xslt");
			
			
			//Получение указателя на процессор
			$proc = new XSLTProcessor();
			$proc->importStylesheet($xslt);
									
			//Преобразование
			$xhtml =  $proc->transformToXML($xml_doc);
			
			//Вставка массивов со значениеями
			$arr_model = new model();
			$arr_model = $arr_model->getArray();			
			$xhtml = str_replace('replace_model_arr', $arr_model, $xhtml);
			
			$arr_room = new room();
			$arr_room = $arr_room->getArray();
			$xhtml = str_replace('replace_room_arr', $arr_room, $xhtml);
			
			$arr_man = new man();
			$arr_man = $arr_man->getArray();
			$xhtml = str_replace('replace_man_arr', $arr_man, $xhtml);
			
			$arr_group = new group();
			$arr_group = $arr_group->getArray();
			$xhtml = str_replace('replace_group_arr', $arr_group, $xhtml);
			
			$arr_type = new model();
			$rows_t = $conn->GetAllTables("тип");
			$arr_type = $arr_type->getArray_type($rows_t);
			$xhtml = str_replace('replace_type_arr', $arr_type, $xhtml);
			
			
			return $xhtml;
						
		}
		
		//Функция применят к результату запроса xslt и возвращает html таблицу 
		public function applyXslt($res){
			//Получение xml 
			$xml = $this->getXML($res);
			$xml_doc = new DOMDocument();
			$xml_doc->loadXML($xml);
			//Использование XSLT преобразования
			$xslt = new DOMDocument();
			$xslt->load("m/item_to_table.xslt");
			$proc = new XSLTProcessor();
			$proc->importStylesheet($xslt);
			
			$xhtml = $proc->transformToXML($xml_doc);
			
			//Создания класс для запросов к БД
			$conn = db_manager::GetConnect();
			
			//Вставка массивов со значениеями
			$arr_model = new model();
			$arr_model = $arr_model->getArray();			
			$xhtml = str_replace('replace_model_arr', $arr_model, $xhtml);
			
			$arr_room = new room();
			$arr_room = $arr_room->getArray();
			$xhtml = str_replace('replace_room_arr', $arr_room, $xhtml);
			
			$arr_man = new man();
			$arr_man = $arr_man->getArray();
			$xhtml = str_replace('replace_man_arr', $arr_man, $xhtml);
			
			$arr_group = new group();
			$arr_group = $arr_group->getArray();
			$xhtml = str_replace('replace_group_arr', $arr_group, $xhtml);
			
			$arr_type = new model();
			$rows_t = $conn->GetAllTables("тип");
			$arr_type = $arr_type->getArray_type($rows_t);
			$xhtml = str_replace('replace_type_arr', $arr_type, $xhtml);
			
			
			//Получение и возвращение xslt
			return $xhtml;
		}
		
		//Создание обычного XML по содержимого запроса
		private function getXML($model)
		{
			if($model == null)  echo "ПУСТАЯ ТАБЛИЦААААА";
			//Строка для сохранения XML
			$xml = '<?xml version="1.0" encoding="utf-8"?>';
			//Добавление заголовка для таблицы
			
			//Первая часть - только модель
			$xml .= '<предметы>';
			//Циклические преобразования результата запроса
			while($row = mysqli_fetch_assoc($model))
			{
				$xml .= "<строка>";
				$xml .= "<id>" . $row['id'] . "</id>";
				$xml .= "<инвентарный_номер> " . $row["инвентарный_номер"] . "</инвентарный_номер>";
				$xml .= "<имя> " . $row["имя"] . "</имя>";
				//$xml .= "<id_помещения> " . $row["id_помещения"] . "</id_помещения>";
				$xml .= "<корпус> " . $row["корпус"] . "</корпус>";
				$xml .= "<номер_помещения> " . $row["номер_помещения"] . "</номер_помещения>";
				$xml .= "<ФИО> " . $row["ФИО"] . "</ФИО>";
				$xml .= "<группа> " . $row["группа"] . "</группа>";
				$xml .= "<тип> " . $row["тип"] . "</тип>";
				$xml .= "<модель> " . $row["имя_модели"] . "</модель>";
				$xml .= "<комментарий> " . $row["комментарий"] . "</комментарий>";
				$xml .= "<количество> " . $row["количество"] . "</количество>";
				$xml .= "<единица> " . $row["еденица_измерений"] . "</единица>";
				$xml .= "</строка>";				
			}
								
			$xml .= '</предметы>';
											
			//Удалить теги, если влезли
			$xml = str_replace('<br>', '', $xml);
			$xml = str_replace('</br>', '', $xml);
			
			//Вернуть содержимого
			return $xml;
		}
		
		//функция изменения элемента группы
		public function edit($id, $name, $count, $id_group, $id_room, $id_model, $kommen, $invent, $id_man){
			//создания массива с аргументами
			$arg = array(
				0 => $id,
				1 => $name,
				2 => $count,
				3 => $id_group,
				4 => $id_room,
				5 => $id_model,
				6 => $kommen,
				7 => $invent,
				8 => $id_man,				
			);			
			//Создания класс для запросов к БД
			$conn = db_manager::GetConnect();
			
			//Вызов соотвествующей процедуры в БД
			$res = $conn->CallProc("изменить_предмет", $arg);
		}
		
		public function delete($id){
			$arg = array(
				0 => $id,
			);
			
			//Создания класс для запросов к БД
			$conn = db_manager::GetConnect();
			
			//Вызов соотвествующей процедуры в БД
			$res = $conn->CallProc("удалить_предмет", $arg);
		}
		
		//Добавление новой записи в таблицу
		public function add($name, $count, $id_group, $id_room, $id_model, $kommen, $invent, $id_man){
			
			//создания массива с аргументами
			$arg = array(
				0 => $name,
				1 => $count,
				2 => $id_group,
				3 => $id_room,
				4 => $id_model,
				5 => $kommen,
				6 => $invent,
				7 => $id_man,				
			);			
			//Создания класс для запросов к БД
			$conn = db_manager::GetConnect();
			
			//Вызов соотвествующей процедуры в БД
			$res = $conn->CallFunc("добавить_предмет", $arg);
			$res2 = $res->fetch_row();
			echo "id". $res2[0];
		}
		
	}	
		//Обработчки вывова методов класса из браузера
	//Проверка, правильно ли адресован запрос
	if($_POST['to'] == 'item'){
		//Класс, через который взаимодействуем
		$i = new item();
	
		//Вызов соответсвующей функции
		switch($_POST['fun']){
			
			//Если функция редактирования
			case 'edit':{		
				
					//Вызов соотвествующей функции для измнения значений
					$i->edit($_POST['0'], $_POST['2'], $_POST['8'], $_POST['5'], $_POST['3'], $_POST['6'], $_POST['7'], $_POST['1'], $_POST['4']);
					echo 'ok';
				
				break;
			}
	
			//Вызов функции удаления
			case 'delet':{
					//Вызо функции удаления
					$i->delete($_POST['0']);
					echo 'ok';
					
				break;
			}
			
			//Вызов функции добавления
			case 'add':{
					$i->add($_POST['1'], $_POST['7'], $_POST['4'], $_POST['2'], $_POST['5'], $_POST['6'], $_POST['0'], $_POST['3']);
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