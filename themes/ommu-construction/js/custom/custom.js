/*custom.js
Adding custom javascript or jquery function
* Copyright (c) 2014, Ommu Platform. All rights reserved.
* version: 0.0.1
*/

//Global Variable
var o = $.parseJSON(globals);
var baseUrl = o.baseUrl;
var lastTitle = o.lastTitle;
var lastDescription = o.lastDescription;
var lastKeywords = o.lastKeywords;
var lastUrl = o.lastUrl;
var contentOther = o.contentOther;

var windowHeight = $(window).height();

//check whether submit button save is click, prevent double post save
var isEnableSave = 0;

//button save click
function setEnableSave() {
	isEnableSave = 1;
}

/**
 * form function
 */
//count total json (obj)
function countProperties(obj) {
	var prop;
	var propCount = 0;

	for (prop in obj) {
		propCount++;
	}
	return propCount;
}

//find existed string
function strpos (haystack, needle) {
	var i = (haystack+'').indexOf(needle, 0);
	return i === -1 ? false : i;
}

//clear input
function clearInput(form) {
	$(form).find(':input').each(function() {
		switch(this.type) {
			case 'password':
			case 'select-multiple':
			case 'select-one':
			case 'text':
			case 'textarea':
				$(this).val('');
				break;
			case 'checkbox':
			case 'radio':
				this.checked = false;
		}
	});
}

//pushState function
function pushStateBar(title, description, keywords, url) {
	var stateObj = {foo: "bar"};
	history.pushState(stateObj, title, url);
	$('title').html(title);
	$('meta[name="description"]').attr('content', description);
	$('meta[name="keywords"]').attr('content', keywords);
}

$(document).ready(function() {
	/**
	 * For general ajax submit
	 * redirect
	 *
	 * type
	 *	0 [show message]
	 *	1 [update grid-view]
	 *	2 [replace spesific and galery upload]
	 *	5 [replace content or show dialog]
	 *	
	 *	msg [0,1,5] => message 
	 *	id [1,2,5] => attribute id (html)
	 *	get [2,5] => url	 
	 *	value [0] => 0,1
	 *	notifier [2] => off
	 *	dialog [2] => off
	 *	parent [2] => on
	 *	element [2] => [element html or attribute]
	 *	data [2] => [html sintag]
	 *	clear [5] => off
	 *
	 *	//3 [hide media-render]
	 *	4 [hide parent div]
	 *	//6 [replace header]
	 *	7 [spesific replace]
	 *
	 */ 

	// Dialog and General Function Form
	$('div[name="post-on"] form').submit(function(event) {
		$(this).find('input[type="submit"]').addClass('active');
		var attrSave = '?&enablesave=' + isEnableSave;
		//var attrSave = '/enablesave/' + isEnableSave;
		var method  = $(this).attr('method');
		var url     = $(this).attr('action') + attrSave;
		var link     = $(this).attr('action');

		if(method != 'get') {
			var options = {
				type: 'GET',
				dataType: 'json',
				//data: { enablesave: isEnableSave },
				success: function(response) {
					var hasError = 0;
					if(countProperties(response) > 0) {
						for(i in response) {
							if(strpos(i,'_'))
								hasError = 1;
						}
						if(hasError == 1) {
							$('form[action="'+link+'"]').find('input[type="submit"]').removeClass('active');

							$('form[action="'+link+'"]').find('div.errorMessage').hide().html('');
							$('form[action="'+link+'"]').find('textarea').removeClass('error');
							$('form[action="'+link+'"]').find('input').removeClass('error');
							for(i in response) {
								$('form[action="'+link+'"]').find('div#ajax-message').html(response.msg);
								$('form[action="'+link+'"] #' + i ).addClass('error');					
								$('form[action="'+link+'"] #' + i + '_em_').show().html(response[i][0]);
							}

						} else {
							$('form[action="'+link+'"]').find('input[type="submit"]').removeClass('active');

							$('form[action="'+link+'"]').find('div.errorMessage').hide().html('');
							$('form[action="'+link+'"]').find('textarea').removeClass('error');
							$('form[action="'+link+'"]').find('input').removeClass('error');
							
							if(response.redirect != null) {
								location.href = response.redirect;
								
							} else {
								if(response.type == 0) {
									if(response.value == 1) {
										//js condition
									}
									$('div.form form div#ajax-message').html('');
									$('form[action="'+link+'"] div#ajax-message').html(response.msg);
									//$.scrollTo("div.body", {duration: 800, axis:"y"});

								} else if(response.type == 1) {
									var grid = $('#'+response.id).find('.grid-view').attr('id');
									$.fn.yiiGridView.update(grid);
									$('#'+response.id+' div#ajax-message').html(response.msg);
									clearInput('form[action="'+link+'"]');

								} else if(response.type == 2) {
									if (typeof(response.get) != 'undefined') {
										$.ajax({
											type: 'get',
											url: response.get,
											dataType: 'json',
											//data: { id: '$id' },
											success: function(render) {
												$('#'+response.id).html(render.data);
											}
										});
									
									} else {
										if (typeof(response.id) != 'undefined') {
											$('#'+response.id).html(render.data);
											
										} else {											
											if (typeof(response.parent) != 'undefined') {
												if (typeof(response.data) != 'undefined') {
													if (typeof(response.element) != 'undefined') {
														$('*[href="'+ link +'"]').parents(response.element).html(response.data);
													} else {
														$('*[href="'+ link +'"]').parent().html(response.data);
													}													
												} else {
													if (typeof(response.element) != 'undefined') {
														$('*[href="'+ link +'"]').parents(response.element).hide();
													} else {
														$('*[href="'+ link +'"]').parent().hide();
													}
												}
											} else {
												$(response.element).html(render.data);
											}
																										
										}										
									}

								} else if(response.type == 3) {
									//js condition

								} else if(response.type == 4) {
									$('*[href="'+ link +'"]').parent('div').hide();

								} else if(response.type == 5) {
									$.ajax({
										type: 'get',
										url: response.get,
										dataType: 'json',
										success: function(render) {
											replaceContent(render, 1);
											if (typeof(response.id) != 'undefined') {
												$('#'+response.id+' div#ajax-message').html(response.msg);
											}
											if (typeof(response.clear) == 'undefined') {
												clearInput('form[action="'+link+'"]');
											}
										}
									});

								} else if(response.type == 6) {
									//js condition

								} else if(response.type == 7) {
									$.ajax({
										type: 'get',
										url: response.get,
										success: function(data) {
											$('#'+response.id).html(data);
											$('#'+response.id).find('div#ajax-message').html(response.msg);
										}
									});
								}
							}
							//$.scrollTo("body", {duration: 800, axis:"y"});
						}
					}
				}
			}
			
			if(method == 'post') {
				options.data = $(this).serialize();
				options.type = 'POST';
			}
			$.ajax(url, options);
			event.preventDefault();
		}
	});
});

