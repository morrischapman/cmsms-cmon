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

if (isset($params['previous']))
{		
	$this->Redirect($id, 'createCampaignStep2', $returnid, array('wizard_id' => $params['wizard_id']));
	exit;
}

if (isset($params['submit']))
{
	$this->Redirect($id, 'createCampaignStep4', $returnid, array('wizard_id' => $params['wizard_id']));
	exit;
}

if (!isset($params['wizard_id']) || !isset($_SESSION['CMon']['wizards'][$params['wizard_id']]))
{
	$this->Redirect($id, 'createCampaignStep1', $returnid, array());exit;
}
else
{
	$this->smarty->assign('campaign_ready', $this->lang('ready_to_send'));
	$this->smarty->assign('campaign_name', $_SESSION['CMon']['wizards'][$params['wizard_id']]['campaign_name']);
	$this->smarty->assign('campaign_name_title', $this->lang('form_campaign_name'));
	$this->smarty->assign('subject', $_SESSION['CMon']['wizards'][$params['wizard_id']]['subject']);
	$this->smarty->assign('subject_title', $this->lang('form_subject'));
	$this->smarty->assign('subscriber_list', CMonBase::getListsTitle($_SESSION['CMon']['wizards'][$params['wizard_id']]['subscriber_list']));
	$this->smarty->assign('subscriber_list_title', $this->lang('form_subscriber_list'));
	$this->smarty->assign('preview_html', $this->lang('preview_html', $_SESSION['CMon']['wizards'][$params['wizard_id']]['url']));
	$this->smarty->assign('preview_plain', $this->lang('preview_plain', $_SESSION['CMon']['wizards'][$params['wizard_id']]['plain_url']));
	
	if(isset($_SESSION['CMon']['wizards'][$params['wizard_id']]['from']))
	$this->smarty->assign('preview_from', $this->lang('preview_from', $_SESSION['CMon']['wizards'][$params['wizard_id']]['from']));		
	
	if(isset($_SESSION['CMon']['wizards'][$params['wizard_id']]['from_email']))
	$this->smarty->assign('preview_from_email', $this->lang('preview_from_email', $_SESSION['CMon']['wizards'][$params['wizard_id']]['from_email']));
	
	
	
	if ($this->getPreference('send_immediately') == 1)
	{
		$this->smarty->assign('schedule', $this->lang('sent_immediately'));
	}
	else
	{
		$this->smarty->assign('schedule', $this->lang('scheduled_on', date('d/m/Y \a\t H:i:s', $_SESSION['CMon']['wizards'][$params['wizard_id']]['schedule'])));
	}
	
	// Preparation
	$form = new CMSForm('CMon', $id, 'createCampaignStep3', $returnid);
    $form->setLabel('submit', $this->lang('send'));
	$form->setWidget('wizard_id', 'hidden');
	$form->setButtons(array('previous','cancel','submit'));

	$this->smarty->assign('form', $form);

	echo $this->ProcessTemplate('admin.createCampaignStep3.tpl');
}
