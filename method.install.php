<?php
if (!isset($gCms)) exit;

	/*---------------------------------------------------------
	   Install()
	   When your module is installed, you may need to do some
	   setup. Typical things that happen here are the creation
	   and prepopulation of database tables, database sequences,
	   permissions, preferences, etc.
	   	   
	   For information on the creation of database tables,
	   check out the ADODB Data Dictionary page at
	   http://phplens.com/lens/adodb/docs-datadict.htm
	   
	   This function can return a string in case of any error,
	   and CMS will not consider the module installed.
	   Successful installs should return FALSE or nothing at all.
	  ---------------------------------------------------------*/
		
		// Typical Database Initialization
		$db =& $gCms->GetDb();
		
		// mysql-specific, but ignored by other database
		$taboptarray = array('mysql' => 'TYPE=MyISAM');
		$dict = NewDataDictionary($db);
		
        // table schema description
        $flds = "
			campaign_id VAR(32) KEY NOTNULL,
			campaign_name VAR(50),
			client_id I NOTNULL,
			subject VAR(50),
			from_name VAR(50),
			from_email VAR(50),
			reply_email VAR(50),
			html_content VAR(100),
			text_content VAR(100),
			subscriber_listid VAR(400),
			subscriber_segments VAR(400),
			date_created DEFTIMESTAMP
			";

		// create it. This should do error checking, but I'm a lazy sod.
		$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_cmon_draft_mail",
				$flds, $taboptarray);
		$dict->ExecuteSQLArray($sqlarray);

		// create a sequence
		$db->CreateSequence(cms_db_prefix()."module_cmon_sent_mail_seq");
		
		
		// permissions
		$this->CreatePermission('Manage Campaign Monitor','Manage Campaign Monitor');


		// put mention into the admin log
		$this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('installed',$this->GetVersion()));
		
?>