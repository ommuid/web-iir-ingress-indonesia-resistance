/* Daops Member */
$('#daop-member .boxed .title a').click(function() {
	$(this).toggleClass('minus');
	$(this).parents('div.boxed').find('form').slideToggle();
});