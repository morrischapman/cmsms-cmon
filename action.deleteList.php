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
	
	$this->smarty->assign('delete_list_title', $this->Lang('title_delete_list'));
	
	$this->smarty->assign('form_start', $this->CreateFormStart($id, 'deleteList', $returnid));
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
	
	$cm->debug_level = 1;

	$result = $cm->listDelete($list_id);
	echo '<br><br>';
	
	switch ($result['anyType']['Code'])
	{
	
	case "0":
		$this->smarty->assign('done', "List successfully deleted.");
		break;
		
	case "100":
		$this->smarty->assign('error', "Error: API key is invalid.");
		break;
		
	case "101":
		$this->smarty->assign('error', "Error: List ID is invalid.");
		break;
		
	case "252":
		$this->smarty->assign('error', "Error: This list is currently attached to one or more draft campaigns, so cannot be deleted.");
		break;
		
	default:
		$this->smarty->assign('done', "List successfully deleted.");
		break;				
	}
	
	
	
	
	
	
}	
	echo $this->ProcessTemplate('deleteList.tpl');
?>
