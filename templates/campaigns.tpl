{*<div class="pageoptions">
	<p class="pageoptions">
	<div style="border: 1px solid;">
	{$addCampaignIcon}
	{$addCampaign}
	&nbsp;&nbsp;&nbsp;&nbsp;
	{$sendCampaignIcon}
	{$sendCampaign}
	&nbsp;&nbsp;&nbsp;&nbsp;
	{$viewDraftsIcon}
	{$viewDrafts}
	&nbsp;&nbsp;&nbsp;&nbsp;
	{$deleteCampaignIcon}
	{$deleteCampaign}
	&nbsp;&nbsp;&nbsp;&nbsp;
	</div>
	</p>
</div>*}

{if $campaigns|count > 0}
<table cellspacing="0" class="pagetable">
	<thead>
		<tr>
			<th>{$campaign_title}</th>
			<th>{$campaign_id_title}</th>
			<th>{$sent}</th>
			<th>{$total_recipients_title}</th>
			<th class="pageicon"> </th>
		</tr>
	</thead>
<tbody>
{foreach from=$campaigns item=entry}
	<tr class="{$entry->rowclass}" onmouseover="this.className='{$entry->rowclass}hover';" onmouseout="this.className='{$entry->rowclass}';">
		<td>{$entry->name}</td>
		<td>{$entry->campaign_id}</td>
		<td>{$entry->date}</td>
		<td>{$entry->total_recipients}</td>
		<td>{*$entry->manageIcon*}</td>
	</tr>
{/foreach}
	</tbody></table>

{*	<div class="pageoptions">
		<p class="pageoptions">
		{$addCampaignIcon}
		{$addCampaign}</p>
	</div>*}

{/if}

