<?php

function pb_posts_display_render_cb()
{

    $search = false;
    $category = false;


    $args = [
        'post_type' => 'post',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
    ];

    $query = new WP_Query($args);


    ob_start();
?>
<div class="wp-block-portfolio-posts-display-block">
    <h1>POSTS DISPLAY BLOCKS</h1>
    <div class="posts-display__search-container">
        <input type="text" class="posts-display__search" value="<?= $search ?>">
        <select name="categories" class="posts-display__categories" id="">
            <?php
                //exclude category with id 1 (Uncategorized)
                //add option All
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
    <?php endif; ?>

</div>
<?php

    $output = ob_get_clean();
    ob_end_clean();

    return $output;
}