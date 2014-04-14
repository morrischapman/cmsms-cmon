<?php
if (!isset($gCms)) exit;

if (! $this->CheckAccess("Manage Campaign Monitor"))
{
	return $this->DisplayErrorPage($id, $params, $returnid,$this->Lang('accessdenied'));
}

if (isset($params['cancel']))
{
	$this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'campaigns'));exit;
}

if (!isset($params['wizard_id']) || !isset($_SESSION['CMon']['wizards'][$params['wizard_id']]))
{
	$this->Redirect($id, 'createCampaignStep1', $returnid, array());exit;
}
else
{	
	$from = isset($_SESSION['CMon']['wizards'][$params['wizard_id']]['from'])?$_SESSION['CMon']['wizards'][$params['wizard_id']]['from']:$this->getPreference('from_name');
	$from_email = isset($_SESSION['CMon']['wizards'][$params['wizard_id']]['from_email'])?$_SESSION['CMon']['wizards'][$params['wizard_id']]['from_email']:$this->getPreference('from_email');

//    var_dump($_SESSION['CMon']['wizards'][$params['wizard_id']]['url']);

	$campaign = CMonBase::createCampaign(
		$_SESSION['CMon']['wizards'][$params['wizard_id']]['campaign_name'], 
		$_SESSION['CMon']['wizards'][$params['wizard_id']]['subject'], 
		html_entity_decode($_SESSION['CMon']['wizards'][$params['wizard_id']]['url']), 
		html_entity_decode($_SESSION['CMon']['wizards'][$params['wizard_id']]['plain_url']),
		$_SESSION['CMon']['wizards'][$params['wizard_id']]['subscriber_list'],
		$from,
		$from_email		
		);

//    var_dump($campaign);
	
	if (!is_array($campaign))
	{
		// Process ok: Send the campaign.
		if ($this->getPreference('send_immediately') == 1)
		{
			$send = CMonBase::sendCampaign($campaign);	
		}
		else
		{
			$send = CMonBase::sendCampaign($campaign, date('Y-m-d H:i:s',	$_SESSION['CMon']['wizards'][$params['wizard_id']]['schedule']));
		}
		
		if ($send['Code'] == '0')
		{
			echo '<p>' . $this->lang('send_success') .'</p>';
		}
		else
		{
			echo '<p>' . $this->lang('send_fail', '#'.$send['Code'] . ': ' . $send['Message']) .'</p>';
		}
	}
	else
	{
		
		echo '<p>' . $this->lang('send_fail', '#'.$campaign['Code'] . ': ' . $campaign['Message']) .'</p>';
//		var_dump($campaign);
	
	
	
	// Preparation
	
	$form = new CMSForm('CMon', $id, 'createCampaignStep2', $returnid);

	$form->setLabel('previous', $this->lang('start_over'));
	$form->setWidget('wizard_id', 'hidden');
	$form->setButtons(array('previous'));

	$this->smarty->assign('form', $form);
	
	echo $this->ProcessTemplate('admin.createCampaignStep4.tpl');
	
	}
}
?>