<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:output method="html" encoding="iso-8859-1" indent="no"/>
	
	<xsl:template match="помещение">
			<table id='main_table' edit='true' delete='true' add='true'>
		
			<xsl:attribute name='room_arr'>
				<xsl:text> var arr = []; arr[0]=['ОТИ', 'ОТИ']; arr[1]=['СПО', 'СПО'];	arr</xsl:text>
			</xsl:attribute>
		
			<xsl:attribute name='class'>
				<xsl:text>room</xsl:text>
			</xsl:attribute>
			
			<tbody class='ctbody'>
			
			<tr>
				<th selecting='room_arr'><xsl:text>Корпус</xsl:text></th> 				
				<th><xsl:text>Номер помещения</xsl:text></th> 
				<th><xsl:text>Комментарий</xsl:text></th> 
			</tr>
		
			
			<xsl:for-each select="строка"> 
				<xsl:sort select='корпус'/>
				<xsl:sort select='номер'/>
				<tr>
					<xsl:attribute name="main_id">
						<xsl:value-of select='id'/>
					</xsl:attribute>																			
										
					<td bgcolor='#f7f8fc' selecting='room_arr'> <xsl:value-of select="корпус"/> </td> 
					<td bgcolor='#f7f8fc'> <xsl:value-of select="номер"/>  </td> 
					<td bgcolor='#f7f8fc'> <xsl:value-of select="комментарий"/>  </td> 
					<td> <button onclick="edit_row(this)"> Изменить </button> </td>
					<td> <button onclick='delet_row(this)'> Удалить </button> </td>
				</tr>
			</xsl:for-each>
			</tbody>
		</table>		
	</xsl:template>
	  
</xsl:stylesheet>