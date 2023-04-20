<?php
require_once dirname(__FILE__) . '/template.php';
require_once dirname(__FILE__) . '/api.php';



function pb_posts_display_render_cb()
{

    $s = false;
    $category = false;
    $page = 1;

    function posts_search_filter_title($where, $query)
    {
        global $wpdb;
        if ($search_term = $query->get('s')) {
            $where .= ' AND (' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql($wpdb->esc_like($search_term)) . '%\')';
        }
        return $where;
    }



    $args = [
        'post_type' => 'post',
        'posts_per_page' => 2,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
    ];

    if (array_key_exists('search', $_GET)) {
        $s = $_GET['search'];
        $args['s'] = $s;
    }

    $page = get_query_var('pages');

    if ($page) {
        $args['paged'] = $page;
    }

    add_filter('posts_where', 'posts_search_filter_title', 10, 2);
    $query = new WP_Query($args);
    remove_filter('posts_where', 'posts_search_filter_title', 10, 2);


    ob_start();
?>
    <div class="wp-block-portfolio-posts-display-block">
        <h1>POSTS DISPLAY BLOCKS</h1>
        <div class="posts-display__search-container">
            <input type="text" class="posts-display__search" value="<?= $s ?>">
            <select name="categories" class="posts-display__categories" id="">
                <?php
                $cat_args = [
                    'exclude' => [1],
                    'option_all' => 'All',
                ];

                $categories = get_categories($cat_args); ?>
                <option>All</option>
                <?php foreach ($categories as $category) {
                    echo '<option value="' . $category->term_id . '">' . $category->name . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="posts-display__container">
            <?php if ($query->have_posts()) : ?>
                <ul class="posts-display__list">
                    <?php while ($query->have_posts()) : $query->the_post();
                        echo render_posts_display_item();
                    ?>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                </ul>
            <?php else : ?>
                <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
            <?php endif; ?>
            <div class="posts-display__pagination">
                <?php
                echo paginate_links(array(
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
                    'add_args'     => true,
                ));
                ?>
            </div>
        </div>
    </div>
<?php

    $output = ob_get_clean();
    ob_end_clean();

    return $output;
}
