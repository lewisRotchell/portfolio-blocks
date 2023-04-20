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
    $search = false;
    $page = 1;

    if (isset($params['s'])) {
        $search = $params['s'];
    }

    if (isset($params['page'])) {
        $page = $params['page'];
    }



    $args = [
        'post_type'      => 'post',
        'posts_per_page' => 2,
        'paged'          => $page,
        'orderby' => 'date',
    ];


    if ($search) {
        $args['s'] = $search;
    }

    function posts_search_filter_title($where, $query)
    {
        global $wpdb;
        if ($search_term = $query->get('s')) {
            $where .= ' AND (' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql($wpdb->esc_like($search_term)) . '%\')';
        }
        return $where;
    }

    add_filter('posts_where', 'posts_search_filter_title', 10, 2);
    $query = new WP_Query($args);
    remove_filter('posts_where', 'posts_search_filter_title', 10, 2);

    ob_start();
?>
    <?php if ($query->have_posts()) : ?>
        <ul class="posts-display__list">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <?php echo render_posts_display_item(); ?>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        </ul>
    <?php else : ?>
        <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
    <?php endif; ?>
    <div class="posts-display__pagination">
        <?php
        echo paginate_links(array(
            'base'         => '%_%',
            'total'        => $query->max_num_pages,
            'current'      => max(1, get_query_var('pages')),
            'format'       => '?pages=%#%',
            'show_all'     => false,
            'type'         => 'plain',
            'end_size'     => 2,
            'mid_size'     => 1,
            'prev_next'    => true,
            'prev_text'    => 'Previous',
            'next_text'    => 'Next',
            'add_args'     => false,
            'add_fragment' => '&search=' . $search,

        ));
        ?>
    </div>
    <?php $response = new WP_REST_Response(ob_get_clean());
    $response->set_status(200);
    return $response;
    ?>
<?php }

function seoworks_query_vars($vars)
{
    $vars[] = 'pages';
    return $vars;
}
add_filter('query_vars', 'seoworks_query_vars');
