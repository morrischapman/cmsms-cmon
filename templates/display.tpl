
<br />
<table width="100%" border="1" bordercolor="#660000" height="343" style="border-collapse: collapse" valign="top" cellspacing="5">
	<tr>{section name=header loop=$listNames}<th>{$listNames[header]}</th>{/section}<tr>
	{section name=element loop=$list}
		<tr bgcolor="{cycle values="#eeeeee,#dddddd"}"><td><b>{$list[element].0}</b></td><td>{$list[element].1}</td>
					 <td>{$list[element].2}</td><td>{$list[element].3}</td>
					 <td>{$list[element].4}</td>
		</tr>
	{/section}
</table>
<br />
<br />					 


