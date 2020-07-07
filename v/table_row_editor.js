function edit_row(button){
	//получение строки
	var row = button.parentNode.parentNode;
	
	//Перебор всех столбцов внутри строки, что бы включить среди них редактируемые, то есть не кнопки, которые последние 2
	//Сохранение старых значений
	for (var i = 0; i < row.childNodes.length - 2; i++) {				
		var child = row.cells[i];
		//Проверка, является ли атрибут обычным
		if(child.hasAttribute('selecting')){
			
			//Получение массивая со значениями для таблицы
			var arr = get_array_forname(child.getAttribute('selecting'));
			//Если не является обычным, вызов функции для ячеейки
			replace_select(child, arr, false, 'table')
			
			
			//Если явлется, то подготовка ячеек для редакттирования
		} else {
			child.setAttribute("old_innerHTML", child.innerHTML);
			
			//Если колонка связана со значением, то она не радкатируется
			if(!child.hasAttribute('link'))	{
				child.setAttribute("contenteditable", true);
			}
			
			
		}
		
		child.setAttribute("oldbgcolor", child.getAttribute('bgcolor'));
		//Если колонкан привязана, то цвет меняется
		if(!child.hasAttribute('link')) child.setAttribute("bgcolor", '#bee2c7');
    }
	
	//Для последних двух элементов - изменение кнопок
	var child = row.childNodes[row.childNodes.length - 2];	
	var old_inn = child.innerHTML;	
	child.innerHTML = "<button onclick='save(this)'>Сохранить</button>";
	child.setAttribute('old_innerHTML', old_inn);
	
	child = row.childNodes[row.childNodes.length - 1];	
	old_inn = child.innerHTML;	
	child.innerHTML = "<button onclick='cancel(this)'>Отмена</button>";
	child.setAttribute('old_innerHTML', old_inn);
}

function save(butt){
	// 2. Создание переменной request
	var request = new XMLHttpRequest();
	//получение данных из таблицы
	var main_t = document.getElementById("main_table");
	//Полчение имени, по которому вызывается метод
	var name = main_t.getAttribute('class');
	// 3. Настройка запроса
	request.open('POST','m/' + name +'.php', true);
	//Строка для дальнейшен работы
	var row = butt.parentNode.parentNode;
	// 4. Подписка на событие onreadystatechange и обработка его с помощью анонимной функции	
	request.addEventListener('readystatechange', function() {		
	// если состояния запроса 4 и статус запроса 200 (OK)
	if ((request.readyState==4) && (request.status==200)) {		
		// и ответ (текст), пришедший с сервера в окне alert
		var text_res = request.responseText;		
		//Если не удалось получить ok
		if(text_res != 'ok') {
			alert('Не удалось изменить значения. Ошибка:' + text_res);
			return;
		}
		//Вернуть значение всех ячеек как до отмены		
		for (var i = 0; i < row.childNodes.length ; i++) {
			var child = row.cells[i];		
					
			//Если ячейка - содержит тег select
			if(child.hasAttribute('selecting')){
				//Вызов спец функции
				replace_text(child);
			}
					
			if(child.hasAttribute('oldbgcolor')) child.setAttribute('bgcolor', child.getAttribute("oldbgcolor"));
			if(child.hasAttribute('contenteditable')) child.setAttribute('contenteditable', false);
		}
		
		//Вернуть значение только для интерактивных кнопок
		for(i = row.childNodes.length - 2; i < row.childNodes.length; i++){ 						
			var child = row.childNodes[i];						
			child.innerHTML = child.getAttribute("old_innerHTML");
		}
	}
	});
	// создать объект для передачи параметров
	var formData = new FormData(document.forms.person);
	//Указатель, какой файл вызываем
	formData.append('to', name);
	//Указатель, какая функця вызывается
	formData.append('fun','edit');
	//Формирование остальных параметров
	var index = 0;
	//Вставка главного параметра
	formData.append(index++, row.getAttribute('main_id'));
	
	for (var i = 0; i < row.childNodes.length - 2; i++) {
		var child = row.childNodes[i];
		//Проверка, не явлется ли атрибут связным
		if(child.hasAttribute('link')) continue;
		//Проверка, не является ли элемент спец элементом
		if(child.hasAttribute('selecting')){
			//То для получения ид используется спец функция
			formData.append(index++, get_select_id(child))
		}  else {
			formData.append(index++, child.innerHTML.replace(/<br>/g, ''));
			
		}
    }
	
	//получение первых ячеек
	request.send(formData);
}

function cancel(button){
	//Отмена всех изменений
	//Для всех столбцов возвращаются старые значения + старый цвет, если таковой есть
	var row = button.parentNode.parentNode;
	for (var i = 0; i < row.childNodes.length ; i++) {
		var child = row.childNodes[i];		
		child.innerHTML = child.getAttribute("old_innerHTML");
		if(child.hasAttribute('oldbgcolor')) child.setAttribute('bgcolor', child.getAttribute("oldbgcolor"));
		if(child.hasAttribute('contenteditable')) child.setAttribute('contenteditable', false);
		//if(child.hasAttribute('old_butt')) child.setAttribute('innerHTML', child.getAttribute('old_butt'));
	}
	
}