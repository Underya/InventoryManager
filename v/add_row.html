//Добавление формы, с окнами для ввода данных
function form_add(button){
	//СОздание глобальной переменной
	execute_add_row = false;
	//Есле ещё не создавно окно для добавления
	var n_table = document.getElementById('table_from_add');
	
	if(n_table == null){
		//Получение указателя на таблица, для формирования ячеек для вводда
		var table = document.getElementById('main_table');		
		//Создание строки таблицы, в которой будет запись
		var insert_cell = document.getElementById("r_table").insertRow(-1).insertCell(-1);
		insert_cell.setAttribute('contenteditable', true);
		insert_cell.setAttribute('id', 'cell_from_add_table')
		//Получение информации о том, какие есть поля из заголовков
		var rows = table.rows[0];
		//Создание таблицы, 
		n_table = document.createElement('table');
		//n_table.setAttribute('style','position: fixed; right: 2%; top:30');
		//Формирование внутреннего HTML страницы
		n_table.setAttribute('id', 'table_from_add');
		n_table.setAttribute('border', '1');
		n_table.setAttribute('style', 'margin:3;');
		//Создание полей
		for(var i = 0; i < rows.cells.length; i++){
			//Проверка, не является ли столбец связанным
			var nrow = n_table.insertRow(-1);
			var ncell = nrow.insertCell(-1);			
			//Вставка названия вводимого поля
			ncell.innerHTML = rows.cells[i].innerHTML;
			//Вставка столбца для редактирования
			ncell = nrow.insertCell(-1);
			ncell.setAttribute('style', 'width: 20;');
			//Проверка, не является ли вводимое поле спец атрибутом
			if(rows.cells[i].hasAttribute('selecting')) {
				//То значение ячейки - спец селектор, то вставить его в ячейку
				var arr = get_array_forname(rows.cells[i].getAttribute('selecting'));
				replace_select(ncell, arr, true, 'block');
				//Для ячейки добавляется аттрибут со значением как у столбца
				ncell.setAttribute('selecting', rows.cells[i].getAttribute('selecting'));
				
			} else 
				ncell.setAttribute('contenteditable', true);
			
			//Если ячейка - связанная, она не редктирумая
			if(rows.cells[i].hasAttribute('link')) { 
				ncell.setAttribute('contenteditable', false); 
				//А так же добавление параметров
				nrow.setAttribute('link', rows.cells[i].getAttribute('link'))
				nrow.setAttribute('source', rows.cells[i].getAttribute('source'))
				nrow.setAttribute('in_arr', rows.cells[i].getAttribute('in_arr'))
			}
		}
		//Добавление в правый блок таблицы с данными для ввода		
		insert_cell.appendChild(n_table);
		//Создание кнопки для подтверждения/отмены
		var b = document.createElement('button');
		b.innerHTML = 'Добавить';
		b.setAttribute('style', 'margin: 3; font-size:15');
		b.setAttribute('id', 'id_b_add_add');
		b.setAttribute('onclick', 'add_new_row()');
		//Добавление в правый блок кнопки добавления
		insert_cell.appendChild(b);
		b.parentNode.setAttribute('contenteditable', false);
		//Кнопка отмена
		var b = document.createElement('button');
		b.innerHTML = 'Отмена';
		b.setAttribute('style', 'margin: 3; font-size:15');
		b.setAttribute('id', 'id_b_add_cancel');
		b.setAttribute('onclick', 'cancel_add_button()');		
		insert_cell.appendChild(b);
		b.parentNode.setAttribute('contenteditable', false);
	}
}

//Вызов соотвествующей функции в соотвествующем срипте
function add_new_row(){
	//Провека, не происходит ли уже добавление
	//Если происходит, ничего не делать
	if(execute_add_row == true) return;
	//Указание на добавление
	execute_add_row = true;
	//Получение данных из таблицы
	var name_class = document.getElementById('main_table').getAttribute('class');
	//Формирование запроса к скрипту
	var request = new XMLHttpRequest();
	request.open('POST','m/' + name_class +'.php', true);
	//Формирование параметров для отправки
	var formData = new FormData(document.forms.person);
	//Указатель, какой файл вызываем
	formData.append('to', name_class);
	//Указатель, какая функця вызывается
	formData.append('fun','add');	
	//Формирование остальных параметров
	var index = 0;
	//Получение таблицы с новыми данными
	var table_data = document.getElementById('table_from_add');
	//Цикл, в ходе которого разбирается содержимое
	for(var i = 0; i < table_data.rows.length; i++){
		//Если колонка зависимая - надо пропустить
		if(table_data.rows[i].getAttribute('link')) continue;
		//Получение значения в ячейке
		var cell = table_data.rows[i].cells[1];
		var datacell = '';
		//Проверка, не явлеяется ли текущая ячейки ячейкой select
		if(cell.hasAttribute('selecting')) {
			//Получение значения из ячейки
			datacell = get_select_id(cell)
		} else {
			datacell = table_data.rows[i].cells[1].innerHTML;
		}
		
		//Удаление тегов из содержимого ячейки
		datacell = datacell.replace(/<br>/g, '');
		
		//Добавление к параметрам
		formData.append(index++, datacell);
	}
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
		
		//Добавление нового значения в таблицу 
		var mtable = document.getElementById('main_table');		 
		//Добавление новой строчки
		var n_row = mtable.insertRow(-1);
		
		//Вставка ячеек
		for(var i = 0; i < table_data.rows.length; i++){
			//Получение значения в ячейке
			//Проверка, не является ли ячейка - спец ячейкой
			if(table_data.rows[i].cells[1].hasAttribute('selecting')) {
				//ЗАмена на простой текст
				replace_text(table_data.rows[i].cells[1])
			}
			var datacell = table_data.rows[i].cells[1].innerHTML;
			//Добавление к параметрам
			var n_cell = n_row.insertCell(-1);
			n_cell.innerHTML = datacell;
			n_cell.setAttribute('bgcolor', '#f7f8fc');
		}
		
		//Проверка, нет связанных ячеек, которые не отображаются в правом блоке
		var main_table = document.getElementById('main_table');
		var header_row = main_table.rows[0];
		//Цикл по всем элементам заголовка
		
		//Если у таблицы есть свойство редактировния, добавить нужную кнопку
		if(mtable.getAttribute('edit')){
			var n_cell = n_row.insertCell(-1);
			n_cell.innerHTML = '<button onclick="edit_row(this)"> Изменить </button>';
		}
		
		if(mtable.getAttribute('delete')){
			var n_cell = n_row.insertCell(-1);
			n_cell.innerHTML = '<button onclick="delet_row(this)"> Удалить </button>';
		}
		
		

		//Добавление атрибута с ид строкой из БД
		var new_id = text_res.substring( text_res.indexOf('id') + 2, text_res.indexOf('ok'));

		
		n_row.setAttribute('main_id', new_id);
		
		//Вернуть значение ячеек как до отмены				
		//Закрыть окно ввода
		cancel_add_button();
		//Указать, что прошла операция добавления
		execute_add_row = false;
	}
	});
	
	//Отправка данных
	request.send(formData);
	
}

//Закртыие окна для добавления новых элементов
function cancel_add_button(){
	var n_cell = document.getElementById('cell_from_add_table');
	//удаление содержимого ячейки
	n_cell.innerHTML = null;
	//Удаление самой ячейки
	n_cell.parentNode.deleteCell(n_cell.indexCell);
	
}