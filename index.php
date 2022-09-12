<?php
/*
* Plugin Name: ISOBIT - Electoral
* Description: Este plugin es para la gestion de personeros y el registro de actas de las elecciones regionales en Perú.
* Version:     1.0.1
* Author:      Erik A. Pinedo
* Author URI:  http://www.isobit.org
* License:     GPL2
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: ib
* Domain Path: /languages
*/

error_reporting(E_ERROR | E_PARSE);
global $wpdb;
defined( 'ABSPATH' ) or die( '¡Sin trampas!' );
$wpdb->show_errors(); 


global $ib_db_version;
$ib_db_version = '1.0.1'; 


if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

function el_admin_menu()
{

	add_menu_page(__('Colegiados', 'ib'), __('Colegiados', 'ib'), 'admin_collegiates', 'collegiate', 'ib_parties_page_handler','dashicons-location-alt');
    add_submenu_page('collegiate', __('Colegiados', 'ib'), __('Colegiados', 'ib'), 'admin_collegiates', 'collegiate', 'ib_parties_page_handler');
	add_submenu_page('collegiate', __('Agregar colegiado', 'ib'), __('Agregar', 'ib'), 'admin_collegiates', 'collegiate_form', 'ib_partie_form_page_handler');	
		
		
	add_menu_page(__('Partidos', 'ib'), __('Partidos', 'ib'), 'admin_parties', 'parties', 'ib_parties_page_handler','dashicons-location-alt');
    add_submenu_page('parties', __('Partidos', 'ib'), __('Partidos', 'ib'), 'admin_parties', 'parties', 'ib_parties_page_handler');
    
	add_submenu_page('parties', __('Editar partido', 'ib'), __('Editar', 'ib'), 'admin_parties', 'partie_form', 'ib_partie_form_page_handler');
	
	
	add_menu_page(__('Provincias', 'ib'), __('Provincias', 'ib'), 'admin_provinces', 'provinces', 'ib_provinces_page_handler','dashicons-location-alt');
    add_submenu_page('provinces', __('Provincias', 'ib'), __('Provincias', 'ib'), 'admin_provinces', 'provinces', 'ib_provinces_page_handler');
    add_submenu_page('provinces', __('Editar provincia', 'ib'), __('Editar', 'ib'), 'admin_provinces', 'province_form', 'ib_province_form_page_handler');
	
	add_menu_page(__('Distritos', 'ib'), __('Distritos', 'ib'), 'access_districts', 'districts', 'ib_districts_page_handler','dashicons-location-alt');
    add_submenu_page('districts', __('Distritos', 'ib'), __('Distritos', 'ib'), 'access_districts', 'districts', 'ib_districts_page_handler');
    add_submenu_page('districts', __('Editar distrito', 'ib'), __('Editar', 'ib'), 'access_districts', 'district_form', 'ib_district_form_page_handler');
	
	add_menu_page(__('Locales', 'ib'), __('Locales', 'ib'), 'acceder_personeros', 'locales', 'ib_locals_page_handler','dashicons-admin-home');
    add_submenu_page('locales', __('Locales', 'ib'), __('Locales', 'ib'), 'acceder_personeros', 'locales', 'ib_locals_page_handler');
    add_submenu_page('locales', __('Editar', 'ib'), __('Editar', 'ib'), 'acceder_personeros', 'local_form', 'ib_local_form_page_handler');
	add_submenu_page(null, __('Actas', 'ib'), __('Actas', 'ib'), 'acceder_personeros', 'acta_form', 'ib_acta_form_handler');
	
	add_menu_page(__('Personeros', 'ib'), __('Personeros', 'ib'), 'acceder_personeros', 'personeros', 'ib_personero_page_handler','dashicons-groups');
    add_submenu_page('personeros', __('Listar', 'ib'), __('Listar', 'ib'), 'acceder_personeros', 'personeros', 'ib_personero_page_handler');
    add_submenu_page('personeros', __('Añadir personero', 'ib'), __('Añadir', 'ib'), 'acceder_personeros', 'personero_form', 'ib_personero_form_page_handler');
	
	add_submenu_page(null, __('Ver local', 'ib'), __('Ver local', 'ib'), 'acceder_personeros', 'local', 'ib_local_page_handler');
	
	add_submenu_page(null, __('Validar credencial', 'ib'), __('Ver local', 'ib'), null, 'validate', 'ib_local_page_handler');
	
	add_submenu_page(null, __('Importar personeros', 'ib'), __('Importar personeros', 'ib'), 'admin_parties','import_personeros' , 'ib_gear_page_handler');
	
	
	
	add_menu_page(__('Credenciales', 'ib'), __('Credenciales', 'ib'), 'admin_provinces', 'credenciales', 'ib_credencial_1_page_handler','
dashicons-id-alt');
    add_submenu_page('credenciales', __('Personero de centro de votacion', 'ib'), __('Personero de centro de votacion', 'ib'), 'admin_provinces', 'credencial_1', 'ib_credencial_1_page_handler');
	add_submenu_page('credenciales', __('Personero de mesa', 'ib'), __('Personero de mesa', 'ib'), 'admin_provinces', 'credencial_2', 'ib_credencial_2_page_handler');
	
	add_menu_page(__('Mapas', 'ib'), __('Mapas', 'ib'), 'acceder_mapa', 'mapa', 'ib_local_mapa_page_handler','dashicons-admin-site');
    add_submenu_page('mapa', __('Mapa de distribucion de personeros por local', 'ib'), __('Mapa de distribucion de personeros por local', 'ib'), 'acceder_mapa', 'local_mapa', 'ib_local_mapa_page_handler');
	add_submenu_page('mapa', __('Mapa de resultados por local', 'ib'), __('Mapa de resultados por local', 'ib'), 'acceder_mapa', 'result_mapa', 'ib_result_mapa_page_handler');
	
	
	add_menu_page(__('Votaciones', 'ib'), __('Votaciones', 'ib'), 'acceder_reports', 'acta_form', 'ib_acta_form_handler','dashicons-forms');
    add_submenu_page('acta_form', __('Mapa', 'ib'), __('Registrar', 'ib'), 'acceder_reports', 'acta_form', 'ib_acta_form_handler');
	
	add_menu_page(__('Reportes', 'ib'), __('Reportes', 'ib'), 'acceder_reports', 'reportes', 'ib_local_page_handler','dashicons-analytics');
    add_submenu_page('reportes', __('Listado detallado de personeros', 'ib'), __('Listado detallado de personeros', 'ib'), 'acceder_reports', 'reporte_1', 'ib_report_1_page_handler');
	add_submenu_page('reportes', __('Avance General de Personeros', 'ib'), __('Avance General de Personeros', 'ib'), 'acceder_reports', 'reporte_2', 'ib_report_2_page_handler');
	add_submenu_page('reportes', __('Grafico del Avance de Personeros', 'ib'), __('Grafico del Avance de Personeros', 'ib'), 'acceder_reports', 'reporte_3', 'ib_report_3_page_handler');
	add_submenu_page('reportes', __('Reporte Consolidado de Resultados', 'ib'), __('Reporte consolidado de resultados', 'ib'), 'acceder_reports', 'reporte_4', 'ib_report_4_page_handler');
	add_submenu_page('reportes', __('Grafico del Avance de Resultados', 'ib'), __('Grafico del Avance de Resultados', 'ib'), 'acceder_reports', 'reporte_5', 'ib_report_5_page_handler');
	add_submenu_page('reportes', __('Listado de actas observadas', 'ib'), __('Listado de actas observadas', 'ib'), 'acceder_reports', 'reporte_6', 'ib_report_6_page_handler');
}

add_action('admin_menu', 'el_admin_menu');
