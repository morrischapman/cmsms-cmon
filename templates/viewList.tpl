<h4>{$view_list_title}</h4>
<br />
<br />
{$form_start}
<form>
<fieldset>
<legend>View list</legend>
<table>
	<tr><td>{$api_key_title}</td><td>{$api_key}</td></tr>
	<tr><td>{$list_id_title}</td><td>{$list_id}</td></tr>
	<tr><td></td><td>{$submit}{$cancel}</td></tr>
	<tr><td>&nbsp;</td><td></td></tr>
	<tr><td>&nbsp;</td><td></td></tr>
	<tr><td></td><td><div style="color:green;">{$list_details}</div></td></tr>
	<tr><td>{$list_id_title2}</td><td>{$list_id2}</td></tr>
	<tr><td>{$list_name_title}</td><td>{$list_name}</td></tr>
	<tr><td>{$unsubscribe_page_title}</td><td>{$unsubscribe_page}</td></tr>
	<tr><td>{$confirm_optin_title}</td><td>{$confirm_optin}</td></tr>
	<tr><td>{$confirm_success_page_title}</td><td>{$confirm_success_page}</td></tr>
</table>
</fieldset>
{$form_end}
<br />
<br />
<div style="color:red;">{$error}</div><div style="color:green;">{$done}</div>
	<br />
<br />
<p>{$addBackIcon}{$goBack}</p>
<br />
<br />	
	