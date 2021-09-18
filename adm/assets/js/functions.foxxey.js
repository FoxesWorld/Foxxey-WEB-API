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
			$.post('admin.php', {
				action: 'loadPage',
				page: page
					
			}, function (data) {
				$(block).html(data);
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