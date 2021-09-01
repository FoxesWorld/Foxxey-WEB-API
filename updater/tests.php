
<?php
	$os = $_POST['os'];
	$version = $_POST['version'];
	$bitDepth = $_POST['bitDepth'] ?? 64;
	$method = $_POST['method'] ?? 'POST';
	$runnerType = $_POST['runnerType'];
	$runnerHash = $_POST['runnerHash'];
	$launcherHash = $_POST['launcherHash'];

	switch($method){
		case 'GET':
		$request = base64_encode('{"n": "'.$os.'","v": "'.$version.'","b": "'.$bitDepth.'","rnh": "'.$runnerHash.'","rnty": "'.$runnerType.'","lnh": "'.$launcherHash.'"}');
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

fieldset {
	margin: 5px 0px;
}

p{
	    margin: -2px;
}

span{
	color: #ea4607;
    font-size: 16pt;
}
</style>
<center>
<form style="width: fit-content;" <?php if($method === 'POST') echo 'method="POST"'; ?>>

	<fieldset>
	<h4>Send Method</h4>
        <input type="radio" name="method"  id="method" value="GET" />GET<br>
        <input type="radio" name="method" id="method" value="POST" />POST<br>
    </fieldset>
	

	
	<fieldset>
	<h4>Runner</h4>
		<input type="text" id="runnerHash" name="runnerHash" placeholder="runnerHash"> <span>rnh</span><br>
		<input type="text" id="runnerType" name="runnerType" placeholder="runnerType">	<span>rnty</span>
	</fieldset>
	
	<fieldset>
		<h4>Launcher</h4>
		<input type="text" id="launcherHash" name="launcherHash" placeholder="launcherHash"> <span>lnh</span>
	</fieldset>
	
	<fieldset>
		<h4>Runtime</h4>
		<input type="text" id="os" name="os" value="win" placeholder="Operation System" /> <span>n</span> <br>
		<input type="text" id="version" name="version" value="301" placeholder="jreVersion" /> <span>v</span>
		<fieldset>
			<input type="radio" name="bitDepth"  id="bitDepth" value="32" />32 bit<br>
			<input type="radio" name="bitDepth" id="bitDepth" value="64" />64 bit <span>b</span><br>
		</fieldset>
    </fieldset>

	<input type="submit" />
</form>

<hr>

	<p>Это - вся информация, которая должна быть отправлена с помощью Раннера,</p>
	<p>с целью получить runtime  и удостовериться в валидности как себя так и лаунчера.</p>
	<p>Запрос должен передаваться с использованием JSON и при этом быть зашифрован в base64,</p>
	<p>Ключ каждого поля JSON указан справа от строки (Красным цыетом)</p>
</center>
