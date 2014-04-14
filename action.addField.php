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
	
	$this->smarty->assign('add_field_title', $this->Lang('title_add_field'));
	
  $chooseOpt = array('Yes' => 'true', 'No'=> 'false');
	
	$this->smarty->assign('form_start', $this->CreateFormStart($id, 'addField', $returnid));
	$this->smarty->assign('form_end',$this->CreateFormEnd());
	$this->smarty->assign('api_key_title', $this->Lang('title_api_key'));
	$this->smarty->assign('api_key', $this->CreateInputText($id, 'api_key', $api_key, 80));
	$this->smarty->assign('list_id_title', $this->Lang('title_list_id'));
	$this->smarty->assign('list_id', $this->CreateInputText($id, 'list_id', $list_id, 80));
	$this->smarty->assign('field_name_title', $this->Lang('title_field_name'));
	$this->smarty->assign('field_name', $this->CreateInputText($id, 'field_name', $field_name, 80));
	$this->smarty->assign('data_type_title', $this->Lang('title_data_type'));
	$this->smarty->assign('data_type', $this->CreateInputText($id, 'data_type', $data_type, 80));
	$this->smarty->assign('options_title', $this->Lang('title_options'));
	$this->smarty->assign('options', $this->CreateInputText($id, 'options', $options, 80));
	
  $this->smarty->assign('submit', $this->CreateInputSubmit($id, 'submitbutton', $this->Lang('submit'))); 
  $this->smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancelbutton', $this->Lang('cancel')));
  
  $this->smarty->assign('field_name_help', $this->Lang('field_name_help'));
  $this->smarty->assign('data_type_help', $this->Lang('data_type_help'));
  $this->smarty->assign('options_help', $this->Lang('options_help'));
  
  $this->smarty->assign('goBack',$this->CreateLink($id, 'editList', '', $this->Lang('title_edit_list'),array()));    
  $this->smarty->assign('addBackIcon',$this->CreateLink($id, 'editList', '', $gCms->variables['admintheme']->DisplayImage('icons/system/back.gif', $this->Lang('title_edit_list'),'', '','systemicon'), array()));
   
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
  	
  	if (isset($params['field_name']))
  	{
  	$this->SetPreference('field_name', $params['field_name']);
  	$field_name = $this->GetPreference('field_name');
  	}
  	
  	if (isset($params['data_type']))
  	{
  	$this->SetPreference('data_type', $params['data_type']);
  	$data_type = $this->GetPreference('data_type');
  	}
		
		if (isset($params['options']))
  	{
  	$this->SetPreference('options', $params['options']);
  	$options = $this->GetPreference('options');
  	}
  	else
  	{
  	$this->SetPreference('options', '');
  	}
	
	
		$cm = new CampaignMonitor($api_key);
	
    $result = $cm->listCreateCustomField($list_id, $field_name, $data_type, $options);
    
    print_r($result);
	
		switch ($result['Result']['Code'])
		{
			  case "100";
			  $this->smarty->assign('error' , 'Error: Invalid API key entered.');
			  break;
			  
			  case "101";
			  $this->smarty->assign('error' , 'Error: Invalid List ID entered.');
			  break;
			  
			  case "254";
			  $this->smarty->assign('error' , 'Error: Invalid Field Name entered.');
			  break;
			  
			  case "255";
			  $this->smarty->assign('error' , 'Error: The Field key already exists.');
			  break;
			  
			  case "256";
			  $this->smarty->assign('error' , 'Error: Options defined for Text or Number field.');
			  break;
			  
			  case "257";
			  $this->smarty->assign('error' , 'Error: No Options defined for Multi-Valued field.');
			  break;
			  
			  case "259";
			  $this->smarty->assign('error' , 'Error: Invalid type entered for Data Type.');
			  break;
			  
			  case "0";
			  $this->smarty->assign('done' , 'Field added successfully.');
			  break;
			  
			
		}
		
	
	
	
	

	
}	
	
	echo $this->ProcessTemplate('addField.tpl');

?>
