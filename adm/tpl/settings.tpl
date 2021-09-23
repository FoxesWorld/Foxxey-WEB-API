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
					<h4>Configuring <b>startUpSound</b> eventList</h4>
					
							<div class="row">
								<div class="col-md-12">
									<table class="table table-normal">
										<tbody>
											<tr>
												<td class="col-md-3 white-line">musFilesNum:</td>
												<td class="col-md-9 white-line" id="musNum">0</td>
											</tr>
											<tr>
												<td>sndFilesNum:</td>
												<td id="sndNum">0</td>
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