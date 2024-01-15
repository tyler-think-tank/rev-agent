<?php
    $content = get_field('content');
    $image = get_field('image');
    $background = get_field('background') ?: 'bg-light-grey';
?>

<section class="image-text <?php echo $background; ?>">
    <div class="container">
        <div class="image-text--inner">
            <div class="image-text--text" data-aos="fade-up">
                <?php echo $content; ?>
            </div>
            <div class="image-text--image" data-aos="fade-right" data-aos-delay="200">
                <?php echo wp_get_attachment_image($image['id'], 'full'); ?>
            </div>
        </div>
    </div>
</section>