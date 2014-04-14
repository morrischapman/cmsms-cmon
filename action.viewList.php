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
	
	if(isset($params['list_id']) && !isset($params['cancelbutton']))
	{
  $this->SetPreference('list_id', $params['list_id']);
	}
	$list_id = $this->GetPreference('list_id');
	
	$this->smarty->assign('view_list_title', $this->Lang('title_view_list'));
	
	$chooseOpt = array('Yes' => 'true', 'No'=> 'false');
	
	$this->smarty->assign('form_start', $this->CreateFormStart($id, 'viewList', $returnid));
	$this->smarty->assign('form_end',$this->CreateFormEnd());
	$this->smarty->assign('api_key_title', $this->Lang('title_api_key'));
	$this->smarty->assign('api_key', $this->CreateInputText($id, 'api_key', $api_key, 80));
	$this->smarty->assign('list_id_title', $this->Lang('title_list_id'));
	$this->smarty->assign('list_id', $this->CreateInputText($id, 'list_id', $list_id, 80));
	
	
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
  	
  	$cm = new CampaignMonitor($api_key);
  	$result = $cm->listGetDetail($list_id);

		
		$list_name = $result['anyType']['Title'];
		$unsubscribe_page = $result['anyType']['UnsubscribePage'];
		$confirm_optin = $result['anyType']['ConfirmOptIn'];
		
		if (isset($result['anyType']['ConfirmationSuccessPage']))
		{
		$confirm_success_page = $result['anyType']['ConfirmationSuccessPage'];
		}
		else
		{
		$confirm_success_page = 'Not set';
		}
		
		if ((!$result['anyType']['Code'] == "100") && (!$result['anyType']['Code']== "101"))
		{
	
	    $this->smarty->assign('list_details', $this->Lang('title_list_details'));
    	$this->smarty->assign('list_id_title2', $this->Lang('title_list_id'));
    	$this->smarty->assign('list_id2', $this->CreateInputText($id, 'list_id2', $list_id, 80));
      $this->smarty->assign('list_name_title', $this->Lang('title_list_name'));
      $this->smarty->assign('list_name', $this->CreateInputText($id, 'list_name', $list_name, 80));
      $this->smarty->assign('unsubscribe_page_title', $this->Lang('title_unsubscribe_page'));
      $this->smarty->assign('unsubscribe_page', $this->CreateInputText($id, 'unsubscribe_page', $unsubscribe_page, 80));
      $this->smarty->assign('confirm_optin_title', $this->Lang('title_confirm_optin'));
      $this->smarty->assign('confirm_optin', $this->CreateInputRadioGroup($id, 'confirm_optin', $chooseOpt, $selectedvalue = $confirm_optin, '','',''));
      $this->smarty->assign('confirm_success_page_title', $this->Lang('title_confirm_success_page'));
      $this->smarty->assign('confirm_success_page', $this->CreateInputText($id, 'confirm_success_page', $confirm_success_page, 80));
    }	
	
	
	switch ($result['anyType']['Code'])
		{
			  case "100";
			  $this->smarty->assign('error' , 'Error: Invalid API key entered.');
			  break;
			  
			  case "101";
			  $this->smarty->assign('error' , 'Error: Invalid List ID entered.');
			  break;
	
			  default;
			  $this->smarty->assign('done' , 'List retrieved successfully.');
			  break;
	
		}
	
	
	
	
	
	
	
	
	
	
	
	
	
}	
echo $this->ProcessTemplate('viewList.tpl');	
	
?>
