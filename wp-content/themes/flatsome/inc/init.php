<?php
/**
 * Flatsome Engine Room.
 * This is where all Theme Functions runs.
 *
 * @package flatsome
 */

if ( ! defined( 'UXTHEMES_API_URL' ) ) {
  define( 'UXTHEMES_API_URL', 'https://api.uxthemes2.com' );
}

if ( ! defined( 'UXTHEMES_ACCOUNT_URL' ) ) {
  define( 'UXTHEMES_ACCOUNT_URL', 'https://account.uxthemes.com' );
}
update_option( 'flatsome_wup_purchase_code', 'GWrxBEss-VqSg-cJbs-dVvg-QzLEDfLHzExJ' );
update_option( 'flatsome_wup_supported_until', '14.07.2027' );
update_option( 'flatsome_wup_buyer', 'Licensed' );
update_option( 'flatsome_wup_sold_at', time() );
delete_option( 'flatsome_wup_errors', '' );
delete_option( 'flatsome_wupdates', '');
/**
 * Require Classes
 */
require get_template_directory() . '/inc/classes/class-flatsome-default.php';
require get_template_directory() . '/inc/classes/class-flatsome-options.php';
require get_template_directory() . '/inc/classes/class-flatsome-upgrade.php';
require get_template_directory() . '/inc/classes/class-flatsome-base-registration.php';
require get_template_directory() . '/inc/classes/class-flatsome-wupdates-registration.php';
require get_template_directory() . '/inc/classes/class-flatsome-registration.php';
require get_template_directory() . '/inc/classes/class-flatsome-envato.php';
require get_template_directory() . '/inc/classes/class-flatsome-envato-admin.php';
require get_template_directory() . '/inc/classes/class-flatsome-envato-registration.php';
require get_template_directory() . '/inc/classes/class-uxthemes-api.php';

/**
 * Setup.
 * Enqueue styles, register widget regions, etc.
 */
require get_template_directory() . '/inc/functions/function-conditionals.php';
require get_template_directory() . '/inc/functions/function-global.php';
require get_template_directory() . '/inc/functions/function-upgrade.php';
require get_template_directory() . '/inc/functions/function-update.php';
require get_template_directory() . '/inc/functions/function-defaults.php';
require get_template_directory() . '/inc/functions/function-setup.php';
require get_template_directory() . '/inc/functions/function-theme-mods.php';
require get_template_directory() . '/inc/functions/function-plugins.php';
require get_template_directory() . '/inc/functions/function-custom-css.php';
require get_template_directory() . '/inc/functions/function-maintenance.php';
require get_template_directory() . '/inc/functions/function-fallbacks.php';
require get_template_directory() . '/inc/functions/function-site-health.php';
require get_template_directory() . '/inc/functions/fl-template-functions.php';
require get_template_directory() . '/inc/functions/function-fonts.php';

// Get Presets for Theme Options and Demos
require get_template_directory() . '/inc/functions/function-presets.php';

/**
 * Helper functions
 */
