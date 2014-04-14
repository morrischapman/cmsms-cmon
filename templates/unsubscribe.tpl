<br />
<h4>{$unsubscribe_title}</h4>
<br />
{$form_start}
<form>
<fieldset>
<legend>Unsubscribe a list subscriber</legend>
<table>
	<tr><td>{$api_key_title}</td><td>{$api_key}</td></tr>
	<tr><td>{$list_id_title}</td><td>{$list_id}</td></tr>
	<tr><td>{$email_address_title}</td><td>{$email_address}</td></tr>
	<tr><td></td><td>{$submit}{$cancel}</td></tr>
	</fieldset>
</table>
{$form_end}
<br />
<p>{$addBackIcon}{$goBack}</p>
<br />
<br />
<p style="color:red;">{$error}</p><div style="color:green;">{$done}</div>