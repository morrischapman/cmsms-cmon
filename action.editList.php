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
	
	
	
	
	$this->smarty->assign('edit_list_title', $this->Lang('title_edit_list'));
	
	//array to hold the radio buttons, for confirm opt in.
	$chooseOpt = array('Yes' => 'true', 'No'=> 'false');
	


	$this->smarty->assign('form_start', $this->CreateFormStart($id, 'editList', $returnid));
	$this->smarty->assign('form_end',$this->CreateFormEnd());
	$this->smarty->assign('api_key_title', $this->Lang('title_api_key'));
	$this->smarty->assign('api_key', $this->CreateInputText($id, 'api_key', $api_key, 80));
	$this->smarty->assign('list_id_title', $this->Lang('title_list_id'));
	$this->smarty->assign('list_id', $this->CreateInputText($id, 'list_id', $list_id, 80));
  $this->smarty->assign('list_name_title', $this->Lang('title_list_name'));
  $this->smarty->assign('list_name', $this->CreateInputText($id, 'list_name', $list_name, 80));
  $this->smarty->assign('unsubscribe_page_title', $this->Lang('title_unsubscribe_page'));
  $this->smarty->assign('unsubscribe_page', $this->CreateInputText($id, 'unsubscribe_page', $unsubscribe_page, 80));
  $this->smarty->assign('confirm_optin_title', $this->Lang('title_confirm_optin'));
  $this->smarty->assign('confirm_optin', $this->CreateInputRadioGroup($id, 'confirm_optin', $chooseOpt, $selectedvalue = $confirm_optin, '','',''));
  $this->smarty->assign('confirm_success_page_title', $this->Lang('title_confirm_success_page'));
  $this->smarty->assign('confirm_success_page', $this->CreateInputText($id, 'confirm_success_page', $confirm_success_page, 80));
  $this->smarty->assign('submit', $this->CreateInputSubmit($id, 'submitbutton', $this->Lang('submit'))); 
  $this->smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancelbutton', $this->Lang('cancel')));
	
	$this->smarty->assign('addField', $this->CreateLink($id, 'addField', '', $this->Lang('title_add_field'), array()));
	$this->smarty->assign('addFieldIcon', $this->CreateLink($id, 'addField', '', $gCms->variables['admintheme']->DisplayImage('icons/topfiles/layout.gif', $this->Lang('title_add_field'), '25', '25','systemicon'), array()));
	
	$this->smarty->assign('deleteField', $this->CreateLink($id, 'deleteField', '', $this->Lang('title_delete_field'), array()));
	$this->smarty->assign('deleteFieldIcon', $this->CreateLink($id, 'deleteField', '', $gCms->variables['admintheme']->DisplayImage('icons/system/delete.gif', $this->Lang('title_delete_field'), '25', '25','systemicon'), array()));
	
	
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
  	
  $cm = new CampaignMonitor($api_key);
  $result = $cm->listUpdate($list_id, $list_name, $unsubscribe_page, $confirm_optin, $confirm_success_page);
  				

  				
	switch ($result['Result']['Code'])
		{
			  case "100";
			  $this->smarty->assign('error' , 'Error: Invalid API key entered.');
			  break;
			  
			  case "101";
			  $this->smarty->assign('error' , 'Error: Invalid List ID entered.');
			  break;
			  
			  case "251";
			  $this->smarty->assign('error' , 'Error: List Name cannot be empty.');
			  break;
			  
			  case "0";
			  $this->smarty->assign('done' , 'List update successfully.');
			  break;
			  
			
		}
		
		
}
   



echo $this->ProcessTemplate('editList.tpl');
?>
