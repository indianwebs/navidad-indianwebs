<?php
/*
Plugin Name: Plugin Navidad IndianWebs
Plugin URI: https://indianwebs.com/plugins
Description: Pon un mensaje navideño y un efecto de nieve en tu web.
Version: 1.4.1
Author: Cristopher Quispe , Phuguet
Author URI: https://indianwebs.com/
License: GPLv2 or later
*/

/* Detecta el tipo de versión de WordPress */
register_activation_hook(__FILE__, 'efecto_nieve_install');

function efecto_nieve_install()
{
	global $wp_version;

	if (version_compare($wp_version, "3.2.1", "<")) {
		deactivate_plugins(basename(__FILE__));
		wp_die("This plugin requires WordPress version 3.2.1 or higher.");
	}

	set_navidad();
}

add_action('admin_menu', 'efecto_nieve_menu');

function efecto_nieve_menu()
{
	add_menu_page(
		'NAVIDAD',
		'NAVIDAD',
		'administrator',
		'navidad-indianwebs.php',
		'efecto_nieve_action',
		plugins_url('snowflake.png', __FILE__)
	);
}

/* Administrador del Plugin */
function efecto_nieve_action()
{
	$option_name1 = 'set_copos';
	$option_name1_1 = 'set_flakeCount';
	$option_name1_2 = 'set_minSize';
	$option_name1_3 = 'set_maxSize';
	$option_name1_4 = 'set_maxSpeed';

	$option_name2 = 'set_msg';
	$option_name3 = 'set_postal';
	$option_name4 = 'set_imagen';
	$option_name5 = 'set_posicion';

	$accion = isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
	switch ($accion) {
		case "save":
			if (
				!isset($_POST['nieve_nonce']) ||
				!wp_verify_nonce($_POST['nieve_nonce'], 'nieve_action')
			) {
				print 'Sorry, your nonce did not verify.';
				exit;
			} else {
				set_navidad();
				echo '<div class="updated below-h2" id="message" style="position:relative; clear:both;"><p>Efecto nieve: ' . $_REQUEST['set_copos'] . '</p></div>';
				echo '<div class="updated below-h2" id="message" style="position:relative; clear:both;"><p>Mensaje de navidad: ' . $_REQUEST['set_postal'] . '</p></div>';
				break;
			}
		default:
	}

	/* Establecer opciones */
	$set_copos = get_option($option_name1);
	$set_flakeCount = get_option($option_name1_1);
	$set_minSize = get_option($option_name1_2);
	$set_maxSize = get_option($option_name1_3);
	$set_maxSpeed = get_option($option_name1_4);

	$set_msg = get_option($option_name2);
	$set_postal = get_option($option_name3);
	$set_imagen = get_option($option_name4);
	$set_posicion = get_option($option_name5);

	require_once('form.php');
}

function set_navidad()
{
	$option_name1   = 'set_copos';
	$option_name1_1 = 'set_flakeCount';
	$option_name1_2 = 'set_minSize';
	$option_name1_3 = 'set_maxSize';
	$option_name1_4 = 'set_maxSpeed';
	$option_name2   = 'set_msg';
	$option_name3   = 'set_postal';
	$option_name4   = 'set_imagen';
	$option_name5   = 'set_posicion';
	$option_name6   = 'set_imagen2';

	// Valores por defecto
	$new_value1 = ($_REQUEST['set_copos'] == "") ? 'No' : $_REQUEST['set_copos'];
	if (get_option($option_name1) !== false) {
		update_option($option_name1, $new_value1);
	} else {
		add_option($option_name1, $new_value1, null, 'no');
	}

	// UPDATE 1.3
	$new_value1_1 = ($_REQUEST['set_flakeCount'] == "") ? '25' : $_REQUEST['set_flakeCount'];
	if (get_option($option_name1_1) !== false) {
		update_option($option_name1_1, $new_value1_1);
	} else {
		add_option($option_name1_1, $new_value1_1);
	}

	$new_value1_2 = ($_REQUEST['set_minSize'] == "") ? '10' : $_REQUEST['set_minSize'];
	if (get_option($option_name1_2) !== false) {
		update_option($option_name1_2, $new_value1_2);
	} else {
		add_option($option_name1_2, $new_value1_2);
	}

	$new_value1_3 = ($_REQUEST['set_maxSize'] == "") ? '20' : $_REQUEST['set_maxSize'];
	if (get_option($option_name1_3) !== false) {
		update_option($option_name1_3, $new_value1_3);
	} else {
		add_option($option_name1_3, $new_value1_3);
	}

	$new_value1_4 = ($_REQUEST['set_maxSpeed'] == "") ? '3' : $_REQUEST['set_maxSpeed'];
	if (get_option($option_name1_4) !== false) {
		update_option($option_name1_4, $new_value1_4);
	} else {
		add_option($option_name1_4, $new_value1_4);
	}
	// END UPDATE 1.3

	$new_value2 = (isset($_REQUEST['set_msg']) && $_REQUEST['set_msg'] !== '') ? $_REQUEST['set_msg'] : '';
	if (get_option($option_name2) !== false) {
		update_option($option_name2, $new_value2);
	} else {
		add_option($option_name2, $new_value2);
	}

	$new_value3 = ($_REQUEST['set_postal'] == "") ? 'No' : $_REQUEST['set_postal'];
	if (get_option($option_name3) !== false) {
		update_option($option_name3, $new_value3);
	} else {
		add_option($option_name3, $new_value3, null, 'no');
	}

	$new_value4 = (isset($_REQUEST['set_imagen']) && $_REQUEST['set_imagen'] !== '') ? $_REQUEST['set_imagen'] : '';
	update_option('set_imagen', $new_value4);


	$new_value5 = ($_REQUEST['set_posicion'] == "") ? 'Derecha' : $_REQUEST['set_posicion'];
	if (get_option($option_name5) !== false) {
		update_option($option_name5, $new_value5);
	} else {
		add_option($option_name5, $new_value5, null, 'derecha');
	}
}



