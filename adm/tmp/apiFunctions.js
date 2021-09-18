parseModules();
parseSystemInformation ();
parseCitiesInformation();
	
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

function parseSystemInformation () {
	$.ajax({ 
		type: 'GET', 
		url: '/foxxey/api.php', 
		data: { systemInfo: 'value' }, 
		dataType: 'json',
		success: function (data) {
			$("#OS").html(data.serverOS);
			$("#phpVersion").html(data.phpVersion);
		}
	});
}

function parseCitiesInformation () {
	$.ajax({ 
		type: 'GET', 
		url: '/foxxey/api.php', 
		data: { cities: 'value' }, 
		dataType: 'json',
		success: function (data) {
			$("#totalCities").html(data.totalCities);
			$("#totalPlayers").html(data.totalPlayers);
		}
	});
}