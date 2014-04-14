<?php

if (!isset($gCms)) exit;

if (! $this->CheckAccess())
	{
	return $this->DisplayErrorPage($id, $params, $returnid,$this->Lang('accessdenied'));
	}
	
echo CMonBase::getApiKey() .'<br />';
echo CMonBase::getClientId() .'<br />';

//var_dump(CMonBase::getSubscriberLists());

//echo MC_CreateInputSelectList($id, 'list_id', CMonBase::getSubscriberLists(true), array(), 1, '', false);


CMonBase::getCampaigns();
