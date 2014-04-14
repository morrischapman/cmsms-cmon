<?php
if (!isset($gCms)) exit;

if (! $this->CheckAccess())
	{
	return $this->DisplayErrorPage($id, $params, $returnid,$this->Lang('accessdenied'));
	}

/* -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-

   Code for CM "defaultadmin" admin action
   
   -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
   
   Typically, this will display something from a template
   or do some other task.
   
*/
$tab = '';
if (isset($params['tab'])) $tab = $params['tab'];


$this->smarty->assign('tab_headers',$this->StartTabHeaders().
	$this->SetTabHeader('campaigns',$this->Lang('title_campaigns')).
	$this->SetTabHeader('subscribers',$this->Lang('title_subscribers')).
	$this->SetTabHeader('options',$this->Lang('title_options'),($tab == 'options')?true:false).
	$this->EndTabHeaders().$this->StartTabContent());
$this->smarty->assign('end_tab',$this->EndTab());
$this->smarty->assign('tab_footers',$this->EndTabContent());
$this->smarty->assign('start_campaigns_tab',$this->StartTab('campaigns'));
$this->smarty->assign('start_subscribers_tab',$this->StartTab('subscribers'));
$this->smarty->assign('start_options_tab',$this->StartTab('options'));

// PREFERENCES

if(isset($params['cancel']))
{
	return 	$this->Redirect($id, 'defaultadmin', $returnid, array('tab' => 'options')); exit;
}

$form = new CMSForm('CMon', $id, 'defaultadmin', $returnid);
$form->setLabel('submit', $this->lang('save'));
$form->setWidget('tab','hidden',array('value' => 'options'));
$form->setWidget('api_key','text', array('preference' => 'api_key'));
$form->setWidget('client_id','text', array('preference' => 'client_id'));
$form->setWidget('campaign_name','text', array('preference' => 'campaign_name'));
$form->setWidget('subject','text', array('preference' => 'subject'));
$form->setWidget('from_name','text', array('preference' => 'from_name'));
$form->setWidget('from_email','text', array('preference' => 'from_email'));
$form->setWidget('reply_email','text', array('preference' => 'reply_email'));
$form->setWidget('confirm_email','text', array('preference' => 'confirm_email'));
$form->setWidget('subscribers_list','select', array('preference' => 'subscribers_list', 'values' => CMonBase::getSubscriberLists(true)));
$form->setWidget('send_immediately', 'checkbox', array('preference' => 'send_immediately'));
$form->setWidget('default_time', 'time', array('preference' => 'default_time'));

if($form->isSent())
{
    $form->process();
}

$this->smarty->assign('form', $form);




$api_key = $this->GetPreference('api_key');
$client_id = $this->GetPreference('client_id');

// Campaigns

$this->smarty->assign('sent_campaigns_title', $this->Lang('title_sent_campaigns'));

if (!empty($api_key) && !empty($client_id))
{
	$this->init();
	if (!empty($this->cm))
	{
		$result = $this->cm->clientGetCampaigns( $client_id );
		$campaigns = array();
		$rowclass = 'row1';
		
		if (isset($result['anyType']))
		{
			foreach($result['anyType']['Campaign'] as $campaign)
			{
				$onerow = new StdClass();
				$onerow->name = $campaign['Name'];
				$onerow->subject = $campaign['Subject'];
				$onerow->date = $campaign['SentDate'];
				$onerow->campaign_id = $campaign['CampaignID'];
				$onerow->total_recipients = $campaign['TotalRecipients'];
				$onerow->manage = $this->createLink($id, 'viewCampaign', $returnid, '', array('CampaignID' => $campaign['CampaignID']), false, true);
				//$onerow->manageIcon = $this->CreateLink($id, 'viewCampaign', $returnid, $gCms->variables['admintheme']->DisplayImage('icons/system/edit.gif', $this->Lang('manage_campaign'),'','','systemicon'), array('CampaignID' => $campaign['CampaignID']));
				$onerow->rowclass = $rowclass;
				($rowclass=="row1"?$rowclass="row2":$rowclass="row1");
				$campaigns[] = $onerow;
	
				/*?><pre><?php
				//var_dump($campaign);
				?></pre><?php*/
			}
		}
		
		$this->smarty->assign('campaign_title', $this->lang('campaign'));
		$this->smarty->assign('campaign_id_title', $this->lang('title_campaign_id'));
		$this->smarty->assign('sent', $this->lang('sent'));
		$this->smarty->assign('total_recipients_title', $this->lang('title_total_recipients'));
		$this->smarty->assign('campaigns', $campaigns);
			
			/*?><pre><?php
			var_dump($result);
			?></pre><?php*/
			
		
	}

	 // $this->smarty->assign('sendCampaign', $this->CreateLink($id, 'sendCampaign', '', $this->Lang('title_send_campaign'), array()));
	 // $this->smarty->assign('sendCampaignIcon', $this->CreateLink($id, 'sendCampaign', '', $gCms->variables['admintheme']->DisplayImage('icons/system/contractall.gif', $this->Lang('title_send_campaign'), '', '', 'systemicon'), array()));
	 // 
	 // $this->smarty->assign('viewDrafts', $this->CreateLink($id, 'viewDrafts', '', $this->Lang('title_view_drafts'), array()));
	 // $this->smarty->assign('viewDraftsIcon', $this->CreateLink($id, 'viewDrafts', '', $gCms->variables['admintheme']->DisplayImage('icons/system/newfolder.gif', $this->Lang('title_view_drafts'), '', '', 'systemicon'), array()));
	 // 
	 // $this->smarty->assign('deleteCampaign', $this->CreateLink($id, 'deleteCampaign', '', $this->lang('title_delete_campaign'), array()));
	 // $this->smarty->assign('deleteCampaignIcon', $this->CreateLink($id, 'deleteCampaign', '', $gCms->variables['admintheme']->DisplayImage('icons/system/false.gif', $this->Lang('title_delete_campaign'), '', 30, 'systemicon'), array())); 
	 
	 $this->smarty->assign('campaigns_tpl', $this->ProcessTemplate('campaigns.tpl'));
}
else
{
	$this->smarty->assign('campaigns_tpl', $this->lang('api_client_notset'));
}

