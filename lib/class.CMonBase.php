<?php
	/*
	CMonBase
	
	This class have some methods to easily handle CM
	
	Author: Jean-Christophe Cuvelier - cybertotophe@gmail.com
	Copyrights: Jean-Christophe Cuvelier - Morris & Chapman Belgiul
	Code under GPL licence
	
	*/

class CMonBase 
{
	var $cm;
	var $api_key;
	var $client_id;
	
	public function __construct()
	{
		$this->cm = self::init();
		$this->api_key = self::getApiKey();
		$this->client_id = self::getClientId();
	}
	
	public static function init()
	{
		global $CampaingMonitor;
		if (!is_object($CampaingMonitor['object']))
		{
			$CampaingMonitor['object'] = new CampaignMonitor(self::getApiKey());
		}
		return $CampaingMonitor['object'];
	}
	
	public static function getApiKey()
	{
		$cmon = cms_utils::get_module('CMon');
		return $cmon->getPreference('api_key');
	}

	public static function getClientId()
	{
		$cmon = cms_utils::get_module('CMon');
		return $cmon->getPreference('client_id');
	}
	
	public static function getListsTitle($list_ids)
	{
		if (!is_array($list_ids)) $list_ids = array($list_ids);
		$titles = array();
		$cm = self::init();
		foreach($list_ids as $list_id)
		{
			$list = $cm->listGetDetail($list_id);
			$stats = $stats = $cm->listGetStats($list_id);
			$titles[] = $list['anyType']['Title'] . ' ('.$stats['anyType']['TotalActiveSubscribers'].')';
		}
		return implode(', ',$titles);
	}
	
	public static function createCampaign($campaign_name, $subject, $url, $plain_url,$subscriber_list, $from, $from_email, $reply_from = null)
	{
		$cm = self::init();
//		 $gCms->modules['CMon']['object']->getPreference('api_key');
		
		$cmon = cms_utils::get_module('CMon');
		
		if(is_null($reply_from))
		{
			$reply_from = $cmon->getPreference('reply_email');
		}

		if($reply_from == '')
		{
			$reply_from = $from_email;
		}

		$campaign = $cm->campaignCreate( 
			self::getClientId(), 
			$campaign_name, 
			$subject, 
			$from,
			$from_email,
			$reply_from, 
			$url, 
			$plain_url, 
			$subscriber_list, 
			null
			);
			
		return $campaign;
	}
	
	public static function sendCampaign($campaign_id, $send_date = 'Immediately')
	{
		$cm = self::init();
		$cmon = cms_utils::get_module('CMon');
		
		$send = $cm->campaignSend( 
			$campaign_id, 
			$cmon->getPreference('confirm_email'), 
			$send_date
			);
		return $send;
	}
	
	public static function getSubscriberLists($extended = false)
	{
		$cm = self::init();
		$results = $cm->clientGetLists(self::getClientId());
		$lists = array();
		if (isset($results['anyType']))
		{	
			if (isset($results['anyType']['List']['ListID']))
			{
				$list = $results['anyType']['List'];
				if ($extended == true)
				{
					$stats = $cm->listGetStats($list['ListID']);
					$lists[$list['ListID']] = $list['Name'] . ' ('.$stats['anyType']['TotalActiveSubscribers'].')';
				}
				else
				{
					$lists[$list['ListID']] = $list['Name'];					
				}
			}
			else
			{
				foreach($results['anyType']['List'] as $key => $list)
				{
					if ($extended == true)
					{
						$stats = $cm->listGetStats($list['ListID']);
						$lists[$list['ListID']] = $list['Name'] . ' ('.$stats['anyType']['TotalActiveSubscribers'].')';
					}
					else
					{
						$lists[$list['ListID']] = $list['Name'];					
					}
				}
			}
			
			
		}
		return $lists;
	}
	
	public static function getCampaigns()
	{
		$cm = self::init();
		$results = $cm->ClientGetCampaigns(self::getClientId());
		var_dump($results);
	}
	
	public static function getHtmlPageTitle($url)
	{
		$value = '';
		$text = file_get_contents(html_entity_decode($url));
		$title = self::getDocumentTitle($text);				
		return $title;//$value;
	}
	
	private static function getDocumentTitle($file){ 
	    $h1tags = preg_match('/<title>(.*)<\/title>/siU',$file,$patterns); 
		if (isset($patterns[1])) return $patterns[1]; 
		return null;
	}
	
	public function getNextScheduledDate($time)
	{
		$today_time = mktime($time[0],$time[1],$time[2]);		
		if ($today_time > time())
		{
			return date('Y:m:d',$today_time);
		}
		else
		{
			return date('Y:m:d',strtotime('+1 day', $today_time));
		}
	}
	
	public function checkScheduledDate($timestamp)
	{
		if ($timestamp > time())
		{
			return true;
		}
		return false;
	}
	
	public function getDateTimeFromWidgets($date,$time)
	{
		return (int) mktime(
			(int)$time[0],(int)$time[1],(int)$time[2],
			(int)$date[1],(int)$date[2],(int)$date[0]
			);
	}
}


?>