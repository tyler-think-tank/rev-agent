<?php

get_header(); ?>

<main id="site-content" role="main">

   <section class="page-not-found block">
        <div class="container inner">
            <div class="page-not-found--inner">
                <div class="page-not-found--content">
                    <h2 class="heading">Oops! This Page Can't Be Found.</h2>
                    <p>We're sorry, but the page you're looking for seems to have disappeared or never existed. But don't worry, we're here to help you find your way:</p>
                    <a href="<?php echo get_home_url(); ?>" class="button primary">Return to homepage</a>
                </div>
            </div>
        </div>
   </section>

</main>

<?php get_footer(); ?>
