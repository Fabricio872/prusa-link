<?php
/**
 * Plugin Name: Prusa link
 * Plugin URI: https://github.com/Fabricio872/prusa-link
 * Description: Widget for caching and showing data from web
 * Version: 0.0.1
 * Author: Fabricio Jakubec
 * Author URI: https://github.com/Fabricio872
 */

require __DIR__ . '/vendor/autoload.php';

add_action('rest_api_init', 'register_api');
add_action('init', 'register_shortcodes');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

function register_api()
{
    register_rest_route('prusa-link/v1', '/data/', array(
        'methods'  => 'GET',
        'callback' => 'json_api',
    ));
}

function register_shortcodes()
{
    add_shortcode('pp-link', 'widget');
}

function widget($atts = array(), $content = null)
{
    $main = new \App\Main($atts[0]);

    return $main->getWidget();
}

function json_api(WP_REST_Request $request)
{
    $main = new \App\Main($request->get_param('link'));

    return rest_ensure_response($main->getJson());
}
