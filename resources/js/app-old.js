var App = function() {
    return {
        baseUrl: function(url) {
            return 'http://oficina.vnstudios.com/dingdong/site/' + url;
        },
        uriSegment: function(n) {
            segment = window.location.pathname.split('/');
            return segment[n];
        },
        coachMark: function() {
        	coachMark();
		    $(window)
		    .scroll(coachMark)
		    .resize(coachMark);
		    function coachMark() {
		        var docHeight = $(document.body).height() - $('#padding-coachmark').height() + parseInt($('body').css('padding-top'));
		        if(docHeight < $(window).height()){
		            var diff = $(window).height() - docHeight;
		            if (!$('#padding-coachmark').length > 0){
		                $('#coachmark').append('<div id="padding-coachmark"></div>');
		            }
		            $('#padding-coachmark').height(diff);    
		        }
		    }
		    $('#coachmark .step-0').on('click', function() {
		    	$('#step-0').fadeOut();
		    	$('#step-1').fadeIn();
		    	App.coachMark();
		    });
        },
        vegas: function() {
        	if ($('#login').length) {
        		$.vegas({src:App.baseUrl('../resources/img/1.jpg')});
        	}
        },
        facebookSDKInit: function() {
        	window.fbAsyncInit = function() {
				FB.init({
		          	appId      : '338346469695953',
		          	status     : true,
		          	xfbml      : true,
		          	version    : 'v2.1'
	        	});
	    	};
			(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) {return;}
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/es_LA/sdk.js";
			fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
        },
        facebookLogin: function() {
        	$('#login a.login').click(function() {
				FB.login(function(response) {
					if (response.authResponse) {
						FB.api('/me', function(response) {
							if (response) {
								picture(response);
							}
						});
					} else {
						bootbox.dialog({
	                        title: '¡Atención!',
	                        message: 'El usuario canceló el inicio de sesión o no autorizó la aplicación.',
	                        buttons: {
	                            success: {
	                                label: 'Aceptar',
	                                className: 'btn-danger'
	                            }
	                        }
	                    });
					}
				},{scope:'email'});
				FB.getLoginStatus(function(response) {
					if (!response.status === 'connected') {
						FB.login();
					} 
				});
        	});
        	function picture(user) {
        		FB.getLoginStatus(function(response) {
        			if (response.status === 'connected') {
		        		FB.api('/me/picture', function(response) {
		        			if (response && response.data) {
			        			data = new Object();
								data.User = user;
								data.User.picture = response.data.url;
								$.ajax({
                                    url: App.baseUrl('users/login'),
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                    	'data': data
                                    }
                                }).always(function() {

                                }).done(function(data) {
                                    if (data.login) {
                                    	$.get('views/coachmark.html', function(data) {
										  $('#content').html(data);
										  $.vegas('destroy', 'background');
										  App.coachMark();
										});
                                    }
                                });
		        			}
							
						});
					}
				});
        	}
        },
        init: function() {
        	App.vegas();
        	App.coachMark();
        	App.facebookSDKInit();
        	App.facebookLogin();
        }
    }
}();

jQuery(document).ready(function() {
    App.init();
});