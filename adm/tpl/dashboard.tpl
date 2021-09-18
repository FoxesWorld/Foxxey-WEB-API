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

/* Buttons */
.btn {
	color: #fff;
	-webkit-border-radius: 2px;
	-moz-border-radius: 2px;
	-ms-border-radius: 2px;
	-o-border-radius: 2px;
	border-radius: 2px;
	font-size: 11px;
	font-weight: 600;
	text-shadow: 0 -1px #6f6f6f;
}
.btn:hover,
.btn:active,
.btn:focus {
	color: #fff;
}
.btn.btn-full {
	display: block;
}
.btn.btn-default {
	color: #333;
	text-shadow: none;
}
.btn.btn-default:hover,
.btn.btn-default:active {
	color: #333;
}
.btn.btn-default .caret {
	border-top: 4px solid black;
}
.btn .caret {
	border-top: 4px solid white;
}
.btn.btn-lg {
	font-size: 12px;
}
.btn.btn-default {
	border: 1px solid #d4d4d4;
	-webkit-box-shadow: inset 0 1px 2px white;
	-moz-box-shadow: inset 0 1px 2px white;
	box-shadow: inset 0 1px 2px white;
	background-repeat: repeat-x;
	background-image: -webkit-gradient(linear, left 0%, left 100%, color-stop(0%, #baa263), color-stop(100%, #e9e9e9));
	background-image: -webkit-linear-gradient(top, #baa263, 0%, #e9e9e9, 100%);
	background-image: -moz-linear-gradient(top, #baa263, 0%, #e9e9e9, 100%);
	background-image: linear-gradient(to bottom, #baa263 0%, #e9e9e9 100%);
}
.btn.btn-default:hover {
	background: #e6e6e6;
	background-repeat: repeat-x;
	background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #baa263), color-stop(100%, #e6e6e6));
	background-image: -webkit-linear-gradient(top, #baa263, 0%, #e6e6e6, 100%);
	background-image: -moz-linear-gradient(top, #baa263, 0%, #e6e6e6, 100%);
	background-image: -o-linear-gradient(top, #baa263, 0%, #e6e6e6, 100%);
	background-image: linear-gradient(to bottom, #baa263 0%, #e6e6e6 100%);
	-webkit-transition: box-shadow 0.05s ease-in-out;
	-moz-transition: box-shadow 0.05s ease-in-out;
	-o-transition: box-shadow 0.05s ease-in-out;
	transition: box-shadow 0.05s ease-in-out;
}
.btn.btn-default:active {
	background: #f3f3f3;
	border-color: #cfcfcf;
	-webkit-box-shadow: 0 0 5px #f3f3f3 inset;
	-moz-box-shadow: 0 0 5px #f3f3f3 inset;
	box-shadow: 0 0 5px #f3f3f3 inset;
}
[class^="icon-"],
[class*=" icon-"] {
	font-family: FontAwesome;
	font-weight: normal;
	font-style: normal;
	text-decoration: inherit;
	-webkit-font-smoothing: antialiased;
	display: inline;
	width: auto;
	height: auto;
	line-height: normal;
	vertical-align: baseline;
	background-image: none;
	background-position: 0% 0%;
	background-repeat: repeat;
	margin-top: 0;
}
.btn.btn-gold {
	border: 1px solid #a87a27;
	-webkit-box-shadow: inset 0 1px 2px #daaf61;
	-moz-box-shadow: inset 0 1px 2px #daaf61;
	box-shadow: inset 0 1px 2px #daaf61;
	background: #c9922f;
	background-image: url('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4gPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PGxpbmVhckdyYWRpZW50IGlkPSJncmFkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjUwJSIgeTE9IjAlIiB4Mj0iNTAlIiB5Mj0iMTAwJSI+PHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2Q1YTQ0YyIvPjxzdG9wIG9mZnNldD0iMTAwJSIgc3RvcC1jb2xvcj0iI2M5OTIyZiIvPjwvbGluZWFyR3JhZGllbnQ+PC9kZWZzPjxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JhZCkiIC8+PC9zdmc+IA==');
	background-size: 100%;
	background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #d5a44c), color-stop(100%, #c9922f));
	background-image: -webkit-linear-gradient(top, #d5a44c, #c9922f);
	background-image: -moz-linear-gradient(top, #d5a44c, #c9922f);
	background-image: -o-linear-gradient(top, #d5a44c, #c9922f);
	background-image: linear-gradient(top, #d5a44c, #c9922f);
}
.btn.btn-gold:hover {
	background: #c58f2e;
	background-image: url('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4gPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PGxpbmVhckdyYWRpZW50IGlkPSJncmFkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjUwJSIgeTE9IjAlIiB4Mj0iNTAlIiB5Mj0iMTAwJSI+PHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2Q1YTQ0YyIvPjxzdG9wIG9mZnNldD0iMTAwJSIgc3RvcC1jb2xvcj0iI2M1OGYyZSIvPjwvbGluZWFyR3JhZGllbnQ+PC9kZWZzPjxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JhZCkiIC8+PC9zdmc+IA==');
	background-size: 100%;
	background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #d5a44c), color-stop(100%, #c58f2e));
	background-image: -webkit-linear-gradient(top, #d5a44c, #c58f2e);
	background-image: -moz-linear-gradient(top, #d5a44c, #c58f2e);
	background-image: -o-linear-gradient(top, #d5a44c, #c58f2e);
	background-image: linear-gradient(top, #d5a44c, #c58f2e);
	-webkit-transition: box-shadow 0.05s ease-in-out;
	-moz-transition: box-shadow 0.05s ease-in-out;
	-o-transition: box-shadow 0.05s ease-in-out;
	transition: box-shadow 0.05s ease-in-out;
}
.btn.btn-gold:active {
	background: #d19c3b;
	border-color: #a07425;
	-webkit-box-shadow: 0 0 5px #d19c3b inset;
	-moz-box-shadow: 0 0 5px #d19c3b inset;
	box-shadow: 0 0 5px #d19c3b inset;
}
</style>

<div class="page-content">
	<!--	<div class="row">
			<div class="card radius-15 col-md-9 d-sm-block">
				<div class="card-body p-2">	
					<pre id="data" url="https://api.foxesworld.ru/files/logs/AuthLog.log">
							<code>
								Loading...
							</code>
					</pre>
				</div>
			</div>

			<div class="card radius-15 col-md-3">
				<div class="d-block box">
					<div class="boxContent">
					<h5>Modules installed</h1>
						<div id="modules"></div>
					</div>
				</div>
			</div>        
		</div> -->
		
		<div class="row">
			<div class="card col-md-9 d-sm-block">					
				<pre id="data" url="https://api.foxesworld.ru/files/logs/AuthLog.log">
						<code>
							Loading...
						</code>
				</pre>
			</div>

			<div class="card col-md-3 rightBlock">
				<div class="card-body p-2">
					<div class="boxContent">
					<h5>Modules installed</h1>
						<div id="modules"></div>
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
						  <button id="clearsubscribe" name="clearsubscribe" class="btn btn-gold"><i class="icon-user"></i> Очистить список награждений</button>
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
												<td id="OS"></td>
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
		<script>parseModules();	
			function parseModules () {	
				$.ajax({ 
					type: 'GET', 
					url: '/foxxey/api.php', 
					data: { modules: 'value' }, 
					dataType: 'json',
					success: function (data) {			
						$.each(data, function(index, element) {
							$('#modules').append($('<div>', {
								text: element.module
							}));
						});
					}
				});
			}
</script>
				