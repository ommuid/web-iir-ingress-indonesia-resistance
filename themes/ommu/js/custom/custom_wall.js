/* Show Commnet */
$('.wall .list-view .sep .meta a.comment').click(function() {
	$(this).parents('div.status').find('.list-view').slideToggle();
});

$('#admin .wall .list-view .paging a').click(function() {
	var url = $(this).attr('href');
	$(this).addClass('load');
	
	if (typeof(url) != 'undefined') {
		$.ajax({
			type: 'get',
			url: url,
			dataType: 'json',
			success: function(response) {
				$('#admin .wall .list-view .paging a').removeClass('load');
				
				if(response.type == 0) {
					$('#admin .wall .list-view .items.wall').append(response.data);
					$('#admin .wall .list-view .paging span').text(response.summarypager);
					if(response.nextpage != 0)
						$('#admin .wall .list-view .paging a.wall').attr('href', response.nextpage);
					else
						$('#admin .wall .list-view .paging a.wall').hide();
				} else {				
					$('#admin .wall #'+response.wallid+' .list-view .items.comment').append(response.data);
					if(response.nextpage != 0)
						$('#admin .wall .list-view .paging a.comment').attr('href', response.nextpage);
					else
						$('#admin .wall .list-view .list-view .paging').hide();
				}
			}
		});
	}	
	return false;
});