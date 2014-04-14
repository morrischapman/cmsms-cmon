<?php

$this->smarty->assign('draft_campaigns_title', $this->lang('title_draft_campaigns'));

$this->smarty->assign('campaign_id_title', $this->lang('title_campaign_id'));
$this->smarty->assign('campaign_name_title', $this->lang('title_campaign_name'));
$this->smarty->assign('client_id_title', $this->lang('title_client_id'));
$this->smarty->assign('subject_title', $this->lang('title_subject'));
$this->smarty->assign('from_name_title', $this->lang('title_from_name'));
$this->smarty->assign('from_email_title', $this->lang('title_from_email'));
$this->smarty->assign('reply_email_title', $this->lang('title_reply_email'));
$this->smarty->assign('html_content_title', $this->lang('title_html_content'));
$this->smarty->assign('text_content_title', $this->lang('title_text_content'));
$this->smarty->assign('subscriber_listid_title', $this->lang('title_subscriber_listid'));
$this->smarty->assign('subscriber_segements_title', $this->lang('title_subscriber_segments'));
$this->smarty->assign('date_created_title', $this->lang('title_date_created'));

$db =& $this->GetDb();
$q = "SELECT * FROM ". cms_db_prefix()."module_cmon_draft_mail ORDER BY date_created ASC";
$r = $db->Execute($q);

if ($r)
{
$list = array();

	while ($r && $row = $r->FetchRow())
	{
	
	$i = count($list);

	$list[$i][0] = $row['campaign_id'];
	$list[$i][1] = $row['campaign_name'];
	$list[$i][2] = $row['client_id'];
	$list[$i][3] = $row['subject'];
	$list[$i][4] = $row['from_name'];
	$list[$i][5] = $row['from_email'];
	$list[$i][6] = $row['reply_email'];
	$list[$i][7] = $row['html_content'];
	$list[$i][8] = $row['text_content'];
	$list[$i][9] = $row['subscriber_listid'];
	$list[$i][11] = $row['date_created'];
	
	}
	
	$this->smarty->assign('list', $list);

}
else
{
echo 'Query failed: ' . mysql_error();
}

$this->smarty->assign('goBack',$this->CreateLink($id, 'defaultadmin', '', $this->Lang('admin_title'),array()));    
$this->smarty->assign('addBackIcon',$this->CreateLink($id, 'defaultadmin', '', $gCms->variables['admintheme']->DisplayImage('icons/system/back.gif', $this->Lang('admin_title'),'', '','systemicon'), array())); 

echo $this->ProcessTemplate('viewDrafts.tpl');
?>
