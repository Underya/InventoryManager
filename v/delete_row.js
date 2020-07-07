function delet_row(butt){
	//Проверка, есть ли необходиомсть вставлять новую строку?
	var delet_rows = document.getElementById("delete_row_row");
	if(delet_rows == null){
		//Получение указателя боковую панель
		var r_block = document.getElementById("r_table");
		//Добавление нового столбца
		delet_rows = r_block.insertRow(1);
		delet_rows.setAttribute('id', 'delete_row_row');
		delet_rows.innerHTML = '<button onclick="all_delete_rows(this)">Удалить все выбранные элементы?</button>';
		//Создания массива элементов на удаление
		delet_rows.array_for_delete = new Object();
		//Добавление кнопки на отмену всех удалений
		var cancel_all_row = r_block.insertRow(2);
		cancel_all_row.innerHTML = '<button onclick="all_cancel_delete_rows(this)">Отменить удаление всех выбранных элементов</button>';
		cancel_all_row.setAttribute('id', 'cancel_button');
	}
	
	//Добавить новый элемент в массив всех элментов на удаление
	//Найти сам элемент, и получить его как строку
	var row = butt.parentNode.parentNode;
	//Вставить в массив, как объект, с ключом в виде ид
	delet_rows.array_for_delete[row.getAttribute('main_id')] = row;
	
	//теперь изменить строку
	for(i = 0; i < row.childNodes.length - 2; i++) {
		child = row.childNodes[i];
		child.setAttribute("old_bgcolor", child.getAttribute('bgcolor'));
		child.setAttribute("bgcolor", '#efaba2');
	}
	//Последние два элемента, кнопки, тоже меняются
	child = row.childNodes[row.childNodes.length - 2];
	//Кнопка - удаление
	child.setAttribute('old_innerHTML', child.innerHTML);
	child.innerHTML = '<button onclick="execlute_delet(this)">Удалить</button>';
	
	child = row.childNodes[row.childNodes.length - 1];
	//Кнопка - удаление
	child.setAttribute('old_innerHTML', child.innerHTML);
	child.innerHTML = '<button onclick="cancel_delete_row(this)">Отмена</button>';	
}

//Удаление конкретной строчки
function execlute_delet(butt){
	//Получение строчки)
	var row = butt.parentNode.parentNode;
	//Получение ид записи в бд
	var main_id = row.getAttribute('main_id');
	//Вызов соотвествующей функции в БД
	// 2. Создание переменной request
	var request = new XMLHttpRequest();
	//Получение названия файла для запроса
	var t_class = document.getElementById("main_table").getAttribute('class');
	// 3. Настройка запроса
	request.open('POST','m/' + t_class + '.php',true);	
	// 4. Подписка на событие onreadystatechange и обработка его с помощью анонимной функции	
	request.addEventListener('readystatechange', function() {		
	// если состояния запроса 4 и статус запроса 200 (OK)
	if ((request.readyState==4) && (request.status==200)) {
		// например, выведем объект XHR в консоль браузера
		console.log(request);
		// и ответ (текст), пришедший с сервера в окне alert
		var text_res = request.responseText;		
		//Если не удалось получить ok
		if(text_res != 'ok') {
			alert('Не удалось изменить значения. Ошибка:' + text_res);
			return;
		}
		//удаление строки из ассоциативного массива
		var row_for_delete = document.getElementById("delete_row_row");
		delete row_for_delete.array_for_delete[row.getAttribute('main_id')];
		//Вызов функции для проверки, есть ли элменты ещё на удаление, и если нет - удалить строку
		chek_count_element_row_delet(row_for_delete);
		//Удаление строки из таблицы
		table = row.parentNode.parentNode;
		table.deleteRow(row.rowIndex);
		
	}
	});
	// создать объект для передачи параметров
	var formData = new FormData(document.forms.person);
	//Указатель, какой файл вызываем
	formData.append('to', row.parentNode.parentNode.getAttribute('class'));
	//Указатель, какая функця вызывается
	formData.append('fun','delet');	
	formData.append(0, row.getAttribute('main_id'));
	//получение первых ячеек
	request.send(formData);
}

//Проверка в необходимости стрки удалить всё  
function chek_count_element_row_delet(row){
		
	//Если нет элементов на удаление, удалить строку из боковой таблицы
	if(Object.keys(row.array_for_delete).length == 0){
		var table = row.parentNode.parentNode;
		table.deleteRow(row.rowIndex);
		//Удаление кнопки отмены всех выбранных элементов
		var delet_buuton = document.getElementById('cancel_button');
		table.deleteRow(delet_buuton.rowIndex);
	}
}

//Функция, для удаления всех выбранных элементов
function all_delete_rows(button){
	
	var all_delete_rows_row = button.parentNode;
	//Для всех элментов вызывается функция удаления, как при нажатии на кнопку
	for( var ArrVal in all_delete_rows_row.array_for_delete) {	
		var dr = all_delete_rows_row.array_for_delete[ArrVal];
		execlute_delet(dr.childNodes[dr.childNodes.length -1].childNodes[0]);
		//alert(Object.keys(row.array_for_delete).length + '-после');
	}
	
}

//Отмена всех выбранных элементов на удаление
function all_cancel_delete_rows(button){
	var all_delete_rows_row = document.getElementById("delete_row_row");	
	
	//Для всех элментов вызывается функция удаления, как при нажатии на кнопку
	for( var ArrVal in all_delete_rows_row.array_for_delete) {
		
		dr = all_delete_rows_row.array_for_delete[ArrVal];
		cancel_delete_row(dr.childNodes[dr.childNodes.length -1].childNodes[0]);
		//alert(Object.keys(row.array_for_delete).length + '-после');
	}
}

//Отмена удаления кнопки
function cancel_delete_row(butt){
	//Полчение строки
	var row = butt.parentNode.parentNode;
	//Возвращение цвета
	for(var i = 0; i < row.childNodes.length - 2; i++) {
		var child = row.childNodes[i];		
		child.setAttribute("bgcolor", child.getAttribute('old_bgcolor'));
	}
	//Удаление объекта из списка на удаление
	var row_for_delete = document.getElementById("delete_row_row");
	delete row_for_delete.array_for_delete[row.getAttribute('main_id')];
	chek_count_element_row_delet(row_for_delete);
	
	var child = row.childNodes[row.childNodes.length - 2];
	child.innerHTML = child.getAttribute('old_innerHTML');
	child = row.childNodes[row.childNodes.length - 1];
	child.innerHTML = child.getAttribute('old_innerHTML');
}