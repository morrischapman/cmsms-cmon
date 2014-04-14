<br />
<h4>{$delete_list_title}</h4>
<br/>
{$form_start}
<form>
<fieldset>
<legend>Delete a list</legend>
<table>
<tr><td>{$api_key_title}</td><td>{$api_key}</td></tr>
<tr><td>{$list_id_title}</td><td>{$list_id}</td></tr>
<tr><td></td><td>{$submit}{$cancel}</td></tr>
</fieldset>
</table>
{$form_end}
<br />
<div style="color:red;">{$error}</div><div style="color:green;">{$done}</div>
<br />
<br />
<p>{$addBackIcon}{$goBack}</p>