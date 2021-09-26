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

<script>
parseJSONapi('/launcher.php?startUpSound', 'startUpSoundAPI');

function clearCacheButton() {
	let cacheStatus = $("#cacheFile").text();
	
	switch(cacheStatus){// data-toggle="modal" data-target="#clearCacheModal"
		case 'cacheExists':
			$("#cacheFile").html('<button class="btn btn-gold" onclick="clearCache($(this))">ClearCache</button>');
		break;
		
		case 'cacheDeleted':
			$("#cacheFile").html('<span class="badge badge-light">Already cleared</span>');
		break;
	}
}
setInterval("clearCacheButton()", 1000);
</script>

<div class="page-content">
	<div class="row">
		<div class="container-fluid card">
			<div class="tabs">
				<input type="radio" name="tab-btn" id="tab-btn-1" value="" checked>
				<label for="tab-btn-1"><i class="fadeIn animated bx bx-microchip"></i> Base Settings</label>
				<input type="radio" name="tab-btn" id="tab-btn-2" value="">
				<label for="tab-btn-2"><i class="fadeIn animated bx bx-shape-polygon"></i> Acces Settings</label>
				<input type="radio" name="tab-btn" id="tab-btn-3" value="">
				<label for="tab-btn-3"><img src="assets/images/startUpSound.png" style="height: 20px;width: auto; margin: 0px 5px;">startUpSound</label>
						
				<div id="content-1">
					<h4>Configuring <b>Foxxey</b></h4>
				</div>
				
				<div id="content-2">
					 <h4>Access Settings</h4>
				</div>

				<div id="content-3">
					<div class="row">
						<div class="col-12 col-lg-7 border-right">
							<h4>Information</h4>
								<table class="table table-normal">
									<tbody>
										<tr>
											<td>serverVersion:</td>
											<td id="serverVersion">undefined</td>
										</tr>
									<!-- Common mus files -->
										<tr>
											<td>CommonMusFilesNum:</td>
											<td id="musNum">0</td>
										</tr>
										<tr>
											<td>CommonSndFilesNum:</td>
											<td id="sndNum">0</td>
										</tr>
										
									<!-- Easter musFiles  -->
										<tr>
											<td>EasterMusFilesNum:</td>
											<td id="easterMusNum">0</td>
										</tr>
										<tr>
											<td>EasterSndFilesNum:</td>
											<td id="easterSndNum">0</td>
										</tr>
										
										<tr>
											<td>eventNow:</td>
											<td id="eventNow">undefined</td>
										</tr>
										
										<tr>
											<td>CachePath:</td>
											<td><div id="cachePath"></div></td>
										</tr>
										<!--
										<tr>
											<div id="warn" class="p-3 mb-2 bg-warning text-dark radius-15"></div>
										</tr> -->
										
									</tbody>
								</table>
						</div>

						<div class="col-12 col-lg-5">
							<h4>Options</h4>
							<div id="cacheFile"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
							<div class="modal fade" id="clearCacheModal" tabindex="-1" role="dialog" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered">
									<div class="modal-content">
										<div class="animate__animated modal-header animate__bounceInLeft">
											<h5 class="modal-title">Очистка Кеша</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										</div>
										<div class="animate__animated modal-body animate__bounceInRight">
										startUpSound - кеширует свои настройки после первого запуска, поэтому для применения новых настроек кеш нужно очищать, в данный момент эта функция недоступна, поскольку не была доделана</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-red" data-dismiss="modal">Закрыть</button>
											<!-- <button type="button" class="btn btn-light">Очистить</button> -->
										</div>
									</div>
								</div>
							</div>
</div>




