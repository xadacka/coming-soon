<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php bloginfo('name'); ?> - Coming Soon</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
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
    </style>
    <?php wp_head(); ?>
</head>
<body>
    <div class="container">
        <h1 style="color: #fff !important;">Coming Soon</h1>
        <p style="color: #fff !important;">This site is under construction.<br>Please check back later.</p>
        <p style="color: #fff !important;">If you have a password, you can enter it below to unlock the site.</p>
        <form method="post">
            <input type="password" name="csbf_password" placeholder="Enter password">
            <input type="submit" value="Unlock">
        </form>
    </div>
    <div class="footer">
        powered by <a href="https://florian.ie">florian.ie</a>
    </div>
    <?php wp_footer(); ?>
</body>
</html> 