<br />
<form action="{$self}" method="post">
	<fieldset>
		<legend>Enter search details</legend>
		
  <p>Enter Mail ID:<input type="text" name="mail" size="4" maxlength="4" /></p>
	<p>Enter Client ID: <input type="text" name="client" size="5" maxlength="5" /></p>
	<p>Enter Campaign ID: <input type="text"  name="campaign" size="7" maxlength="7" /></p>
	<p>Enter Contents: <textarea name="contents"  rows="4" cols="20"></textarea></p>
	<p>Enter Date: <input type="text" name="date" size="10" maxlength="16" /></p>
	<p><input type="submit" name="submit" value="Submit" /><input type="button" value="Clear" onClick="window.location='{$self}' "></p>
	<input type="hidden" name="submitted" value="TRUE" />
		</fieldset>
</form>
<br />






