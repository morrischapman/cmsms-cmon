<h4>{$delete_field_title}</h4>
<br />
<br />
{$form_start}
<form>
<fieldset>
<legend>Delete Field</legend>
<table>
	<tr><td>{$api_key_title}</td><td>{$api_key}</td><td></td></tr>
	<tr><td>{$list_id_title}</td><td>{$list_id}</td></tr>
	<tr><td>{$field_key_title}</td><td>{$field_key}</td><td><div style="color:grey;"><i>Key must be surrounded by [ ] brackets, e.g [Age]</i></div></td></tr>
	<tr><td></td><td>{$submit}{$cancel}</td>
	</fieldset>
</table>
{$form_end}
<br />
<br />
<div style="color:red;">{$error}</div><div style="color:green;">{$done}</div>
	<br />
<br />
<p>{$addBackIcon}{$goBack}</p>
<br />
<br />