/* Muestra las opciones */
function mostrar_efecto_nieve()
{
	$option_name1 = 'set_copos';
	$set_copos = get_option($option_name1);

	// Condicional para mostrar las opciones
	if ($set_copos == 'Yes') {
		$script  = '<script>';
		$script .= 'jQuery(document).snowfall({';
		$script .= 'flakeCount : ' . get_option('set_flakeCount') . ',';
		$script .= 'image : "' . plugins_url('/images/snowflake.png', __FILE__) . '",';
		$script .= 'minSize : ' . get_option('set_minSize') . ',';
		$script .= 'maxSize : ' . get_option('set_maxSize') . ',';
		$script .= 'maxSpeed : ' . get_option('set_maxSpeed');
		$script .= '});</script>';

		echo $script;
	}
}

/* Cargar jQuery */
function cargar_jquery()
{
	wp_register_script('efecto', plugins_url('/js/jquery-3.5.1.min.js', __FILE__));
	wp_enqueue_script('efecto');
}
add_action('wp_enqueue_scripts', 'cargar_jquery');

/* Mostrar efecto de nieve */
function mostrar_nieve()
{
	wp_register_script('efecto', plugins_url('/js/snowfall.jquery.min.js', __FILE__));
	wp_enqueue_script('efecto');
}
add_action('init', 'mostrar_nieve');

/* Agregar script JS para popups */
function agregar_js()
{
	wp_register_script('popup', plugins_url('/js/script.js', __FILE__));
	wp_enqueue_script('popup');
}
add_action('wp_enqueue_scripts', 'agregar_js');




function agregar_estilo()
{

	wp_register_style('estilo', plugins_url('/css/style.css', __FILE__));

	wp_enqueue_style('estilo');
}

add_action('wp_enqueue_scripts', 'agregar_estilo');

function mostrar_tarjeta()
{
	$set_postal  = get_option('set_postal');
	$set_msg     = get_option('set_msg');
	$set_posicion = get_option('set_posicion');
	$set_imagen  = get_option('set_imagen');
	$set_imagen2 = get_option('set_imagen2');

	// Si se activa postal y se subió imagen personalizada
	if ($set_postal == 'Yes' && $set_imagen != '' && $set_msg == '') {
		$style = 'background: url(' . $set_imagen . '); 
		background-size: cover; 
		width: 540px; 
		height: 220px; 
		position: fixed; 
		z-index: 9999;';

		if ($set_posicion == 'derecha') {
			// Posicionamiento en la parte inferior derecha
			$style .= ' right: 0; bottom: 0;   margin-bottom: 20px;'; // Usa bottom: 0 para pegarlo a la parte inferior
		} elseif ($set_posicion == 'izquierda') {
			// Posicionamiento en la parte superior izquierda
			$style .= ' left: 0; top: 0; margin-top: 20px;'; // Usa top: 0 para pegarlo a la parte superior
		} elseif ($set_posicion == 'centro') {
			// Posicionamiento centrado
			$style .= ' z-index: 9999; transform: translate(-50%, -50%); top: 50%; left: 50%;';
		}

		echo '<div class="tarjeta" style="' . $style . '"><span id="close" onclick="cerrar()">x</span></div>';
	}


	// Si se seleccionó una imagen predefinida
	elseif ($set_postal == 'Yes' && $set_msg != '') {
		$set_imagen = ''; // se ignora imagen personalizada

		$prefix = ($set_posicion == 'centro') ? '-cen' : (($set_posicion == 'izquierda') ? '-iz' : '');
		$popup_id = match ($set_msg) {
			'feliznavidad1' => 'popup1',
			'feliznavidad2' => 'popup2',
			'feliznavidad3' => 'popup3',
			'feliznavidad4' => 'popup4',
			'feliznavidad5' => 'popup5',
			'feliznavidad6' => 'popup6',
			default => '',
		};

		if ($popup_id) {
			echo '<div class="tarjeta" id="' . $popup_id . $prefix . '"><span id="close" onclick="cerrar()">x</span></div>';
		}
	}
}

function cargar_media_uploader_admin()
{
	if (is_admin()) {
		wp_enqueue_media(); // Esta es la clave
	}
}
add_action('admin_enqueue_scripts', 'cargar_media_uploader_admin');

// Llamadas para media-upload
wp_enqueue_style('thickbox');
wp_enqueue_script('thickbox');
wp_enqueue_script('media-upload');

// Mostrar efectos en el footer
add_action('wp_footer', 'mostrar_tarjeta');
add_action('wp_footer', 'mostrar_efecto_nieve');
