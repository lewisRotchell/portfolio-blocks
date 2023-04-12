<?php

add_action('rest_api_init', function () {
    register_rest_route('portfolio/v1', '/posts-display/', [
        'methods'             => 'POST',
        'callback'            => 'portfolio_get_posts',
        'permission_callback' => function () {
            return '';
        }
    ]);
});

function portfolio_get_posts(WP_REST_REQUEST $request)
{
    $params = $request->get_params();
    $search = $params['s'];
    $cat = false;

    if (isset($params['cat'])) {
        $cat = $params['cat'];
    }

    if (isset($params['s'])) {
        $search = $params['s'];
    }

    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    $args = [
        'post_type'      => 'post',
        'posts_per_page' => 6,
        'paged'          => $paged,
    ];

    if ($cat) {
        $args['cat'] = $cat;
    }

    if ($search) {
        $args['s'] = $search;
    }


    $query = new WP_Query($args);

    ob_start();
?>
<?php if ($query->have_posts()) : ?>
<ul>
    <?php while ($query->have_posts()) : $query->the_post(); ?>
    <li>
        <a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
        </a>
    </li>
    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
</ul>
<?php else : ?>
<span>No posts found</span>
<?php endif;
    $response = new WP_REST_Response(ob_get_clean());
    $response->set_status(200);
    return $response;
    ?>
<?php }