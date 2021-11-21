		/* Base methods */
				function show(url, block) {  
					 $.ajax({  
						url: url,  
						cache: false,  
						success: function(html){  
							$(block).html(html);  
						}  
					});  
				}
				
				function sendPost(button, url, action) {
					$.post(url, {
						action: action,
							
					}, function (data) {
						data = JSON.parse(data);
						let type = data['type'];
						let message = data['message'];
						if(type === 'success') {
								if(action === 'logOut') {
									show('', 'body');
								}	
						} else {
							console.log(message);
						}
						button.notify(message, type);
						});
				}
		
		/* Authorisation */
				function login(button){
					let action = $("#action").val();
					let login = $("#login").val();
					let password = $("#password").val();
					let rememberMe = $("#rememberMe:checked").val();
				
						$.post('admin.php', {
							action: action,
							login: login,
							password: password,
							rememberMe: rememberMe
						
						}, function (data) {
							data = JSON.parse(data);
							let type = data['type'];
							let message = data['message'];

							if(type == 'success'){
								addAnimation('animate__zoomOut', 'authBox');
								setTimeout(function(){
										 $('#authBox').remove();
								}, 1500);
							setTimeout(function(){
									show('', 'body');
							}, 1500);
								
							} else {
								addAnimation('animate__shakeX', 'authBox');
								button.notify(message,type);
							}
						});
				}
		
		/* API asynchronous functions */
				function parseJSONapi(url, request, debug = false) {
					$.ajax({
						url: url,
						method: 'POST',
						dataType: 'json',
						data: String(request),
						success: function(data) {
							for (var key in data) {
							  let value = data[key];
							  if(debug === true) {
								console.log('ключ: ' + key + ', значение: ' + value);
							  }
							  $("#"+String(key)).html(value);
							}
						}
					});
				}
				
				//Test
				function parseJSONMulti(url, request, debug = false) {
					let row;
					let value;
					$.ajax({
						url: url,
						method: 'POST',
						dataType: 'json',
						data: String(request),
						success: function(data) {
							for (let key in data) {
								  row = data[key];
								  if(debug === true) {
									console.log(row);
								  }
								let tr = $('#'+request).append('<tr>');
								for (let key in row) {
									value = row[key];
									tr.append($('<td>', {
										text: value
									}));
								}
							}
						}
					});
				}

				function loadPage(page, block) {
					$(block).animate({opacity: 0}, 300);
					$.post('admin.php', {
						action: 'loadPage',
						page: page
					}, function (data) {
							setTimeout(function(){
								$(block).html(data).animate({opacity: 1}, 500);
							}, 500);
					});
				}
		
		/* Admin Notes */
				function saveNotes(button) {
					let notes = $("#notice").val();
					
					$.post('admin.php', {
						action: 'sendNotes',
						adminNotes: notes
							
					}, function (data) {
						data = JSON.parse(data);
						let type = data['type'];
						let message = data['message'];
						button.notify(message, type);
					});
				}
		
				function readNotes(){
					$.post('admin.php', {
						action: 'readNotes'	
					}, function (data) {
						$('#notice').html(data);
					});
				}
		
		/* startUpSound */
				function clearCache(button){
					$.post('admin.php', {
						action: 'clearSUScache',
						cachePath: $("#cachePath").text()
					
					}, function (data) {
						data = JSON.parse(data);
						let type = data['type'];
						let message = data['message'];
						button.notify(message, type);
							setTimeout(function(){
								parseJSONapi('/startUpSound', 'startUpSoundAPI');
							}, 1500);
						
					});
				}
				
		/* Animations */
				function addAnimation(animation, block) {
					setTimeout(() => { 
						 $('#'+block).addClass(animation);
						 setTimeout(() => { 
							$('#'+block).removeClass(animation);
						 }, 1000);
					}, 500);
				}