/**
 * jquery address function
 */
//show dialog
function replaceContent(data, type) {
	if(type == 1)
		pushStateBar(data.title, data.description, data.keywords, data.address);

	var content = data.render;
		
	lastTitle = data.title;
	lastDescription = data.description;
	lastKeywords = data.keywords;
	lastUrl = data.address;
	$('header').html(data.header);
	$('div.body div.wrapper').html(content);

	if(data.script.cssFiles != '' || data.script.scriptFiles != '') {
		$('style[type="text/css"]').html('');
		$('style[type="text/css"]').html(data.script.cssFiles);
		$.when(
			$.each(data.script.scriptFiles, function(key, val) {
				$.getScript(val);
			})
		).then(function() {
		});
	}

	if(data.dialog != 0) {
		//$.scrollTo("body div.dialog, body div.notifier", {duration: 800, axis:"y"});		
	}
}

/**
 * ScrollTo Function
 */
function scrollDefaultFunction() {
	/* Default ScrollTo */
	$('a').click(function() {
		var scroll = $(this).attr('name');
		//alert(scroll);
		if (typeof(scroll) != 'undefined') {
			if(scroll != null) {
				//$.scrollTo('#'+scroll, {duration: 800, axis:"y"});
				return false;
			}
		}
	});
}
scrollDefaultFunction();

/**
 * Global Utility Function
 */
function utilityFunction() {
	// Error Dialog Fixed Formulir Type
	$('.dialog#module form.form div.errorMessage').hover(function() {
		var text = $(this).text();
		$(this).attr('title', text);
	});
	
	//images ratio
	processImages();

}
utilityFunction();

/**
 * Query the device pixel ratio.
 * Process all document images
 **/
function getDevicePixelRatio() {
	if(window.devicePixelRatio === undefined)
		return 1;								// No pixel ratio available. Assume 1:1.
	return window.devicePixelRatio;
}

function processImages() {
	if(getDevicePixelRatio() > 1) {
		var images = $('img');
		
		// Scale each image's width to 50%. Height will follow.
		for(var i = 0; i < images.length; i++) {
			images.eq(i).width(images.eq(i).width() / 2);
		}
	}

}