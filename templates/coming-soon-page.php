<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php bloginfo('name'); ?> - Coming Soon</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <?php
        $options = get_option( 'csbf_options' );
        $color1 = ! empty( $options['gradient_color_1'] ) ? $options['gradient_color_1'] : '#ee7752';
        $color2 = ! empty( $options['gradient_color_2'] ) ? $options['gradient_color_2'] : '#e73c7e';
        $color3 = ! empty( $options['gradient_color_3'] ) ? $options['gradient_color_3'] : '#23a6d5';
        $color4 = ! empty( $options['gradient_color_4'] ) ? $options['gradient_color_4'] : '#23d5ab';
    ?>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(-45deg, <?php echo $color1; ?>, <?php echo $color2; ?>, <?php echo $color3; ?>, <?php echo $color4; ?>);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #fff;
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

        .container {
            text-align: center;
            padding: 50px;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            max-width: 500px;
            width: 90%;
        }
        h1 {
            font-size: 3em;
            margin-bottom: 0.5em;
            color: #fff;
        }
        p {
            font-size: 1.1em;
            margin-bottom: 1.5em;
            color: #fff;
        }
        form {
            margin-top: 20px;
        }
        input[type="password"] {
            padding: 15px;
            width: calc(100% - 34px);
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            padding: 15px 30px;
            background-color: #0073aa;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #005177;
        }
        .footer {
            position: absolute;
            bottom: 20px;
            font-size: 0.9em;
            color: #fff;
        }
        .footer a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        .logo-container {
            margin-bottom: 20px;
        }
        .logo {
            max-height: 100px;
            max-width: 80%;
            width: auto;
            height: auto;
        }
    </style>
</head>
<body>
    <?php
        $logo_url = isset( $options['logo_url'] ) ? $options['logo_url'] : '';
        $title = isset( $options['title'] ) && ! empty( $options['title'] ) ? $options['title'] : 'Coming Soon';
        $text = isset( $options['text'] ) && ! empty( $options['text'] ) ? $options['text'] : "This site is under construction. Please check back later.\nIf you have a password, you can enter it below to unlock the site.";
        $footer_text = isset( $options['footer_text'] ) && ! empty( $options['footer_text'] ) ? $options['footer_text'] : 'powered by <a href="https://florian.ie">florian.ie</a>';
    ?>
    <div class="container">
        <?php if ( ! empty( $logo_url ) ) : ?>
            <div class="logo-container">
                <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> Logo" class="logo">
            </div>
        <?php endif; ?>
        <h1 style="color: #fff !important;"><?php echo esc_html( $title ); ?></h1>
        <p style="color: #fff !important;"><?php echo nl2br( esc_html( $text ) ); ?></p>
        <form method="post">
            <input type="password" name="csbf_password" placeholder="Enter password">
            <input type="submit" value="Unlock">
        </form>
    </div>
    <div class="footer">
        <?php echo wp_kses_post( $footer_text ); ?>
    </div>
</body>
</html> 