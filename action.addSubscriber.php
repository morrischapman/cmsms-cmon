<?php

if (!isset($gCms)) exit;

if (! $this->CheckAccess())
	{
	return $this->DisplayErrorPage($id, $params, $returnid,$this->Lang('accessdenied'));
	}
	
 if(isset($params['api_key']) && !isset($params['cancelbutton']))
	{
  $this->SetPreference('api_key', $params['api_key']);
	}
	$api_key = $this->GetPreference('api_key');
	
	$this->smarty->assign('add_subscriber_title', $this->Lang('title_add_subscriber'));
	
	$this->smarty->assign('form_start', $this->CreateFormStart($id, 'addSubscriber', $returnid));
	$this->smarty->assign('form_end',$this->CreateFormEnd());
	$this->smarty->assign('api_key_title', $this->Lang('title_api_key'));
	$this->smarty->assign('api_key', $this->CreateInputText($id, 'api_key', $api_key, 80));
	$this->smarty->assign('list_id_title', $this->Lang('title_list_id'));
	$this->smarty->assign('list_id', $this->CreateInputText($id, 'list_id', $list_id, 80));
	$this->smarty->assign('email_address_title', $this->Lang('title_email_address'));
	$this->smarty->assign('email_address', $this->CreateInputText($id, 'email_address', $email_address, 80));
	$this->smarty->assign('subscriber_name_title', $this->Lang('title_subscriber_name'));
	$this->smarty->assign('subscriber_name', $this->CreateInputText($id, 'subscriber_name', $subscriber_name, 80));
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
    
  if (isset($params['subscriber_name']))
    {
      $this->SetPreference('subscriber_name', $params['subscriber_name']);
      $subscriber_name = $this->GetPreference('subscriber_name');
    }
  	
  	/*debugging
  	echo 'api key is ' . $api_key . '<br /><br />';
  	echo 'list_id is ' . $list_id . '<br /><br />';
  	echo 'email_address is ' . $email_address . '<br /><br />';
  	echo 'subscriber name is ' . $subscriber_name . '<br /><br />';*/
  	
  	$cm = new CampaignMonitor($api_key, $client_id, $campaign_id, $list_id);	
		$cm->debug_level = 1;
	
	//This is the actual call to the method, passing email address, name.
	$result = $cm->subscriberAdd($email_address, $subscriber_name);

	
	if($result['Result']['Code'] == 0)
	{
		$this->smarty->assign('done', 'Subscriber added.');
	}	
	else
	{
		//echo 'Error : ' . $result['Result']['Message'];
		$error = 'Error: ' . $result['Result']['Message'];
		$this->smarty->assign('error', $error);
	}
	//Print out the debugging info
	//print_r($cm);
  			
}    
    
	
	
	
	
	
	
	
	
	
	
	
	
	
	echo $this->ProcessTemplate('addSubscriber.tpl');
?>
