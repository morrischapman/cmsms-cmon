<br />
<h4>{$edit_list_title}</h4>
<br />
<br />
{$form_start}
<div style="float:right;"><ul><li>{$addFieldIcon}{$addField}</li>
<li>{$deleteFieldIcon}{$deleteField}</li></ul></div>
<form>
<fieldset>
<legend>Edit list</legend>
<table>
	<tr><td>{$api_key_title}</td><td>{$api_key}</td><td></td></tr>
	<tr><td>{$list_id_title}</td><td>{$list_id}</td></tr>
	<tr><td>{$list_name_title}</td><td>{$list_name}</td></tr>
	<tr><td>{$unsubscribe_page_title}</td><td>{$unsubscribe_page}</td></tr>
	<tr><td>{$confirm_optin_title}</td><td>{$confirm_optin}</td></tr>
	<tr><td>{$confirm_success_page_title}</td><td>{$confirm_success_page}</td></tr>
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
