<footer class="footer">
    <div class="container">
        <div class="footer--title">
            <h2>Contact us</h2>
        </div>
        <div class="footer--inner">
            <div class="footer-col--left">
                <h3>Get in touch</h3>
                <?php echo get_field('get_in_touch', 'option'); ?>     
                <div class="footer--socials">
                    <?php foreach(get_field('socials', 'option') as $social): ?>
                        <a href="<?php echo $social['url']; ?>" target="_blank">
                            <?php echo svg($social['platform'], [], true); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="footer-col--right">
                <h3>Join us</h3>
                <?php echo get_field('join_us', 'option'); ?>
            </div>
        </div>
        <div class="footer--bottom">
            <div class="footer--bottom-logo">
                <?php 
                    $logo = get_field('footer_logo', 'option');
                    echo wp_get_attachment_image($logo['id'], 'full');
                ?>
            </div>
            <div class="footer--bottom-copyright">
                <p>RevAgent&copy; <?php echo date('Y'); ?>. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
