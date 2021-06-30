<?php

namespace Local;

use WP_Post;

/**
 * Gutenberg configuration.
 *
 * @package Local
 */
class Gutenberg
{
    public static function wp_init()
    {
        add_filter(
            'use_block_editor_for_post_type',
            [self::class, 'use_block_editor_for_post_type'],
            10,
            2
        );
        add_filter(
            'use_block_editor_for_post',
            [self::class, 'use_block_editor_for_post'],
            10,
            2
        );
        add_filter(
            'allowed_block_types',
            [self::class, 'allowed_block_types'],
        );
    }

    /**
     * Disables the Gutenberg editor all post types
     * except listed in $gutenberg_supported_types.
     *
     * @param bool $can_edit Whether to use the Gutenberg editor.
     * @param string $post_type Name of WordPress post type.
     * @return bool $can_edit
     */
    public static function use_block_editor_for_post_type(bool $can_edit, string $post_type): bool
    {
        $gutenberg_supported_types = [];

        if (!in_array($post_type, $gutenberg_supported_types, true)) {
            $can_edit = false;
        }

        return $can_edit;
    }

    /**
     * Reenables Gutenberg for specific templates.
     *
     * @param bool $can_edit Whether the post can be edited or not
     * @param WP_Post $post The post being checked
     * @return bool
     */
    public static function use_block_editor_for_post(bool $can_edit, WP_Post $post): bool
    {
        if ($post->post_type === 'page'
            && get_page_template_slug($post->ID) === 'templates/block-editor-gutenberg.php') {
            $can_edit = true;
        }

        return $can_edit;
    }

    /**
     * Enables only specific editor blocks.
     *
     * @param bool|string[] $allowed_blocks Array of block type slugs, or boolean to enable/disable all.
     * @return bool|string[]
     */
    public static function allowed_block_types($allowed_blocks): array
    {
        return [
//            'core-embed/amazon-kindle',
//            'core-embed/animoto',
//            'core-embed/cloudup',
//            'core-embed/collegehumor',
//            'core-embed/crowdsignal',
//            'core-embed/dailymotion',
//            'core-embed/facebook',
//            'core-embed/flickr',
//            'core-embed/imgur',
//            'core-embed/instagram',
//            'core-embed/issuu',
//            'core-embed/kickstarter',
//            'core-embed/meetup-com',
//            'core-embed/mixcloud',
//            'core-embed/polldaddy',
//            'core-embed/reddit',
//            'core-embed/reverbnation',
//            'core-embed/screencast',
//            'core-embed/scribd',
//            'core-embed/slideshare',
//            'core-embed/smugmug',
//            'core-embed/soundcloud',
//            'core-embed/speaker',
//            'core-embed/speaker-deck',
//            'core-embed/spotify',
//            'core-embed/ted',
//            'core-embed/tiktok',
//            'core-embed/tumblr',
//            'core-embed/twitter',
//            'core-embed/videopress',
//            'core-embed/vimeo',
//            'core-embed/wordpress',
//            'core-embed/wordpress-tv',
            'core-embed/youtube',
//            'core/archives',
//            'core/audio',
//            'core/block',
//            'core/button',
//            'core/buttons',
//            'core/calendar',
//            'core/categories',
//            'core/code',
            'core/column',
            'core/columns',
//            'core/cover',
//            'core/embed',
//            'core/file',
//            'core/freeform',
//            'core/gallery',
//            'core/group',
            'core/heading',
//            'core/html',
            'core/image',
//            'core/latest-comments',
//            'core/latest-posts',
            'core/list',
//            'core/media-text',
//            'core/missing',
//            'core/more',
//            'core/nextpage',
            'core/paragraph',
            'core/preformatted',
//            'core/pullquote',
            'core/quote',
//            'core/rss',
//            'core/search',
//            'core/separator',
//            'core/shortcode',
//            'core/social-link',
//            'core/social-links',
//            'core/spacer',
//            'core/subhead',
            'core/table',
//            'core/tag-cloud',
//            'core/text-columns',
//            'core/verse',
            'core/video',
        ];
    }
}