// Subscribers
if (!empty($api_key) && !empty($client_id))
{
	$this->init();
	if (!empty($this->cm))
	{
		$all_lists = $this->cm->clientGetLists($client_id);
		$lists = array();
		$rowclass = 'row1';
		
			if (isset($all_lists['anyType']['List']['ListID']))
			{
				$fulllist = array($all_lists['anyType']['List']);
			}
			else
			{
				$fulllist = $all_lists['anyType']['List'];
			}

				foreach ($fulllist as $list)
				{
			//	var_dump($list);
				$onerow = new stdClass();
				$onerow->title = $list['Name'];
				$onerow->id = $list['ListID'];
				$onerow->rowclass = $rowclass;
				($rowclass=="row1"?$rowclass="row2":$rowclass="row1");
				$stats = $this->cm->listGetStats($list['ListID']);
				$onerow->stats = $stats['anyType'];
				$onerow->total_subscribers = $stats['anyType']['TotalActiveSubscribers'];
				$lists[] = $onerow;
			}
		
	//menu inside the subscribers tab
		// $this->smarty->assign('addSubscriber',$this->CreateLink($id, 'addSubscriber', '', $this->Lang('title_add_subscriber'),array()));    
		//     $this->smarty->assign('addSubscriberIcon',$this->CreateLink($id, 'addSubscriber', '', $gCms->variables['admintheme']->DisplayImage('icons/system/groupassign.gif', $this->Lang('title_add_subscriber'), '', 30,'systemicon'), array()));
		// 	$this->smarty->assign('createList',$this->CreateLink($id, 'createList', '', $this->Lang('title_create_list'),array()));    
		//     $this->smarty->assign('createListIcon',$this->CreateLink($id, 'createList', '', $gCms->variables['admintheme']->DisplayImage('icons/system/bookmark.gif', $this->Lang('title_create_list'),'', 30,'systemicon'), array()));
		// 	$this->smarty->assign('deleteList',$this->CreateLink($id, 'deleteList', '', $this->Lang('title_delete_list'),array()));    
		//     $this->smarty->assign('deleteListIcon',$this->CreateLink($id, 'deleteList', '', $gCms->variables['admintheme']->DisplayImage('icons/system/delete.gif', $this->Lang('title_delete_list'),'', 30,'systemicon'), array()));
		// 	$this->smarty->assign('unsubscribe', $this->CreateLink($id, 'unsubscribe', '', $this->Lang('title_unsubscribe'), array()));
		// 	$this->smarty->assign('unsubscribeIcon', $this->CreateLink($id, 'unsubscribe', '', $gCms->variables['admintheme']->DisplayImage('icons/topfiles/template.gif', $this->Lang('title_unsubscriber'), '', 35, 'systemicon'), array()));
		// 	$this->smarty->assign('editList', $this->CreateLink($id, 'editList', '', $this->Lang('title_edit_list'), array()));
		// 	$this->smarty->assign('editListIcon', $this->CreateLink($id, 'editList', '', $gCms->variables['admintheme']->DisplayImage('icons/system/edit.gif', $this->Lang('title_edit_list'), '', 30,'systemicon'), array()));
		// 	$this->smarty->assign('viewList', $this->CreateLink($id, 'viewList', '', $this->Lang('title_view_list'), array()));
		// 	$this->smarty->assign('viewListIcon', $this->CreateLink($id, 'viewList', '', $gCms->variables['admintheme']->DisplayImage('icons/system/view.gif', $this->Lang('title_view_list'), '', 30, 'systemicon'), array())); 
		// 	
		$this->smarty->assign('lists', $lists);

		$this->smarty->assign('subscribers', $this->ProcessTemplate('subscribers.tpl'));
		
	//	var_dump($lists);
	//	$result = $this->cm->clientGetCampaigns( $client_id );
	}
}
else
{
	$this->smarty->assign('subscribers', $this->lang('api_client_notset'));
}


echo $this->ProcessTemplate('adminpanel.tpl');
?>