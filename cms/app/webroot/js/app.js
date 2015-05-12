var App = function() {
    $brochureId = null;
    $productId = null;
    $imageId = null;
    $offerId = null;
    $coords = null;
    $shape = null;
    $angle = 0;
    return {
        baseUrl: function(url) {
            return 'http://oficina.vnstudios.com/dingdong/cms/' + url;
        },
        uriSegment: function(n) {
            segment = window.location.pathname.split('/');
            return segment[n];
        },
        validatorTranslate: function() {
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
        },
        breadcrumbsDisableLast: function() {
            $('.breadcrumbs .last a').click(function(e) {
                e.preventDefault();
            });
        },
        alertDelete: function() {
            $(document).on('click', 'a.delete', function(e) {
                var link = $(this).attr('href');
                e.preventDefault();
                bootbox.dialog({
                    message: "¿Desea eliminar el registro de forma permanente?",
                    title: "¡Atención!",
                    buttons: {
                        success: {
                            label: "Aceptar",
                            className: "btn btn-primary",
                            callback: function() {
                                window.location.href = link;
                            }
                        },
                        danger: {
                            label: "Cancelar",
                            className: "btn"
                        }
                    }
                });
            });
        },
        categoriesSort: function() {
            $('#sortable ul').sortable({
                cursor: 'move',
                connectWith: '#sortable ul',
                placeholder: 'widget-placeholder',
                distance: 5,
                revert: true,
                update: function(event, ui) {
                    $('sortable ul')
                    var order = $(this).sortable('toArray').toString();
                    var _parent = Number(ui.item[0].parentElement.id);
                    var id = ui.item[0].id;
                    if (!isNaN(_parent)) {
                        parent_category_id = _parent;
                    }
                    $.post(App.baseUrl('categories/update_order'), {
                        'id': id,
                        'parent_category_id': parent_category_id,
                        'order': order
                    }).done(function(data) {});
                }
            });
        },
        CategoryDialog: function() {
            $(document).on('click', 'a.dialog', function() {
                var url = $(this).data('url');
                var title = $(this).data('original-title');
                var id = $(this).data('id');
                $.get(App.baseUrl(url), function(data) {
                    bootbox.dialog({
                        title: title,
                        message: data,
                        buttons: {
                            success: {
                                label: "Guardar",
                                className: "btn-primary",
                                callback: function() {
                                    App.formValidation();
                                    if ($('.bootbox form').valid()) {
                                        $('.modal-footer .btn-primary').addClass('disabled');
                                        var data = $('.bootbox form').serializeArray();
                                        data.splice(0, 1);
                                        data.push({
                                            "name": "data[Category][parent_category_id]",
                                            "value": id
                                        });
                                        $.post(App.baseUrl(url), data).done(function(data) {
                                            $('#sortable').html(data);
                                            App.categoriesSort();
                                            bootbox.hideAll();
                                        });
                                    }
                                    return false;
                                }
                            },
                            danger: {
                                label: "Cancelar",
                                className: "btn"
                            }
                        }
                    });
                });
            });
        },
        ShopBrochureImage: function() {
            if ($('#fileupload').length) {
                $(function() {
                    'use strict';
                    $('#fileupload').fileupload({
                        url: App.baseUrl('shop_brochures/files/' + $('#ShopBrochureId').val())
                    });
                    $('#fileupload').fileupload(
                        'option',
                        'redirect',
                        window.location.href.replace(
                            /\/[^\/]*$/,
                            '/cors/result.html?%s'
                        )
                    );
                    $('#fileupload').addClass('fileupload-processing');
                    $.ajax({
                        url: $('#fileupload').fileupload('option', 'url'),
                        type: 'GET',
                        dataType: 'json',
                        context: $('#fileupload')[0]
                    }).always(function() {
                        $(this).removeClass('fileupload-processing');
                    }).done(function(result) {
                        $(this).fileupload('option', 'done').call(this, $.Event('done'), {
                            result: result
                        });
                    });
                });
                
                if ($('#ShopBrochureId').length) {
                    $brochureId = $('#ShopBrochureId').val();
                }

                $(document).on('click', 'a.create-product', function() {
                    if (!$('.crop').hasClass('active') || $('.ord-n').parent().css('display') == 'none') {
                        bootbox.alert('Seleccione un área para asociar al producto.');
                        return false;
                    } else {
                        var brochureId = {
                            'name': 'data[ShopBrochureProduct][shop_brochure_id]',
                            'value': $brochureId
                        };
                        var id = {
                            'name': 'data[ShopBrochureProduct][shop_brochure_image_id]',
                            'value': $imageId
                        };
                        var shape = {
                            'name': 'data[ShopBrochureProduct][coords][shape]',
                            'value': $shape
                        };
                        var angle = {
                            'name': 'data[ShopBrochureProduct][coords][angle]',
                            'value': $angle
                        };
                        var h = {
                            'name': 'data[ShopBrochureProduct][coords][h]',
                            'value': $coords.h
                        };
                        var w = {
                            'name': 'data[ShopBrochureProduct][coords][w]',
                            'value': $coords.w
                        };
                        var x = {
                            'name': 'data[ShopBrochureProduct][coords][x]',
                            'value': $coords.x
                        };
                        var x2 = {
                            'name': 'data[ShopBrochureProduct][coords][x2]',
                            'value': $coords.x2
                        };
                        var y = {
                            'name': 'data[ShopBrochureProduct][coords][y]',
                            'value': $coords.y
                        };
                        var y2 = {
                            'name': 'data[ShopBrochureProduct][coords][y2]',
                            'value': $coords.y2
                        };
                    }
                    var url = 'shop_brochures/create_product';
                    var title = 'Agregar Producto';
                    $.get(App.baseUrl(url), function(data) {
                        bootbox.dialog({
                            title: title,
                            message: data,
                            buttons: {
                                success: {
                                    label: "Guardar",
                                    className: "btn-primary",
                                    callback: function() {
                                        App.formWizard();
                                        App.formValidation();
                                        if ($('.bootbox form').valid()) {
                                            var data = $('.bootbox form').serializeArray();
                                            data.splice(0, 1);
                                            data.push(brochureId);
                                            data.push(id);
                                            data.push(shape);
                                            data.push(angle);
                                            data.push(w);
                                            data.push(h);
                                            data.push(x);
                                            data.push(x2);
                                            data.push(y);
                                            data.push(y2);
                                            $.post(App.baseUrl(url), data).done(function(data) {
                                                bootbox.hideAll();
                                                Jcrop.release();
                                                App.productsMarkedArea($imageId);
                                            });
                                        }
                                        return false;
                                    }
                                },
                                danger: {
                                    label: "Cancelar",
                                    className: "btn"
                                }
                            }
                        });
                        var $eventSelect = $('#ShopBrochureProductProductId').select2({
                            language: 'es'
                        });
                        $eventSelect.on('change', function(e) {
                            if (e.val) {
                                $.ajax({
                                    url: App.baseUrl('shop_brochures/read_product/' + e.val),
                                    type: 'GET',
                                    dataType: 'json',
                                }).always(function() {}).done(function(data) {
                                    $('#ShopBrochureProductPrice').val('');
                                    $('#ShopBrochureProductCode').val('');
                                    if (data && data.Product) {
                                        if (data.Product.price) {
                                            $('#ShopBrochureProductPrice').val(data.Product.price);
                                        }
                                        if (data.Product.code) {
                                            $('#ShopBrochureProductCode').val(data.Product.code);
                                        }
                                    }
                                });
                            }
                        });

                    });
                });

                $(document).on('click', 'a.update-product', function() {
                    if ($('.area-product.selected').length) {
                        var url = 'shop_brochures/update_product/' + $productId;
                        var title = 'Actualizar Producto';
                        $.get(App.baseUrl(url), function(data) {
                            bootbox.dialog({
                                title: title,
                                message: data,
                                buttons: {
                                    success: {
                                        label: "Guardar",
                                        className: "btn-primary",
                                        callback: function() {
                                            App.formWizard();
                                            App.formValidation();
                                            if ($('.bootbox form').valid()) {
                                                var data = $('.bootbox form').serializeArray();
                                                data.splice(0, 1);
                                                data.push({
                                                    'name': 'data[ShopBrochureProduct][shop_brochure_image_id]',
                                                    'value': $imageId
                                                });
                                                $.post(App.baseUrl(url), data).done(function(data) {
                                                    bootbox.hideAll();
                                                });
                                            }
                                            return false;
                                        }
                                    },
                                    danger: {
                                        label: "Cancelar",
                                        className: "btn"
                                    }
                                }
                            });
                            var $eventSelect = $('#ShopBrochureProductProductId').select2({
                                language: 'es'
                            });
                            $eventSelect.on('change', function(e) {
                                if (e.val) {
                                    $.ajax({
                                        url: App.baseUrl('shop_brochures/read_product/' + e.val),
                                        type: 'GET',
                                        dataType: 'json',
                                    }).always(function() {}).done(function(data) {
                                        $('#ShopBrochureProductPrice').val('');
                                        $('#ShopBrochureProductCode').val('');
                                        if (data && data.Product) {
                                            if (data.Product.price) {
                                                $('#ShopBrochureProductPrice').val(data.Product.price);
                                            }
                                            if (data.Product.code) {
                                                $('#ShopBrochureProductCode').val(data.Product.code);
                                            }
                                        }
                                    });
                                }
                            });

                        });
                    } else {
                        bootbox.alert('Seleccione Producto');
                    }
                });

                $('.fancybox').fancybox({
                    margin: [20, 60, 20, 60],
                    padding: 0,
                    openEffect: 'elastic',
                    closeEffect: 'elastic',
                    nextEffect: 'fade',
                    prevEffect: 'fade',
                    openOpacity: true,
                    openSpeed: 500,
                    closeSpeed: 250,
                    autoResize: false,
                    fitToView: true,
                    helpers: {
                        overlay: {
                            closeClick: false
                        },
                        thumbs: {
                            width: 50,
                            height: 50
                        }
                    },
                    beforeLoad: function() {},
                    beforeShow: function() {
                        if (!$('.create-product').length) {
                            $('.fancybox-overlay').append('<div class="actions"></div>');
                            $('.fancybox-overlay .actions').append('<a class="btn crop"><i class="glyphicon-crop"></i> Marcar Área</a>');
                            $('.fancybox-overlay .actions').append('<div class="btn-group clearfix" data-toggle="buttons"><label class="btn shape-square active"><input type="radio" name="options" id="option1" autocomplete="off" checked><i class="glyphicon-vector_path_square"></i></label><label class="btn shape-circle"><input type="radio" name="options" id="option2" autocomplete="off"><i class="glyphicon-vector_path_circle"></i></label></div>');
                            $('.fancybox-overlay .actions').append('<div class="btn-group clearfix"><a href="javascript:;" class="btn rotate-right"><i class="fa fa-repeat"></i></a><a href="javascript:;" class="btn rotate-left"><i class="fa fa-undo"></i></a></div>');
                            $('.fancybox-overlay .actions').append('<a class="btn btn-success create-product"><i class="glyphicon glyphicon-circle_plus"></i> Cargar</a>');
                        }
                    },
                    afterShow: function() {
                        $image               = $('.fancybox-image');
                        $imageNaturalWidth   = $image[0].naturalWidth;
                        $imageNaturalHeight  = $image[0].naturalHeight;
                        $imageclientWidth    = $image[0].clientWidth;
                        $imageclientHeight   = $image[0].clientHeight;
                        $('.crop').removeClass('active');
                        $('.update-product').remove();
                        $('.delete-product').remove();
                        $imageId = $(this.element).parent().parent().parent()[0].id;
                        App.productsMarkedArea($imageId);
                    },
                    beforeClose: function() {}
                });
                $(document).on('click', '.area-product', function() {
                    $('.area-product').removeClass('selected');
                    $(this).addClass('selected');
                    if (!$('.update-product').length) {
                        $('.fancybox-overlay .actions').append('<a class="btn btn-primary update-product"><i class="glyphicon-edit"></i> Editar</a>');
                    }
                    if (!$('.delete-product').length) {
                        $('.fancybox-overlay .actions').append('<a class="btn btn-danger delete-product"><i class="glyphicon glyphicon-delete"></i> Eliminar</a>');
                    }
                    $productId = $(this).data('id');
                });
                $(document).on('click', '.delete-product', function() {
                    if ($('.area-product.selected').length) {
                        $.ajax({
                            url: App.baseUrl('shop_brochures/delete_product/' + $productId),
                            type: 'POST',
                            dataType: 'json',
                        }).done(function(data) {
                            if (data.result) {
                                $('.update-product').remove();
                                $('.delete-product').remove();
                                $('.area-product[data-id="' + $productId + '"]').remove();
                            }
                            if (data.message) {
                                bootbox.alert(data.message);
                            }
                        }).fail(function(e) {
                            bootbox.alert('Error' + e);
                        });
                    } else {
                        bootbox.alert('Seleccione Producto');
                    }
                });
            }
        },
        assignCategory: function() {
            $('.assign-category').click(function() {
                var url = 'categories/read';
                var title = 'Asignar Categoría';
                $.get(App.baseUrl(url), function(data) {
                    bootbox.dialog({
                        title: title,
                        message: data,
                        buttons: {
                            success: {
                                label: "Guardar",
                                className: "btn-primary hidden",
                                callback: function() {
                                    return false;
                                }
                            },
                            danger: {
                                label: "Cancelar",
                                className: "btn"
                            }
                        }
                    });
                });
            });

            $(document).on('click', '.selectable a', function() {
                var id = $(this).parent()[0].id;
                $('#ProductCategoryId').val(id);
                $.get(App.baseUrl('categories/read_parents/' + id), function(data) {
                    $('#ProductCategoryName').val(data);
                    bootbox.hideAll();
                });

            });

        },
        crop: function() {
            $(document).on('click', '.shape-square', function() {
                $('.ord-nw.jcrop-handle, .ord-ne.jcrop-handle, .ord-se.jcrop-handle, .ord-sw.jcrop-handle').css({
                    'display': 'block'
                });
                $('.jcrop-holder div:nth-child(1)').css({
                    'border-radius': '0'
                });
                $shape = 1;
            });
            $(document).on('click', '.shape-circle', function() {
                $('.ord-nw.jcrop-handle, .ord-ne.jcrop-handle, .ord-se.jcrop-handle, .ord-sw.jcrop-handle').css({
                    'display': 'none'
                });
                $('.jcrop-holder div:nth-child(1)').css({
                    'border-radius': '50%'
                });
                $shape = 2;
            });

            $(document).on('click', '.rotate-left', function() {
                $angle = $angle + 2;
                if ($angle <= 90) {
                    $('.jcrop-holder').children().eq(0).css({
                        'transform': 'rotate('+$angle+'deg)'
                    });
                    $('.jcrop-holder').children().eq(0).attr('id', 'angle');
                    var el = document.getElementById('angle');
                    var st = window.getComputedStyle(el, null);
                    var tr = st.getPropertyValue("-webkit-transform") ||
                             st.getPropertyValue("-moz-transform") ||
                             st.getPropertyValue("-ms-transform") ||
                             st.getPropertyValue("-o-transform") ||
                             st.getPropertyValue("transform") ||
                             "Either no transform set, or browser doesn't do getComputedStyle";
                        var values = tr.split('(')[1],
                            values = values.split(')')[0],
                            values = values.split(',');
                        var a = values[0];
                        var b = values[1];
                        var c = values[2];
                        var d = values[3];
                        var angle = Math.round(Math.asin(b) * (180/Math.PI));
                        $angle = angle;
                        $('.jcrop-holder').children().eq(0).css({
                            'border': '1px solid #fff'
                        });
                        $('.jcrop-holder div img').css({
                            'display':'none'
                        });
                }
            });
            $(document).on('click', '.rotate-right', function() {
                $angle = $angle - 2;
                if ($angle >= -90) {
                    $('.jcrop-holder').children().eq(0).css({
                        'transform': 'rotate('+$angle+'deg)'
                    });
                    $('.jcrop-holder').children().eq(0).attr('id', 'angle');
                    var el = document.getElementById('angle');
                    var st = window.getComputedStyle(el, null);
                    var tr = st.getPropertyValue("-webkit-transform") ||
                             st.getPropertyValue("-moz-transform") ||
                             st.getPropertyValue("-ms-transform") ||
                             st.getPropertyValue("-o-transform") ||
                             st.getPropertyValue("transform") ||
                             "Either no transform set, or browser doesn't do getComputedStyle";
                        var values = tr.split('(')[1],
                            values = values.split(')')[0],
                            values = values.split(',');
                        var a = values[0];
                        var b = values[1];
                        var c = values[2];
                        var d = values[3];
                        var angle = Math.round(Math.asin(b) * (180/Math.PI));
                        $angle = angle;
                        $('.jcrop-holder').children().eq(0).css({
                            'border': '1px solid #fff'
                        });
                        $('.jcrop-holder div img').css({
                            'display':'none'
                        });
                }
            });

            $(document).on('click', '.crop', function() {
                $angle = 0;
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                    Jcrop.destroy();
                    Jcrop.release();
                } else {
                    $(this).addClass('active');
                    $('.fancybox-image').Jcrop({
                        boxWidth: $('.fancybox-image').width(),
                        boxHeight: $('.fancybox-image').height(),
                        trueSize: [$imageNaturalWidth, $imageNaturalHeight],
                        keySupport: false,
                        onSelect: function(coords) {
                            $coords = coords;
                        }
                    }, function() {
                        Jcrop = this;
                        // Jcrop.release();
                        // Jcrop.disable();
                        // Jcrop.enable();
                        // Jcrop.destroy();
                    });
                    if ($('.shape-square').hasClass('active')) {
                        $('.shape-square').trigger('click');
                        $shape = 1;
                    }
                    if ($('.shape-circle').hasClass('active')) {
                        $('.shape-circle').trigger('click');
                        $shape = 2;
                    }
                }
            });
        },
        productsMarkedArea: function($imageId) {
            $.ajax({
                url: App.baseUrl('shop_brochures/read_products/' + $imageId),
                type: 'POST',
                dataType: 'json',
            }).done(function(data) {
                $('.update-product').remove();
                $('.delete-product').remove();
                $('.area-product').remove();
                $(data.products).each(function() {

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
                        'data-id': this.ShopBrochureProduct.id,
                    });
                    $('.fancybox-wrap').append(link);
                });
            }).fail(function(e) {
                bootbox.alert('Error' + e);
            });
        },
        formValidation: function() {
            if ($('.form-validate').length > 0) {
                $('.form-validate').each(function() {
                    var id = $(this).attr('id');
                    $("#" + id).validate({
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
                });
            }
        },
        formWizard: function() {
            if ($('.form-wizard').length > 0) {
                $('.form-wizard').formwizard({
                    formPluginEnabled: false,
                    validationEnabled: true,
                    focusFirstInput: true,
                    disableUIStyles: true,
                    validationOptions: {
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
                        }
                    },
                    formOptions: {
                        success: function(data) {},
                        beforeSubmit: function(data) {},
                        dataType: 'json',
                        resetForm: false,
                    }
                });
            }
        },
        datepicker: function() {
            $('.input-daterange').datepicker({
                language: 'es',
                format: 'dd/mm/yyyy',
            });
        },
        ShopBrochureImageOrder: function() {
            $('#fileupload').bind('fileuploadcompleted', function(e, data) {
                $("table tbody").sortable({
                    revert: true,
                    items: 'tr',
                    cursor: 'move',
                    update: function(event, ui) {
                        var order = $(this).sortable('toArray');
                        $.ajax({
                            url: App.baseUrl('shop_brochures/update_order'),
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                order: order
                            }
                        }).done(function(data) {

                        });
                    }
                }).disableSelection();
                for (var i = 1; i < 5; i++) {
                    $('td:nth-child(' + i + ')').width($(this).width());
                }
            });
        },
        OfferProductGroupShopBrochure: function() {
            $eventSelect = $('#OfferProductGroup0ShopBrochureId').select2({
                language: 'es'
            });
            $eventSelect.on('change', function(e) {
                if (e.val) {
                    $.ajax({
                        url: App.baseUrl('offers/read_products/' + e.val),
                        type: 'GET',
                        dataType: 'json',
                    }).always(function() {}).done(function(data) {
                        if (data.products) {
                            $multiSelect.multiSelect('deselect_all');
                            $multiSelect.empty().multiSelect('refresh'); 
                            $(data.products).each(function(i) {
                                $multiSelect.multiSelect('addOption', { value: this.ShopBrochureProduct.id, text: this.Product.name, index: i });
                            });
                        }
                    });
                }
            });
            $eventSelectOfferType = $('#OfferOfferTypeId').select2({
                language: 'es'
            });
            $eventSelectOfferType.on('change', function(e) {
                if (e.val == 2) {
                    $('#offer-price').fadeIn();
                } else {
                    $('#offer-price').fadeOut();
                }
            });
            $multiSelect = $('#OfferProductGroupShopBrochureProductId').multiSelect({
                selectableHeader: '<input type="text" class="search-input form-control" style="margin-bottom:10px" autocomplete="off" placeholder="Filtrar">',
                selectionHeader:  '<input type="text" class="search-input form-control" style="margin-bottom:10px" autocomplete="off" placeholder="Filtrar">',
                afterInit: function(ms) {
                    var that = this,
                        $selectableSearch = that.$selectableUl.prev(),
                        $selectionSearch = that.$selectionUl.prev(),
                        selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
                        selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';
                    that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                    .on('keydown', function(e) {
                      if (e.which === 40){
                        that.$selectableUl.focus();
                        return false;
                      }
                    });
                    that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                    .on('keydown', function(e){
                      if (e.which == 40){
                        that.$selectionUl.focus();
                        return false;
                      }
                    });
                  },
                  afterSelect: function() {
                    this.qs1.cache();
                    this.qs2.cache();
                  },
                  afterDeselect: function() {
                    this.qs1.cache();
                    this.qs2.cache();
                  }
            });
            if ($('#OfferProductGroup0ShopBrochureId').length) {
                $brochureId = $('#OfferProductGroup0ShopBrochureId').val();
            }

            $offerId = $('#OfferId').val();
            if ($('#OfferOfferTypeId').val() == 2) {
                $('#offer-price').fadeIn();   
            }
            if ($brochureId) {
                $.ajax({
                    url: App.baseUrl('offers/read_products/' + $brochureId),
                    type: 'GET',
                    dataType: 'json',
                }).always(function() {}).done(function(data) {
                    if (data.products) {
                        $multiSelect.multiSelect('deselect_all');
                        $multiSelect.empty().multiSelect('refresh'); 
                        $(data.products).each(function(i) {
                            $multiSelect.multiSelect('addOption', { value: this.ShopBrochureProduct.id, text: this.Product.name, index: i });
                        });
                        $.ajax({
                            url: App.baseUrl('offers/read_offer_product/' + $offerId),
                            type: 'GET',
                            dataType: 'json',
                        }).always(function() {}).done(function(data) {
                            if (data.products) {
                                $multiSelect.multiSelect('select', data.products);
                            }
                        });
                    }
                });

            }
        },
        campaigns: function () {
            $multiSelectCampaign = $('#CampaignShopBrochureId').multiSelect({});
            $('#CampaignStartDate, #CampaignEndDate').datepicker({
                language: 'es',
                format: 'dd/mm/yyyy',
            }).on('changeDate', function(e) {
                if ($('#CampaignStartDate').val() && $('#CampaignEndDate').val()) {
                    $.ajax({
                        url: App.baseUrl('campaigns/read_shop_brochures'),
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            'data[ShopBrochure][release_date]' : $('#CampaignStartDate').val(),
                            'data[ShopBrochure][expiration_date]' : $('#CampaignEndDate').val(),
                        }
                    }).always(function() {

                    }).done(function(data) {
                        if (data.shop_brochures) {
                            $multiSelectCampaign.multiSelect('deselect_all');
                            $multiSelectCampaign.empty().multiSelect('refresh'); 
                            $(data.shop_brochures).each(function(i) {
                                $multiSelectCampaign.multiSelect('addOption', { value: this.ShopBrochure.id, text: this.ShopBrochure.name, index: i });
                            });
                        }
                    });
                }
            });
            if ($('#CampaignStartDate').val() && $('#CampaignEndDate').val() && $('#CampaignId').val()) {
                $.ajax({
                    url: App.baseUrl('campaigns/read_shop_brochures'),
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'data[ShopBrochure][release_date]' : $('#CampaignStartDate').val(),
                        'data[ShopBrochure][expiration_date]' : $('#CampaignEndDate').val(),
                    }
                }).always(function() {

                }).done(function(data) {
                    if (data.shop_brochures) {
                        $multiSelectCampaign.multiSelect('deselect_all');
                        $multiSelectCampaign.empty().multiSelect('refresh'); 
                        $(data.shop_brochures).each(function(i) {
                            $multiSelectCampaign.multiSelect('addOption', { value: this.ShopBrochure.id, text: this.ShopBrochure.name, index: i });
                        });
                        $.ajax({
                            url: App.baseUrl('campaigns/read_campaign_shop_brochures/' + $('#CampaignId').val()),
                            type: 'GET',
                            dataType: 'json',
                        }).always(function() {

                        }).done(function(data) {
                            if (data.shop_brochures) {
                                $multiSelectCampaign.multiSelect('select', data.shop_brochures);
                            }
                        });
                    }
                }); 
            }
        },
        nav: function () {
            $('.subnav').each(function() {
                if ($(this).data('module') == App.uriSegment(3)) {
                    $(this).removeClass('subnav-hidden');
                    $('ul', this).css('display', 'block');
                }
            });
        },
        init: function() {
            App.formWizard();
            App.validatorTranslate();
            App.formValidation();
            App.breadcrumbsDisableLast();
            App.alertDelete();
            App.categoriesSort();
            App.CategoryDialog();
            App.datepicker();
            App.ShopBrochureImage();
            App.ShopBrochureImageOrder();
            App.assignCategory();
            App.crop();
            App.OfferProductGroupShopBrochure();
            App.nav();
            App.campaigns();
        }
    }
}();

jQuery(document).ready(function() {
    App.init();
});