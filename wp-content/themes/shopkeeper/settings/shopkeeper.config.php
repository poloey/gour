<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }


    // This is your option name where all the Redux data is stored.
    $opt_name = "shopkeeper_theme_options";

        // Replace this string your opt_name
    $opt_name = 'shopkeeper_theme_options';

    Redux::setExtensions( $opt_name, dirname( __FILE__ ) . '/redux/extensions/advanced_customizer' );
    Redux::setExtensions( $opt_name, dirname( __FILE__ ) . '/redux/extensions/ad_remove' );

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $show_admin         = false;
    $page_parent        = 'getbowtied_theme';
    $menu_type          = 'submenu';
    $menu_title         = 'Theme Options';
    $allow_sub_menu     = true;
    $page_priority      = null;

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $theme->get( 'Name' ),
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version' ),
        // Version that appears at the top of your panel
        'menu_type'            => $menu_type,
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => $allow_sub_menu,
        // Show the sections below the admin menu item or not
        'menu_title'           => __( $menu_title, 'redux-framework-demo' ),
        'page_title'           => __( 'Theme Options', 'redux-framework-demo' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => 'AIzaSyDGJehqeZnxz4hABrNgi9KrBTG7ev6rIgY',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => true,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => true,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => $show_admin,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-portfolio',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => true,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => true,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => $page_priority,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => $page_parent,
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => '',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => 'theme_options',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        'footer_credit'        => '&nbsp;',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'system_info'          => false,
        // REMOVE

        //'compiler'             => true,

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'red',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );

    // Panel Intro text -> before the form
    if ( ! isset( $args['global_variable'] ) || $args['global_variable'] !== false ) {
        if ( ! empty( $args['global_variable'] ) ) {
            $v = $args['global_variable'];
        } else {
            $v = str_replace( '-', '_', $args['opt_name'] );
        }
        //$args['intro_text'] = "";
    } else {
        //$args['intro_text'] = "";
    }

    // Add content after the form.
    //$args['footer_text'] = "";

    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */


    /*
     *
     * ---> START SECTIONS
     *
     */

    /*

        As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for


     */

    // -> START Basic Fields

    Redux::setSection( $opt_name, array(
        'icon'   => 'el el-website',
        'title'  => __( 'Header Layout & Style', 'shopkeeper' ),
        'fields' => array(
            
            array(
                'id'       => 'main_header_layout',
                'type'     => 'image_select',
                'compiler' => true,
                'title'    => __( 'Header Layout', 'shopkeeper' ),
                'options'  => array(
                    '1' => array(
                        'alt' => 'Layout 1 - Left',
                        'img' => get_template_directory_uri() . '/images/theme_options/icons/header_1.png'
                    ),
                    '11' => array(
                        'alt' => 'Layout 11 - Right',
                        'img' => get_template_directory_uri() . '/images/theme_options/icons/header_1b.png'
                    ),
                    '2' => array(
                        'alt' => 'Layout 2 - Align to Logo',
                        'img' => get_template_directory_uri() . '/images/theme_options/icons/header_2.png'
                    ),
                    '22' => array(
                        'alt' => 'Layout 22 - Align to Edges',
                        'img' => get_template_directory_uri() . '/images/theme_options/icons/header_2b.png'
                    ),
                    '3' => array(
                        'alt' => 'Layout 3',
                        'img' => get_template_directory_uri() . '/images/theme_options/icons/header_3.png'
                    ),
                ),
                'default'  => '1'
            ),

            array (
                'id' => 'main_nav_font_options',
                'icon' => 'fa fa-font',
                'type' => 'info',
                'raw' => '<h3>Font Settings</h3>',
            ),
            
            array(
                'title' => __('Main Header Font Size', 'shopkeeper'),
                'id' => 'main_header_font_size',
                'type' => 'slider',
                "default" => 13,
                "min" => 11,
                "step" => 1,
                "max" => 16,
                'display_value' => 'text'
            ),
            
            array (
                'title' => __('Main Header Font Color', 'shopkeeper'),
                'id' => 'main_header_font_color',
                'type' => 'color',
                'default' => '#fff',
                'transparent' => false
            ),
            
            array (
                'id' => 'header_size_spacing',
                'icon' => 'fa fa-sliders',
                'type' => 'info',
                'raw' => '<h3>Spacing and Size</h3>',
            ),
            
            array(
                'title' => __('Spacing Above the Logo', 'shopkeeper'),
                'id' => 'spacing_above_logo',
                'type' => 'slider',
                "default" => 22,
                "min" => 0,
                "step" => 1,
                "max" => 200,
                'display_value' => 'text'
            ),
            
            array(
                'title' => __('Spacing Below the Logo', 'shopkeeper'),
                'id' => 'spacing_below_logo',
                'type' => 'slider',
                "default" => 22,
                "min" => 0,
                "step" => 1,
                "max" => 200,
                'display_value' => 'text'
            ),                      

            array(
                'id'       => 'header_width',
                'type'     => 'button_set',
                'title'    => __( 'Header Width', 'shopkeeper' ),
                'options'  => array(
                    'full'  => 'Full',
                    'custom'    => 'Custom'
                ),
                'default'  => 'custom',
            ),
            
            array(
                'title' => __('Header Max Width', 'shopkeeper'),
                'id' => 'header_max_width',
                'type' => 'slider',
                "default" => 1680,
                "min" => 960,
                "step" => 1,
                "max" => 1680,
                'display_value' => 'text',
                'required' => array( 'header_width', 'equals', array( 'custom' ) ),
            ),  
            
            array (
                'id' => 'header_bg_options',
                'icon' => 'fa fa-eyedropper',
                'type' => 'info',
                'raw' => '<h3>Header Background</h3>',
            ),
            
            array(
                'id'            => 'main_header_background',
                'type'          => 'background',
                'title'         => "Header Background Color",
                'default'  => array(
                    'background-color' => '#333333',
                ),
                'transparent'   => false,
            ),                      

        ),
        
    ) );

    Redux::setSection( $opt_name, array(
        'icon'       => 'fa fa-angle-right',
        'title'      => __( 'Header Elements', 'shopkeeper' ),
        'subsection' => true,
        'fields'     => array(
            
            array (
                'id' => 'wishlist_header_info',
                'icon' => true,
                'type' => 'info',
                'icon' => 'fa fa-heart',
                'raw' => '<h3>Wishlist Icon</h3>',
            ),
            
            array (
                'id' => 'main_header_wishlist',
                'on' => __('Enabled', 'shopkeeper'),
                'off' => __('Disabled', 'shopkeeper'),
                'type' => 'switch',
                'default' => 1,
            ),
            
            array (
                'title' => __('Custom Wishlist Icon', 'shopkeeper'),
                'id' => 'main_header_wishlist_icon',
                'type' => 'media',
                'required' => array( 'main_header_wishlist', 'equals', array( '1' ) ),
            ),

            array (
                'id' => 'bag_header_info',
                'icon' => true,
                'type' => 'info',
                'icon' => 'fa fa-shopping-cart',
                'raw' => '<h3>Shopping Cart Icon</h3>',
            ),
            
            array (
                'id' => 'main_header_shopping_bag',
                'on' => __('Enabled', 'shopkeeper'),
                'off' => __('Disabled', 'shopkeeper'),
                'type' => 'switch',
                'default' => 1,
            ),
            
            array (
                'title' => __('Custom Cart Icon', 'shopkeeper'),
                'id' => 'main_header_shopping_bag_icon',
                'type' => 'media',
                'required' => array( 'main_header_shopping_bag', 'equals', array( '1' ) ),
            ),
            
            array (
                'id' => 'search_header_info',
                'icon' => true,
                'type' => 'info',
                'icon' => 'fa fa-search',
                'raw' => '<h3>Search Icon</h3>',
            ),
            
            array (
                'id' => 'main_header_search_bar',
                'on' => __('Enabled', 'shopkeeper'),
                'off' => __('Disabled', 'shopkeeper'),
                'type' => 'switch',
                'default' => 1,
            ),
            
            array (
                'title' => __('Custom Search Icon', 'shopkeeper'),
                'id' => 'main_header_search_bar_icon',
                'type' => 'media',
                'required' => array( 'main_header_search_bar', 'equals', array( '1' ) ),
            ),
            
            array (
                'id' => 'offcanvas_header_info',
                'icon' => true,
                'type' => 'info',
                'icon' => 'fa fa-bars',
                'raw' => '<h3>Off-Canvas Drawer</h3>',
            ),
            
            array (
                'id' => 'main_header_off_canvas',
                'on' => __('Enabled', 'shopkeeper'),
                'off' => __('Disabled', 'shopkeeper'),
                'type' => 'switch',
                'default' => 0,
            ),
            
            array (
                'title' => __('Main Header Off-Canvas Icon', 'shopkeeper'),
                'id' => 'main_header_off_canvas_icon',
                'type' => 'media',
                'required' => array( 'main_header_off_canvas', 'equals', array( '1' ) ),
            ),
            
        )
        
    ) );

    Redux::setSection( $opt_name, array(
        'icon'       => 'fa fa-angle-right',
        'title'      => __( 'Logo', 'shopkeeper' ),
        'subsection' => true,
        'fields'     => array(
        
            array (
                'title' => __('Your Logo', 'shopkeeper'),
                'id' => 'site_logo',
                'type' => 'media',
                'default' => array (
                    'url' => get_template_directory_uri() . '/images/shopkeeper-theme-logo-dark.png',
                ),
            ),
            
            array (
                'title' => __('Alternative Logo', 'shopkeeper'),
                'subtitle' => __('Used on the <strong>Sticky Header</strong> and <strong>Mobile Devices</strong>.', 'shopkeeper'),
                'id' => 'sticky_header_logo',
                'type' => 'media',
                'default' => array (
                    'url' => get_template_directory_uri() . '/images/shopkeeper-theme-logo-light.png',
                ),
            ),
            
            array(
                'title' => __('Logo Container Min Width', 'shopkeeper'),
                'id' => 'logo_min_height',
                'type' => 'slider',
                "default" => 300,
                "min" => 0,
                "step" => 1,
                "max" => 600,
                'display_value' => 'text',
                'required' => array( 'main_header_layout', 'equals', array( '2' ) ),
            ),
            
            array(
                'title' => __('Logo Height', 'shopkeeper'),
                'id' => 'logo_height',
                'type' => 'slider',
                "default" => 46,
                "min" => 0,
                "step" => 1,
                "max" => 300,
                'display_value' => 'text',
            ),
            
        )
        
    ) );

    Redux::setSection( $opt_name, array(
        'icon'       => 'fa fa-angle-right',
        'title'      => __( 'Header Transparency', 'shopkeeper' ),
        'subsection' => true,
        'fields'     => array(
        
            array (
                'title' => __('Header Transparency (Global)', 'shopkeeper'),
                'id' => 'main_header_transparency',
                'on' => __('Enabled', 'shopkeeper'),
                'off' => __('Disabled', 'shopkeeper'),
                'type' => 'switch',
                'default' => 0,
            ),
            
            array(
                'id'       => 'main_header_transparency_scheme',
                'type'     => 'button_set',
                'title'    => __( 'Default Color Scheme - Global', 'shopkeeper' ),
                'subtitle' => __( 'Set a default color scheme for the transparent header to be inherited by all the pages.', 'shopkeeper' ),
                'options'  => array(
                    'transparency_light'    => '<i class="fa fa-circle-o"></i> Light',
                    'transparency_dark'     => '<i class="fa fa-circle"></i> Dark',
                ),
                'default'  => 'transparency_light',
            ),

            array(
                'id'       => 'shop_category_header_transparency_scheme',
                'type'     => 'button_set',
                'title'    => __( 'Default Color Scheme - Product Categories', 'mr_tailor_settings' ),
                'subtitle' => __( 'Set the color scheme for the transparent header to be displayed on the shop category page.', 'mr_tailor_settings' ),
                'options'  => array(
                    'inherit'               => 'Inherit',
                    'no_transparency'       => 'No Transparency',
                    'transparency_light'    => '<i class="fa fa-circle-o"></i> Light',
                    'transparency_dark'     => '<i class="fa fa-circle"></i> Dark',
                ),
                'default'  => 'inherit',
            ),
            
            array (
                'id' => 'light_scheme',
                'icon' => true,
                'type' => 'info',
                'icon' => 'fa fa-circle-o',
                'raw' => '<h3>Light Color Scheme</h3>',
            ),                      
            
            array (
                'title' => __('Transparent Header Light Color', 'shopkeeper'),
                'id' => 'main_header_transparent_light_color',
                'type' => 'color',
                'default' => '#fff',
                'transparent' => false
            ),
            
            array (
                'title' => __('Logo for Light Transparent Header', 'shopkeeper'),
                'id' => 'light_transparent_header_logo',
                'type' => 'media',
                'default' => array (
                    'url' => get_template_directory_uri() . '/images/shopkeeper-theme-logo-light.png',
                ),
            ),

            array (
                'id' => 'dark_scheme',
                'icon' => true,
                'type' => 'info',
                'icon' => 'fa fa-circle',
                'raw' => '<h3>Dark Color Scheme</h3>',
            ),  
            
            array (
                'title' => __('Transparent Header Dark Color', 'shopkeeper'),
                'id' => 'main_header_transparent_dark_color',
                'type' => 'color',
                'default' => '#000',
                'transparent' => false
            ),
            
            array (
                'title' => __('Logo for Dark Transparent Header', 'shopkeeper'),
                'id' => 'dark_transparent_header_logo',
                'type' => 'media',
                'default' => array (
                    'url' => get_template_directory_uri() . '/images/shopkeeper-theme-logo-dark.png',
                ),
            ),                      
            
        )
        
    ) );

    Redux::setSection( $opt_name, array(
        'icon'       => 'fa fa-angle-right',
        'title'      => __( 'Top Bar', 'shopkeeper' ),
        'subsection' => true,
        'fields'     => array(
        
            array (
                'title' => __('Top Bar', 'shopkeeper'),
                'id' => 'top_bar_switch',
                'on' => __('Enabled', 'shopkeeper'),
                'off' => __('Disabled', 'shopkeeper'),
                'type' => 'switch',
                'default' => 0,
            ),
            
            array (
                'title' => __('Top Bar Background Color', 'shopkeeper'),
                'id' => 'top_bar_background_color',
                'type' => 'color',
                'default' => '#333333',
                'required' => array('top_bar_switch','=','1')
            ),
            
            array (
                'title' => __('Top Bar Text Color', 'shopkeeper'),
                'id' => 'top_bar_typography',
                'type' => 'color',
                'default' => '#fff',
                'transparent' => false,
                'required' => array('top_bar_switch','=','1')
            ),
            
            array (
                'title' => __('Top Bar Text', 'shopkeeper'),
                'id' => 'top_bar_text',
                'type' => 'text',
                'default' => 'Free Shipping on All Orders Over $75!',
                'required' => array('top_bar_switch','=','1')
            ),
            
            array(
                'id'       => 'top_bar_navigation_position',
                'type'     => 'button_set',
                'title'    => __( 'Top Bar Navigation Position', 'shopkeeper' ),
                //Must provide key => value pairs for radio options
                'options'  => array(
                    'left' => 'Left',
                    'right' => 'Right'
                ),
                'default'  => 'right',
                'required' => array('top_bar_switch','=','1')
            ),
            
            array (
                'title' => __('Top Bar Social Icons', 'shopkeeper'),
                'id' => 'top_bar_social_icons',
                'on' => __('Enabled', 'shopkeeper'),
                'off' => __('Disabled', 'shopkeeper'),
                'type' => 'switch',
                'default' => 1,
                'required' => array('top_bar_switch','=','1')
            ),
            
        )
        
    ) );

    Redux::setSection( $opt_name, array(
        'icon'       => 'fa fa-angle-right',
        'title'      => __( 'Sticky Header', 'shopkeeper' ),
        'subsection' => true,
        'fields'     => array(
        
            array (
                'title' => __('Sticky Header', 'shopkeeper'),
                'id' => 'sticky_header',
                'on' => __('Enabled', 'shopkeeper'),
                'off' => __('Disabled', 'shopkeeper'),
                'type' => 'switch',
                'default' => 1,
            ),
            
            array (
                'title' => __('Sticky Header Background Color', 'shopkeeper'),
                'id' => 'sticky_header_background_color',
                'type' => 'color',
                'default' => '#333333',
                'transparent' => false,
                'required' => array('sticky_header','=','1')
            ),
            
            array (
                'title' => __('Sticky Header Color', 'shopkeeper'),
                'id' => 'sticky_header_color',
                'type' => 'color',
                'default' => '#fff',
                'transparent' => false,
                'required' => array('sticky_header','=','1')
            ),
            
        )
        
    ) );

    Redux::setSection( $opt_name, array(
        'icon'    => 'el el-website',
        'title'   => __( 'Footer', 'shopkeeper' ),
        'fields'  => array(
            
            array (
                'title' => __('Footer Background Color', 'shopkeeper'),
                'id' => 'footer_background_color',
                'type' => 'color',
                'default' => '#F4F4F4',
            ),
            
            array (
                'title' => __('Footer Text', 'shopkeeper'),
                'id' => 'footer_texts_color',
                'type' => 'color',
                'transparent' => false,
                'default' => '#868686',
            ),
            
            array (
                'title' => __('Footer Links', 'shopkeeper'),
                'id' => 'footer_links_color',
                'type' => 'color',
                'transparent' => false,
                'default' => '#333333',
            ),
            
            array (
                'title' => __('Social Icons', 'shopkeeper'),
                'id' => 'footer_social_icons',
                'on' => __('Enabled', 'shopkeeper'),
                'off' => __('Disabled', 'shopkeeper'),
                'type' => 'switch',
                'default' => 1,
            ),
            
            array (
                'title' => __('Copyright Footnote', 'shopkeeper'),
                'id' => 'footer_copyright_text',
                'type' => 'text',
                'default' => 'Shopkeeper - eCommerce WP Theme',
            ),

            array (
                'title' => __('Expandable Footer on Mobiles', 'shopkeeper'),
                'id' => 'expandable_footer',
                'on' => __('Enabled', 'shopkeeper'),
                'off' => __('Disabled', 'shopkeeper'),
                'type' => 'switch',
                'default' => 1,
            ),
            
        )
        
    ) );

    Redux::setSection( $opt_name, array(
        'icon'   => 'fa fa-newspaper-o',
        'title'  => __( 'Blog', 'shopkeeper' ),
        'fields' => array(
            
            array (
                'title' => __('Blog Sidebar', 'shopkeeper'),
                'id' => 'sidebar_blog_listing',
                'on' => __('Enabled', 'shopkeeper'),
                'off' => __('Disabled', 'shopkeeper'),
                'type' => 'switch',
                'default' => 0,
            ),

            array (
                'title' => __('Portfolio Posts Slug', 'shopkeeper'),
                'subtitle' => __('Enter a custom slug for portfolio item posts.', 'shopkeeper'),
                'desc'  => __('Default slug is "portfolio-item". Enter a custom one to overwrite it. <br/><b>You need to regenerate your permalinks if you modify this!</b>', 'shopkeeper'),
                'id' => 'portfolio_item_slug',
                'type' => 'text',
                'default' => 'portfolio-item',
            ),            
            
        )
        
    ) );

    Redux::setSection( $opt_name, array(
        'icon'   => 'fa fa-shopping-cart',
        'title'  => __( 'Shop', 'shopkeeper' ),
        'fields' => array(
            
            array (
                'title' => __('Catalog Mode', 'shopkeeper'),
                'desc' => __('When enabled, the feature Turns Off the shopping functionality of WooCommerce.', 'shopkeeper'),
                'id' => 'catalog_mode',
                'on' => __('Enabled', 'shopkeeper'),
                'off' => __('Disabled', 'shopkeeper'),
                'type' => 'switch',
            ),
            
            array (
                'title' => __('Breadcrumbs', 'shopkeeper'),
                'id' => 'breadcrumbs',
                'on' => __('Enabled', 'shopkeeper'),
                'off' => __('Disabled', 'shopkeeper'),
                'type' => 'switch',
                'default' => 1,
            ),

            array (
                'title' => __('Quick View', 'shopkeeper'),
                'id' => 'quick_view',
                'on' => __('Enabled', 'shopkeeper'),
                'off' => __('Disabled', 'shopkeeper'),
                'type' => 'switch',
            ),

            array (
                'title' => __('Add to Cart Button Display', 'shopkeeper'),
                'id' => 'add_to_cart_display',
                'on' => __('When hovering', 'shopkeeper'),
                'off' => __('At all times', 'shopkeeper'),
                'type' => 'switch',
                'default' => 1
            ),

            array (
                'title' => __('Parallax on Category Header images', 'shopkeeper'),
                'id' => 'category_header_parallax',
                'on' => __('Enabled', 'shopkeeper'),
                'off' => __('Disabled', 'shopkeeper'),
                'type' => 'switch',
                'default' => 1
            ),
            
            array (
                'title' => __('Number of Products per Column', 'shopkeeper'),
                'id' => 'products_per_column',
                'min' => '2',
                'step' => '1',
                'max' => '6',
                'type' => 'slider',
                'default' => '6',
            ),
            
            array (
                'title' => __('Number of Products per Page', 'shopkeeper'),
                'id' => 'products_per_page',
                'min' => '1',
                'step' => '1',
                'max' => '48',
                'type' => 'slider',
                'edit' => '1',
                'default' => '18',
            ),
            
            array (
                'title' => __('Sidebar Style', 'shopkeeper'),
                'id' => 'sidebar_style',
                'on' => __('On Page', 'shopkeeper'),
                'off' => __('Off-Canvas', 'shopkeeper'),
                'type' => 'switch',
                'default' => 1,
            ),
            
            array (
                'title' => __('Second Image on Catalog Page (Hover)', 'shopkeeper'),
                'id' => 'second_image_product_listing',
                'on' => __('Enabled', 'shopkeeper'),
                'off' => __('Disabled', 'shopkeeper'),
                'type' => 'switch',
                'default' => 1,
            ),
            
            array (
                'title' => __('Ratings on Catalog Page', 'shopkeeper'),
                'id' => 'ratings_catalog_page',
                'on' => __('Enabled', 'shopkeeper'),
                'off' => __('Disabled', 'shopkeeper'),
                'type' => 'switch',
                'default' => 1,
            ),

            array (
                'title' => __('Out of Stock Label', 'shopkeeper'),
                'id' => 'out_of_stock_label',
                'type' => 'text',
                'default' => 'Out of stock',
            ),

            array (
                'title' => __('Sale Label', 'shopkeeper'),
                'id' => 'sale_label',
                'type' => 'text',
                'default' => 'Sale!',
            ),
            
        )
        
    ) );

    Redux::setSection( $opt_name, array(
        'icon'   => 'fa fa-archive',
        'title'  => __( 'Product Page', 'shopkeeper' ),
        'fields' => array(
            
            array (
                'title' => __('Product Gallery Zoom', 'shopkeeper'),
                'id' => 'product_gallery_zoom',
                'on' => __('Enabled', 'shopkeeper'),
                'off' => __('Disabled', 'shopkeeper'),
                'type' => 'switch',
                'default' => 1,
            ),
            
            array (
                'title' => __('Related Products', 'shopkeeper'),
                'id' => 'related_products',
                'on' => __('Enabled', 'shopkeeper'),
                'off' => __('Disabled', 'shopkeeper'),
                'type' => 'switch',
                'default' => 1,
            ),
            
            array (
                'title' => __('Sharing Options', 'shopkeeper'),
                'id' => 'sharing_options',
                'on' => __('Enabled', 'shopkeeper'),
                'off' => __('Disabled', 'shopkeeper'),
                'type' => 'switch',
                'default' => 1,
            ),
            
            array (
                'title' => __('Review Tab', 'shopkeeper'),
                'id' => 'review_tab',
                'on' => __('Enabled', 'shopkeeper'),
                'off' => __('Disabled', 'shopkeeper'),
                'type' => 'switch',
                'default' => 1,
            ),
            
        )
        
    ) );

    Redux::setSection( $opt_name, array(
        'icon'   => 'fa fa-paint-brush',
        'title'  => __( 'Styling', 'shopkeeper' ),
        'fields' => array(
            
            array (
                'title' => __('Body Texts Color', 'shopkeeper'),
                'id' => 'body_color',
                'type' => 'color',
                'transparent' => false,
                'default' => '#545454',
            ),
            
            array (
                'title' => __('Headings Color', 'shopkeeper'),
                'id' => 'headings_color',
                'type' => 'color',
                'transparent' => false,
                'default' => '#000000',
            ),
            
            array (
                'title' => __('Accent Color', 'shopkeeper'),
                'id' => 'main_color',
                'type' => 'color',
                'transparent' => false,
                'default' => '#EC7A5C',
            ),
            
            array(
                'id'            => 'main_background',
                'type'          => 'background',
                'title'         => "Body Background",
                'default'  => array(
                    'background-color' => '#fff',
                ),
                'transparent'   => false,
            ),

            array (
                'title' => __('Smooth Transition Between Pages', 'shopkeeper'),
                'id' => 'smooth_transition_between_pages',
                'on' => __('Enabled', 'shopkeeper'),
                'off' => __('Disabled', 'shopkeeper'),
                'type' => 'switch',
                'default' => 0,
            ),
            
        )
        
    ) );

    $fonts = array( 
            "Radnika"                                               => "Radnika",
            "NeueEinstellung"                                       => "NeueEinstellung",
            "Arial, Helvetica, sans-serif"                          => "Arial, Helvetica, sans-serif",
            "'Arial Black', Gadget, sans-serif"                     => "'Arial Black', Gadget, sans-serif",
            "'Bookman Old Style', serif"                            => "'Bookman Old Style', serif",
            "'Comic Sans MS', cursive"                              => "'Comic Sans MS', cursive",
            "Courier, monospace"                                    => "Courier, monospace",
            "Garamond, serif"                                       => "Garamond, serif",
            "Georgia, serif"                                        => "Georgia, serif",
            "Impact, Charcoal, sans-serif"                          => "Impact, Charcoal, sans-serif",
            "'Lucida Console', Monaco, monospace"                   => "'Lucida Console', Monaco, monospace",
            "'Lucida Sans Unicode', 'Lucida Grande', sans-serif"    => "'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
            "'MS Sans Serif', Geneva, sans-serif"                   => "'MS Sans Serif', Geneva, sans-serif",
            "'MS Serif', 'New York', sans-serif"                    => "'MS Serif', 'New York', sans-serif",
            "'Palatino Linotype', 'Book Antiqua', Palatino, serif"  => "'Palatino Linotype', 'Book Antiqua', Palatino, serif",
            "Tahoma,Geneva, sans-serif"                             => "Tahoma,Geneva, sans-serif",
            "'Times New Roman', Times,serif"                        => "'Times New Roman', Times,serif",
            "'Trebuchet MS', Helvetica, sans-serif"                 => "'Trebuchet MS', Helvetica, sans-serif",
            "Verdana, Geneva, sans-serif"                           => "Verdana, Geneva, sans-serif"
            );



    Redux::setSection( $opt_name, array(
        'icon'   => 'fa fa-font',
        'title'  => __( 'Fonts', 'shopkeeper' ),
        'fields' => array(

            
            array (
                'id' => 'main_font_info',
                'icon'   => 'fa fa-font',
                'type' => 'info',
                'raw' => __('<h3>Main Font / Headings</h3>', 'shopkeeper'),
            ),
            
            // Standard + Google Webfonts
            array (
                'id' => 'main_font',
                'type' => 'typography',
                'line-height' => false,
                'text-align' => false,
                'font-style' => false,
                'font-weight' => false,
                'all_styles'=> true,
                'font-size' => false,
                'color' => false,
                'fonts' => $fonts,
                'default' => array (
                    'font-family' => 'NeueEinstellung',
                    'subsets' => '',
                ),
            ),
            
            array (
                'title' => __('Headings Font Size (px)', 'shopkeeper'),
                'id' => 'headings_font_size',
                'min' => '16',
                'step' => '1',
                'max' => '40',
                'type' => 'spinner',
                'default' => '23',
            ),          
            
            
            array (
                'id' => 'secondary_font_info',
                'icon' => 'fa fa-font',
                'type' => 'info',
                'raw' => __('<h3>Secondary Font / Body</h3>', 'shopkeeper'),
            ),
            
            // Standard + Google Webfonts
            array (
                'id' => 'secondary_font',
                'type' => 'typography',
                'line-height' => false,
                'text-align' => false,
                'font-style' => false,
                'font-weight' => false,
                'all_styles'=> true,
                'font-size' => false,
                'color' => false,
                'fonts' => $fonts,
                'default' => array (
                    'font-family' => 'Radnika',
                    'subsets' => '',
                ),           
            ),

            array (
                'title' => __('Body Font Size (px)', 'shopkeeper'),
                'id' => 'body_font_size',
                'min' => '12',
                'step' => '1',
                'max' => '20',
                'type' => 'spinner',
                'default' => '18',
            ), 
            
            
        )
        
    ) );

    Redux::setSection( $opt_name, array(
        'icon'   => 'fa fa-share-alt-square',
        'title'  => __( 'Social Media', 'shopkeeper' ),
        'fields' => array(
            
            array (
                'title' => __('<i class="fa fa-facebook"></i> Facebook', 'shopkeeper'),
                'id' => 'facebook_link',
                'type' => 'text',
                'default' => 'https://www.facebook.com/',
            ),
            
            array (
                'title' => __('<i class="fa fa-twitter"></i> Twitter', 'shopkeeper'),
                'id' => 'twitter_link',
                'type' => 'text',
                'default' => 'http://twitter.com/',
            ),
            
            array (
                'title' => __('<i class="fa fa-pinterest"></i> Pinterest', 'shopkeeper'),
                'id' => 'pinterest_link',
                'type' => 'text',
                'default' => 'http://www.pinterest.com/',
            ),
            
            array (
                'title' => __('<i class="fa fa-linkedin"></i> LinkedIn', 'shopkeeper'),
                'id' => 'linkedin_link',
                'type' => 'text',
            ),
            
            array (
                'title' => __('<i class="fa fa-google-plus"></i> Google+', 'shopkeeper'),
                'id' => 'googleplus_link',
                'type' => 'text',
            ),
            
            array (
                'title' => __('<i class="fa fa-rss"></i> RSS', 'shopkeeper'),
                'id' => 'rss_link',
                'type' => 'text',
            ),
            
            array (
                'title' => __('<i class="fa fa-tumblr"></i> Tumblr', 'shopkeeper'),
                'id' => 'tumblr_link',
                'type' => 'text',
            ),
            
            array (
                'title' => __('<i class="fa fa-instagram"></i> Instagram', 'shopkeeper'),
                'id' => 'instagram_link',
                'type' => 'text',
                'default' => 'http://instagram.com/',
            ),
            
            array (
                'title' => __('<i class="fa fa-youtube-play"></i> Youtube', 'shopkeeper'),
                'id' => 'youtube_link',
                'type' => 'text',
                'default' => 'https://www.youtube.com/',
            ),
            
            array (
                'title' => __('<i class="fa fa-vimeo-square"></i> Vimeo', 'shopkeeper'),
                'id' => 'vimeo_link',
                'type' => 'text',
            ),
            
            array (
                'title' => __('<i class="fa fa-behance"></i> Behance', 'shopkeeper'),
                'id' => 'behance_link',
                'type' => 'text',
            ),
            
            array (
                'title' => __('<i class="fa fa-dribbble"></i> Dribble', 'shopkeeper'),
                'id' => 'dribble_link',
                'type' => 'text',
            ),
            
            array (
                'title' => __('<i class="fa fa-flickr"></i> Flickr', 'shopkeeper'),
                'id' => 'flickr_link',
                'type' => 'text',
            ),
            
            array (
                'title' => __('<i class="fa fa-git"></i> Git', 'shopkeeper'),
                'id' => 'git_link',
                'type' => 'text',
            ),
            
            array (
                'title' => __('<i class="fa fa-skype"></i> Skype', 'shopkeeper'),
                'id' => 'skype_link',
                'type' => 'text',
            ),
            
            array (
                'title' => __('<i class="fa fa-weibo"></i> Weibo', 'shopkeeper'),
                'id' => 'weibo_link',
                'type' => 'text',
            ),
            
            array (
                'title' => __('<i class="fa fa-foursquare"></i> Foursquare', 'shopkeeper'),
                'id' => 'foursquare_link',
                'type' => 'text',
            ),
            
            array (
                'title' => __('<i class="fa fa-soundcloud"></i> Soundcloud', 'shopkeeper'),
                'id' => 'soundcloud_link',
                'type' => 'text',
            ),

            array (
                'title' => __('<i class="fa fa-vk"></i> VK', 'shopkeeper'),
                'id' => 'vk_link',
                'type' => 'text',
            ),
            
        )
        
    ) );

    Redux::setSection( $opt_name, array(
        'icon'   => 'fa fa-code',
        'title'  => __( 'Custom Code', 'shopkeeper' ),
        'fields' => array(
            
            array (
                'title' => __('Custom CSS', 'shopkeeper'),
                'subtitle' => __('Paste your custom CSS code here.', 'shopkeeper'),
                'id' => 'custom_css',
                'type' => 'ace_editor',
                'mode' => 'css',
            ),
            
            array (
                'title' => __('Header JavaScript Code', 'shopkeeper'),
                'subtitle' => __('Paste your custom JS code here. The code will be added to the header of your site.', 'shopkeeper'),
                'id' => 'header_js',
                'type' => 'ace_editor',
                'mode' => 'javascript',
            ),
            
            array (
                'title' => __('Footer JavaScript Code', 'shopkeeper'),
                'subtitle' => __('Here is the place to paste your Google Analytics code or any other JS code you might want to add to be loaded in the footer of your website.', 'shopkeeper'),
                'id' => 'footer_js',
                'type' => 'ace_editor',
                'mode' => 'javascript',
            ),
            
        )
        
    ) );

    /*
     * <--- END SECTIONS
     */