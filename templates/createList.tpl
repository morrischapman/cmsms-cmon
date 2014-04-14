<br />
<h4>{$create_list_title}</h4>
<br />
{$form_start}
<form>
<fieldset>
<legend>Create a new list</legend>
<table>
<tr><td>{$api_key_title}</td><td>{$api_key}</td></tr>
<tr><td>{$client_id_title}</td><td>{$client_id}</td></tr>
<tr><td>{$list_name_title}</td><td>{$list_name}</td></tr>
<tr><td>{$unsubscribe_page_title}</td><td>{$unsubscribe_page}</td></tr>
<tr><td>&nbsp</td><td></td></tr>
<tr><td>{$confirm_optin_title}</td><td>{$confirm_optin}</td></tr>
<tr><td>&nbsp</td><td></td></tr>
<tr><td>{$confirm_success_page_title}</td><td>{$confirm_success_page}</td></tr>
<tr><td></td><td>{$submit}{$cancel}</td></tr>
</table>
</fieldset>
{$form_end}
<br />
<div style="color:red;">{$error}</div><div style="color:green;">{$done}</div>
<br />
<br />
<p>{$addBackIcon}{$goBack}</p>