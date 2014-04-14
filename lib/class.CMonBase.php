<?php
	/*
	CMonBase
	
	This class have some methods to easily handle CM
	
	Author: Jean-Christophe Cuvelier - cybertotophe@gmail.com
	Copyrights: Jean-Christophe Cuvelier - Morris & Chapman Belgiul
	Code under GPL licence
	
	*/

/**
 * Class CMonBase
 */
// TODO: Refactor and link with CMClient
class CMonBase 
{
    private static $instance;

    /** @var \CampaignMonitor */
	var $cm;
	private $api_key;
	private $client_id;
	
	public function __construct()
	{
//		$this->api_key = self::getApiKey();
//		$this->client_id = self::getClientId();
	}

    /**
     * @return CampaignMonitor
     * @deprecated
     */
    public static function init()
	{
        return self::getInstance()->getCM();
	}

    public static function getInstance()
    {
        return isset(static::$instance)
            ? static::$instance
            : static::$instance = new self
            ;
    }

    /**
     * @return CampaignMonitor
     */
    private function getCM()
    {
        return isset($this->cm)
            ? $this->cm
            : $this->cm = $this->loadCM()
        ;
    }

    /**
     * @return CampaignMonitor
     */
    private function loadCM()
    {
        return new CampaignMonitor($this->getApiKey());
    }

	public function getApiKey()
	{
        return isset($this->api_key)
            ? $this->api_key
            : $this->api_key = static::loadApiKey()
        ;
	}

    private static function loadApiKey()
    {
        return cms_utils::get_module('CMon')->getPreference('api_key');
    }

	public function getClientId()
	{
        return isset($this->client_id)
            ? $this->client_id
            : $this->client_id = static::loadClientID()
        ;
	}

    private static function loadClientID()
    {
        return cms_utils::get_module('CMon')->getPreference('client_id');
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

        $instance = self::getInstance();

        // TODO: Use this code
//        $cm = CMClient::getInstance();
//        $campaign = $cm->cs_campaigns(null)->create($cm->getClientId(), array(
//                'Subject' => $subject,
//                'Name' => $campaign_name,
//                'FromName' => $from,
//                'FromEmail' => $from_email,
//                'ReplyTo' => $reply_from,
//                'HtmlUrl' => $url,
//                'TextUrl' => $plain_url,
//                'ListIDs' => array($subscriber_list),
////                'SegmentIDs' => array('First Segment', 'Second Segment')
//            ));

		$campaign = $cm->campaignCreate( 
			$instance->getClientId(),
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
        $instance = self::getInstance();
		$cm = self::init();
		$results = $cm->clientGetLists($instance->getClientId());
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
        $instance = self::getInstance();
		$results = $cm->ClientGetCampaigns($instance->getClientId());
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