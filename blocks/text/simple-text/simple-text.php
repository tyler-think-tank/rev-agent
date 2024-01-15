<?php
    $classes = '';
    $container = get_field('container') ?: 'container';
    $background = get_field('background') ?: 'bg-green';
    $removePaddingTop = get_field('remove_padding_top') ? 'remove-padding-top' : '';
    $removePaddingBottom = get_field('remove_padding_bottom') ? 'remove-padding-bottom' : '';

    if($background) {
        $classes .= $background . ' ';
    }
    if($removePaddingTop) {
        $classes .= $removePaddingTop . ' ';
    }
    if($removePaddingBottom) {
        $classes .= $removePaddingBottom . ' ';
    }

    $title = get_field('title');
    $titleAlign = get_field('title_align') ? 'text-' . get_field('title_align') : 'text-left';
    $content = get_field('content');
?>

<section class="simple-text<?php echo $classes ? ' ' . $classes : ''; ?>">
    <div class="<?php echo $container; ?>">
        <div class="simple-text--wrapper">
            <div class="simple-text--content" data-aos="fade-up">
                <?php echo $title ? '<h2 class="simple-text--title ' . $titleAlign . '">' . $title . '</h2>' : ''; ?>
                <?php echo $content ? $content : ''; ?>
            </div>
        </div>
    </div>
</section>