<?php
/**
 * The main template file.
 *
 * @package WordPress
 * @subpackage TwentyTwenty
 * @since TwentyTwenty 1.0
 */

get_header(); ?>

<main id="site-content" role="main">

    <?php if ( have_posts() ) : ?>

        <?php while ( have_posts() ) : the_post(); ?>

            <?php get_template_part( 'template-parts/content/content', get_post_type() ); ?>

        <?php endwhile; ?>

    <?php else : ?>

        <?php get_template_part( 'template-parts/content/content', 'none' ); ?>

    <?php endif; ?>

</main><!-- #site-content -->

<?php get_footer(); ?>
