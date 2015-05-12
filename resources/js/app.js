var App = angular.module('App', ['ngRoute', 'ngCookies', 'ui.bootstrap', 'angular-jquery-validate', 'angularUtils.directives.dirPagination']);

App.baseUrl = function(url) {return 'http://oficina.vnstudios.com/dingdong/site/' + url}

App.config(function($jqueryValidateProvider, $routeProvider) {
    
    $routeProvider.when('/', {
        controller: 'UsersController',
        templateUrl: 'resources/views/login.html'
    }).when('/reseller/:resellerId/:brochureId', {
        controller: 'UsersController',
        templateUrl: 'resources/views/login.html'
    }).when('/invite/:brochureId', {
        controller: 'UsersController',
        templateUrl: 'resources/views/login.html'
    }).when('/coachmark', {
        controller: 'CoachMarkController',
        templateUrl: 'resources/views/coachmark.html'
    }).when('/brochures', {
        controller: 'BrochuresController',
        templateUrl: 'resources/views/brochures.html'
    }).when('/brochure/:brochureId', {
        controller: 'BrochureController',
        templateUrl: 'resources/views/brochure.html'
    }).when('/send-brochure', {
        controller: 'SendBrochuresController',
        templateUrl: 'resources/views/send-brochure.html'
    }).when('/cart', {
        controller: 'CartController',
        templateUrl: 'resources/views/cart.html'
    }).when('/orders-by-customers', {
        controller: 'OrdersByCustomersController',
        templateUrl: 'resources/views/orders-by-customers.html'
    }).when('/orders-by-products', {
        controller: 'OrdersByProductsController',
        templateUrl: 'resources/views/orders-by-products.html'
    }).when('/print-orders-by-customers/:parchuseDate', {
        controller: 'PrintOrdersByCustomersController',
        templateUrl: 'resources/views/print-orders-by-customers.html'
    }).when('/print-orders-by-products/:parchuseDate', {
        controller: 'PrintOrdersByProductsController',
        templateUrl: 'resources/views/print-orders-by-products.html'
    }).when('/order-history', {
        controller: 'OrderHistoryController',
        templateUrl: 'resources/views/order-history.html'
    }).otherwise({
        redirectTo: '/'
    });

    $jqueryValidateProvider.setDefaults({
        ignore: ':hidden:not(.form-control)',
        errorElement: 'span',
        errorClass: 'help-block has-error',
        errorPlacement: function(error, element) {
            if (element.parents("label").length > 0) {
                element.parents("label").after(error);
            } else {
                element.after(error);
            }
        },
        highlight: function(label) {
            $(label).closest('.form-group').removeClass('has-error has-success').addClass('has-error');
        },
        success: function(label) {
            label.addClass('valid').closest('.form-group').removeClass('has-error has-success').addClass('has-success');
        },
        onkeyup: function(element) {
            $(element).valid();
        },
        onfocusout: function(element) {
            $(element).valid();
        }
    });

    jQuery.extend(jQuery.validator.messages, {
        required: "Este campo es obligatorio.",
        remote: "Por favor, rellena este campo.",
        email: "Por favor, escribe una dirección de correo válida",
        url: "Por favor, escribe una URL válida.",
        date: "Por favor, escribe una fecha válida.",
        dateISO: "Por favor, escribe una fecha (ISO) válida.",
        number: "Por favor, escribe un número entero válido.",
        digits: "Por favor, escribe sólo dígitos.",
        creditcard: "Por favor, escribe un número de tarjeta válido.",
        equalTo: "Por favor, escribe el mismo valor de nuevo.",
        accept: "Por favor, escribe un valor con una extensión aceptada.",
        maxlength: jQuery.validator.format("Por favor, no escribas más de {0} caracteres."),
        minlength: jQuery.validator.format("Por favor, no escribas menos de {0} caracteres."),
        rangelength: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
        range: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1}."),
        max: jQuery.validator.format("Por favor, escribe un valor menor o igual a {0}."),
        min: jQuery.validator.format("Por favor, escribe un valor mayor o igual a {0}.")
    });

});

