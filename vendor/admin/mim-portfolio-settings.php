<?php
if( ! defined( 'ABSPATH' ) ) exit();

require_once dirname( __FILE__ ) . '/class.mdc-settings-api.php';

if ( ! class_exists( 'MIM_PORTFOLIO_SETTINGS' ) ) :

class MIM_PORTFOLIO_SETTINGS {

    private $settings_api;

    function __construct() {
        $this->settings_api = new MDC_Settings_API;

        add_action( 'admin_init', array( $this, 'admin_init' ) );
        add_action( 'admin_menu', array( $this, 'admin_menu' ), 51 );
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    function admin_menu() {
        add_submenu_page( 'edit.php?post_type=portfolio', 'Settings', 'Settings' , 'manage_options', 'portfolio-settings', array( $this, 'option_page' ) );
    }

    function get_settings_sections() {
        $sections = array(
            array(
                'id' => 'mim_portfolio',
                'title' => 'General Settings',
            ),
        );
        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {
        $settings_fields = array(
            
            'mim_portfolio' => array(
                array(
                    'name'    =>  'title',
                    'label'   =>  'Title',
                    'type'    =>   'text',
                    'desc'    =>  'Your Portfolio Title'
                ),
                array(
                    'name'    =>  'description',
                    'label'   =>  'Description',
                    'type'    =>   'textarea',
                    'desc'    =>  'Your Portfolio Description'
                ),
                array(
                    'name'    =>  'background',
                    'label'   =>  'Background Color',
                    'type'    =>   'color',
                    'desc'    =>  '',
                    'default' =>  'transparent',
                ),
                array(
                    'name'    =>  'color',
                    'label'   =>  'Fonts Color',
                    'type'    =>   'color',
                    'desc'    =>  '',
                    'default' =>  '#5b777f',
                ),
                array(
                    'name'    =>  'btnbg',
                    'label'   =>  'Button background Color',
                    'type'    =>   'color',
                    'desc'    =>  '',
                    'default' =>  '#5b777f',
                ),
                array(
                    'name'    =>  'activebtn',
                    'label'   =>  'Active Button Color',
                    'type'    =>   'color',
                    'desc'    =>  '',
                    'default' =>  '#032934',
                ),
                array(
                    'name'    =>  'fontsize',
                    'label'   =>  'Title Size (px)',
                    'type'    =>   'number',
                    'desc'    =>  'Default Size 30px',
                    'default' =>  '30',
                ),
                array(
                    'name'    =>  'btnfontsize',
                    'label'   =>  'Button Font Size (px)',
                    'type'    =>   'number',
                    'desc'    =>  'Default Size 16px',
                    'default' =>  '16',
                ),
                array(
                    'name'    =>  'btntransform',
                    'label'   =>  'Button Transform',
                    'type'    =>   'radio',
                    'default' =>  'uppercase',
                    'options' => array( 'uppercase' => 'Uppercase', 'capitalize' => 'Capitalize', 'lowercase' => 'Lowercase' ),
                ),
                array(
                    'name'    =>  'textposition',
                    'label'   =>  'Position of Text',
                    'type'    =>   'radio',
                    'default' =>  'center',
                    'options' => array( 'left' => 'Left', 'center' => 'Center', 'right' => 'Right' )
                ),
                array(
                    'name'    =>  'btnposition',
                    'label'   =>  'Position of Button',
                    'type'    =>   'radio',
                    'default' =>  'center',
                    'options' => array( 'left' => 'Left', 'center' => 'Center', 'right' => 'Right' )
                ),
                array(
                    'name'    =>  'rownumber',
                    'label'   =>  'Grid Layouts',
                    'type'    =>   'radio',
                    'default' =>  'center',
                    'options' => array( '100%' => '1 Column Grid','50%' => '2 Column Grid', '33.33%' => '3 Column Grid', '25%' => '4 Column Grid', '20%' => '5 Column Grid', '16.66%' => '1 Column Grid' )
                ),
                array(
                    'name'    =>  'portfoliostyle',
                    'label'   =>  'Layouts Style',
                    'type'    =>   'radio',
                    'default' =>  'style1',
                    'options' => array( 'style1' => 'Layouts 1', 'style2' => 'Layouts 2', 'style3' => 'Layouts 3', 'style4' => 'Layouts 4', 'style5' => 'Layouts 5', 'style6' => 'Layouts 6' )
                ),
            ),

        );

        return $settings_fields;
    }

    function option_page() {
        echo '<div class="wrap">';
        ?>
        
            <div class="scroll-to-up-setting-page-title">
                <h1><i>Portfolio</i> Settings</h1>
            </div>

        <div class="stp-col-left">
            <?php 
            $this->settings_api->show_navigation();
            $this->settings_api->show_forms(); ?>
        </div>


    <?php echo '</div>';
    }

    public function preset_icons() {
        $icons = [];
        for( $i=1; $i<=80; $i++){
            $icons[plugins_url( 'assets/icons/arrow' . $i . '.png', MDC_SCROLL_TO_TOP )] = '<img src="' . plugins_url( 'assets/icons/arrow' . $i . '.png', MDC_SCROLL_TO_TOP ) . '" />';
        }
        return $icons;
    }

}

new MIM_PORTFOLIO_SETTINGS;
endif;

if( ! function_exists( 'mdc_get_option' ) ) :
function mdc_get_option( $option, $section, $default = '' ) {
 
    $options = get_option( $section );
 
    if ( isset( $options[$option] ) ) {
        return $options[$option];
    }
 
    return $default;
}
endif;
