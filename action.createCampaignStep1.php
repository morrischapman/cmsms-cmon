<?php
if (!isset($gCms)) exit;

if (! $this->CheckAccess("Manage Campaign Monitor"))
{
	return $this->DisplayErrorPage($id, $params, $returnid,$this->Lang('accessdenied'));
}

if (isset($params['cancel']))
{
	$this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'campaigns'));
}

if (isset($params['wizard_id']))
{
	$wizard_id = $params['wizard_id'];
}
else
{
	$wizard_id = time();
}

if(isset($params['from']) && ($params['from'] != ''))
{
	$_SESSION['CMon']['wizards'][$wizard_id]['from'] = $params['from']; 
} 
else
{
	$_SESSION['CMon']['wizards'][$wizard_id]['from'] = $this->getPreference('from_name');
}

if(isset($params['from_email']) && ($params['from_email'] != ''))
{
 	$_SESSION['CMon']['wizards'][$wizard_id]['from_email'] = $params['from_email']; 
}
else
{
	$_SESSION['CMon']['wizards'][$wizard_id]['from_email'] = $this->getPreference('from_email');
}

$form = new CMSForm('CMon', $id, 'createCampaignStep1', $returnid);
$form->setLabel('submit', $this->lang('continue'));

$form->setWidget('wizard_id', 'hidden', array('value' => $wizard_id));
$form->setWidget('url','text', array('default_value' => isset($_SESSION['CMon']['wizards'][$wizard_id]['url'])?$_SESSION['CMon']['wizards'][$wizard_id]['url']:''));
$form->setWidget('plain_url','text', array('default_value' => isset($_SESSION['CMon']['wizards'][$wizard_id]['plain_url'])?$_SESSION['CMon']['wizards'][$wizard_id]['plain_url']:''));

// TODO: Use user_preference from CMS Forms

if ($form->isSent())
{
    $form->process();

	if (isset($params['url']))
	{
		$_SESSION['CMon']['wizards'][$wizard_id]['url'] = $params['url'];
		$_SESSION['CMon']['wizards'][$wizard_id]['plain_url'] = $params['plain_url'];
		$this->Redirect($id, 'createCampaignStep2', $returnid, array('wizard_id' => $wizard_id));
	}
}

$this->smarty->assign('form', $form);
echo $this->ProcessTemplate('admin.createCampaignStep1.tpl');