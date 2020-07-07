<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:output method="html" encoding="iso-8859-1" indent="no"/>
	
	<xsl:template match="модель">
			<table id='main_table' edit='true' delete='true' add='true' >
		
			<xsl:attribute name='type_arr'>
				<xsl:text> replace_type_arr</xsl:text>
			</xsl:attribute>
		
			<xsl:attribute name='class'>
				<xsl:text>model</xsl:text>
			</xsl:attribute>
			
			<tbody class='ctbody'>
			
			<tr>
				<th selecting='type_arr'><xsl:text>Тип</xsl:text></th> 				
				<th><xsl:text>Наименование</xsl:text></th> 
				<th link='0' source='type_arr' in_arr='2'><xsl:text >Еденица измерения</xsl:text></th> 
			</tr>
		
			
			<xsl:for-each select="строка"> 
				<xsl:sort select='тип'/>
				<xsl:sort select='наименование'/>
				<tr>
					<xsl:attribute name="main_id">
						<xsl:value-of select='id'/>
					</xsl:attribute>																			
										
					<td bgcolor='#f7f8fc' selecting='type_arr'> <xsl:value-of select="тип"/> </td> 
					<td bgcolor='#f7f8fc'> <xsl:value-of select="наименование"/>  </td> 
					<td bgcolor='#f7f8fc' link='0' source='type_arr' in_arr='2' > <xsl:value-of select="единица"/>  </td> 
					<td> <button onclick="edit_row(this)"> Изменить </button> </td>
					<td> <button onclick='delet_row(this)'> Удалить </button> </td>
				</tr>
			</xsl:for-each>
			</tbody>
		</table>		
	</xsl:template>
	  
</xsl:stylesheet>