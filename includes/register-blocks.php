<?php

function pb_register_blocks()
{
    $blocks = [
        [
            'name' => 'posts-display',
            'options' => [
                'render_callback' => 'pb_posts_display_render_cb',
            ]
        ]
    ];

    foreach ($blocks as $block) {
        register_block_type(
            PB_PLUGIN_DIR . 'build/blocks/' . $block['name'],
            isset($block['options']) ? $block['options'] : []
        );
    }
}
