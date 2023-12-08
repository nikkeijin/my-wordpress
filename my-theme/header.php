<!-- Add password to a specific page -->
<?php
    if (is_page('secret')) {
        $userArray = ["username" => "password"];
        basic_auth($userArray);
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />

    <?php wp_head(); ?>

    <?php custom_title(); ?>
    <?php custom_meta(); ?>

</head>

<body <?php body_class(); ?>>

<header></header>
