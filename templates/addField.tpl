<h4>{$add_field_title}</h4>
<br />
<br />
<br />
{$form_start}
<form>
<fieldset>
<legend>Add field</legend>
<table>
	<tr><td>{$api_key_title}</td><td>{$api_key}</td>
	<tr><td>{$list_id_title}</td><td>{$list_id}</td></tr>
	<tr><td>{$field_name_title}</td><td>{$field_name}</td><td><div style="color:grey;"><i>{$field_name_help}</i></div></td></tr>
	<tr><td>{$data_type_title}</td><td>{$data_type}</td><td><div style="color:grey;"><i>{$data_type_help}</i></div></td></tr>
	<tr><td>{$options_title}</td><td>{$options}</td><td><div style="color:grey;"><i>{$options_help}</i></div></td></tr>
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