<?php

class Coming_Soon_By_Florian_IE_Options {
    private $options;

    public function init() {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
    }

    public function enqueue_admin_scripts( $hook ) {
        // Only load on our admin page
        if ( 'toplevel_page_coming-soon-by-florian-ie' !== $hook ) {
            return;
        }
        wp_enqueue_media();
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script(
            'csbf-admin-js',
            plugin_dir_url( dirname( __FILE__ ) ) . 'js/admin.js',
            array( 'jquery', 'wp-color-picker' ),
            '1.0.1',
            true
        );
    }

    public function add_plugin_page() {
        add_menu_page(
            'Coming Soon Settings',
            'Coming Soon',
            'manage_options',
            'coming-soon-by-florian-ie',
            array( $this, 'create_admin_page' ),
            'dashicons-hourglass'
        );
    }

    public function create_admin_page() {
        $this->options = get_option( 'csbf_options' );
        
        // Get current gradient colors or use defaults
        $defaults = array( '#ee7752', '#e73c7e', '#23a6d5', '#23d5ab' );
        $color1 = isset( $this->options['gradient_color_1'] ) && ! empty( $this->options['gradient_color_1'] ) ? $this->options['gradient_color_1'] : $defaults[0];
        $color2 = isset( $this->options['gradient_color_2'] ) && ! empty( $this->options['gradient_color_2'] ) ? $this->options['gradient_color_2'] : $defaults[1];
        $color3 = isset( $this->options['gradient_color_3'] ) && ! empty( $this->options['gradient_color_3'] ) ? $this->options['gradient_color_3'] : $defaults[2];
        $color4 = isset( $this->options['gradient_color_4'] ) && ! empty( $this->options['gradient_color_4'] ) ? $this->options['gradient_color_4'] : $defaults[3];
        
        ?>
        <style>
            #csbf-settings-container {
                display: grid;
                grid-template-columns: 2fr 1fr;
                gap: 30px;
            }
            #csbf-live-preview-container {
                background: #fff;
                padding: 20px;
                border: 1px solid #c3c4c7;
            }
            #csbf-live-preview {
                color: #fff;
                padding: 30px;
                text-align: center;
                border-radius: 5px;
                height: 400px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                background: linear-gradient(-45deg, <?php echo esc_attr( $color1 ); ?>, <?php echo esc_attr( $color2 ); ?>, <?php echo esc_attr( $color3 ); ?>, <?php echo esc_attr( $color4 ); ?>);
                background-size: 400% 400%;
                animation: gradient 15s ease infinite;
            }
            @keyframes gradient {
                0% {
                    background-position: 0% 50%;
                }
                50% {
                    background-position: 100% 50%;
                }
                100% {
                    background-position: 0% 50%;
                }
            }
            #csbf-live-preview h1, #csbf-live-preview p {
                color: #fff;
                margin: 10px 0;
            }
            #csbf-live-preview h1 {
                font-size: 2.5em;
                font-weight: bold;
            }
            #csbf-live-preview p {
                font-size: 1.1em;
                line-height: 1.5;
            }
            .csbf-presets .button.active {
                border-color: #007cba;
                box-shadow: 0 0 0 1px #007cba;
            }
            .csbf-footer {
                margin-top: 30px;
                border-top: 1px solid #ddd;
                padding-top: 15px;
                text-align: center;
                font-style: italic;
            }
        </style>
        <div class="wrap">
            <h1>Coming Soon by florian.ie</h1>
            <div id="csbf-settings-container">
                <form method="post" action="options.php" id="csbf-settings-form">
                    <?php
                        settings_fields( 'csbf_option_group' );
                        do_settings_sections( 'csbf-setting-admin' );
                        submit_button();
                    ?>
                </form>
                <div id="csbf-live-preview-container">
                    <h2>Live Preview</h2>
                    <div id="csbf-live-preview">
                        <div class="logo-container-preview">
                            <?php if ( ! empty( $this->options['logo_url'] ) ) : ?>
                                <img src="<?php echo esc_url( $this->options['logo_url'] ); ?>" style="max-height: 100px; max-width: 80%; width: auto; height: auto;">
                            <?php endif; ?>
                        </div>
                        <h1 class="preview-title"><?php echo esc_html( isset( $this->options['title'] ) && ! empty( $this->options['title'] ) ? $this->options['title'] : 'Coming Soon' ); ?></h1>
                        <p class="preview-text"><?php echo nl2br( esc_html( isset( $this->options['text'] ) && ! empty( $this->options['text'] ) ? $this->options['text'] : 'This site is under construction. Please check back later.' ) ); ?></p>
                    </div>
                </div>
            </div>
             <div class="csbf-footer">
                <p>Coming Soon plugin is powered by <a href="https://florian.ie" target="_blank">florian.ie</a> | <a href="https://buymeacoffee.com/florian.ie" target="_blank">Buy me a coffee</a></p>
            </div>
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

        add_settings_field(
            'logo_url',
            'Logo',
            array( $this, 'logo_url_callback' ),
            'csbf-setting-admin',
            'csbf_setting_section'
        );

        add_settings_field(
            'title',
            'Headline',
            array( $this, 'title_callback' ),
            'csbf-setting-admin',
            'csbf_setting_section'
        );

        add_settings_field(
            'text',
            'Content',
            array( $this, 'text_callback' ),
            'csbf-setting-admin',
            'csbf_setting_section'
        );

        add_settings_field(
            'footer_text',
            'Footer Text',
            array( $this, 'footer_text_callback' ),
            'csbf-setting-admin',
            'csbf_setting_section'
        );

        add_settings_field(
            'gradient_presets',
            'Gradient Presets',
            array( $this, 'gradient_presets_callback' ),
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

        if ( isset( $input['logo_url'] ) ) {
            $new_input['logo_url'] = esc_url_raw( $input['logo_url'] );
        }

        if ( isset( $input['title'] ) ) {
            $new_input['title'] = sanitize_text_field( $input['title'] );
        }

        if ( isset( $input['text'] ) ) {
            $new_input['text'] = wp_kses_post( $input['text'] );
        }

        if ( isset( $input['footer_text'] ) ) {
            $new_input['footer_text'] = wp_kses_post( $input['footer_text'] );
        }

        for ( $i = 1; $i <= 4; $i++ ) {
            if ( isset( $input['gradient_color_' . $i] ) ) {
                $new_input['gradient_color_' . $i] = sanitize_hex_color( $input['gradient_color_' . $i] );
            }
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

    public function logo_url_callback() {
        $logo_url = isset( $this->options['logo_url'] ) ? $this->options['logo_url'] : '';
        ?>
        <div class="csbf-logo-uploader">
            <input type="text" name="csbf_options[logo_url]" id="csbf_logo_url" value="<?php echo esc_url( $logo_url ); ?>" class="regular-text">
            <button type="button" class="button" id="csbf_upload_logo_button">Upload Logo</button>
            <div class="csbf-logo-preview">
                <?php if ( ! empty( $logo_url ) ) : ?>
                    <img src="<?php echo esc_url( $logo_url ); ?>" style="max-width: 200px; max-height: 100px; margin-top: 10px;">
                    <button type="button" class="button button-secondary" id="csbf_remove_logo_button" style="display:inline-block;">Remove Logo</button>
                <?php else : ?>
                    <img src="" style="max-width: 200px; max-height: 100px; margin-top: 10px; display: none;">
                     <button type="button" class="button button-secondary" id="csbf_remove_logo_button" style="display:none;">Remove Logo</button>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    public function title_callback() {
        printf(
            '<input type="text" id="title" name="csbf_options[title]" value="%s" class="regular-text" />',
            isset( $this->options['title'] ) ? esc_attr( $this->options['title'] ) : 'Coming Soon'
        );
    }

    public function text_callback() {
        $content = isset( $this->options['text'] ) ? $this->options['text'] : "This site is under construction. Please check back later.\nIf you have a password, you can enter it below to unlock the site.";
        printf(
            '<textarea id="text" name="csbf_options[text]" rows="5" class="large-text">%s</textarea>',
            esc_textarea( $content )
        );
    }

    public function footer_text_callback() {
        $content = isset( $this->options['footer_text'] ) ? $this->options['footer_text'] : 'powered by <a href="https://florian.ie">florian.ie</a>';
        printf(
            '<input type="text" id="footer_text" name="csbf_options[footer_text]" value="%s" class="regular-text" />',
            esc_attr( $content )
        );
    }

    public function gradient_presets_callback() {
        $defaults = array( '#ee7752', '#e73c7e', '#23a6d5', '#23d5ab' );
        ?>
        <div id="csbf-presets-wrapper">
            <p class="description">Select a preset or customise the colours below.</p>
            <div class="csbf-presets">
                <button type="button" class="button csbf-preset-button" data-preset="1">Sunrise</button>
                <button type="button" class="button csbf-preset-button" data-preset="2">Ocean</button>
                <button type="button" class="button csbf-preset-button" data-preset="3">Forest</button>
                <button type="button" class="button csbf-preset-button" data-preset="4">Sunset</button>
                <button type="button" class="button csbf-preset-button" data-preset="5">Grape</button>
            </div>
            <div class="csbf-color-fields" style="margin-top: 15px;">
                <p class="description">Gradient Colours:</p>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 10px;">
                    <?php for ( $i = 1; $i <= 4; $i++ ) : ?>
                        <?php $color = isset( $this->options['gradient_color_' . $i] ) && ! empty( $this->options['gradient_color_' . $i] ) ? $this->options['gradient_color_' . $i] : $defaults[ $i - 1 ]; ?>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <label for="gradient_color_<?php echo $i; ?>" style="min-width: 60px;">Colour <?php echo $i; ?>:</label>
                            <input type="text" id="gradient_color_<?php echo $i; ?>" name="csbf_options[gradient_color_<?php echo $i; ?>]" value="<?php echo esc_attr( $color ); ?>" class="csbf-color-picker" />
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
        <?php
    }
} 