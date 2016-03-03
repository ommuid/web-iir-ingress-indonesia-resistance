/*custom.js
Adding custom javascript or jquery function
* Copyright (c) 2014, Ommu Platform. All rights reserved.
* version: 0.0.1
*/

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

/**
 * dialog function
 */
//show loading
function loadingShow() {
	$('div.loading').fadeIn();
	$('header .message').fadeOut('slow').html('');
}

//hide loading
function loadingHidden() {
	$('div.loading').hide();
}

//show dialog
function dialogShow(content, dialog, width) {
	loadingHidden();
	$('div#ajax-message').html('');
	if(dialog == 1) {
		$('div.dialog').show().attr('name', width);
		$('div.dialog div.content').attr('id', width);
		$('div.dialog div.content').html(content);
	} else {
		$('div.notifier').show().attr('name', width);
		$('div.notifier div.content').attr('id', width);
		$('div.notifier div.content').html(content);
	}
	
	dialogActionClosed();
}

//pushState function
function pushStateBar(title, description, keywords, url) {
	var stateObj = {foo: "bar"};
	history.pushState(stateObj, title, url);
	$('title').html(title);
	$('meta[name="description"]').attr('content', description);
	$('meta[name="keywords"]').attr('content', keywords);
}

//hide dialog
function dialogClosed() {
	$('body').attr('style', '');
	$('div.dialog').fadeOut().attr('id','').attr('name','');
	$('div.dialog .dialog-box .content').html('').attr('id', '');
}
//hide notifier
function notifierClosed() {
	if($('div[name="dialog-wrapper"]').html() == '') {
		$('body').attr('style', '');
	}
	$('div.notifier').fadeOut().attr('name','');
	$('div.notifier .dialog-box .content').html('').attr('id', '');
}
function dialogClosedPush() {
	pushStateBar(lastTitle, lastDescription, lastKeywords, lastUrl);
}

//dialog close action
function dialogActionClosed() {
	$('.dialog .dialog-box a.closed').click(function(){
		dialogClosed();
		dialogClosedPush();
	});
	$('.notifier .dialog-box input#closed').click(function(){
		notifierClosed();
		if($('div[name="dialog-wrapper"]').html() == '') {
			dialogClosedPush();
		}
	});
	/* $("div.dialog .dialog-box .content").mouseup(function() {
		return false
	});
	//clode dialog
	$(document).mouseup(function(e) {
		if($(e.target).parent("div.dialog .dialog-box .content").length==0) {
			dialogClosed();
			dialogClosedPush();
		}
	}); */
}

/**
 * Ajax global function
 ** dialogAjax
 ** ajaxFunction
 */
function dialogAjax(url, type) {
	//url = link ajax
	loadingShow();
	$.ajax({
		type: 'get',
		url: url,
		dataType: 'json',
		success: function(response) {
			loadingHidden();
			$('*[href="'+url+'"]').removeClass('active');
			replaceContent(response, type);
		},
        error: function(jqXHR, textStatus, error) {
			location.href = url;
        }
	});	
}
function ajaxFunction() {
	/*
	$(window).on("popstate", function(e) {
		if (e.originalEvent.state !== null) {
			dialogAjax(location.href, 0);
		}
	});

	// Default url push
	$('a:not("[off_address]")').click(function(){
		var url = $(this).attr('href');
		if (typeof(url) != 'undefined') {
			if(url != 'javascript:void(0);') {
				dialogAjax(url, 1);				
			} else {
				return false;
			}
			return false;
		}
		return false;
	});
	*/
	
	// Custom show dialog
	$('a.link-dialog').click(function() {
		var id = $(this).attr('id');
		var width = $(this).attr('rel');
		var url = $(this).attr('href');
		if (typeof(url) != 'undefined') {
			if(url != 'javascript:void(0);') {
				dialogAjax(url, 1);
			} else {
				var content = $('.open-dialog-'+id).html();
				dialogShow(content, 2, width+'px');
			}
			return false;
		}
		return false;
	});	
}
ajaxFunction();

