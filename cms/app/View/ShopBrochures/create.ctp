<?php $this->Html->addCrumb('Catálogos', array('controller' => 'shop_brochures', 'action' => 'index')) ?>
<?php $this->Html->addCrumb('Agregar', array('controller' => 'shop_brochures', 'action' => 'create')) ?>
<div class="box clearfix">
	<div class="box-title">
		<h3>
			<i class="fa fa-file-image-o"></i>
			Agregar Catálogo
		</h3>
	</div>
	<div class="box-content">
		<?php echo $this->Form->create('ShopBrochure', array('class' => 'form-horizontal form-validate')) ?>
		<?php echo $this->Form->input('ShopBrochure.id', array('type' => 'hidden')) ?>
			<div class="form-group">
				<label for="ShopBrochureName" class="control-label col-sm-2">Nombre</label>
				<div class="col-sm-10">
					<?php echo $this->Form->input('ShopBrochure.name', array('div' => false, 'label' => false, 'class' => 'form-control', 'data-rule-required' => true)) ?>
				</div>
			</div>
			<div class="input-daterange">
				<div class="form-group">
					<label for="UserFirstName" class="control-label col-sm-2">Fechas Lanzamiento</label>
					<div class="col-sm-10">
						<?php echo $this->Form->input('ShopBrochure.release_date', array('type' => 'text', 'div' => false, 'label' => false, 'class' => 'form-control', 'data-rule-required' => true)) ?>
					</div>
				</div>
				<div class="form-group">
					<label for="UserFirstName" class="control-label col-sm-2">Fechas Expiración</label>
					<div class="col-sm-10">
						<?php echo $this->Form->input('ShopBrochure.expiration_date', array('type' => 'text', 'div' => false, 'label' => false, 'class' => 'form-control', 'data-rule-required' => true)) ?>
					</div>
				</div>
			</div>
			<div class="form-actions">
				<?php echo $this->Form->submit('Guardar', array('div' => false, 'class' => 'btn btn-primary')) ?>
				<a href="<?php echo $this->request->referer() ?>" class="btn">Cancelar</a>
			</div>
		<?php echo $this->Form->end() ?>
	</div>
	<div class="box-content">
		<div class="alert alert-info alert-dismissable">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>¡Atención!</strong>
			<br>
			Puede arrastrar las imagenes para agregar a la carga, luego de la carga, puedo arrastrarlas a la posición deseada para ordenarlas.
			<br>
			Click en las imagenes para abrir galeria y realizar marcado de productos.
		</div>
		<!-- Bootstrap styles -->
		<!-- <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"> -->
		<!-- blueimp Gallery styles -->
		<link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
		<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
		<?php echo $this->Html->css('plugins/jQuery-File-Upload/jquery.fileupload') ?>
		<?php echo $this->Html->css('plugins/jQuery-File-Upload/jquery.fileupload-ui') ?>
		<!-- CSS adjustments for browsers with JavaScript disabled -->
		<noscript>
			<?php echo $this->Html->css('plugins/jQuery-File-Upload/jquery.fileupload-noscript') ?>
		</noscript>
		<noscript>
			<?php echo $this->Html->css('plugins/jQuery-File-Upload/jquery.fileupload-ui-noscript') ?>
		</noscript>
	    
	    <!-- Jcrop CSS -->
		<?php echo $this->Html->css('plugins/Jcrop/jquery.Jcrop') ?>

	    <!-- The file upload form used as target for the file upload widget -->
	    <form id="fileupload" action="" method="POST" enctype="multipart/form-data">
	        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
	        <div class="row fileupload-buttonbar">
	            <div class="col-lg-7">
	                <!-- The fileinput-button span is used to style the file input field as button -->
	                <span class="btn btn-success fileinput-button">
	                    <i class="glyphicon glyphicon-circle_plus"></i>
	                    <span>Añadir archivos ...</span>
	                    <input type="file" name="data[ShopBrochureImage]" multiple>
	                </span>
	                <button type="submit" class="btn btn-primary start">
	                    <i class="glyphicon glyphicon-upload"></i>
	                    <span>Comenzar carga</span>
	                </button>
	                <button type="reset" class="btn btn-warning cancel">
	                    <i class="glyphicon glyphicon-circle_remove"></i>
	                    <span>Cancelar carga</span>
	                </button>
	                <button type="button" class="btn btn-danger delete">
	                    <i class="glyphicon glyphicon-delete"></i>
	                    <span>Borrar</span>
	                </button>
	                <input type="checkbox" class="toggle">
	                <!-- The global file processing state -->
	                <span class="fileupload-process"></span>
	            </div>
	            <!-- The global progress state -->
	            <div class="col-lg-5 fileupload-progress fade">
	                <!-- The global progress bar -->
	                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
	                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
	                </div>
	                <!-- The extended global progress state -->
	                <div class="progress-extended">&nbsp;</div>
	            </div>
	        </div>
	        <!-- The table listing the files available for upload/download -->
	        <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
	    </form>
		<!-- The blueimp Gallery widget -->
		<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
		    <div class="slides"></div>
		    <!-- <h3 class="title"></h3> -->
		    <a class="prev">‹</a>
		    <a class="next">›</a>
		    <a class="close">×</a>
		    <!-- <a class="play-pause"></a> -->
		    <ol class="indicator"></ol>
		</div>
		<script id="template-upload" type="text/x-tmpl">
		{% for (var i=0, file; file=o.files[i]; i++) { %}
		<tr class="template-upload fade" id="{%=file.id%}">
		<td>
		<span class="preview"></span>
		</td>
		<td>
		<p class="name">{%=file.name%}</p>
		<strong class="error text-danger"></strong>
		</td>
		<td>
		<p class="size">Procesando...</p>
		<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
		</td>
		<td>
		{% if (!i && !o.options.autoUpload) { %}
		<button class="btn btn-primary start" disabled>
		<i class="glyphicon glyphicon-upload"></i>
		<span>Iniciar</span>
		</button>
		{% } %}
		{% if (!i) { %}
		<button class="btn btn-default btn-warning cancel">
		<i class="glyphicon glyphicon-circle_remove"></i>
		<span>Cancelar</span>
		</button>
		{% } %}
		</td>
		</tr>
		{% } %}
		</script>
		<script id="template-download" type="text/x-tmpl">
		{% for (var i=0, file; file=o.files[i]; i++) { %}
		<tr class="template-download fade" id="{%=file.id%}">
		<td>
		<span class="preview">
		{% if (file.thumbnailUrl) { %}
		<a href="{%=file.url%}"  data-name="{%=file.name%}" data-id="{%=file.id%}" data-x="{%=file.x%}" data-y="{%=file.y%}" data-x2="{%=file.x2%}" data-y2="{%=file.y2%}" data-width="{%=file.w%}" data-height="{%=file.h%}" rel="fancybox-thumb" class="fancybox" download="{%=file.name%}">
		<img src="{%=file.thumbnailUrl%}">
		</a>
		{% } %}
		</span>
		</td>
		<td>
		<p class="name">
		{% if (file.url) { %}
		<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" class="btn btn-primary">
		<i class="glyphicon glyphicon-download"></i>
		Descargar
		</a>
		{% } else { %}
		<span>{%=file.name%}</span>
		{% } %}
		</p>
		{% if (file.error) { %}
		<div><span class="label label-danger">Error</span> {%=file.error%}</div>
		{% } %}
		</td>
		<td>
		<span class="size">{%=o.formatFileSize(file.size)%}</span>
		</td>
		<td>
		{% if (file.deleteUrl) { %}
		<button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
		<i class="glyphicon glyphicon-delete"></i>
		<span>Eliminar</span>
		</button>
		<input type="checkbox" name="delete" value="1" class="toggle">
		{% } else { %}
		<button class="btn btn-warning cancel">
		<i class="glyphicon glyphicon-ban-circle"></i>
		<span>Cancelar</span>
		</button>
		{% } %}
		</td>
		</tr>
		{% } %}
		</script>
		<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
		<?php echo $this->Html->script('plugins/jQuery-File-Upload/vendor/jquery.ui.widget.js') ?>
		<!-- The Templates plugin is included to render the upload/download listings -->
		<script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
		<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
		<script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
		<!-- The Canvas to Blob plugin is included for image resizing functionality -->
		<script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
		<!-- blueimp Gallery script -->
		<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
		<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
		<?php echo $this->Html->script('plugins/jQuery-File-Upload/jquery.iframe-transport') ?>
		<!-- The basic File Upload plugin -->
		<?php echo $this->Html->script('plugins/jQuery-File-Upload/jquery.fileupload') ?>
		<!-- The File Upload processing plugin -->
		<?php echo $this->Html->script('plugins/jQuery-File-Upload/jquery.fileupload-process') ?>
		<!-- The File Upload image preview & resize plugin -->
		<?php echo $this->Html->script('plugins/jQuery-File-Upload/jquery.fileupload-image') ?>
		<!-- The File Upload audio preview plugin -->
		<?php echo $this->Html->script('plugins/jQuery-File-Upload/jquery.fileupload-audio') ?>
		<!-- The File Upload video preview plugin -->
		<?php echo $this->Html->script('plugins/jQuery-File-Upload/jquery.fileupload-video') ?>
		<!-- The File Upload validation plugin -->
		<?php echo $this->Html->script('plugins/jQuery-File-Upload/jquery.fileupload-validate') ?>
		<!-- The File Upload user interface plugin -->
		<?php echo $this->Html->script('plugins/jQuery-File-Upload/jquery.fileupload-ui') ?>
		<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
		<!--[if (gte IE 8)&(lt IE 10)]>
			<?php echo $this->Html->script('jQuery-File-Upload/cors/jquery.xdr-transport') ?>
		<![endif]-->
		<!-- Jcrop JS -->
		<?php echo $this->Html->script('plugins/Jcrop/jquery.Jcrop') ?>
	</div>	
</div>