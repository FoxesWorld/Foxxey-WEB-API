
<?php
	$os = $_POST['os'];
	$version = $_POST['version'];
	$bitDepth = $_POST['bitDepth'] ?? 64;
	$method = $_POST['method'] ?? 'POST';
	
	switch($method){
		case 'GET':
		$request = base64_encode('{"n": "'.$os.'",
				 "v": "'.$version.'",
				 "b": "'.$bitDepth.'"}');
		header('Location: /updater/?'.$request.'');
		break;
		
		case 'POST':
		
		break;
	}
?>
<style>
h4 {
    margin: 0;	
}

input {
	margin: 10px 0;
}

body {
	margin: 5% auto;
	width: fit-content;
}
</style>
<form style="width: fit-content;" method="POST" <?php if($method === 'POST') echo 'action="/updater/"'; ?>>

	<fieldset id="method">
	<h4>Send Method</h4>
        <input type="radio" name="method"  id="method" value="GET" />GET<br>
        <input type="radio" name="method" id="method" value="POST" />POST<br>
    </fieldset>
	
	<input type="text" id="os" name="os" value="win" placeholder="Operation System" /> <br>
	<input type="text" id="version" name="version" value="301" placeholder="jreVersion" />
	
	<fieldset id="bitDepth">
        <input type="radio" name="bitDepth"  id="bitDepth" value="32" />32 bit<br>
        <input type="radio" name="bitDepth" id="bitDepth" value="64" />64 bit<br>
    </fieldset>

	<input type="submit" />
</form>
