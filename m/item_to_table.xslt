<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:output method="html" encoding="iso-8859-1" indent="no"/>
	
	<xsl:template match="предметы">
			<table id='main_table' edit='true' delete='true' add='true'>
		
			<xsl:attribute name='model_arr'>
				<xsl:text> replace_model_arr</xsl:text>
			</xsl:attribute>
			
			<xsl:attribute name='type_arr'>
				<xsl:text> replace_type_arr</xsl:text>
			</xsl:attribute>
			
			<xsl:attribute name='man_arr'>
				<xsl:text> replace_man_arr</xsl:text>
			</xsl:attribute>
			
			<xsl:attribute name='group_arr'>
				<xsl:text> replace_group_arr</xsl:text>
			</xsl:attribute>
			
			<xsl:attribute name='room_arr'>
				<xsl:text> replace_room_arr</xsl:text>
			</xsl:attribute>
		
			<xsl:attribute name='class'>
				<xsl:text>item</xsl:text>
			</xsl:attribute>
						
			<tbody>
			
			<tr>
				<th><xsl:text>Инвент номер</xsl:text></th> 				
				<th><xsl:text>Имя</xsl:text></th> 
				<th link='3' source='room_arr' in_arr='2'><xsl:text>Корпус</xsl:text></th> 
				<th selecting='room_arr'><xsl:text>Помещение</xsl:text></th> 
				<th selecting='man_arr'><xsl:text>ФИО</xsl:text></th> 
				<th selecting='group_arr'><xsl:text>Группа</xsl:text></th> 
				<th link='7' source='model_arr' in_arr='2'><xsl:text>Тип</xsl:text></th> 
				<th selecting='model_arr'><xsl:text>Модель</xsl:text></th> 
				<th link='7' source='model_arr' in_arr='3'><xsl:text >Еденица измерения</xsl:text></th> 
				<th><xsl:text>Коммент</xsl:text></th> 
				<th><xsl:text>Кол-во</xsl:text></th> 				
			</tr>
		
			
			<xsl:for-each select="строка"> 
				<xsl:sort select='тип'/>
				<xsl:sort select='инвентнарный_номер'/>
				<tr class='item_row'>
					<xsl:attribute name="main_id">
						<xsl:value-of select='id'/>
					</xsl:attribute>																			
										
					<td bgcolor='#f7f8fc'> <xsl:value-of select="инвентарный_номер"/>  </td> 
					<td bgcolor='#f7f8fc'> <xsl:value-of select="имя"/>  </td> 
					<td bgcolor='#f7f8fc' link='3' source='room_arr' in_arr='2'> <xsl:value-of select="корпус"/>  </td> 
					<td bgcolor='#f7f8fc' selecting='room_arr'> <xsl:value-of select="номер_помещения"/>  </td> 
					<td bgcolor='#f7f8fc' selecting='man_arr'> <xsl:value-of select="ФИО"/>  </td> 
					<td bgcolor='#f7f8fc'  selecting='group_arr'> <xsl:value-of select="группа"/>  </td> 
					<td bgcolor='#f7f8fc' link='7' source='model_arr' in_arr='2'> <xsl:value-of select="тип"/> </td> 
					<td bgcolor='#f7f8fc' selecting='model_arr'> <xsl:value-of select="модель"/>  </td> 
					<td bgcolor='#f7f8fc' link='7' source='model_arr' in_arr='3' > <xsl:value-of select="единица"/>  </td> 
					<td bgcolor='#f7f8fc'> <xsl:value-of select="комментарий"/>  </td> 
					<td bgcolor='#f7f8fc'> <xsl:value-of select="количество"/>  </td> 
					
					
					<td> <button onclick="edit_row(this)"> Изменить </button> </td>
					<td> <button onclick='delet_row(this)'> Удалить </button> </td>
				</tr>
			</xsl:for-each>
			</tbody>
		</table>		
	</xsl:template>
	  
</xsl:stylesheet>