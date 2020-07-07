<?PHP
	 session_start();
	 
	//Соеденение с базой данной, через которую проходят все запросы
	class db_connect
	{
		//Соеденение с БД, через которое идёт работа
		private $link;
		
		//Создание нового экземпляра на основе 
		function __construct($link_db)
		{
			if($link_db == null) echo "$link_db == null";
			$this->link = $link_db;
		}
			
		//Получение всего содержимого таблицы или представления
		public function GetAllTables($table_name)
		{					
			//Формирование текста запроса
			$query  = "SELECT * FROM " . $table_name . ";";
			//Выполнение запроса
			$result = mysqli_query($this->link, $query);			
			if ($result == null) echo 'Пустой результат';
			//Возвращение реузльтатов запроса
			return $result;
		}
		
		public function CallFunc($name_poc, $arg){
			//Получение числа параметров
			$counta = count($arg);
			//Формирование текста запроса
			$query = "select `" . $name_poc . "` ( ";
			
			//Добавление аргументов
			for($i = 0; $i < $counta; $i++){
				//Разделение аргументов через ,
				if($i != 0) $query .= ', ';
				$query .= '\'' . $arg[$i] . '\' ';							
			}
			//Конец текста вызова
			$query .= " ); ";
			
			//вызов непосредственно функции из БД
			$res = mysqli_query($this->link, $query);
			if(mysqli_error($this->link) != null) trigger_error(mysqli_error($this->link));
			//echo mysqli_error($this->link);
			//Возвращение результата
			return $res;
		}
		
		//Выполнеие указаной процедуры с указанным списком параметров
		public function CallProc($name_poc, $arg){
			//Получение числа параметров
			$counta = count($arg);
			//Формирование текста запроса
			$query = "CALL `" . $name_poc . "` ( ";
			
			//Добавление аргументов
			for($i = 0; $i < $counta; $i++){
				//Разделение аргументов через ,
				if($i != 0) $query .= ', ';
				$query .= '\'' . $arg[$i] . '\' ';							
			}
			//Конец текста вызова
			$query .= " ); ";
			
			//вызов непосредственно функции из БД
			$res = mysqli_query($this->link, $query);
			if(mysqli_error($this->link) != null) trigger_error(mysqli_error($this->link));
			//echo mysqli_error($this->link);
			//Возвращение результата
			return $res;
		}
		
		//Выполнение специального запроса
		//$sel - Текст запроса
		//Вовзращает набор строк, полученных в результате запроса
		public function SpecialSelect($sel){
			//вовзращение результатов запроса
			return mysqli_query($this->link, $sel);
		}
		
		public function Close()
		{
			mysqli_close($this->link);
		}
	}

	//Соеденение с базой данной, через которую проходят все запросы
	class db_manager
	{
		//Данные для связи с БД
		private static $host = "p:localhost";
		private static $database = "k";
		
		//Указатель на главное соеденение
		private static $link_db = null;
		
		//Получить соеденение для работы с базой данных
		public static function GetConnect()
		{
		
			//Если соеденение уже было открыто, вернуть на него указатель
			if(db_manager::$link_db != null) return new db_connect(db_manager::$link_db);			
			
			//Получение соеденения с БД
			db_manager::$link_db = mysqli_connect(db_manager::$host, $_SESSION['login'], $_SESSION['pass'], db_manager::$database);
			
						
			if (mysqli_connect_errno()) {
				printf("Соединение не удалось: %s\n", mysqli_connect_error());
				exit();
			}
			
			if(db_manager::$link_db == null) echo "ВСЁ ЕЩЁ db_manager::$link_db == null";
			//Вернуть новый экземпляр для связи с БД
			return new db_connect(db_manager::$link_db);
		}
		
		//Создание соеднения по логину и паролю
		public static function CreateConnect($login, $password){
			//Получение соеденения с БД
			db_manager::$link_db = mysqli_connect(db_manager::$host, $login, $password, db_manager::$database);
		}
	}
		
?>