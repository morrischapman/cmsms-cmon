{*<div class="pageoptions">
	<p class="pageoptions">
	<div style="border: 1px solid;">
	{$createListIcon}
	{$createList}
	&nbsp;&nbsp;&nbsp;&nbsp;
	{$viewListIcon}
	{$viewList}
	&nbsp;&nbsp;&nbsp;&nbsp;
	{$editListIcon}
	{$editList}
	 &nbsp;&nbsp;&nbsp;&nbsp;
	{$deleteListIcon}
	{$deleteList}
	&nbsp;&nbsp;&nbsp;&nbsp;
	{$addSubscriberIcon}
	{$addSubscriber}
	&nbsp;&nbsp;&nbsp;&nbsp;
	{$unsubscribeIcon}
	{$unsubscribe}
	&nbsp;&nbsp;&nbsp;&nbsp;
	</div>
	</p>
</div>*}

{if $lists|count > 0}
<table cellspacing="0" class="pagetable">
	<thead>
		<tr>
			<th>List Name</th>
			<th>List ID</th>
			<th class="pageicon">Total Active Subscribers</th>
		</tr>
	</thead>
<tbody>
{foreach from=$lists item=list}
	<tr class="{$list->rowclass}" onmouseover="this.className='{$list->rowclass}hover';" onmouseout="this.className='{$list->rowclass}';">
		<td>{$list->Name}</td>
		<td>{$list->ListID}</td>
		<td>{$list->stats->TotalActiveSubscribers}</td>
	</tr>
{/foreach}
	</tbody></table>
{/if}