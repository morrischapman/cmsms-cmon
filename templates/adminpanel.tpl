{$tab_headers}

{$start_campaigns_tab}
{$campaigns_tpl}
{$end_tab}

{$start_subscribers_tab}
{$subscribers}
{$end_tab}

{$start_options_tab}

{if isset($form)}
	{$form->getHeaders()}
	{$form->showWidgets('<div class="pageoverflow">
		<p class="pagetext">%LABEL%:</p>
		<p class="pageinput">%INPUT%</p>
	</div>')}
	<p style="text-align: left;">
		{$form->getButtons()}
	</p>
	{$form->getFooters()}
{/if}



{$end_tab}

{$tab_footers}