$(document).ready(function() {

	dialogActionClosed();

	/**
	 * For general ajax submit
	 * redirect
	 *
	 * type
	 *	0 [show message]
	 *	1 [update grid-view]
	 *	2 [replace spesific and galery upload]
	 *	3 [append, prepand]
	 *	5 [replace content or show dialog]
	 *
	 *	4 [hide parent div]
	 *	//6 [replace header]
	 *	7 [spesific replace]
	 *
	 *	id [2,7] => attribute id (html)
	 *	msg [0,1,7] => message
	 *	get [0,2,3,5] => url
	 *	value [0,3] => 0,1 (3"1=append,0=prepand")
	 *	data [3] => [html sintag]
	 *	idclass [3] => [selector]
	 *
	 */ 

	// Dialog and General Function Form
	$('div[name="post-on"] form, .dialog .dialog-box form:not("[on_post]"), .notifier .dialog-box form:not("[on_post]")').submit(function(event) {
		$(this).find('input[type="submit"]').addClass('active');
		var attrSave = '?&enablesave=' + isEnableSave;
		//var attrSave = '/enablesave/' + isEnableSave;
		var method  = $(this).attr('method');
		var url     = $(this).attr('action') + attrSave;
		var link     = $(this).attr('action');

		//Show Loading
		loadingShow();

		if(method != 'get') {
			var options = {
				type: 'GET',
				dataType: 'json',
				//data: { enablesave: isEnableSave },
				success: function(response) {
					//Hide Loading
					loadingHidden();

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

							if(response.type == 1) {
								dialogClosedPush();
							}
							if(response.redirect != null) {
								dialogClosed();
								notifierClosed();
								location.href = response.redirect;
							} else {
								if(response.type == 0) {
									if(response.value == 1) {
										//js condition
									}
									$('div.form form div#ajax-message').html('');
									$('form[action="'+link+'"] div#ajax-message').html(response.msg);
									$('header .message').html(response.msg).fadeIn();

								} else if(response.type == 1) {
									var grid = $('#'+response.id).find('.grid-view').attr('id');
									$.fn.yiiGridView.update(grid);
									$('#'+response.id+' div#ajax-message').html(response.msg);
									$('header .message').html(response.msg).fadeIn();
									clearInput('form[action="'+link+'"]');

								} else if(response.type == 2) {
									notifierClosed();
									dialogClosedPush();
									$.ajax({
										type: 'get',
										url: response.get,
										dataType: 'json',
										//data: { id: '$id' },
										success: function(render) {
											$('#'+response.id).html(render.data);
											mediaRenderFunction();
										}
									});

								} else if(response.type == 3) {
									if (typeof(response.get) != 'undefined') {
										
									} else {
										if (typeof(response.value) == 'undefined' || (typeof(response.value) != 'undefined' && response.value == 1)) {
											$(response.idclass).append(response.data);
										} else {
											$(response.idclass).prepend(response.data);
										}
									}

								} else if(response.type == 4) {
									notifierClosed();
									dialogClosedPush();
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
												$('header .message').html(response.msg).fadeIn();
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
											$('header .message').html(response.msg).fadeIn();
										}
									});
								}
							}
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

	// Administrator Upload Photo
	var uploadphoto = $('a#uplaod-image').attr('href');
	if (typeof(uploadphoto) != 'undefined') {
		new AjaxUpload($('a#uplaod-image'), {
			// Arquivo que fará o upload
			action: uploadphoto,
			//Nome da caixa de entrada do arquivo
			name: 'namaFile',
			responseType: 'json',
			onSubmit: function(file, ext){
				loadingShow();
				if (! (ext && /^(jpg|png|jpeg|gif|JPG|PNG|JPEG|GIF)$/.test(ext))){ 
					// verificar a extensão de arquivo válido
					alert('Hanya file JPG, PNG or GIF yang dibolehkan.');
					loadingHidden();
					return false;
				}
			},
			onComplete: function(file, response){
				loadingHidden();
				$(response.id).attr('src', response.image);
			}
		});
	}
});

/**
 * Global Utility Function
 */
function mediaRenderFunction() {	
	var linkupload = $('a#upload-gallery').attr('href');
	if (typeof(linkupload) != 'undefined') {
		new AjaxUpload($('li#upload'), {
			// Arquivo que fará o upload
			action: linkupload,
			//Nome da caixa de entrada do arquivo
			name: 'namaFile',
			responseType: 'json',
			onSubmit: function(file, ext){
				loadingShow();
				if (! (ext && /^(jpg|png|jpeg|gif|JPG|PNG|JPEG|GIF)$/.test(ext))){
					// verificar a extensão de arquivo válido
					alert('Hanya file JPG, PNG or GIF yang dibolehkan.');
					loadingHidden();
					return false;
				}
			},
			onComplete: function(file, response) {
				if (typeof(response.get) != 'undefined') {
					$.ajax({
						type: 'get',
						url: response.get,
						dataType: 'json',
						success: function(render) {
							loadingHidden();
							$('#'+response.id).html(render.data);
							mediaRenderFunction();
						}
					});
				} else {
					loadingHidden();
					if(response.type == 0) {
						$('#'+response.id).before(response.a);
					} else {
						$('#'+response.id).after(response.a);
					}
				}
			}
		});
	}
}
mediaRenderFunction();

/**
 * load content ground
 */
if(dialogGroundUrl != '') {
	$.ajax({
		type: 'get',
		url: dialogGroundUrl,
		dataType: 'json',
		success: function(data) {
			if(data.redirect != null) {
				location.href = data.redirect;
				
			} else {
				//render condition
				if(data.page == 1)
					var content = data.render.content;
				else 
					var content = data.render;

				if(data.dialog == 0) {
					//push title and last url
					lastTitle = data.title;
					lastDescription = data.description;
					lastKeywords = data.keywords;
					lastUrl = data.address;
					$('div.body .sidebar .menu').html(data.header);
					$('div.body div.wrapper').html(content);

				} else {
					$('body').attr('style', 'overflow-y: hidden');
					dialogShow(content, data.dialog, data.dialogWidth);
				}
				
				if(data.page == 1) {
					$.each(data.render.other, function(key, val) {
						if(val.type == 1) {
							$.ajax({
								type: 'get',
								url: val.url,
								//dataType: 'json',
								success: function(response) {
									$('#'+val.id).html(response);
								}
							});
						} else {
							$('#'+val.id).html(val.data);
						}
					});
				}

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
			}
		},
        complete: function(xhr,status) {
        }
	});
}

/**
 * jquery address function
 */
//show dialog
function replaceContent(data, type) {
	if(data.redirect != null) {
		location.href = data.redirect;
		
	} else {
		if(type == 1)
			pushStateBar(data.title, data.description, data.keywords, data.address);
		
		if(data.page == 1)
			var content = data.render.content;
		else 
			var content = data.render;
		
		if(data.dialog == 0) {
			lastTitle = data.title;
			lastDescription = data.description;
			lastKeywords = data.keywords;
			lastUrl = data.address;
			dialogClosed();
			notifierClosed();
			$('div.body .sidebar .menu').html(data.header);
			$('div.body div.wrapper').html(content);
			mediaRenderFunction();

		} else {
			$('body').attr('style', 'overflow-y: hidden');
			if(data.dialog == 1) {
				$('div.dialog').attr('id', data.apps);
				notifierClosed();
			}
			dialogShow(content, data.dialog, data.dialogWidth);
		}

		if(data.page == 1) {
			$.each(data.render.other, function(key, val) {
				if(val.type == 1) {
					$.ajax({
						type: 'get',
						url: val.url,
						//dataType: 'json',
						success: function(response) {
							$('#'+val.id).html(response);
						}
					});
				} else {
					$('#'+val.id).html(val.data);
				}
			});
		}

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
	}
}

/**
 * Global Utility Function
 */
function utilityFunction() {
	reinstallDatePicker();
}
utilityFunction();


/**
 *  reinstallDatePicker
 * 
 **/
function reinstallDatePicker() {
	$('input[on_datepicker]').focus(function(){
		$(this).datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['ja'],[]));
	});
}