<?php

class Coming_Soon_By_Florian_IE {
    private $options;

    public function init() {
        $this->options = get_option( 'csbf_options' );
        add_action( 'template_redirect', array( $this, 'maybe_show_coming_soon' ) );
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
            // Prevent search engines from indexing the coming soon page
            header('HTTP/1.1 503 Service Temporarily Unavailable');
            header('Status: 503 Service Temporarily Unavailable');
            header('Retry-After: 86400'); // 1 day

            include $template_path;
            exit();
        }
    }
} 