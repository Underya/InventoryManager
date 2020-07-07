<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:output method="html" encoding="iso-8859-1" indent="no"/>
	
	<xsl:template match="тип">
			<table id='main_table' edit='true' delete='true' add='true'>
		
			<xsl:attribute name='class'>
				<xsl:text>type</xsl:text>
			</xsl:attribute>
			
			<tbody class='ctbody'>
			
			<tr>
				<th><xsl:text>Название</xsl:text></th> 				
				<th><xsl:text>Ееденица измерения</xsl:text></th> 
			</tr>
		
			
			<xsl:for-each select="строка" order-by="имя"> 
				<tr>
					<xsl:attribute name="main_id">
						<xsl:value-of select='id'/>
					</xsl:attribute>																			
										
					<td bgcolor='#f7f8fc'> <xsl:value-of select="имя"/> </td> 
					<td bgcolor='#f7f8fc'> <xsl:value-of select="еденица"/>  </td> 
					<td> <button onclick="edit_row(this)"> Изменить </button> </td>
					<td> <button onclick='delet_row(this)'> Удалить </button> </td>
				</tr>
			</xsl:for-each>
			</tbody>
		</table>		
	</xsl:template>
	  
</xsl:stylesheet>