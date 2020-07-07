<?PHP
	try{
		session_start();
	} catch(Exception $e) {
		
		EXIT('Не прошло начало сессии');
	}
	
	//Получение логина и пароля
	
	$login = $_POST['login'];
	$pass = $_POST['pass'];	
	
	//Подключение модуля с ДБ
	include 'm/database.php';	
	
	//Вызов функции создания соеденения с БД
	db_manager::CreateConnect($login, $pass);
	//Указать, что соеденение с БД работает
	$include_db = true;
	
	//Сохранение переменных сессиии
	$_SESSION['login'] = $login;
	$_SESSION['pass'] = $pass;
	
	session_write_close();
	
	//Для проверки запуск скрипта с предметами
	include 's_item.php';
?>
