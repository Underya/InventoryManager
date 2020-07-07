//Модуль содержит набор функций для работы

//Получить массива из таблицу main_table по
function get_array_forname(name){
	//Получение значения атрибута
	var val = document.getElementById('main_table').getAttribute(name);
	//Создание и возвращение массива со значениями
	return eval(val)
}

//Функция заменяет содержимое клетки на тег select по массиву array
//Флан new_option означает, что нужно добавить не выбираемое значение по умолчанию
//where - место расположения таблицы block - правый блок при добавлении, table - таблица слева
function replace_select(cell, array, new_option, where){
	//Установка значений ячейки, для начала
	cell.setAttribute("old_innerHTML", cell.innerHTML);
	//Получение старогового значения
	var old_t = cell.innerHTML.substring(1);
	//Удаление текстового содержимого
	cell.innerHTML = '';	
	
	//Переменная для сохранения индекса
	var index = 0;
	
	//Создание элемента селект
	var selector = document.createElement('select');
	
	//Добавление указателя на место
	selector.setAttribute('where', where);
	
	//Если надо вставить новое значение - вставка
	if(new_option == true){
		var op = document.createElement('option');
		op.setAttribute('disabled', true);
		op.text = 'выберите значение';
		//Вставка
		selector.add(op);
	}
	
	//Флаг, было ли найдено подходящее значение
	var sel_index = false;
	
	//Формирование тела селектора
	for(var i = 0; i < array.length; i++){
		//Создание одной из опций выбора
		var op = document.createElement('option');
		//Установка значения 
		op.setAttribute('inner_id', array[i][0]);
		op.text = array[i][1];
		
		
		//Если не надо вставлять новое значение
		if(new_option == false) {
			//Если значение опции совпадает с выбранным значением, то запоминается индекс элемента

			if(old_t == array[i][1]){
				index = i;
			}
		}
		//Добавление значения в селект
		selector.add(op);	
	}
	
	//Если нужно было вставить старое значение, но оно не было найдено
	if(!new_option && !sel_index){
		//То поиск второй обход, но с не на точное совпадение
		for(var i = 0; i <array.length; i++){
			//Проверка на вхождение
			if(array[i][1].indexOf(old_t) != -1){
				//Сохрание индекса, конец цикла
				index = i;
				break;
			}
		}
	}
	
	//Добавление ивента для обновлении связанных значений
	selector.setAttribute('onclick', 'change_select(this)')	
	//Указание выбранного элемента
	selector.selectedIndex = index;
	//Установка в качестве содержимого ячейки
	cell.appendChild(selector);
	
}

//Функция, вызываемая при нажатии на элемент сектора
function change_select(selector){		

	//Получение ячейки, в которой находиться элемент
	var cell = selector.parentNode;	
	//Строка, в которой происходит поиск
	var row = cell.parentNode;

	//Проверка, где находился элемент
	if(selector.getAttribute('where') == 'table'){
		
		//Получение индекса ячейки
		var cell_index = cell.cellIndex;
		//Поиск в строке элементов, указывающих на выбранную ячейку
		for(var i = 0, max_cell = row.cells.length; i < max_cell; i++){
			var c_cell = row.cells[i];
			//Проверка, есть
			if(c_cell.getAttribute('link') == cell_index){
				//Если найден, то получаем массив по имени через параметр
				var array = get_array_forname(c_cell.getAttribute('source'));
				//Найти элемент массива, совпадающий с выбранным в ячейке
				//Значение в выбранном элементе
				var select = selector.item(selector.selectedIndex).getAttribute('inner_id');
				//Поиск в массиве
				for(var k = 0; k < array.length; k++){
					//Если найден выбранный элемент
					if(array[k][0] == select){
						//Подстановка значения в зависимую ячейку
						c_cell.innerHTML = array[k][c_cell.getAttribute('in_arr')];
						//Конец данной итерации для ячейки
						break;
					}					
				}
				
			}
		}
	}
	
	//Тоже самое, но для правого блока
	if(selector.getAttribute('where') == 'block'){
		//Получение выбранного элемента
		var option = selector.item(selector.selectedIndex);
		//Если ничего не выбрано, ничего не делать
		if(option.getAttribute('disabled') == true) return;
		//Если выбран элемент, надо найти строку, связанную с текущим селектором
		var row_index = row.rowIndex;
		//Таблица, в которой происходит посик
		var table = row.parentNode;
		//Поиск среди всех строк таблицы
		for(var i = 0, row_count = table.rows.length; i < row_count; i++){
			var c_row = table.rows[i];
			//Проверка, не связана ли строка с selectom
			if(c_row.getAttribute('link') == row_index ){
				//Получение массива со значениями
				//Если найден, то получаем массив по имени через параметр
				var array = get_array_forname(c_row.getAttribute('source'));
				//Выбранное значение в еэлементе
				var select = selector.item(selector.selectedIndex).getAttribute('inner_id');
				//Поиск совпдающего значения
				for(var k = 0; k < array.length; k++){
					//Если найден выбранный элемент
					if(array[k][0] == select){
						//Подстановка значения в зависимую ячейку
						c_row.cells[1].innerHTML = array[k][c_row.getAttribute('in_arr')];
						//Конец данной итерации для ячейки
						break;
					}					
				}
			}
		}
	}
}

//функция замена ячейки с селектом на ВЫБРАННЫЙ в ней текстового
function replace_text(cell){
		//Получение тега select
		var sel = cell.childNodes[0];
		//Получение выбранной опции
		var op = sel.item(sel.selectedIndex);
		//Получение текста
		var t = op.text;
		//Очищение содержимого ячейки
		cell.innerHTML = '';
		//Вставка текста
		cell.innerHTML = t;
		
}

//Получение атрибута id из ячейки с тегом select внутри
function get_select_id(cell){
	//Получение элемента select
	var s = cell.childNodes[0];
	//Получение выбранной опции
	var op = s.item(s.selectedIndex);
	//Возвращение ИД
	return op.getAttribute('inner_id');
}