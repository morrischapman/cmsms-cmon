<br />
<br />
{$form_start}
<form>
<fieldset>
<legend>Create a new Campaign</legend>
<table>

  <tr><td>{$campaign_name_title}</td>  <td>{$campaign_name}</td></tr>
  <tr><td>{$subject_title}</td>  <td>{$subject}</td></tr>
  
  <tr><td>{$html_content_title}</td>  <td>{$html_content}</td></tr>
  <tr><td>{$text_content_title}</td>  <td>{$text_content}</td></tr>
  <tr><td>{$subscriber_listid_title}</td>  <td>{$subscriber_listid}</td></tr>
  <tr><td>{$subscriber_segments_title}</td>  <td>{$subscriber_segments}</td></tr>
  <tr><td></td><td>{$submit}{$cancel}</td>
  </fieldset>
  </form>
</table>
<br />
<br />
<p>{$addBackIcon}{$goBack}</p>
{$form_end}
<br />
<br />
{section name=element loop=$errors}
		{$errors[element]}<br />
{/section}