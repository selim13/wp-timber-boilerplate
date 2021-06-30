<?php

use Local\AssetsManifest;

$timber = new Timber\Timber();
Timber::$dirname = ['views'];
Timber::$autoescape = false;

class TwigTheme extends Timber\Site
{
    private AssetsManifest $assetsManifest;


    public function __construct()
    {
        $this->assetsManifest = new AssetsManifest(
            get_stylesheet_directory() . '/static/dist/mix-manifest.json'
        );

        add_action('after_setup_theme', array($this, 'theme_supports'));
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_filter('timber/context', array($this, 'add_to_context'));
        add_filter('timber/twig', array($this, 'add_to_twig'));

        /**
         * Remove some meta stuff like XML RPC link,
         * wlwmanifest and generator from head.
         */
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'feed_links_extra', 3);
        remove_action('wp_head', 'feed_links', 2);
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'rest_output_link_wp_head');
        add_filter('the_generator', '__return_empty_string');
        remove_action('wp_head', 'wp_oembed_add_discovery_links');
        remove_action('rest_api_init', 'wp_oembed_register_route');
        remove_filter('rest_pre_serve_request', '_oembed_rest_pre_serve_request');
        remove_action('xmlrpc_rsd_apis', 'rest_output_rsd');
        remove_action('wp_head', 'rest_output_link_wp_head',);
        remove_action('template_redirect', 'rest_output_link_header', 11);
        remove_action('wp_head', 'parent_post_rel_link');
        remove_action('wp_head', 'start_post_rel_link');
        remove_action('wp_head', 'adjacent_posts_rel_link');
        remove_action('wp_head', 'wp_shortlink_wp_head');
        remove_action('template_redirect', 'wp_shortlink_header', 11);

        parent::__construct();
    }

    /**
     * Returns URL of theme's asset.
     *
     * @param string $key
     * @return string
     */
    public function asset(string $key): string
    {
        $asset = $this->assetsManifest->get($key);
        if (!$asset) {
            return '';
        }

        return get_stylesheet_directory_uri() . '/static/dist' . $asset;
    }

    /**
     * Registers the theme assets.
     *
     * @return void
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script(
            'app.js',
            $this->asset('/scripts/app.js'),
            [],
            null,
            true
        );

        // Provides js scripts with data from backend in wpParams object
        wp_localize_script(
            'app.js',
            'wpParams',
            [
                'ajaxurl' => admin_url('admin-ajax.php'), // WordPress AJAX URL,
                'stylesheetDirectoryURI' => get_stylesheet_directory_uri()
            ]
        );

        wp_enqueue_style('app.css', $this->asset('/styles/index.css'), false, null);

        wp_deregister_script('wp-embed');
        wp_dequeue_style('wp-block-library');
    }

    public function add_to_context($context)
    {
        $context['menu'] = new Timber\Menu();
        $context['site'] = $this;
        return $context;
    }

    public function theme_supports()
    {
        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support(
            'html5',
            [
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
            ]
        );
        add_theme_support('menus');
    }

    public function add_to_twig($twig)
    {
        $twig->addExtension(new Twig\Extension\StringLoaderExtension());
        return $twig;
    }

}

new TwigTheme();