App.controller('UsersController', function($rootScope, $scope, $location, $routeParams, $http, $cookies) {

	$scope.init = function() {

		$.vegas({src:App.baseUrl('../resources/img/1.jpg')});

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

	}

	$scope.login = function() {
		FB.login(function(response) {
			if (response.authResponse) {
				FB.api('/me', function(user) {
					if (user) {
						FB.api('/me/picture', function(response) {
		        			if (response && response.data) {
			        			data = new Object();
								if ($routeParams.resellerId) {
									data.UserResellerGroup = new Object();
									data.UserResellerGroup.reseller_user_id = $routeParams.resellerId;
								}
								data.User = user;
								data.User.picture = response.data.url;
								$http({
									url: App.baseUrl('users/login'),
									method: 'POST',
									data:  $.param({'data':data}),
									headers: {'Content-Type': 'application/x-www-form-urlencoded'},
								}).success(function(data, status, headers, config) {
									if (data.login) {
										angular.forEach($cookies, function (k, v) {
										    delete $cookies[v];
										});
										if ($routeParams.brochureId) {
											$cookies.brochureReceived 	= $routeParams.brochureId;
										}
										$cookies.login 					= true;
										$cookies.firstName 				= data.User.first_name;
										$cookies.lastName 				= data.User.last_name;
										$cookies.picture 				= data.User.picture;
										$cookies.userTypeid 			= data.User.user_type_id;
										$cookies.userId 				= data.User.id;
										if (data.UserCart) {
											$cookies.cartTotalQuantity 	= data.UserCart.total_quantity;
										}
										$rootScope.User 				= $cookies;
										$scope.User 					= $cookies;
										// $location.path('/brochures');
										$location.path('/coachmark');
									}
								}).error(function(data, status, headers, config) {
									
								});
		        			}
							
						});
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
		},{scope:'email, user_friends, public_profile'});

		FB.getLoginStatus(function(response) {
			if (!response.status === 'connected') {
				FB.login();
			} 
		});

		$scope.$on('$destroy', function(e) {
	        $.vegas('destroy', 'background');
	    });
		
	}

	$scope.logout = function() {
		$http({
			url: App.baseUrl('users/logout'),
			method: 'POST',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
		}).success(function(data, status, headers, config) {
			if (data.session === false) {
				angular.forEach($cookies, function (k, v) {
				    delete $cookies[v];
				});
				$location.path('/');
			}
		}).error(function(data, status, headers, config) {
			
		});
	}

});

App.controller('CoachMarkController', function($rootScope, $scope, $location, $http, $compile) {

	$('body').css({
		'background':'rgba(0,0,0,0.9)',
		'padding-top': '0',
	});

	var steps = [];
	var stepCero = [];
	var stepOne = [];
	var stepTwo = [];
	var stepThree = [];
	var stepFour = [];

	var buttonComenzar = {
		'name' : 'Button Comenzar',
		'shape': '1',
		'w': '243.5708692247455',
		'h': '57.12624584717608',
		'x': '516.2098668754894',
		'y': '517.1428571428571',
	};
	var circleOne = {
			'name' : 'Circle One',
			'shape': '2',
			'w': '47.110415035238844',
			'h': '49.10852713178294',
			'x': '552.2944400939703',
			'y': '263.58250276854926',
	};
	var circleTwo = {
			'name' : 'Circle Two',
			'shape': '2',
			'w': '49.115113547376666',
			'h': '49.10852713178294',
			'x': '611.433046202036',
			'y': '262.5802879291251',
	};
	var circleThree	= {
			'name' : 'Circle Three',
			'shape': '2',
			'w': '46.108065779169934',
			'h': '45.09966777408638',
			'x': '676.5857478465153',
			'y': '266.5891472868217',
	};
	var buttonEnviar = {
		'name' : 'Button Enviar Pedido',
		'shape': '1',
		'w': '169.39702427564606',
		'h': '36.0797342192691',
		'x': '934.1895066562256',
		'y': '27.059800664451824',
	};
	var buttonCatalogo = {
		'name' : 'Button Ver Catálogo',
		'shape': '1',
		'w': '244.57321848081443',
		'h': '58.12846068660022',
		'x': '516.2098668754894',
		'y': '517.1428571428571',
	};

	stepCero.push(buttonComenzar);
	stepOne.push(circleOne, circleTwo, circleThree);
	stepTwo.push(circleOne, circleTwo, circleThree);
	stepThree.push(circleOne, circleTwo, circleThree, buttonEnviar);
	stepFour.push(buttonCatalogo);
	steps.push(stepCero, stepOne, stepTwo, stepThree, stepFour);


	$scope.step = function(n) {

		if (n === 5) $location.path('/brochures');

		$('#coachmark .coachmark').remove();

		var image = new Image();
		image.src = App.baseUrl('../resources/img/coachmark-' + n + '.jpg');

		$(image).load(function() {
			var element = steps[n];
			$(element).each(function(k, v) {
				rw = 1280 / $('#coachmark .item.active img').width();
			    rh = 905 / $('#coachmark .item.active img').height();
			    w = v.w / rw;
			    h = v.h / rh;
			    x = v.x / rw;
			    y = v.y / rh;
			    var link = $('<a class="coachmark" href="javascript:;"></a>').css({
			    	'position': 'absolute',
			        'width': 	w + 'px',
			        'height': 	h + 'px',
			        'left': 	x + 'px',
			        'top': 		y + 'px',
			    });
			    if (v.shape == 2) {
			        link.css({
			            'border-radius': '50%'
			        });
			    }
			    link.attr({
	                'ng-click':'slide('+(n+1)+')',
	                'data-name': v.name,
	            });
			    $('#carousel .item.active').append($compile(link)($scope));
			});
		});
	}

	$scope.slide = function(n) {
		if (n === 5) $location.path('/brochures');
		$('#coachmark .item.active').removeClass('active');
		$('#coachmark .item[data-step="'+n+'"]').addClass('active');
		$scope.step(n);
	}

	$('#carousel').on('slid.bs.carousel', function (e) {
		var $this = $(this);
		if($('.carousel-inner .item:first').hasClass('active')) {
			$this.children('.left.carousel-control').hide();
		} else if($('.carousel-inner .item:last').hasClass('active')) {
			$this.children('.right.carousel-control').hide();
		} else {
			$this.children('.carousel-control').show();
		}
		var n = $('#carousel .item.active').data('step');
		if (n === 5) $location.path('/brochures'); 
		$scope.step(n);
	});

});

App.controller('NavController', function($scope, $log) {

	$scope.status = {
		isopen: false
	}

	$scope.toggleDropdown = function($event) {
		$event.preventDefault();
		$event.stopPropagation();
		$scope.status.isopen = !$scope.status.isopen;
	}

});

App.controller('BrochuresController', function($rootScope, $scope, $location, $http, $cookies) {

	if ($cookies.brochureReceived) {
		var brochureId = $cookies.brochureReceived;
		delete $cookies.brochureReceived;
		return $location.path('/brochure/' + brochureId);
	}

	$('body').css({
		'background':'#fff',
		'padding-top': '94px',
	});
	
	$rootScope.User = $cookies;
	$scope.User 	= $cookies;

	$http({
		url: App.baseUrl('campaigns'),
		method: 'GET',
		headers: {'Content-Type': 'application/x-www-form-urlencoded'},
	}).success(function(data, status, headers, config) {
		$scope.Campaigns = data;
	}).error(function(data, status, headers, config) {
		
	});

});

App.controller('BrochureController', function($rootScope, $scope, $location, $http, $cookies, $routeParams, $timeout, $compile) {

	$rootScope.User = $cookies;
	$scope.User 	= $cookies;

	$http({
		url: App.baseUrl('shop_brochures/read/' + $routeParams.brochureId),
		method: 'GET',
		headers: {'Content-Type': 'application/x-www-form-urlencoded'},
	}).success(function(data, status, headers, config) {
		$scope.Brochure = data;
		$scope.CountPages = (Object.keys(data.ShopBrochureImage).length - 1) * 2;
		$timeout(function() {
			_productsMarkedArea();
			resizePagination();
			$('.carousel-indicators li').sortable({
                cursor: 'move',
                connectWith: '.carousel-indicators li',
                containment: '.carousel-indicators',
                distance: 0,
                revert: false,
                update: function(event, ui) {
                    $(ui.item[0]).parent().trigger('click');
                	$('.pag-n').remove();
                	var page = ($(ui.item[0]).parent()[0].dataset.page) * 2;
                	page = page - 1 + '-' + page;
                	$(ui.item[0]).append('<span class="pag-n">PAGE '+ page +'</span>');
                },
                over: function( event, ui ) {
                }
            });
		}, 1000);
	}).error(function(data, status, headers, config) {
		
	});

	resizePagination = function() {
		$('.carousel-indicators').width('');
		var tw = $('.carousel-indicators').width();
		var c  = $('.carousel-indicators li').length;
		var uw = parseInt(tw / c); 
		var nw = uw * c; 
		$('.carousel-indicators li').width(uw);
		$('.carousel-indicators li div.pag').width(uw);
		$('.carousel-indicators').width(nw);
	}

	$(window).resize(function() {
		resizePagination();
	});
	
	$('#carousel').on('slid.bs.carousel', function (e) {
		_productsMarkedArea();
	});

	_productsMarkedArea = function() {
		$image               = $('#carousel .item.active img')[0];
        $imageNaturalWidth   = $image.naturalWidth;
        $imageNaturalHeight  = $image.naturalHeight;
        $imageclientWidth    = $image.clientWidth;
        $imageclientHeight   = $image.clientHeight;
		$http({
			url: App.baseUrl('shop_brochures/read_products/' + $('#carousel .item.active').data('id')),
			method: 'GET',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
		}).success(function(data, status, headers, config) {
			$('.area-product').remove();
                $(data).each(function() {
                rw = $imageNaturalWidth / $imageclientWidth;
                rh = $imageNaturalHeight / $imageclientHeight;
                this.ShopBrochureProduct.coords.w = this.ShopBrochureProduct.coords.w / rw;
                this.ShopBrochureProduct.coords.h = this.ShopBrochureProduct.coords.h / rh;
                this.ShopBrochureProduct.coords.x = this.ShopBrochureProduct.coords.x / rw;
                this.ShopBrochureProduct.coords.y = this.ShopBrochureProduct.coords.y / rh;
                var link = $('<a href="javascript:;" class="area-product"></a>').css({
                    'width': this.ShopBrochureProduct.coords.w + 'px',
                    'height': this.ShopBrochureProduct.coords.h + 'px',
                    'left': this.ShopBrochureProduct.coords.x + 'px',
                    'top': this.ShopBrochureProduct.coords.y + 'px',
                    'transform': 'rotate('+this.ShopBrochureProduct.coords.angle+'deg)'
                });
                if (this.ShopBrochureProduct.coords.shape == 2) {
                    link.css({
                        'border-radius': '50%'
                    });
                }
                link.attr({
                	'ng-controller': 'CartController',
                    'ng-click': 'add("'+this.ShopBrochureProduct.id+'")',
                });
                $('#carousel .item.active').append($compile(link)($scope));

            });
		}).error(function(data, status, headers, config) {
			
		});
	}

	$scope.zoom = function(z) {
		var canvasWidth = $('#carousel .item.active').parent().width();
		var canvasHeight = $('#carousel .item.active').parent().height();
		var zoom = parseFloat($('#carousel .item.active').css('zoom'));
		$('#carousel .item.active').parent().css('height', canvasHeight);
		$('#carousel .item.active img').css('max-width', 'inherit');
		$('#carousel .item.active').draggable({
			cursor: 'crosshair',
		});
		if (z == 'in') {
			$('#carousel .item.active').draggable('enable');
			zoom = (zoom + parseFloat(0.01)).toFixed(2);
		} else {
			zoom = (zoom - parseFloat(0.01)).toFixed(2);
		}
		$('#carousel .item.active').css('zoom', zoom);
		if (parseInt(zoom) == 0) {
			$('#carousel .item.active').css('zoom', 1);
			$('#carousel .item.active').draggable('disable');
		}
	}

});

App.controller('CartController', function($rootScope, $scope, $location, $http, $cookies, $routeParams, $modal) {

	$scope.init = function() {
		
		$rootScope.User = $cookies;
		$scope.User 	= $cookies;

		$('body').css({
			'background':'#eaeaea',
			'padding-top': '94px',
		});

		$http({
			url: App.baseUrl('shop_brochures/cart'),
			method: 'GET',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
		}).success(function(data, status, headers, config) {
			if (data && data.result && data.result === true) {
				$cookies.cartTotalQuantity = data.total_quantity;
				$rootScope.cartTotalQuantity = $cookies.cartTotalQuantity;
				$scope.UserCartDeteail = data.UserCartDeteail;
				$scope.Reseller = data.Reseller;
			} else {
				$cookies.cartTotalQuantity = 0;
				$rootScope.cartTotalQuantity = $cookies.cartTotalQuantity;
				$scope.UserCartDeteail = {};
			}
		}).error(function(data, status, headers, config) {
			
		});
	}

	$scope.add = function(product_id) {
		if ($cookies.user_type_id == 3) {
			bootbox.dialog({
                title: '¡Atención!',
                message: 'Para realizar tu pedido, solicitá a una revendedora que te envie los catalogos.',
                buttons: {
                    success: {
                        label: 'Aceptar',
                        className: 'btn-danger'
                    }
                }
            });
		} else {
			data = new Object();
			data.UserCartDeteail = new Object();
			data.UserCartDeteail.product_id = product_id;
			$http({
				url: App.baseUrl('shop_brochures/cart'),
				method: 'POST',
				data:  $.param({'data':data}),
				headers: {'Content-Type': 'application/x-www-form-urlencoded'},
			}).success(function(data, status, headers, config) {
				if (data && data.result && data.result === true) {
					$cookies.cartTotalQuantity = data.UserCart.total_quantity;
					$scope.User = $cookies;
					$rootScope.User = $cookies;
					var modalInstance = $modal.open({
					  	templateUrl: 'resources/views/add-product.html',
						controller: function ($scope, $modalInstance) {
							$scope.cancel = function () {
								$modalInstance.dismiss('cancel');
							}
							$scope.sendCart = function () {
								$modalInstance.dismiss('cancel');
								$location.path('/cart');
							}
						},
						scope: $scope,
					  	size: 'lg',
					});
				}
			}).error(function(data, status, headers, config) {});
		}
	} 

	$scope.remove = function(id) {
		$http({
			url: App.baseUrl('shop_brochures/delete_product'),
			method: 'POST',
			data:  $.param({'data':{'id':id}}),
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
		}).success(function(data, status, headers, config) {
			if (data && data.result && data.result === true) {
				$cookies.cartTotalQuantity = data.total_quantity;
				$rootScope.cartTotalQuantity = $cookies.cartTotalQuantity;
				$scope.UserCartDeteail = data.UserCartDeteail;
				$scope.Reseller = data.Reseller;
			}
		}).error(function(data, status, headers, config) {
			
		});
	}

	$scope.asd = function(id) {
		console.log(id);
		console.log('quantity');
		return;
		$http({
			url: App.baseUrl('shop_brochures/delete_product'),
			method: 'POST',
			data:  $.param({'data':{'id':id}}),
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
		}).success(function(data, status, headers, config) {
			if (data && data.result && data.result === true) {
				$cookies.cartTotalQuantity = data.total_quantity;
				$rootScope.cartTotalQuantity = $cookies.cartTotalQuantity;
				$scope.UserCartDeteail = data.UserCartDeteail;
				$scope.Reseller = data.Reseller;

			}
		}).error(function(data, status, headers, config) {
			
		});
	}

	$scope.selectReseller = function($event) {
		var element = $($event.target)[0];
		if ($('.select-reseller ul').height() > '55') {
			$('.select-reseller ul').height('55');
			$('.select-reseller ul i.icn').after($(element));
		} else {
			$('.select-reseller ul').height('auto');
		}
	}

	$scope.send = function() {
		if ($location.path() == '/cart') {
			if ($cookies.userTypeid == 1) {
				var resellerId = $cookies.userId;
			} else {
				var resellerId = $('.select-reseller ul:first-child li').data('value');
			}
			data = new Object();
			data.UserCart = new Object();
			data.UserCart.reseller_user_id = resellerId;
			$http({
				url: App.baseUrl('shop_brochures/send_cart'),
				method: 'POST',
				data:  $.param({'data':data}),
				headers: {'Content-Type': 'application/x-www-form-urlencoded'},
			}).success(function(data, status, headers, config) {
				if (data && data.result && data.result === true) {
					console.log(data);
					$cookies.cartTotalQuantity = 0;
					$rootScope.cartTotalQuantity = $cookies.cartTotalQuantity;
					angular.forEach($scope.UserCartDeteail, function (k, v) {
					    delete $scope.UserCartDeteail[v];
					});
					if ($cookies.userTypeid == 1) {
						bootbox.dialog({
						    title: '¡Atención!',
						    message: 'Ha cerrado su pedido.',
						    buttons: {
						        success: {
						            label: 'Aceptar',
						            className: 'btn-danger'
						        }
						    }
						});
					} else {
						bootbox.dialog({
						    title: '¡Atención!',
						    message: 'Su pedido ha sido enviado a la revendedora seleccionada.',
						    buttons: {
						        success: {
						            label: 'Aceptar',
						            className: 'btn-danger'
						        }
						    }
						});
					}
				} else {
					bootbox.dialog({
	                    title: '¡Atención!',
	                    message: 'Su pedido no pudo ser enviado enviado, por favor, intente nuevamente.',
	                    buttons: {
	                        success: {
	                            label: 'Aceptar',
	                            className: 'btn-danger'
	                        }
	                    }
	                });
				}
			}).error(function(data, status, headers, config) {
			});
		} else {
			$location.path('/cart')
		}
	}

});

App.controller('SendBrochuresController', function($rootScope, $scope, $location, $http, $cookies, $timeout) {

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

	$timeout(function() {
		FB.api('/me/friends/', {fields:'picture, name', limit: 10000},function(response) {
			$scope.Friends = response.data;
			$scope.$apply();
		});
	}, 2000);

	$('body').css({
		'background':'#eaeaea',
		'padding-top': '94px',
	});
	
	$rootScope.User = $cookies;
	$scope.User 	= $cookies;

	$http({
		url: App.baseUrl('campaigns'),
		method: 'GET',
		headers: {'Content-Type': 'application/x-www-form-urlencoded'},
	}).success(function(data, status, headers, config) {
		$brochures = [];
		angular.forEach(data, function(v, k) {
			angular.forEach(v, function(v2, k2) {
				if (k2 == 'CampaignShopBrochure') {
					angular.forEach(v2, function(v3, k3) {
				  		$brochures.push({'Brochures':v3, 'Campaigns':v});
					});
				}
			});
		});
		$scope.Brochures = $brochures;
	}).error(function(data, status, headers, config) {
		
	});

	$scope.selectBrochure = function($event) {
		var optionSelected = $event.currentTarget;
		if ($('.select-brochure ul').height() > '55') {
			$('.select-brochure ul').height('55');
			$('.select-brochure ul i.icn').after(optionSelected);
		} else {
			$('.select-brochure ul').height('auto');
		}
	}
	$scope.select = function(select) {
		$('input[type=checkbox]').each(function() {
			if (select == 'select') {
				$(this).prop('checked', true);
			} else {
				$(this).prop('checked', false);
			}
		});
	}
	$scope.sendInvite = function() {
		var brochureId = $('.select-brochure ul:first-child li').data('value');
		console.log($location.absUrl().replace('send-brochure', 'invite/' + brochureId));
		if ($cookies.userTypeid == 1) {
			FB.ui({
			    method: 'send',
			    link: $location.absUrl().replace('send-brochure', 'reseller/' + $cookies.userId + '/' +brochureId),
			},
			function(response) {
				if (response) {
					bootbox.dialog({
	                    title: '¡Atención!',
	                    message: 'Su invitación ha sido enviada.',
	                    buttons: {
	                        success: {
	                            label: 'Aceptar',
	                            className: 'btn-danger'
	                        }
	                    }
	                });
				}
			});
		} else {
			FB.ui({
			    method: 'send',
			    link: $location.absUrl().replace('send-brochure', 'invite/' + brochureId),
			},
			function(response) {
				if (response) {
					bootbox.dialog({
	                    title: '¡Atención!',
	                    message: 'Su invitación ha sido enviada.',
	                    buttons: {
	                        success: {
	                            label: 'Aceptar',
	                            className: 'btn-danger'
	                        }
	                    }
	                });
				}
			});
		}
	}
	$scope.send = function() {
		$http({
			url: 'https://graph.facebook.com/notifications?access_token=355642887970474%7Ca9a19bf01081faf33a49eb07a190b071=&href=&template=',
			method: 'GET',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
		}).success(function(data, status, headers, config) {
			console.log(data);
		}).error(function(data, status, headers, config) {
			
		});
	}

});

App.controller('ResellerController', function($rootScope, $scope, $location, $http, $modal) {

	$scope.reseller = function() {

		var modalInstance = $modal.open({
		  	templateUrl: 'resources/views/reseller.html',
			controller: ModalInstanceCtrl,
			scope: $scope,
		  	size: 'lg',
		});
	}

	var ModalInstanceCtrl = function ($scope, $modalInstance) {
		$scope.cancel = function () {
			$modalInstance.dismiss('cancel');
		}
	}

	$scope.signUp = function() {
		if ($('#reseller-form').valid()) {
			data = new Object();
			data.User = new Object();
			data.User.user_type_id = 1;
			data.User.city = $('#reseller-form input[name=city]').val();
			data.User.zone = $('#reseller-form input[name=code]').val();
			$http({
				url: App.baseUrl('users/user_type'),
				method: 'POST',
				data:  $.param({'data':data}),
				headers: {'Content-Type': 'application/x-www-form-urlencoded'},
			}).success(function(data, status, headers, config) {
				if (data && data.result && data.result === true) {
					$scope.cancel();
					$scope.User.userTypeid = 1;
					$rootScope.User.userTypeid = 1;
				}
			}).error(function(data, status, headers, config) {
				
			});
		}
	}

});

App.controller('OrdersByCustomersController', function($rootScope, $scope, $location, $http, $cookies, $timeout) {

	$rootScope.User = $cookies;
	$scope.User 	= $cookies;

	$('body').css({
		'background':'#eaeaea',
		'padding-top': '94px',
	});

	$http({
		url: App.baseUrl('users/orders_by_customers'),
		method: 'GET',
		headers: {'Content-Type': 'application/x-www-form-urlencoded'},
	}).success(function(data, status, headers, config) {
		$scope.UserCart = data.UserCart;
		$scope.UserCart.TotalQuantity = data.total_quantity;
		$rootScope.UserCart.TotalQuantity = data.total_quantity;
	}).error(function(data, status, headers, config) {
		
	});

	$scope.close = function(id) {
		$http({
			url: App.baseUrl('users/close_order'),
			method: 'POST',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
		}).success(function(data, status, headers, config) {
			$scope.UserCart = data.UserCart;
			$scope.UserCart.TotalQuantity = data.total_quantity;
			$rootScope.UserCart.TotalQuantity = data.total_quantity;
		}).error(function(data, status, headers, config) {
			
		});
	}

});

App.controller('PrintOrdersByCustomersController', function($rootScope, $scope, $location, $routeParams, $http, $cookies, $timeout) {

	$scope.init = function() {
		$('body').css({
			'background':'#fff',
			'padding-top': '0',
		});
		console.log($routeParams.parchuseDate);
		$http({
			url: App.baseUrl('users/orders_by_customers/' + $routeParams.parchuseDate),
			method: 'GET',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
		}).success(function(data, status, headers, config) {
			// if (data && data.result && data.result === true) {
				console.log(data);
				// $cookies.cartTotalQuantity = data.total_quantity;
				// $rootScope.cartTotalQuantity = $cookies.cartTotalQuantity;
				// $scope.UserCartDeteail = data.UserCartDeteail;
				// $scope.Reseller = data.Reseller;
				$scope.UserCart = data.UserCart;
				$scope.UserCart.parchuse_date = data.parchuse_date;
				$scope.UserCart.total_quantity = data.total_quantity;
				$scope.UserCart.customers = data.customers;
			// }
		}).error(function(data, status, headers, config) {
			
		});
	}

});

App.controller('PrintOrdersByProductsController', function($rootScope, $scope, $location, $routeParams, $http, $cookies, $timeout) {

	$scope.init = function() {
		$('body').css({
			'background':'#fff',
			'padding-top': '0',
		});
		console.log($routeParams.parchuseDate);
		$http({
			url: App.baseUrl('users/orders_by_products/' + $routeParams.parchuseDate),
			method: 'GET',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
		}).success(function(data, status, headers, config) {
			// if (data && data.result && data.result === true) {
				console.log(data);
				// $cookies.cartTotalQuantity = data.total_quantity;
				// $rootScope.cartTotalQuantity = $cookies.cartTotalQuantity;
				// $scope.UserCartDeteail = data.UserCartDeteail;
				// $scope.Reseller = data.Reseller;
				// $scope.UserCart = data.UserCart;
				// $scope.UserCart.parchuse_date = data.parchuse_date;
				// $scope.UserCart.total_quantity = data.total_quantity;
				// $scope.UserCart.customers = data.customers;
			// }
		}).error(function(data, status, headers, config) {
			
		});
	}

});

App.controller('OrdersByProductsController', function($rootScope, $scope, $location, $http, $cookies, $timeout) {

	$rootScope.User = $cookies;
	$scope.User 	= $cookies;

	$('body').css({
		'background':'#eaeaea',
		'padding-top': '94px',
	});

	$http({
		url: App.baseUrl('users/orders_by_products'),
		method: 'GET',
		headers: {'Content-Type': 'application/x-www-form-urlencoded'},
	}).success(function(data, status, headers, config) {
		$scope.ShopBrochure = data.ShopBrochure;
		$scope.Order = {};
		$scope.Order.TotalQuantity = data.total_quantity;
	}).error(function(data, status, headers, config) {
		
	});

	$scope.close = function(id) {
		$http({
			url: App.baseUrl('users/close_order'),
			method: 'POST',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
		}).success(function(data, status, headers, config) {
			$scope.ShopBrochure = data.ShopBrochure;
			$scope.Order = {};
			$scope.Order.TotalQuantity = data.total_quantity;
		}).error(function(data, status, headers, config) {});
	}

});

App.controller('OrderHistoryController', function($rootScope, $scope, $location, $http, $cookies, $timeout) {

	$('body').css({
		'background':'#eaeaea',
		'padding-top': '94px',
	});

	$rootScope.User 	= $cookies;
	$scope.User 		= $cookies;
	$scope.currentPage 	= 1;
	$scope.pageSize 	= 2;
	$scope.Orders 		= [];

	$http({
		url: App.baseUrl('users/order_history'),
		method: 'GET',
		headers: {'Content-Type': 'application/x-www-form-urlencoded'},
	}).success(function(data, status, headers, config) {
			$scope.Orders = data;
	}).error(function(data, status, headers, config) {
		
	});

});