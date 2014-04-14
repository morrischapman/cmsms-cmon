<?php

if (!isset($gCms)) exit;

if (! $this->CheckAccess())
	{
	return $this->DisplayErrorPage($id, $params, $returnid,$this->Lang('accessdenied'));
	}

$db =& $this->GetDb();
   
$this->smarty->assign('delete_campaign_title', $this->Lang('title_delete_campaign'));

if(isset($params['api_key']) && !isset($params['cancelbutton']))
{
  $this->SetPreference('api_key', $params['api_key']);
}
$api_key = $this->GetPreference('api_key');

$this->smarty->assign('form_start', $this->CreateFormStart($id, 'deleteCampaign', $returnid));
$this->smarty->assign('form_end',$this->CreateFormEnd());
$this->smarty->assign('api_key_title',$this->lang('title_api_key'));    
$this->smarty->assign('api_key',$this->CreateInputText($id, 'api_key', $api_key, 80));
$this->smarty->assign('campaign_id_title', $this->lang('title_campaign_id'));
$this->smarty->assign('campaign_id', $this->CreateInputText($id, 'campaign_id', $campaign_id, 80));
$this->smarty->assign('submit', $this->CreateInputSubmit($id, 'submitbutton', $this->Lang('submit'))); 
$this->smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancelbutton', $this->Lang('cancel'))); 

$this->smarty->assign('goBack',$this->CreateLink($id, 'defaultadmin', '', $this->Lang('admin_title'),array()));    
$this->smarty->assign('addBackIcon',$this->CreateLink($id, 'defaultadmin', '', $gCms->variables['admintheme']->DisplayImage('icons/system/back.gif', $this->Lang('admin_title'),'', '','systemicon'), array())); 


if (isset($params['submitbutton']))
{
  if (isset($params['api_key']))
  {
    $this->smarty->assign('api_key', $api_key);
    $api_key = $this->GetPreference('api_key');
  }
  
  if (isset($params['campaign_id']))
    {
    $this->SetPreference('campaign_id', $params['campaign_id']);
    $campaign_id = $this->GetPreference('campaign_id');
    }
  
 
  $cm = new CampaignMonitor($api_key);
  
  
  $cm->debug_level = 1;
  
  
  $result = $cm->campaignDelete($campaign_id);
  
  if ($result[Result][Code]== 0)
  {	
  $q = "DELETE FROM ".cms_db_prefix()."module_cmon_draft_mail WHERE campaign_id = '$campaign_id'";
  $r = $db->Execute($q);
  if (!$r)
  	{	
  	$this->smarty->assign('error','Error: ' .  mysql_error());
  	}
  	else
  	{
  	$this->smarty->assign('success', 'Successfully deleted.');
  	}
  
  echo '<br><br>';
  
  }
  elseif ($result[Result][Code]== 301)
  {
  $this->smarty->assign('error', 'Invalid Campaign ID entered.');
  }
  elseif ($result[Result][Code]== 100)
  {
  $this->smarty->assign('error', 'Invalid API key entered.');
  }
  
}

echo $this->ProcessTemplate('deleteCampaign.tpl');

?>
