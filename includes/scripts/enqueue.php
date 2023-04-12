<?php

function pb_register_scripts()
{
    wp_register_script('posts-display-frontend', plugins_url('build/blocks/posts-display/frontend.js', dirname(dirname(__FILE__))), [], '1.0.0', true);
}
