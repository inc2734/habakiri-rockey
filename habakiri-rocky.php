<?php
/**
 * Plugin Name: Rocky - Habakiri design skin
 * Plugin URI: https://github.com/inc2734/habakiri-rocky
 * Description: Rocky is a design skin of Habakiri.
 * Version: 2.0.0
 * Author: Takashi Kitajima
 * Author URI: http://2inc.org
 * Created : July 9, 2015
 * Modified: Septermber 14, 2015
 * Text Domain: habakiri-rocky
 * Domain Path: /languages/
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

if ( defined( 'HABAKIRI_DESIGN_SKIN' ) && get_template() === 'habakiri' ) {
	return;
}

define( 'HABAKIRI_DESIGN_SKIN', true );

include_once( plugin_dir_path( __FILE__ ) . 'classes/class.config.php' );
include_once( plugin_dir_path( __FILE__ ) . 'classes/class.github-updater.php' );
new Habakiri_Plugin_GitHub_Updater( 'habakiri-rocky', __FILE__, 'inc2734' );

class Habakiri_Rocky {

	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
		add_action( 'init', array( $this, 'init' ) );
	}

	/**
	 * 言語ファイルの読み込み
	 */
	public function plugins_loaded() {
		load_plugin_textdomain(
			Habakiri_Rocky_Config::NAME,
			false,
			basename( dirname( __FILE__ ) ) . '/languages'
		);
	}

	/**
	 * 初期化処理
	 */
	public function init() {
		add_filter(
			'habakiri_theme_mods_defaults',
			array( $this, 'habakiri_theme_mods_defaults' )
		);

		add_filter(
			'mce_css',
			array( $this, 'mce_css' )
		);

		add_action(
			'wp_enqueue_scripts',
			array( $this, 'wp_enqueue_scripts' )
		);

		remove_theme_support( 'custom-background' );
	}

	/**
	 * CSS の読み込み
	 */
	public function wp_enqueue_scripts() {
		$url = plugins_url( Habakiri_Rocky_Config::NAME );
		wp_enqueue_style(
			Habakiri_Rocky_Config::NAME,
			$url . '/style.min.css',
			array( 'habakiri' )
		);
	}

	/**
	 * エディタに CSS を適用
	 *
	 * @param string $mce_css CSS のURL
	 * @return string
	 */
	public function mce_css( $mce_css ) {
		if ( ! empty( $mce_css ) ) {
			$mce_css .= ',';
		}
		$mce_css .= get_stylesheet_directory_uri() . '/editor-style.min.css';
		return $mce_css;
	}

	/**
	 * デフォルトのテーマオプションを定義して返す
	 *
	 * @param array $args
	 * @return array
	 */
	public function habakiri_theme_mods_defaults( $args ) {
		return shortcode_atts( $args, array(
			'page_header_bg_color'       => '#bf0a19',
			'page_header_text_color'     => '#fff',
			'link_color'                 => '#276989',
			'link_hover_color'           => '#276989',
			'gnav_link_color'            => '#fff',
			'gnav_link_hover_color'      => '#fff',
			'gnav_link_bg_color'         => '#bf0a19',
			'gnav_link_bg_hover_color'   => '#bf0a19',
			'gnav_sub_label_color'       => '#fff',
			'gnav_sub_label_hover_color' => '#fff',
			'logo_text_color'            => '#fff',
			'header_bg_color'            => '#bf0a19',
			'gnav_bg_color'              => '#bf0a19',
			'footer_bg_color'            => '#222',
			'footer_text_color'          => '#fff',
			'footer_link_color'          => '#fff',
		) );
	}
}

$Habakiri_Rocky = new Habakiri_Rocky();
