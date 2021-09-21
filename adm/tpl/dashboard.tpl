<style>
.tabs {
	font-size: 0;
}
.tabs>input[type="radio"] {
	display: none;
}
.tabs>div {
	display: none;
	border-top: 3px solid #a2956c;
	padding: 10px 15px;
	font-size: 16px;
}
#tab-btn-1:checked~#content-1,
#tab-btn-2:checked~#content-2,
#tab-btn-3:checked~#content-3 {
	display: block;
}
.tabs>label {
	border-right: 1px solid #7e7453;
	display: inline-block;
	text-align: center;
	vertical-align: middle;
	user-select: none;
	padding: 2px 8px;
	font-size: 16px;
	line-height: 1.5;
	transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out;
	cursor: pointer;
	position: relative;
	top: 1px;
	margin: 0px;
}
.tabs>label:not(:first-of-type) {
	border-left: none;
}
.tabs>input[type="radio"]:checked+label {
	background: #a2956c;
	-webkit-border-radius: 0;
	-moz-border-radius: 0;
	-ms-border-radius: 0;
	-o-border-radius: 0;
	border-radius: 0;
}
</style>

<div class="page-content">

		<div class="row">
			<div class="card col-md-8 d-sm-block">
				<div class="card-body">
					<h5>Auth LogTail</h5>
					<pre id="data" url="https://api.foxesworld.ru/files/logs/AuthLog.log">
						<code>
							Loading...
						</code>
					</pre>
				</div>
			</div>

			<div class="card card-min col-md-3">
				<div class="card-body">
					<h5>Modules installed</h5>					
					<div id="modules">

					</div>
				</div>
			</div>        
		</div>
		
		<div class="box">
			<div class="box-header">
				<div class="tabs">
						<input type="radio" name="tab-btn" id="tab-btn-1" value="" checked>
						<label for="tab-btn-1">Статистика</label>
						<input type="radio" name="tab-btn" id="tab-btn-2" value="">
						<label for="tab-btn-2">Заметки</label>
						<input type="radio" name="tab-btn" id="tab-btn-3" value="">
						<label for="tab-btn-3">О Системе</label>
					
					<div id="content-1">
						<div>Количество городов: <b id="totalCities">0</b></div>
						<div>Всего игроков: <b id="totalPlayers">0</b></div>
					</div>
					<div id="content-2">
					  Ваши заметки //Coming very soon
					</div>
					<div id="content-3">
							<div class="row">
							<div class="col-md-12">
								<table class="table table-normal">
									<tbody>
										<tr>
											<td class="col-md-3 white-line">Версия PhP:</td>
											<td class="col-md-9 white-line" id="phpVersion"></td>
										</tr>
										<tr>
											<td>Операционная система:</td>
											<td id="serverOS"></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
</div>
		
		<script src="assets/js/logtail.js"></script>

<script>
parseApiJSON('/foxxey/api.php', 'cities', 'totalPlayers');
parseApiJSON('/foxxey/api.php', 'cities', 'totalCities');
parseApiJSON('/foxxey/api.php', 'systemInfo', 'serverOS');
parseApiJSON('/foxxey/api.php', 'systemInfo', 'phpVersion');
parseApiMultiJSON('/foxxey/api.php', 'modules', 'module');
</script>
				