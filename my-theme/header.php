<!-- Add password to a specific page -->
<?php
    if(is_page('secret')):
        $userArray = array(
            "username" => "password"
        );
        basic_auth($userArray);
    endif;
?>

<!DOCTYPE html>
<html lang="ja">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">

    <?php wp_head(); ?>

    <title><?php if ( is_front_page() ) echo ('X Company | Home Page'); else wp_title(); ?></title>

</head>

<body <?php body_class(); ?>>

<header></header>