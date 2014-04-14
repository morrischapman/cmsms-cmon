<?php
if (!isset($gCms)) exit;

if (! $this->CheckAccess("Manage Campaign Monitor"))
{
	return $this->DisplayErrorPage($id, $params, $returnid,$this->Lang('accessdenied'));
}

if (isset($params['cancel']))
{
	$this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'campaigns'));
	exit;
}

if (!isset($params['wizard_id']) || !isset($_SESSION['CMon']['wizards'][$params['wizard_id']]))
{
	var_dump($params);
	$this->Redirect($id, 'createCampaignStep1', $returnid, array());
	exit;
}
else
{	
	if (!isset($_SESSION['CMon']['wizards'][$params['wizard_id']]['url']) || !isset($_SESSION['CMon']['wizards'][$params['wizard_id']]['plain_url']))
	{
		$this->Redirect($id, 'createCampaignStep1', $returnid, array('wizard_id' => $params['wizard_id']));
		exit;
	}
	
	$url = $_SESSION['CMon']['wizards'][$params['wizard_id']]['url'];
	$title = CMonBase::getHtmlPageTitle($url);

	// Preparation
	$campaign_name =  isset($_SESSION['CMon']['wizards'][$params['wizard_id']]['campaign_name'])?$_SESSION['CMon']['wizards'][$params['wizard_id']]['campaign_name']:$title;
	$subject = isset($_SESSION['CMon']['wizards'][$params['wizard_id']]['subject'])?$_SESSION['CMon']['wizards'][$params['wizard_id']]['subject']:$title;	
	
	$form = new CMSForm('CMon', $id, 'createCampaignStep2', $returnid);
	$form->setLabel('submit', $this->lang('continue'));

	$form->setWidget('wizard_id', 'hidden');
	$form->setWidget('campaign_name','text', array('default_value' => $campaign_name));
	$form->setWidget('subject','text', array('default_value' => $subject));
	
	$form->setWidget('from', 'text', array('default_value' => $_SESSION['CMon']['wizards'][$params['wizard_id']]['from']));
	$form->setWidget('from_email', 'text', array('default_value' => $_SESSION['CMon']['wizards'][$params['wizard_id']]['from_email']));
	
	$form->setWidget('subscriber_list','select', array('values' => CMonBase::getSubscriberLists(true), 'default_value' => isset($_SESSION['CMon']['wizards'][$params['wizard_id']]['subscriber_list'])?$_SESSION['CMon']['wizards'][$params['wizard_id']]['subscriber_list']:
	(array($this->getPreference('subscribers_list')))
	));

	if ($this->getPreference('send_immediately') != 1)
	{
		$form->setWidget('scheduled_date', 'date', array('default_value' => explode(':', CMonBase::getNextScheduledDate(isset($params['scheduled_time'])?$params['scheduled_time']:explode('|',$this->getPreference('default_time')))
				)
			)
		);
		$form->setWidget('scheduled_time', 'time',array('default_value' => explode('|', $this->getPreference('default_time'))));
	}

	
	$this->smarty->assign('form', $form);
		
	
	if ($form->isSent())
	{
        $form->process();

		$_SESSION['CMon']['wizards'][$params['wizard_id']]['campaign_name'] = implode(',',$form->getWidget('campaign_name')->getValues());
		$_SESSION['CMon']['wizards'][$params['wizard_id']]['subject'] = implode(',',$form->getWidget('subject')->getValues());
		$_SESSION['CMon']['wizards'][$params['wizard_id']]['subscriber_list'] = $form->getWidget('subscriber_list')->getValues();
		
		
		$_SESSION['CMon']['wizards'][$params['wizard_id']]['from'] = $form->getWidget('from')->getValues();
		$_SESSION['CMon']['wizards'][$params['wizard_id']]['from_email'] = $form->getWidget('from_email')->getValues();
		
		if ($this->getPreference('send_immediately') != 1)
		{
				$timestamp = CMonBase::getDateTimeFromWidgets($form->getWidget('scheduled_date')->getValues(), $form->getWidget('scheduled_time')->getValues());

				if (CMonBase::checkScheduledDate($timestamp))
				{		
					$_SESSION['CMon']['wizards'][$params['wizard_id']]['schedule'] = $timestamp;
				}
				else
				{
					$form->setError($this->lang('cannot_send_past'),'Errors');
				}
		}
		
		if(isset($params['submit']) && $form->noError()) 
		{
			$this->Redirect($id, 'createCampaignStep3', $returnid, array('wizard_id' => $params['wizard_id']));
			exit;
		}
		
	}
	
	// Submit operations	
	
	echo $this->ProcessTemplate('admin.createCampaignStep2.tpl');
}