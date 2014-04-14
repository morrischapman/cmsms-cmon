<?php


if (!isset($gCms)) exit;

if (! $this->CheckAccess())
	{
	return $this->DisplayErrorPage($id, $params, $returnid,$this->Lang('accessdenied'));
	}
	
	$this->smarty->assign('unsubscribe_title', $this->Lang('title_unsubscribe'));
	
	if(isset($params['api_key']) && !isset($params['cancelbutton']))
	{
  $this->SetPreference('api_key', $params['api_key']);
	}
	$api_key = $this->GetPreference('api_key');

	$this->smarty->assign('form_start', $this->CreateFormStart($id, 'unsubscribe', $returnid));
	$this->smarty->assign('form_end',$this->CreateFormEnd());
	$this->smarty->assign('api_key_title', $this->Lang('title_api_key'));
	$this->smarty->assign('api_key', $this->CreateInputText($id, 'api_key', $api_key, 80));
	$this->smarty->assign('list_id_title', $this->Lang('title_list_id'));
	$this->smarty->assign('list_id', $this->CreateInputText($id, 'list_id', $list_id, 80));
	$this->smarty->assign('email_address_title', $this->Lang('title_email_address'));
	$this->smarty->assign('email_address', $this->CreateInputText($id, 'email_address', $email_address, 80));
	$this->smarty->assign('submit', $this->CreateInputSubmit($id, 'submitbutton', $this->Lang('submit'))); 
	$this->smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancelbutton', $this->Lang('cancel')));
	
	
	
	$this->smarty->assign('goBack',$this->CreateLink($id, 'defaultadmin', '', $this->Lang('admin_title'),array()));    
  $this->smarty->assign('addBackIcon',$this->CreateLink($id, 'defaultadmin', '', $gCms->variables['admintheme']->DisplayImage('icons/system/back.gif', $this->Lang('admin_title'),'', '','systemicon'), array())); 
	
if (isset($params['submitbutton']))
{

	if (isset($params['api_key']))
	  {
  	$this->SetPreference('api_key', $params['api_key']);
    $api_key = $this->GetPreference('api_key');
  	}
  	
  if (isset($params['list_id']))
  {
  $this->SetPreference('list_id', $params['list_id']);
  $list_id = $this->GetPreference('list_id');
  }		
	
	if (isset($params['email_address']))
	{
	$this->SetPreference('email_address', $params['email_address']);
	$email_address = $this->GetPreference('email_address');
	}
	
  $cm = new CampaignMonitor($api_key, $client_id, $campaign_id, $list_id);
  	
  $result = $cm->subscriberUnsubscribe($email_address);

  if ($result['Result']['Code'] == 0)
  {
  	$this->smarty->assign('done', 'Successfully Unsubscribed');
  }
  else
  {
  	echo 'Error: ' . $result['Result']['Message'];
  	$this->smarty->assign('error', 'Error: ' . $result['Result']['Message']);
  }		
			
	
}	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	echo $this->ProcessTemplate('unsubscribe.tpl');
?>
