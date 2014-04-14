<br />
<h4>{$draft_campaigns_title}</h4><br /><br />

<table cellspacing="0" class="pagetable">
	<thead>
		<tr>
			<th align="center">{$campaign_id_title}</th>
			<th>{$campaign_name_title}</th>
			<th>{$client_id_title}</th>
			<th>{$subject_title}</th>
			<th>{$from_name_title}</th>
			<th>{$from_email_title}</th>
			<th>{$reply_email_title}</th>
			<th>{$html_content_title}</th>
			<th>{$text_content_title}</th>
			<th>{$subscriber_listid_title}</th>
			<th>{$date_created_title}</th>
		</tr>
	</thead>
	<tbody>
	{section name=element loop=$list}
		<tr bgcolor="{cycle values="#eeeeee,#dddddd"}"><td align="center"><b>{$list[element].0}</b></td><td align="center">{$list[element].1}</td>
					 <td align="center">{$list[element].2}</td><td align="center">{$list[element].3}</td>
					 <td align="center">{$list[element].4}</td><td align="center">{$list[element].5}</td><td align="center">{$list[element].6}</td>
					 <td align="center">{$list[element].7}</td><td align="center">{$list[element].8}</td><td align="center">{$list[element].9}</td>
					 <td align="center">{$list[element].11}</td>
		</tr>
	{/section}
	</tbody>
</table>
	<br />
	<br />
	<br />
<p>{$addBackIcon}{$goBack}</p>