<br />
	<form action="{$self}" method="post">
	<fieldset>
		<legend>Details</legend>
	    <p>Mail ID:<input type="text" size="4" maxlength="5" name="gMail" value="{$rMail}" /></p>
    	<p>Client ID:<input type="text" size="5" maxlength="6" name="gClient" value="{$rClient}" /></p>
    	<p>Campaign ID:<input type="text" size="7" maxlength="8" name="gCampaign" value="{$rCampaign}" /></p>
    	<p>Contents: <textarea rows="6" cols="20" name="gContents">{$rContents}</textarea></p>
    	<p>Date:<input type="text" size="16" maxlength="18" name="gDate" value="{$rDate}" /><p>
    	<p><input type="submit" name="gSubmit" value="Submit" /></p>
			<input type="hidden" name="gSubmitted" value="TRUE" />
		</fieldset>	
	</form>




