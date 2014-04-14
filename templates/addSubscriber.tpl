<br />
<h4>{$add_subscriber_title}</h4>
<br />
<br />
{$form_start}
<form>
<fieldset>
<legend>Add a subscriber to a list</legend>
<table>
<tr><td>{$api_key_title}</td><td>{$api_key}</td></tr>
<tr><td>{$list_id_title}</td><td>{$list_id}</td></tr>
<tr><td>{$email_address_title}</td><td>{$email_address}</td></tr>
<tr><td>{$subscriber_name_title}</td><td>{$subscriber_name}</td></tr>
<tr><td></td><td>{$submit}{$cancel}</td></tr>
</table>
{$form_end}
<br />
<p>{$addBackIcon}{$goBack}</p>
<br />
<br />
<p style="color:red;">{$error}</p><div style="color:green;">{$done}</div>