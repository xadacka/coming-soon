<?php

class Coming_Soon_By_Florian_IE {
    private $options;

    public function init() {
        $this->options = get_option( 'csbf_options' );
        add_action( 'template_redirect', array( $this, 'maybe_show_coming_soon' ) );
        add_action( 'admin_bar_menu', array( $this, 'add_admin_bar_menu' ), 999 );
        add_action( 'admin_init', array( $this, 'process_toggle' ) );
    }

    public function add_admin_bar_menu( $wp_admin_bar ) {
        $is_enabled = isset( $this->options['enabled'] ) && $this->options['enabled'];
        $status_text = $is_enabled ? 'On' : 'Off';

        // Add the main menu item
        $wp_admin_bar->add_node( array(
            'id'    => 'csbf-menu',
            'title' => 'Coming Soon: ' . $status_text,
            'href'  => '#',
            'meta'  => array(
                'class' => 'csbf-admin-bar'
            )
        ) );

        // Add the toggle link
        $toggle_url = wp_nonce_url( admin_url( '?csbf_toggle=1' ), 'csbf_toggle_status' );
        $wp_admin_bar->add_node( array(
            'id'     => 'csbf-toggle',
            'parent' => 'csbf-menu',
            'title'  => $is_enabled ? 'Turn Off' : 'Turn On',
            'href'   => $toggle_url,
        ) );

        // Add link to settings
        $wp_admin_bar->add_node( array(
            'id'     => 'csbf-settings',
            'parent' => 'csbf-menu',
            'title'  => 'Settings',
            'href'   => admin_url( 'admin.php?page=coming-soon-by-florian-ie' ),
        ) );
    }

    public function process_toggle() {
        if ( isset( $_GET['csbf_toggle'] ) && check_admin_referer( 'csbf_toggle_status' ) ) {
            $options = get_option( 'csbf_options' );
            $options['enabled'] = isset( $options['enabled'] ) && $options['enabled'] ? 0 : 1;
            update_option( 'csbf_options', $options );
            wp_redirect( remove_query_arg( array( 'csbf_toggle', '_wpnonce' ) ) );
            exit;
        }
    }

    public function maybe_show_coming_soon() {
        $is_enabled = isset( $this->options['enabled'] ) && $this->options['enabled'];
        $password   = isset( $this->options['password'] ) ? $this->options['password'] : '';
        $cookie_name = 'csbf_unlocked';

        // Don't show to logged in users, or if disabled
        if ( ! $is_enabled || is_user_logged_in() ) {
            return;
        }

        // Check for password submission
        if ( isset( $_POST['csbf_password'] ) ) {
            if ( $_POST['csbf_password'] === $password ) {
                setcookie( $cookie_name, 'true', time() + 86400, COOKIEPATH, COOKIE_DOMAIN );
                wp_redirect( home_url() );
                exit;
            }
        }

        // Check for unlock cookie
        if ( isset( $_COOKIE[ $cookie_name ] ) && $_COOKIE[ $cookie_name ] === 'true' ) {
            return;
        }

        // Show the coming soon page
        $this->show_coming_soon_page();
    }

    private function show_coming_soon_page() {
        $template_path = CSBF_PLUGIN_PATH . 'templates/coming-soon-page.php';

        if ( file_exists( $template_path ) ) {
            // Check if we should send 503 status code (configurable)
            $send_503 = isset( $this->options['send_503_status'] ) ? $this->options['send_503_status'] : false;
            
            if ( $send_503 ) {
                // Prevent search engines from indexing the coming soon page
                header('HTTP/1.1 503 Service Temporarily Unavailable');
                header('Status: 503 Service Temporarily Unavailable');
                header('Retry-After: 86400'); // 1 day
            }

            include $template_path;
            exit();
        }
    }
} 