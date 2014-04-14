<?php
    #-------------------------------------------------------------------------
    # Module: CM - This module allows you to send pages to Campaign Monitor and allows you to send newsletters with many statistics through CMS Made Simple
    # Version: 0.0.1, Jean-Christophe Cuvelier
    #
    #-------------------------------------------------------------------------
    # CMS - CMS Made Simple is (c) 2010 by Ted Kulp (wishy@cmsmadesimple.org)
    # This project's homepage is: http://www.cmsmadesimple.org
    #
    # This file originally created by ModuleMaker module, version 0.3.1
    # Copyright (c) 2010 by Samuel Goldstein (sjg@cmsmadesimple.org)
    #
    #-------------------------------------------------------------------------
    #
    # This program is free software; you can redistribute it and/or modify
    # it under the terms of the GNU General Public License as published by
    # the Free Software Foundation; either version 2 of the License, or
    # (at your option) any later version.
    #
    # This program is distributed in the hope that it will be useful,
    # but WITHOUT ANY WARRANTY; without even the implied warranty of
    # MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    # GNU General Public License for more details.
    # You should have received a copy of the GNU General Public License
    # along with this program; if not, write to the Free Software
    # Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
    # Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
    #
    #-------------------------------------------------------------------------

    #-------------------------------------------------------------------------
    # For Help building modules:
    # - Read the Documentation as it becomes available at
    #   http://dev.cmsmadesimple.org/
    # - Check out the Skeleton Module for a commented example
    # - Look at other modules, and learn from the source
    # - Check out the forums at http://forums.cmsmadesimple.org
    # - Chat with developers on the #cms IRC channel
    #-------------------------------------------------------------------------

    class CMon extends CMSModule
    {
        var $cm; // Campaign Monitor object

        function GetName()
        {
            return 'CMon';
        }

        function GetFriendlyName()
        {
            return $this->Lang('friendlyname');
        }

        function GetVersion()
        {
            return '1.0.0';
        }

        function GetHelp()
        {
            return $this->Lang('help');
        }

        function GetAuthor()
        {
            return 'Jean-Christophe Cuvelier';
        }

        function GetAuthorEmail()
        {
            return 'jcc@atomseeds.com';
        }

        function GetChangeLog()
        {
            return $this->Lang('changelog');
        }

        function IsPluginModule()
        {
            return true;
        }

        function HasAdmin()
        {
            return true;
        }

        function GetAdminSection()
        {
            return 'content';
        }

        function GetAdminDescription()
        {
            return $this->Lang('admindescription');
        }

        function VisibleToAdminUser()
        {
            return $this->CheckAccess();
        }

        function CheckAccess($perm = 'Manage Campaign Monitor')
        {
            return $this->CheckPermission($perm);
        }

        function DisplayErrorPage($id, &$params, $return_id, $message = '')
        {
            $this->smarty->assign('title_error', $this->Lang('error'));
            $this->smarty->assign_by_ref('message', $message);

            // Display the populated template
            echo $this->ProcessTemplate('error.tpl');
        }

        function GetDependencies()
        {
            return array('CMSForms' => '1.10.10');
        }

        function MinimumCMSVersion()
        {
            return "1.10";
        }

        function InstallPostMessage()
        {
            return $this->Lang('postinstall');
        }

        function UninstallPostMessage()
        {
            return $this->Lang('postuninstall');
        }

        function UninstallPreMessage()
        {
            return $this->Lang('really_uninstall');
        }

        public function InitializeFrontend()
        {
            $this->smarty->register_block('CMonAbsoluteUrl', array('CMon','AbsoluteUrl'));
        }

        public function AbsoluteUrl($params, $content, $template, &$repeat)
        {
            if (!$repeat) {
                if (isset($content)) {
                    if(isset($params['url']))
                    {
                        $content = str_replace('"uploads', '"' . $params['url'] . '/uploads', $content);
                    }

                    echo $content;
                }
            }
        }


        function init($force = false)
        {
            if (empty($this->cm)) {
                $api = $this->GetPreference('api_key');
                if (!empty($api)) {
                    $this->cm = new CampaignMonitor($api);
                }
            } elseif ($force) {
                $this->cm = new CampaignMonitor($this->GetPreference('api_key'));
            }
        }

        function addMail($addClient_id, $addCampaign_id, $addContents)
        {

            //get the inputted values and assign them to the object's variables
            $this->client_id   = $addClient_id;
            $this->campaign_id = $addCampaign_id;
            $this->contents    = $addContents;

            $db =& $this->GetDb();

            //build and execute query
            $q = "INSERT INTO $this->dbTable VALUES (NULL, 8, 801 , this, NULL)";
            $r =& $db->Execute($q);

            //check on the operability of the query q
            if (!$r) {
                die("Query unsuccessful: " . mysql_error());
            } else {
                echo '<h3>Added Successfully.</h3>';
            }

            mysql_close($db);

        }

        function getPageURL()
        {
            $this->pageURL = 'http';
            if ($_SERVER["HTTPS"] == "on") {
                $this->pageURL .= "s";
            }
            $this->pageURL .= "://";
            if ($_SERVER["SERVER_PORT"] != "80") {
                $this->pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
            } else {
                $this->pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
            }

            return $this->pageURL;
        }

        function getIcon($icon, $alt = NULL)
        {
            $config     =& $this->getConfig();
            $image_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'icons' . DIRECTORY_SEPARATOR . $icon;
            $image_url  = $config['root_url'] . '/modules/CMon/images/icons/' . $icon;
            if (is_file($image_path)) {
                $img = '<img src="' . $image_url . '"';
                if (!is_null($alt)) {
                    $img .= ' alt="' . $alt . '" title="' . $alt . '"';
                }
                $img .= ' />';

                return $img;
            }

            return NULL;
        }

        function createSendLink($id, $returnid, $url, $plain_url, $from = NULL, $from_email = NULL)
        {
            return $this->CreateLink(
                $id, 'createCampaignStep1', $returnid,
                $this->getIcon('email_go.png', $this->lang('send_via_cmon')),
                array('url' => html_entity_decode($url), 'plain_url' => html_entity_decode($plain_url), 'submit' => 'true', 'from' => $from, 'from_email' => $from_email)
            );
        }
    }

?>