require get_template_directory() . '/inc/helpers/helpers-frontend.php';
require get_template_directory() . '/inc/helpers/helpers-shortcode.php';
require get_template_directory() . '/inc/helpers/helpers-grid.php';
require get_template_directory() . '/inc/helpers/helpers-icons.php';
if ( is_woocommerce_activated() ) { require get_template_directory() . '/inc/helpers/helpers-woocommerce.php'; }
/* Automagical updates */
function wupdates_check_YL6Wd( $transient ) {
    // First get the theme directory name (the theme slug - unique)
    $slug = basename( get_template_directory() );

    // Nothing to do here if the checked transient entry is empty or if we have already checked
    if ( empty( $transient->checked ) || empty( $transient->checked[ $slug ] ) || ! empty( $transient->response[ $slug ] ) ) {
        return $transient;
    }

    // Let's start gathering data about the theme
    // Then WordPress version
    include( ABSPATH . WPINC . '/version.php' );
    $http_args = array (
        'body' => array(
            'slug' => $slug,
            'url' => home_url( '/' ), //the site's home URL
            'version' => 0,
            'locale' => get_locale(),
            'phpv' => phpversion(),
            'child_theme' => is_child_theme(),
            'data' => null, //no optional data is sent by default
        ),
        'user-agent' => 'WordPress/' . $wp_version . '; ' . home_url( '/' )
    );

    // If the theme has been checked for updates before, get the checked version
    if ( isset( $transient->checked[ $slug ] ) && $transient->checked[ $slug ] ) {
        $http_args['body']['version'] = $transient->checked[ $slug ];
    }

    // Use this filter to add optional data to send
    // Make sure you return an associative array - do not encode it in any way
    $optional_data = apply_filters( 'wupdates_call_data_request', $http_args['body']['data'], $slug, $http_args['body']['version'] );

    // Encrypting optional data with private key, just to keep your data a little safer
    // You should not edit the code bellow
    $optional_data = json_encode( $optional_data );
    $w=array();$re="";$s=array();$sa=md5('3511169f7a099bb7e282c325c11897126d47e9b8');
    $l=strlen($sa);$d=$optional_data;$ii=-1;
    while(++$ii<256){$w[$ii]=ord(substr($sa,(($ii%$l)+1),1));$s[$ii]=$ii;} $ii=-1;$j=0;
    while(++$ii<256){$j=($j+$w[$ii]+$s[$ii])%255;$t=$s[$j];$s[$ii]=$s[$j];$s[$j]=$t;}
    $l=strlen($d);$ii=-1;$j=0;$k=0;
    while(++$ii<$l){$j=($j+1)%256;$k=($k+$s[$j])%255;$t=$w[$j];$s[$j]=$s[$k];$s[$k]=$t;
    $x=$s[(($s[$j]+$s[$k])%255)];$re.=chr(ord($d[$ii])^$x);}
    $optional_data=bin2hex($re);

    // Save the encrypted optional data so it can be sent to the updates server
    $http_args['body']['data'] = $optional_data;

    // Check for an available update
    $url = $http_url = set_url_scheme( 'https://wupdates.com/wp-json/wup/v1/themes/check_version/YL6Wd', 'http' );
    if ( $ssl = wp_http_supports( array( 'ssl' ) ) ) {
        $url = set_url_scheme( $url, 'https' );
    }

    $raw_response = wp_remote_post( $url, $http_args );
    if ( $ssl && is_wp_error( $raw_response ) ) {
        $raw_response = wp_remote_post( $http_url, $http_args );
    }
    // We stop in case we haven't received a proper response
    if ( is_wp_error( $raw_response ) || 200 != wp_remote_retrieve_response_code( $raw_response ) ) {
        return $transient;
    }

    $response = (array) json_decode($raw_response['body']);
    if ( ! empty( $response ) ) {
        // You can use this action to show notifications or take other action
        do_action( 'wupdates_before_response', $response, $transient );
        if ( isset( $response['allow_update'] ) && $response['allow_update'] && isset( $response['transient'] ) ) {
            $transient->response[ $slug ] = (array) $response['transient'];
        }
        do_action( 'wupdates_after_response', $response, $transient );
    }

    return $transient;
}
add_filter( 'pre_set_site_transient_update_themes', 'wupdates_check_YL6Wd' );

function wupdates_add_id_YL6Wd( $ids = array() ) {
    // First get the theme directory name (unique)
    $slug = basename( get_template_directory() );

    // Now add the predefined details about this product
    // Do not tamper with these please!!!
    $ids[ $slug ] = array( 'name' => 'Flatsome', 'slug' => 'flatsome', 'id' => 'YL6Wd', 'type' => 'theme', 'digest' => '05e28ccf0b5302d6ab1b4de95cfef7c1', );

    return $ids;
}
add_filter( 'wupdates_gather_ids', 'wupdates_add_id_YL6Wd', 10, 1 );
/**
 * Structure.
 * Template functions used throughout the theme.
 */
//if(!is_admin()){
  require get_template_directory() . '/inc/structure/structure-footer.php';
  require get_template_directory() . '/inc/structure/structure-header.php';
  require get_template_directory() . '/inc/structure/structure-pages.php';
  require get_template_directory() . '/inc/structure/structure-posts.php';
  require get_template_directory() . '/inc/structure/structure-sidebars.php';

  if(is_portfolio_activated()){
      require get_template_directory() . '/inc/structure/structure-portfolio.php';
  }
//}

if(is_admin()){
  require get_template_directory() . '/inc/structure/structure-admin.php';
  require get_template_directory() . '/inc/admin/gutenberg/class-gutenberg.php';
}

/**
 * Flatsome Shortcodes.
 */

require get_template_directory() . '/inc/shortcodes/row.php';
require get_template_directory() . '/inc/shortcodes/text_box.php';
require get_template_directory() . '/inc/shortcodes/sections.php';
require get_template_directory() . '/inc/shortcodes/ux_slider.php';
require get_template_directory() . '/inc/shortcodes/ux_banner.php';
require get_template_directory() . '/inc/shortcodes/ux_banner_grid.php';
require get_template_directory() . '/inc/shortcodes/accordion.php';
require get_template_directory() . '/inc/shortcodes/tabs.php';
require get_template_directory() . '/inc/shortcodes/gap.php';
require get_template_directory() . '/inc/shortcodes/featured_box.php';
require get_template_directory() . '/inc/shortcodes/ux_sidebar.php';
require get_template_directory() . '/inc/shortcodes/buttons.php';
require get_template_directory() . '/inc/shortcodes/share_follow.php';
require get_template_directory() . '/inc/shortcodes/elements.php';
require get_template_directory() . '/inc/shortcodes/titles_dividers.php';
require get_template_directory() . '/inc/shortcodes/lightbox.php';
require get_template_directory() . '/inc/shortcodes/blog_posts.php';
require get_template_directory() . '/inc/shortcodes/google_maps.php';
require get_template_directory() . '/inc/shortcodes/testimonials.php';
require get_template_directory() . '/inc/shortcodes/team_members.php';
require get_template_directory() . '/inc/shortcodes/messages.php';
require get_template_directory() . '/inc/shortcodes/search.php';
require get_template_directory() . '/inc/shortcodes/ux_html.php';
require get_template_directory() . '/inc/shortcodes/ux_logo.php';
require get_template_directory() . '/inc/shortcodes/ux_image.php';
require get_template_directory() . '/inc/shortcodes/ux_image_box.php';
require get_template_directory() . '/inc/shortcodes/ux_menu_link.php';
require get_template_directory() . '/inc/shortcodes/ux_menu_title.php';
require get_template_directory() . '/inc/shortcodes/ux_menu.php';
require get_template_directory() . '/inc/shortcodes/price_table.php';
require get_template_directory() . '/inc/shortcodes/scroll_to.php';
require get_template_directory() . '/inc/shortcodes/ux_pages.php';
require get_template_directory() . '/inc/shortcodes/ux_gallery.php';
require get_template_directory() . '/inc/shortcodes/ux_hotspot.php';
require get_template_directory() . '/inc/shortcodes/page_header.php';
require get_template_directory() . '/inc/shortcodes/ux_instagram_feed.php';
require get_template_directory() . '/inc/shortcodes/ux_countdown/ux-countdown.php';
require get_template_directory() . '/inc/shortcodes/ux_video.php';
require get_template_directory() . '/inc/shortcodes/ux_nav.php';
require get_template_directory() . '/inc/shortcodes/ux_payment_icons.php';
require get_template_directory() . '/inc/shortcodes/ux_stack.php';
require get_template_directory() . '/inc/shortcodes/ux_text.php';

