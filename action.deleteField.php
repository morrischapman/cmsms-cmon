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
	
	$this->smarty->assign('delete_field_title', $this->Lang('title_delete_field'));

	$this->smarty->assign('form_start', $this->CreateFormStart($id, 'deleteField', $returnid));
	$this->smarty->assign('form_end',$this->CreateFormEnd());
	$this->smarty->assign('api_key_title', $this->Lang('title_api_key'));
	$this->smarty->assign('api_key', $this->CreateInputText($id, 'api_key', $api_key, 80));
	$this->smarty->assign('list_id_title', $this->Lang('title_list_id'));
	$this->smarty->assign('list_id', $this->CreateInputText($id, 'list_id', $list_id, 80));
  $this->smarty->assign('field_key_title', $this->Lang('title_field_key'));
  $this->smarty->assign('field_key', $this->CreateInputText($id, 'field_key', $field_key, 80));
  $this->smarty->assign('submit', $this->CreateInputSubmit($id, 'submitbutton', $this->Lang('submit'))); 
  $this->smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancelbutton', $this->Lang('cancel')));

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
  
  if (isset($params['field_key']))
    {
    $this->SetPreference('field_key', $params['field_key']);
    $field_key = $this->GetPreference('field_key');
    }	
    
    $cm = new CampaignMonitor($api_key);
    $result = $cm->listDeleteCustomField($list_id, $field_key);
    

   
    
		switch ($result['Result']['Code'])
		{
			  case "100";
			  $this->smarty->assign('error' , 'Error: Invalid API key entered.');
			  break;
			  
			  case "101";
			  $this->smarty->assign('error' , 'Error: Invalid List ID entered.');
			  break;
			  
			  case "253";
			  $this->smarty->assign('error' , 'Error: Invalid Field Key entered.');
			  break;
			  
			  case "0";
			  $this->smarty->assign('done' , 'List update successfully.');
			  break;
			  
			
		}










}
	
	
	echo $this->ProcessTemplate('deleteField.tpl');
?>
