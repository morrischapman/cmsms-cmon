<?php
if (!cmsms()) exit;

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
/** @var CMon $this */

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
	$this->Redirect($id, 'defaultadmin', $returnid, array('tab' => 'options')); exit;
}

$form = new CMSForm('CMon', $id, 'defaultadmin', $returnid);
$form->setLabel('submit', $this->lang('save'));
$form->setWidget('tab','hidden',array('value' => 'options'));
$form->setWidget('api_key','text', array('preference' => 'api_key'));
$form->setWidget('client_id','text', array('preference' => 'client_id'));
$form->setWidget('use_global_campaign_name', 'checkbox', array('preference' => 'use_global_campaign_name'));
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

// Campaigns

$this->smarty->assign('sent_campaigns_title', $this->Lang('title_sent_campaigns'));

if ($this->hasApiKey() && $this->hasClientId())
{
    $result = $this->getCM()->cs_clients()->get_campaigns();

//    var_dump($result);

    $campaigns = array();

    if($result->http_status_code == 200)
    {
        $rowclass = 'row1';

        foreach($result->response as $response)
        {
            $response->rowclass = $rowclass;
            ($rowclass=="row1"?$rowclass="row2":$rowclass="row1");
            $response->manage = $this->createLink($id, 'viewCampaign', $returnid, '', array('CampaignID' => $response->CampaignID), false, true);
            $campaigns[] = $response;
        }

    }

    $smarty->assign('campaign_title', $this->lang('campaign'));
    $smarty->assign('campaign_id_title', $this->lang('title_campaign_id'));
    $smarty->assign('sent', $this->lang('sent'));
    $smarty->assign('total_recipients_title', $this->lang('title_total_recipients'));
    $smarty->assign('campaigns', $campaigns);

	$smarty->assign('campaigns_tpl', $this->ProcessTemplate('campaigns.tpl'));


    $result = $this->getCM()->cs_clients()->get_lists();
    $lists = array();

//    var_dump($result);

    if($result->http_status_code == 200)
    {
        $rowclass = 'row1';

        foreach($result->response as $response)
        {
            $response->rowclass = $rowclass;
            ($rowclass=="row1"?$rowclass="row2":$rowclass="row1");

            $response->stats = $this->getCM()->cs_lists($response->ListID)->get_stats()->response;
            $lists[] = $response;
        }
    }

    $this->smarty->assign('lists', $lists);
    $this->smarty->assign('subscribers', $this->ProcessTemplate('subscribers.tpl'));

}
else
{
    $this->smarty->assign('campaigns_tpl', $this->lang('api_client_notset'));
    $this->smarty->assign('subscribers', $this->lang('api_client_notset'));
}

echo $this->ProcessTemplate('adminpanel.tpl');
