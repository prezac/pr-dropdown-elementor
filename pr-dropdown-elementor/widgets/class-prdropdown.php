<?php
/**
 * PR-dropdown class.
 *
 * @category   Class
 * @package    ElementorPrdropdown
 * @subpackage WordPress
 * @author     Petr Rezac <prezac@pr-software.net.net>
 * @copyright  2020 PR-software
 * @license    https://opensource.org/licenses/GPL-3.0 GPL-3.0-only
 * @link       link(http://www.pr-software.net/category/wordpress/,
 *             Build Custom Elementor Widgets)
 * @since      1.0.0
 * php version 7.4.4
 */

namespace Prdropdown\Widgets;

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

// Security Note: Blocks direct access to the plugin PHP files.
defined( 'ABSPATH' ) || die();

/**
 * PRdropdown widget class.
 *
 * @since 1.0.0
 */
class Prdropdown extends Widget_Base {
	public static $slug = 'prdropdown';
	/**
	 * Class constructor.
	 *
	 * @param array $data Widget data.
	 * @param array $args Widget arguments.
	 */
	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );

		wp_register_style( 'prdropdown', plugins_url( '/assets/css/prdropdown.css', ELEMENTOR_PRDROPDOWN ), array(), '1.0.0' );
	}

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return self::$slug;
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Prdropdown', self::$slug );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'fa fa-caret-down';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'general' );
	}

	/**
	 * Enqueue styles.
	 */
	public function get_style_depends() {
		return array( 'prdropdown' );
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_content',
			array(
				'label' => __( 'Options', self::$slug ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'option_value',
			array(
				'label' => __( 'Option Value', self::$slug ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( "The Options Value", self::$slug ),
				'placeholder' => __( 'Value Attribute', self::$slug ),
			)
		);

		$repeater->add_control(
			'option_contents',
			array(
				'label' => __( 'Option Content', self::$slug ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( "The Option Contents", self::$slug ),
				'placeholder' => __( 'Option Content', self::$slug ),
			)
		);

		$this->add_control(
			'options_list',
			array(
				'label' => __( 'Option List', self::$slug ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'list_title' => __( 'Options Content', self::$slug ),
						'option_list' => __( 'Item content. Click the edit button to change this text.', self::$slug ),
					],
				],
				'title_field' => '{{{ option_contents }}}'
			)
		);

		$this->end_controls_section();
	}


	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display('options_list');
		echo "<select>";
		foreach ($options_list as $option_item) {
			echo "<option value='{$option_item['option_value']}'>{$option_item['option_contents']}</option>";
		}
		echo "<select>";
	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _content_template() {
		?>
		<select>
		<# if ( settings.options_list.length ) { #>
			<# _.each( settings.options_list, function( item ) { #>
				<option value="{{ item.option_value }}">{{{ item.option_contents }}}</option>
			<# }); #>
		<# } #>
		</select>
		<?php
	}
}
