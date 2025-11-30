<?php
/**
 * Plugin Name: UN Gamification
 * Description: Gamification Plugin for UN Project – Designed for WordPress
 * Version: 1.0
 * Author: Avijei IT
 * License: GPL2
 * Text Domain: un-gamification
 * Domain Path: /languages
 */

defined('ABSPATH') || exit;

add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style('un-flow-style', plugins_url('assets/css/popup-flow.css', __FILE__));
	wp_enqueue_style('un-fonts-style', plugins_url('assets/css/fonts.css', __FILE__));
	wp_enqueue_style('un-dialogue-style', plugins_url('assets/css/dialogue.css', __FILE__));
	
    wp_enqueue_script('un-flow-script', plugins_url('assets/js/popup-flow.js', __FILE__), ['jquery'], null, true);
    wp_enqueue_script('un-dialogue-script', plugins_url('assets/js/dialogue.js', __FILE__), ['jquery'], null, true);
	wp_enqueue_script('un-analytics-script', plugins_url('assets/js/analytics.js', __FILE__), ['jquery'], null, true);
	

	

    wp_localize_script('un-flow-script', 'UNFlow', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('un_flow_nonce')
    ]);
});
function enqueue_gsap_script() {
    wp_enqueue_script(
        'gsap', // هندل اسکریپت
        'assets/js/gsap.min.js', // آدرس فایل CDN
        array(), // وابستگی‌ها (می‌تونی مثلا ['jquery'] بزاری اگر نیاز داشت)
        '3.12.2', // ورژن
        true // لود در footer
    );
}
add_action('wp_enqueue_scripts', 'enqueue_gsap_script');


add_action('init', function() {
    load_plugin_textdomain(
        'un-gamification',
        false,
        dirname(plugin_basename(__FILE__)) . '/languages'
    );
});

// Upload original files
//require_once plugin_dir_path(__FILE__) . 'includes/userID.php';//ساخت یوزر آیدی در کوکی
//require_once plugin_dir_path(__FILE__) . 'includes/userPoints.php';// ساخت امتیاز در کوکی
//require_once plugin_dir_path(__FILE__) . 'includes/userBadges.php';// ساخت بدجت در کوکی
require_once plugin_dir_path(__FILE__) . 'includes/userStageStructure.php'; // ساختار جریان ها و مراحل
//require_once plugin_dir_path(__FILE__) . 'includes/flowLock.php'; // قفل جریان ها
require_once plugin_dir_path(__FILE__) . 'includes/display.php'; // نمایش لیست جریان ها و مراحل
require_once plugin_dir_path(__FILE__) . 'includes/userStageFields.php'; // فیلدهای مراحل
require_once plugin_dir_path(__FILE__) . 'includes/userStageTypeFields.php'; // فیلدهای مراحل بر اساس نوع
require_once plugin_dir_path(__FILE__) . 'includes/userStageView.php'; // ساخت شورت‌کد برای نمایش مراحل در فرانت
require_once plugin_dir_path(__FILE__) . 'includes/btnPopup.php'; // شورت‌کد برای دکمه بازکننده پاپ‌آپ جریان
require_once plugin_dir_path(__FILE__) . 'includes/ajaxHandlers.php'; // لود کننده محتوا در پاپ آپ




function enqueue_custom_script() {
    wp_enqueue_script('my-custom-js', get_template_directory_uri() . '/js/script.js', array('jquery'), null, true);

    // ارسال داده‌های ترجمه به جاوا اسکریپت
    wp_localize_script('my-custom-js', 'unFlowMessages', array(
        'loading' => __('Loading...', 'un-gamification'), 
        'error_loading_stage' => __('Error loading stage.', 'un-gamification'),
        'error_loading_flows' => __('Error fetching flows.', 'un-gamification'),
        'next_stage_loading' => __('Loading next stage...', 'un-gamification'),
        'quiz_next_stage_error' => __('Next stage not defined.', 'un-gamification'),
        'error_next_stage' => __('Error in next stage.', 'un-gamification'),
        'loading_category' => __('Loading...', 'un-gamification'),
        'restart_warning' => __('⛔️ firstStageId not found', 'un-gamification'),
        'category_not_defined' => __('⛔️ currentCategory not defined', 'un-gamification'),
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_script');










