<?php

if (!isset($gCms)) exit;

if (! $this->CheckAccess("Manage Campaign Monitor"))
	{
	return $this->DisplayErrorPage($id, $params, $returnid,$this->Lang('accessdenied'));
	}
	


/* -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-

   Code for CM "sendCampaign" admin action
   
   -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-*/

if(isset($params['api_key']) && !isset($params['cancelbutton']))
	{
  $this->SetPreference('api_key', $params['api_key']);
	}
	$api_key = $this->GetPreference('api_key');
     	
$this->smarty->assign('form_start', $this->CreateFormStart($id, 'sendCampaign', $returnid));
$this->smarty->assign('form_end',$this->CreateFormEnd());
    $this->smarty->assign('api_key_title',$this->lang('title_api_key'));    
    $this->smarty->assign('api_key',$this->CreateInputText($id, 'api_key', $api_key, 80)); 
    $this->smarty->assign('campaign_id_title',$this->lang('title_campaign_id'));    
    $this->smarty->assign('campaign_id',$this->CreateInputText($id, 'campaign_id', $campaign_id, 80));
    $this->smarty->assign('confirm_email_title', $this->lang('title_confirm_email'));
    $this->smarty->assign('confirm_email', $this->CreateInputText($id, 'confirm_email', $confirm_email, 80));
    $this->smarty->assign('send_date_title', $this->lang('title_send_date'));
    $this->smarty->assign('send_date', $this->CreateInputText($id, 'send_date', $send_date, 80));   
$this->smarty->assign('submit', $this->CreateInputSubmit($id, 'submitbutton', $this->Lang('submit'))); 
$this->smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancelbutton', $this->Lang('cancel')));

$this->smarty->assign('goBack',$this->CreateLink($id, 'defaultadmin', '', $this->Lang('admin_title'),array()));    
$this->smarty->assign('addBackIcon',$this->CreateLink($id, 'defaultadmin', '', $gCms->variables['admintheme']->DisplayImage('icons/system/back.gif', $this->Lang('admin_title'),'', '','systemicon'), array())); 

$this->smarty->assign('send_campaign_title', $this->lang('title_send_campaign'));

echo $this->ProcessTemplate('sendCampaign.tpl');

if (isset($params['submitbutton']))
{
	echo 'button is set';
	
	$errors = array();
		
	if (isset($params['api_key']))
	{
	$this->SetPreference('api_key', $params['api_key']);
  $api_key = $this->GetPreference('api_key');
  }
  elseif (empty($params['api_key']))
  {
  $errors[] = 'No API key entered.';
  }
  
  if (isset($params['campaign_id']))
  {
  $this->SetPreference('campaign_id', $params['campaign_id']);
  $campaign_id = $this->GetPreference('campaign_id');
  }
  elseif (empty($params['api_key']))
  {
  $errors[] = 'No Campaign ID entered.';
  }
  
  if (isset($params['confirm_email']))
  {
  $this->SetPreference('confirm_email', $params['confirm_email']);
  $confirm_email = $this->GetPreference('confirm_email');
  }
  elseif (empty($params['confirm_email']))
  {
  $errors[] = 'No Confirmation Email entered.';
  }
  
  if (isset($params['send_date']))
  {
  $this->SetPreference('send_date', $params['send_date']);
  $send_date = $this->GetPreference('send_date');
  }
  elseif (empty($params['send_date']))
  {
  $errors[] = 'No Send Date entered.';
  }
  
  $cm = new CampaignMonitor( $api_key );
	
	$cm->debug_level = 1;
	
	$result = $cm->campaignSend( $campaign_id, $confirm_email, $send_date);
	
	echo '<br><br>';
	print_r($result);
	
	print_r($cm);
}

?>