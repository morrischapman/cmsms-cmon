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
	// Preparation

	$form = new CMSForm('CMon', $id, 'createCampaignStepX', $returnid);

    $form->setLabel('submit', $this->lang('continue'));
    $form->setWidget('wizard_id', 'hidden');

    if($form->isSent())
    {
        $form->process();
    }

	$this->smarty->assign('form', $form);

	echo $this->ProcessTemplate('admin.createCampaignStepX.tpl');
}
