<?php 
    $heading = get_field('heading');
    $headingType = get_field('heading_type') ?: 'h1';

    if($heading) {
        switch($headingType) {
            case 'h1':
                $heading = '<h1 class="heading">' . $heading . '</h1>';
                break;
            case 'h2':
                $heading = '<h2 class="heading">' . $heading . '</h2>';
                break;
            case 'h3':
                $heading = '<h3 class="heading">' . $heading . '</h3>';
                break;
            default :
                $heading = '<h1 class="heading">' . $heading . '</h1>';
                break;
        }
    }

    $predefinedPrompts = get_field('predefined_prompts');
    $predefinedPrompts = array_map(function($item) {
        return array(
            'title' => $item['title'],
            'prompt' => $item['prompt']
        );
    }, $predefinedPrompts);

    $additionalText = get_field('additional_text');
    $videoBackground = get_field('video_background');
?>



<section class="prompt-form-banner">
    <?php if($videoBackground) : ?>
        <div class="prompt-form-banner--background">
            <video autoplay muted loop playsinline>
                <source src="<?php echo $videoBackground; ?>" type="video/mp4">
            </video>
        </div>
    <?php endif; ?>
    <div class="prompt-form-banner--inner">
        <div class="container">
            <div class="prompt-form-banner--logo" data-aos="fade-up">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/dist/assets/images/revagent-logo.png" />
            </div>
            <div class="prompt-form-banner--wrapper" data-aos="fade-up" data-aos-delay="200">
                <h1 class="heading"><?php echo $heading; ?></h1>
                <form class="prompt-form" id="prompt-form">
                    <div class="prompt-form--inner">
                        <div class="prompt-form--input">
                            <input id="input-prompt" type="text" name="prompt" placeholder="Build an audience of UK-based sustainability directors in financial services">
                            <button type="submit" class="prompt-form--submit">
                                <?php echo svg('form-send', [], false); ?>
                            </button>
                        </div>
                    </div>
                </form>
                <div class="prompt-form--predefined">
                    <?php foreach($predefinedPrompts as $item) : ?>
                        <div class="prompt-form--predefined-item">
                            <div class="prompt-form--predefined-item-title">
                                <span><?php echo $item['title']; ?></span>
                            </div>
                            <div class="prompt-form--predefined-item-prompt">
                                <span><?php echo $item['prompt']; ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if($additionalText) : ?>
                    <div class="prompt-form--additional">
                        <?php echo $additionalText; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>