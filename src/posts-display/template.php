<?php function render_posts_display_item()
{
    $image_url = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
    $category = "";
    foreach (get_the_category() as $cat) {
        //ignore Uncategorized
        if ($cat->term_id == 1) {
            continue;
        }
        $category .= $cat->name . ", ";
    }
    $category = rtrim($category, ", ");
?>
<li class="posts-display__item">
    <a href="<?php the_permalink(); ?>">
        <div class="posts-display__image-section">
            <img src="<?= $image_url ?>" alt="<?= the_title(); ?>">
        </div>
        <div class="posts-display__content">
            <span class="posts-display__title"><?php the_title(); ?></span>
            <p class="posts-display__category"><?php echo $category ?></p>
            <p class="posts-display__excerpt"><?php the_excerpt(); ?></p>
        </div>
    </a>
</li>
<?php } 


function render_posts_display_pagination($total){ ?>
<div class="posts-display__pagination">
    <?php
        echo paginate_links(array(
            'total'        => $total,
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
<?php }