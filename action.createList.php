<?php

if (!isset($gCms)) exit;

if (! $this->CheckAccess())
	{
	return $this->DisplayErrorPage($id, $params, $returnid,$this->Lang('accessdenied'));
	}
	
	$this->smarty->assign('create_list_title', $this->Lang('title_create_list'));
	
	if(isset($params['api_key']) && !isset($params['cancelbutton']))
	{
  $this->SetPreference('api_key', $params['api_key']);
	}
	$api_key = $this->GetPreference('api_key');
	
	if(isset($params['client_id']) && !isset($params['cancelbutton']))
	{
  $this->SetPreference('client_id', $params['client_id']);
	}
	$client_id = $this->GetPreference('client_id');
	
	//array to hold the radio buttons, for confirm opt in.
	$chooseOpt = array('Yes' => 'true', 'No'=> 'false');
	
	$this->smarty->assign('form_start', $this->CreateFormStart($id, 'createList', $returnid));
	$this->smarty->assign('form_end',$this->CreateFormEnd());
	    $this->smarty->assign('api_key_title', $this->Lang('title_api_key'));
    	$this->smarty->assign('api_key', $this->CreateInputText($id, 'api_key', $api_key, 80));
    	$this->smarty->assign('client_id_title', $this->Lang('title_client_id'));
    	$this->smarty->assign('client_id', $this->CreateInputText($id, 'client_id', $client_id, 80));
    	$this->smarty->assign('list_name_title', $this->Lang('title_list_name'));
    	$this->smarty->assign('list_name', $this->CreateInputText($id, 'list_name', $list_name, 80));
    	$this->smarty->assign('unsubscribe_page_title', $this->Lang('title_unsubscribe_page'));
    	$this->smarty->assign('unsubscribe_page', $this->CreateInputText($id, 'unsubscribe_page', $unsubscribe_page, 80));
    	$this->smarty->assign('confirm_optin_title', $this->Lang('title_confirm_optin'));
    	$this->smarty->assign('confirm_optin', $this->CreateInputRadioGroup($id, 'confirm_optin', $chooseOpt, $selectedvalue = 'true', '','',''));
    	$this->smarty->assign('confirm_success_page_title', $this->Lang('title_confirm_success_page'));
    	$this->smarty->assign('confirm_success_page', $this->CreateInputText($id, 'confirm_success_page', $confirm_success_page, 80)); 
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
  	
  if (isset($params['client_id']))
	  {
    $client_id = $this->GetPreference('client_id');
  	}
  	
  if (isset($params['list_name']))
	  {
  	$this->SetPreference('list_name', $params['list_name']);
    $list_name = $this->GetPreference('list_name');
  	}		
  	
  if (isset($params['unsubscribe_page']))
	  {
  	$this->SetPreference('unsubscribe_page', $params['unsubscribe_page']);
    $unsubscribe_page = $this->GetPreference('unsubscribe_page');
  	}
  	else
  	  {
    	$this->SetPreference('unsubscribe_page', '');
    	$confirm_success_page = $this->GetPreference('unsubscribe_page');
    	} 	
  	
  if (isset($params['confirm_optin']))
	  {
  	$this->SetPreference('confirm_optin', $params['confirm_optin']);
    $confirm_optin = $this->GetPreference('confirm_optin');
  	}
  	
 if (isset($params['confirm_success_page']))
	  {
  	$this->SetPreference('confirm_success_page', $params['confirm_success_page']);
    $confirm_success_page = $this->GetPreference('confirm_success_page');
  	}
  	else
  	  {
    	$this->SetPreference('confirm_success_page', '');
    	$confirm_success_page = $this->GetPreference('confirm_success_page');
    	} 			

	$cm = new CampaignMonitor($api_key);
	
	$cm->debug_level = 1;
	
	//This is the actual call to the method
	$result = $cm->listCreate($client_id, $list_name, $unsubscribe_page, $confirm_optin, $confirm_success_page );
	
	echo '<br><br>';
	//print_r($result);

	switch ($result['anyType']['Code'])
	{
	
	case "100":
		$this->smarty->assign('error', "Error: Invalid API key entered.");
		break;
		
	case "102":
		$this->smarty->assign('error', "Error: Invalid Client ID entered.");
		break;
		
	case "205":
		$this->smarty->assign('error', "Error: List name already exists.");
		break;
		
	case "251":
		$this->smarty->assign('error', "Error: List name cannot be empty.");
		break;
		
	default:
		$this->smarty->assign('done', "List successfully created.");
		break;				
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
}	
	echo $this->ProcessTemplate('createList.tpl');
?>
