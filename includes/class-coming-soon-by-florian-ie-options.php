<?php

class Coming_Soon_By_Florian_IE_Options {
    private $options;

    public function init() {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    public function add_plugin_page() {
        add_options_page(
            'Coming Soon Settings',
            'Coming Soon by florian.ie',
            'manage_options',
            'coming-soon-by-florian-ie',
            array( $this, 'create_admin_page' )
        );
    }

    public function create_admin_page() {
        $this->options = get_option( 'csbf_options' );
        ?>
        <div class="wrap">
            <h1>Coming Soon by florian.ie</h1>
            <form method="post" action="options.php">
                <?php
                    settings_fields( 'csbf_option_group' );
                    do_settings_sections( 'csbf-setting-admin' );
                    submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function page_init() {
        register_setting(
            'csbf_option_group',
            'csbf_options',
            array( $this, 'sanitize' )
        );

        add_settings_section(
            'csbf_setting_section',
            'Settings',
            null,
            'csbf-setting-admin'
        );

        add_settings_field(
            'enabled',
            'Enable Coming Soon Mode',
            array( $this, 'enabled_callback' ),
            'csbf-setting-admin',
            'csbf_setting_section'
        );

        add_settings_field(
            'password',
            'Password',
            array( $this, 'password_callback' ),
            'csbf-setting-admin',
            'csbf_setting_section'
        );
    }

    public function sanitize( $input ) {
        $new_input = array();
        if ( isset( $input['enabled'] ) ) {
            $new_input['enabled'] = absint( $input['enabled'] );
        }

        if ( isset( $input['password'] ) ) {
            $new_input['password'] = sanitize_text_field( $input['password'] );
        }

        return $new_input;
    }

    public function enabled_callback() {
        printf(
            '<input type="checkbox" id="enabled" name="csbf_options[enabled]" value="1" %s />',
            isset( $this->options['enabled'] ) && $this->options['enabled'] == 1 ? 'checked' : ''
        );
    }

    public function password_callback() {
        printf(
            '<input type="text" id="password" name="csbf_options[password]" value="%s" />',
            isset( $this->options['password'] ) ? esc_attr( $this->options['password'] ) : ''
        );
    }
} 