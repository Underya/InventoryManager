//Функция добавляет таблицу для добавления новых моделей
function add_table_add_model(button){
	
	//Проверка, не создана ли таблица
	if(document.getElementById('table_add_model')) return;
	
	//Получение указателя на таблицу
	var table = button.parentNode.parentNode.parentNode;
	//Вставка значения в таблицу, и получения ячейки
	var row = table.insertRow(1);
	var n_cell = row.insertCell(0);
	//Добавление на ячейки ид, что бы закрывать без проблем
	n_cell.setAttribute('id', 'cell_add_model');
	
	//Создание спец таблицы с содержимым окна запроса
	table = document.createElement('table');
	//Добавление таблицы в ячейку
	n_cell.appendChild(table);
	//Указание рамок
	table.setAttribute('border', '1px');
	//Указание ид для облегчения поиска
	table.setAttribute('id', 'table_add_model');
	
	//Добавление всех полей + кнопок
	row = table.insertRow(-1);
	var c_cell = row.insertCell(-1);
	c_cell.innerHTML = 'Тип';
	c_cell.setAttribute('selecting', true);
	c_cell = row.insertCell(-1);	
	c_cell.setAttribute('width', '20px');
	//Замена содержимого ячейки на селектор
	replace_select(c_cell, get_array_forname('type_arr'), true, 'block');
	
	//Вставка ячейки с еденицами измерений
	row = table.insertRow(-1);
	//Установка атрибутов для правильной установки значений от селектора
	row.setAttribute('link', 0);
	row.setAttribute('source', 'type_arr');
	row.setAttribute('in_arr', 2);
	c_cell = row.insertCell(-1);
	c_cell.innerHTML = 'Единица измерения';
	c_cell = row.insertCell(-1);	
	c_cell.setAttribute('width', '20px');
	//Установка строчки с вводом имени модели
	row = table.insertRow(-1);
	c_cell = row.insertCell(-1);
	c_cell.innerHTML = 'название'
	c_cell = row.insertCell(-1);
	c_cell.setAttribute('contenteditable', true);
	
	//Добавление кнопки вызова
	var b = document.createElement('button');
	b.innerHTML = 'Добавить';
	b.setAttribute('onclick', 'add_model(this)')
	//Добавление кнопки
	n_cell.appendChild(b);	
	
	//Добавление кнопок отмены
	b = document.createElement('button');
	b.innerHTML = 'Отмена';
	b.setAttribute('onclick', 'close_model_add(this)')
	//Добавление кнопки
	n_cell.appendChild(b);	
	//Указание на то, что вывода не происходит
	execute_add_row_model = false;
	
}

//Добавление новго элемента
function add_model(button){
	
	//Провека, не происходит ли уже добавление
	//Если происходит, ничего не делать
	if(execute_add_row_model == true) return;
	//Указание на добавление
	execute_add_row_model = true;
	
	//Получение указателя на строки из таблицы c данными
	var row = document.getElementById('table_add_model').rows;
	//Формирование строки с данными
	var formData = new FormData(document.forms.person);
	//Указатель, какой файл вызываем
	formData.append('to', 'model');
	//Указатель, какая функця вызывается
	formData.append('fun','add');
	//Добавление параметров в ручную
	formData.append('0', get_select_id(row[0].cells[1]));
	formData.append('1', row[2].cells[1].innerHTML);
	
	//Формирование функции для отправки
	var request = new XMLHttpRequest();
	request.open('POST','m/model.php', true);
	
	// 4. Подписка на событие onreadystatechange и обработка его с помощью анонимной функции	
	request.addEventListener('readystatechange', function() {		
	// если состояния запроса 4 и статус запроса 200 (OK)
	if ((request.readyState==4) && (request.status==200)) {		
	
		// и ответ (текст), пришедший с сервера в окне alert
		var text_res = request.responseText;		
		//Если не удалось получить ok
		if(text_res.indexOf('ok') == -1 || text_res.indexOf('ok') > 40) {
			alert('Не удалось добавить значение. Ошибка:' + text_res);
			//Указать, что не происходит добавления
			execute_add_row = false;
			return;
		}
		
		//Если всё пришло, ок, получить id
		var new_id = text_res.substring( text_res.indexOf('id') + 2, text_res.indexOf('ok'));
		//Получить массив с типами
		var arr = get_array_forname('model_arr');
		//Получение текста с типами
		var arr_text = document.getElementById('main_table').getAttribute('model_arr');
		//Добавить в него новое значение
		//Строка с новым текстом, который надо добавить
		var n_text = '[';
		n_text += arr.length + ']=[' + new_id + ', "' + row[2].cells[1].innerHTML + '", "'+
		row[0].cells[1].firstChild.item(row[0].cells[1].firstChild.selectedIndex).innerHTML + '", "'+ row[1].cells[1].innerHTML + '"]; arr'
		//Добавление к массиву
		arr_text += n_text;
		//Установка нового массива
		document.getElementById('main_table').setAttribute('model_arr', arr_text);
		//Вызов функции закрытия окна
		close_model_add(button);
	}})
	//Отправка данных
	request.send(formData);
}

//Функция закрывает таблицу для ввода элементов
function close_model_add(button){
	
	//Строчка в таблице, которую нужно удалить
	var row = button.parentNode.parentNode;
	//Таблица, из которй надо удалить
	var table = row.parentNode;
	//удаление таблицы
	table.deleteRow(row.rowIndex);
}






















