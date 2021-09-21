		function show(url, block) {  
             $.ajax({  
                url: url,  
                cache: false,  
                success: function(html){  
                    $(block).html(html);  
                }  
            });  
        }

		function addAnimClass(className, block) {
			setTimeout(() => { 
				 $('#'+block).addClass(className);
				 setTimeout(() => { 
					$('#'+block).removeClass(className);
				 }, 1000);
			}, 500);
		}
		
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
						addAnimClass('animate__shakeY', 'authBox');
					setTimeout(function(){
							show('', 'body');
					}, 1500);
						
					} else {
						addAnimClass('animate__shakeX', 'authBox');
					}
					button.notify(message,type);
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
		
		function LogOut() {
			$.post('admin.php', {
				action: 'logOut',
					
			}, function (data) {
				data = JSON.parse(data);
				let type = data['type'];
				let message = data['message'];
				show('', 'body');
				button.notify(message,type);
				});
		}
		
		function parseApiJSON(url, request, textValue){
			$.ajax({
				url: url,
				method: 'POST',
				data: String(request),
				success: function(data) {
					
					if(!data.message){
						$("#"+String(textValue)).html(data[String(textValue)]);
					} else {
						alert(data['message']);
					} 
				}
			});
		}
		
		function parseApiMultiJSON (url, request, requestValue) {	
			$.ajax({ 
				type: 'GET', 
				url: url, 
				data: String(request), 
				dataType: 'json',
				success: function (data) {			
					$.each(data, function(index, element) {
						$('#'+String(request)).append($('<div>', {
							text: element[String(requestValue)]
						}));
					});
				}
			});
		}