<title>Panel de control</title>

<div class="wrap">
	<div class="icon32" id="icon-edit-pages"></div>

	<!-- Panel de control -->
	<h2>Configurador de:</h2>
	<h3>Plugin de Navidad - IndianWebs</h3>

	<div id="poststuff" class="metabox-holder has-right-sidebar">
		<div id="post-body">
			<div style="float:right; width:25%;">
				<img src="<?php echo plugin_dir_url(__FILE__) . 'logoindianwebsgrande.png'; ?>" />
				<p>Con más de 2500 clientes satisfechos en creación y mantenimiento de webs, intranets, y apps en internet. Las páginas web y tiendas virtuales avalan nuestra trayectoria, a lo largo de 19 años de actividad, desde 1996.</p>
				<p>IndianWebs es un proveedor de soluciones web, ofreciendo desde servicios de páginas web, promoción, mantenimiento, consultoría y programación.</p>
				<a href="http://www.indianwebs.com">www.indianwebs.com</a>
			</div>

			<div id="post-body-content" class="form-wrap">
				<form name="post_form" method="post" action="" enctype="multipart/form-data">
					<?php wp_nonce_field('nieve_action', 'nieve_nonce'); ?>

					<!-- Activar Nieve -->
					<div id="titlediv">
						<div class="form-field">
							<h3>¿Activar copos de nieve?</h3>
							<select name="set_copos" id="set_copos">
								<option value="No" <?php echo ($set_copos == 'No') ? 'selected=selected' : ''; ?>>No</option>
								<option value="Yes" <?php echo ($set_copos == 'Yes') ? 'selected=selected' : ''; ?>>Sí</option>
							</select>
						</div>

						<!-- Valores Nieve -->
						<div class="form-field">
							<h3>Personaliza los copos de nieve</h3>
							<h4>Número de copos de nieve: Entre 1 y 100</h4>
							<input name="set_flakeCount" type="number" min="1" max="100" style="width: 52px;" value="<?php echo $set_flakeCount; ?>">
							<h4>Tamaño mínimo: Entre 10 y 30</h4>
							<input name="set_minSize" type="number" min="10" max="30" style="width: 52px;" value="<?php echo $set_minSize; ?>">
							<h4>Tamaño máximo: Entre 20 y 50</h4>
							<input name="set_maxSize" type="number" min="20" max="50" style="width: 52px;" value="<?php echo $set_maxSize; ?>">
							<h4>Velocidad máxima: Entre 1 y 10</h4>
							<input name="set_maxSpeed" type="number" min="1" max="10" style="width: 52px;" value="<?php echo $set_maxSpeed; ?>">
						</div>

						<!-- Activar Postal -->
						<div class="form-field">
							<h3>¿Activar postal de navidad?</h3>
							<select name="set_postal" id="set_postal">
								<option value="No" <?php echo ($set_postal == 'No') ? 'selected=selected' : ''; ?>>No</option>
								<option value="Yes" <?php echo ($set_postal == 'Yes') ? 'selected=selected' : ''; ?>>Sí</option>
							</select>
						</div>

						<!-- Selección de Postal -->
						<div class="form-field">
							<h3>Selecciona una imagen</h3>
							<?php for ($i = 1; $i <= 6; $i++): ?>
								<input type="radio" name="set_msg" id="set_msg" value="feliznavidad<?php echo $i; ?>" <?php echo ($set_msg == "feliznavidad$i") ? 'checked=checked' : ''; ?>>
								<img style="width:200px; margin-top:10px;" src="<?php echo plugin_dir_url(__FILE__) . "/images/Navidad-$i.jpg"; ?>" />
								<?php echo ($i % 3 == 0) ? '<br />' : ''; ?>
							<?php endfor; ?>
						</div>

						<!-- Seleccionar Posición -->
						<div class="form-field">
							<h3>Selecciona una posición</h3>
							<select name="set_posicion" id="set_posicion">
								<option value="derecha" <?php echo ($set_posicion == 'derecha') ? 'selected=selected' : ''; ?>>Derecha</option>
								<option value="centro" <?php echo ($set_posicion == 'centro') ? 'selected=selected' : ''; ?>>Centro</option>
								<option value="izquierda" <?php echo ($set_posicion == 'izquierda') ? 'selected=selected' : ''; ?>>Izquierda</option>
							</select>
						</div>

						<div class="form-field">
							<h3>Subir una postal</h3>
							<input id="set_imagen" type="hidden" name="set_imagen" value="<?php echo esc_url(get_option('set_imagen')); ?>" />

							<input id="upload_image_button" type="button" class="button" value="Upload Image" />

							<div style="margin-top:10px;">
								<?php if (get_option('set_imagen')): ?>
									<img id="preview_imagen" src="<?php echo esc_url(get_option('set_imagen')); ?>" style="max-width:300px;" />
								<?php else: ?>
									<img id="preview_imagen" src="" style="display:none; max-width:300px;" />
								<?php endif; ?>
							</div>
						</div>

						<script>
							jQuery(document).ready(function($) {
								// Cuando se hace clic en el botón para subir la imagen
								$('#upload_image_button').on('click', function(e) {
									e.preventDefault();

									var image = wp.media({
											title: 'Seleccionar Imagen',
											multiple: false
										}).open()
										.on('select', function() {
											var uploaded_image = image.state().get('selection').first();
											var image_url = uploaded_image.toJSON().url;

											$('#set_imagen').val(image_url); // Actualiza el campo de la imagen subida
											$('#preview_imagen').attr('src', image_url).show(); // Muestra la previsualización

											// Desmarcar cualquier imagen predefinida seleccionada
											$('input[name="set_msg"]').prop('checked', false);
										});
								});

								// Cuando se selecciona una imagen predefinida
								$('input[name="set_msg"]').on('change', function() {
									// Limpiar el campo de la imagen subida
									$('#set_imagen').val('');
									$('#preview_imagen').hide(); // Ocultar la previsualización de la imagen subida

									// También asegurarse de que el campo de la imagen subida esté vacío
									$('#set_imagen').remove();
								});
							});
						</script>



						<!-- Botón Guardar -->
						<div style="margin-top:15px;">
							<input type="submit" name="submit" value="Guardar" class="button" />
							<input type="hidden" name="act" value="save" />
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>