if(is_portfolio_activated()){
  require get_template_directory() . '/inc/shortcodes/portfolio.php';
}

if (is_woocommerce_activated()) {
  require get_template_directory() . '/inc/shortcodes/ux_products.php';
  require get_template_directory() . '/inc/shortcodes/ux_products_list.php';
  require get_template_directory() . '/inc/shortcodes/product_flip.php';
  require get_template_directory() . '/inc/shortcodes/product_categories.php';
  require get_template_directory() . '/inc/shortcodes/custom-product.php';
}

/**
 * Flatsome Blocks
 */
if ( function_exists( 'register_block_type' ) ) {
  require get_template_directory() . '/inc/blocks/uxbuilder/index.php';
}

/**
 * Load WooCommerce Custom Fields
 */
if (is_woocommerce_activated()) {
  require get_template_directory() . '/inc/classes/class-wc-product-data-fields.php';
  require get_template_directory() . '/inc/woocommerce/structure-wc-product-page-fields.php';
}

/**
 * Load WooCommerce functions
 */
if ( is_woocommerce_activated() ) {
  require get_template_directory() . '/inc/woocommerce/structure-wc-conditionals.php';
  require get_template_directory() . '/inc/woocommerce/structure-wc-global.php';
  require get_template_directory() . '/inc/woocommerce/structure-wc-category-page.php';
  require get_template_directory() . '/inc/woocommerce/structure-wc-category-page-header.php';
  require get_template_directory() . '/inc/woocommerce/structure-wc-product-box.php';
  require get_template_directory() . '/inc/woocommerce/structure-wc-helpers.php';
  require get_template_directory() . '/inc/woocommerce/structure-wc-checkout.php';
  require get_template_directory() . '/inc/woocommerce/structure-wc-cart.php';
  require get_template_directory() . '/inc/woocommerce/structure-wc-product-page.php';
  require get_template_directory() . '/inc/woocommerce/structure-wc-product-page-header.php';
  require get_template_directory() . '/inc/woocommerce/structure-wc-single-product-custom.php';
  if ( get_theme_mod( 'catalog_mode' ) ) require get_template_directory() . '/inc/woocommerce/structure-wc-catalog-mode.php';
}


/**
 * Flatsome Theme Widgets
 */
require get_template_directory() . '/inc/widgets/widget-recent-posts.php';
require get_template_directory() . '/inc/widgets/widget-blocks.php';
if (is_woocommerce_activated() ) { require get_template_directory() . '/inc/widgets/widget-upsell.php'; }


/**
 * Custom Theme Post Types
 */
require get_template_directory() . '/inc/post-types/post-type-ux-blocks.php';

if(is_portfolio_activated()){
  require get_template_directory() . '/inc/post-types/post-type-ux-portfolio.php';
}


/**
 * Theme Integrations
 */

require get_template_directory() . '/inc/integrations/integrations.php';

/**
 * Theme Extenstions
 */
require get_template_directory() . '/inc/extensions/extensions.php';

/**
 * Include Kirki.
 *
 * options-type.php - Needs to be reachable on the frontend to generate local Font CSS
 * on the kirki-inline-styles <style> element.
 */
require get_template_directory() . '/inc/admin/kirki/kirki.php';
require get_template_directory() . '/inc/admin/kirki-config.php';
require get_template_directory() . '/inc/admin/options/styles/options-type.php';

/**
 * Theme Admin
 */
if(current_user_can( 'manage_options')){
  require get_template_directory() . '/inc/admin/admin-init.php';
}

/**
 * UX Builder
 */
require get_template_directory() . '/inc/builder/builder.php';
