<p>{$campaign_ready}</p>

<div class="pageoverflow">
	<p class="pagetext">{$campaign_name_title}:</p>
	<p class="pageinput">{$campaign_name}</p>
</div>

<div class="pageoverflow">
	<p class="pagetext">{$subject_title}:</p>
	<p class="pageinput">{$subject}</p>
</div>

<div class="pageoverflow">
	<p class="pagetext">{$subscriber_list_title}:</p>
	<p class="pageinput">{$subscriber_list}</p>
</div>

<div class="pageoverflow">
	<p class="pagetext"></p>
	<p class="pageinput">{$preview_html}</p>
</div>

<div class="pageoverflow">
	<p class="pagetext"></p>
	<p class="pageinput">{$preview_plain}</p>
</div>

{if isset($preview_from)}
<div class="pageoverflow">
	<p class="pagetext"></p>
	<p class="pageinput">{$preview_from}</p>
</div>
{/if}

{if isset($preview_from_email)}
<div class="pageoverflow">
	<p class="pagetext"></p>
	<p class="pageinput">{$preview_from_email}</p>
</div>
{/if}


<div class="pageoverflow">
	<p class="pagetext"></p>
	<p class="pageinput">{$schedule}</p>
</div>


{if isset($form)}
	{$form->getHeaders()}
	{$form->showWidgets('<div class="pageoverflow">
		<p class="pagetext">%LABEL%:</p>
		<p class="pageinput">%INPUT%</p>
	</div>')}
	<p style="text-align: right;">
		{$form->getButtons()}
	</p>
	{$form->getFooters()}
{/if}