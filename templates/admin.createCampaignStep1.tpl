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