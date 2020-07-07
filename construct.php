<?PHP

	//Класс для сбора содержимого сайта из разных деталей
	class construct{
		
		//Всё содержимое сайта в текстовой форме
		private $full_sheet = "";
	
		//конструктор по умолчанию
		public function __construct(){
			//По умолчанию идёт получение содержимого из простого шаблона
			$this->full_sheet = file_get_contents("v/simple_template.html");
		}
		
		//Установка имени сайта
		public function set_name($name){
			//Замена тега имени на имя
			$this->full_sheet = str_replace("<tимя-сайтаt>", $name, $this->full_sheet);
		}
		
		//Установка шапки сайта
		public function set_hat($hat){
			$this->full_sheet = str_replace("<tшапкаt>", file_get_contents($hat), $this->full_sheet);
		}
		
		//Установка содержимого сайта
		public function add_body($body){
			//Помимо замены самого тега, добавляется ещё такой же тег, что бы добавить ещё содержимого
			$this->full_sheet = str_replace("<tсодержимоеt>", $body . ' <tсодержимоеt> ', $this->full_sheet);
		}
		
		//Добавить функцию к страничке
		public function add_function($ftext){
			$this->full_sheet = str_replace("<tфункцияt>",  "<script src=" . $ftext . '></script>' . ' <tфункцияt> ', $this->full_sheet);
		}
		
		//Добавить правый блок
		public function add_r_block($ftext){
			$this->full_sheet = str_replace("<tправый-блокt>", file_get_contents($ftext)  , $this->full_sheet);
		}
		
		//Добавить левый блок
		public function add_l_block($ftext){
			$this->full_sheet = str_replace("<tлевый-блокt>", file_get_contents($ftext)  , $this->full_sheet);
		}
		
		//Вернуть финальную страницу 
		public function get_page(){
			//Сначала удаляются не использованные теги
			$this->full_sheet = str_replace("<tсодержимоеt>", " ", $this->full_sheet);
			$this->full_sheet = str_replace("<tфункцияt>", " ", $this->full_sheet);
			$this->full_sheet = str_replace("<tправый-блокt>", " ", $this->full_sheet);
			$this->full_sheet = str_replace("<tлевый-блокt>", " ", $this->full_sheet);
			//Возвращение содержимого страницы
			return $this->full_sheet;
		}
		
	}


?>