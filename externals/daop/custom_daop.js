/* Daops Member */
$(document).on('click', '#daop-member .boxed .title a', function() {
	$(this).toggleClass('minus');
	$(this).parents('div.boxed').find('form').slideToggle();
	return false;
});

/* Daops City */
$(document).on('click', '#daop-city .boxed.box-info .area-info li a', function() {
	var id = $(this).attr('class');
	$('#daop-city .boxed.box-info .area-info li').removeClass('active');
	$(this).parent('li').addClass('active');
	$('#daop-city .boxed .box-contant').hide();
	$('#daop-city .boxed #'+id).show();
	return false;
});