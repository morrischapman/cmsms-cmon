<?php
/**
 * Date: 14/04/14
 * Time: 10:51
 * Author: Jean-Christophe Cuvelier <jcc@morris-chapman.com>
 * Proxy for CS_Rest functions
 */

class CMClient {

    /** @var CMClient $instance */
    private static $instance;

    private $api_key;
    private $client_id;

    final private function __construct()
    {
        static::init();
    }

    /**
     * @return CMClient
     */
    public static function getInstance()
    {
        return isset(static::$instance)
            ? static::$instance
            : static::$instance = new self
        ;
    }

    protected function init()
    {
    }

    /**
     * @return CS_REST_General
     */
    public function cs_general()
    {
        return new CS_REST_General($this->getAuth());
    }

    /**
     * @param $campaign_id
     * @return CS_REST_Campaigns
     */
    public function cs_campaigns($campaign_id = null)
    {
        return new CS_REST_Campaigns($campaign_id, $this->getAuth());
    }

    /**
     * @return CS_REST_Clients
     */
    public function cs_clients()
    {
        return new CS_REST_Clients($this->getClientId(), $this->getAuth());
    }

    /**
     * @param $list_id
     * @return CS_REST_Lists
     */
    public function cs_lists($list_id)
    {
        return new CS_REST_Lists($list_id, $this->getAuth());
    }

    /**
     * @return array
     */
    private function getAuth()
    {
        return array('api_key' => $this->getApiKey());
    }

    /**
     * @return string
     */
    private function getApiKey()
    {
        return isset($this->api_key)
            ? $this->api_key
            : $this->api_key = static::loadApiKey()
        ;
    }

    /**
     * @return string
     */
    private static function loadApiKey()
    {
        return cms_utils::get_module('CMon')->GetPreference('api_key');
    }

    /**
     * @return string
     */
    public function getClientId()
    {
        return isset($this->client_id)
            ? $this->client_id
            : $this->client_id = static::loadClientId()
            ;
    }

    /**
     * @return string
     */
    private static function loadClientId()
    {
        return cms_utils::get_module('CMon')->GetPreference('client_id');
    }
} 