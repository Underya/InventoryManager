<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:output method="html" encoding="iso-8859-1" indent="no"/>
	
	<xsl:template match="человек">
			<table id='main_table' edit='true' delete='true' add='true'>
		
			<xsl:attribute name='class'>
				<xsl:text>man</xsl:text>
			</xsl:attribute>
			
			<tbody class='ctbody'>
			
			<tr>
				<th><xsl:text>ФИО</xsl:text></th> 
				<th><xsl:text>Должность</xsl:text></th> 
				<th><xsl:text>Комментарий</xsl:text></th> 
			</tr>
		
			
			<xsl:for-each select="строка" order-by="фио"> 
				<tr>
					<xsl:attribute name="main_id">
						<xsl:value-of select='id'/>
					</xsl:attribute>																			
										
					<td bgcolor='#f7f8fc'> <xsl:value-of select="фио"/> </td> 
					<td bgcolor='#f7f8fc'> <xsl:value-of select="должность"/>  </td> 					
					<td bgcolor='#f7f8fc' width='20'> <xsl:value-of select="комментарий"/>  </td> 
					<td> <button onclick="edit_row(this)"> Изменить </button> </td>
					<td> <button onclick='delet_row(this)'> Удалить </button> </td>
				</tr>
			</xsl:for-each>
			</tbody>
		</table>		
	</xsl:template>
	  
</xsl:stylesheet>