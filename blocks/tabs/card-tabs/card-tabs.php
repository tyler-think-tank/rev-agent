<section class="card-tabs">
    <div class="container">
        <div class="card-tabs--wrapper">
            <div class="card-tabs--tabs" role="tablist" aria-label="GPT Categories">
                <?php
                    $terms = get_terms(array('taxonomy' => 'gpt_category', 'hide_empty' => false));
                    foreach ($terms as $index => $term) {
                        $aria_selected = $index == 0 ? 'true' : 'false';
                        $hidden = $index == 0 ? '' : 'hidden';
                        echo "<button role='tab' aria-controls='{$term->slug}' aria-selected='{$aria_selected}' id='tab-{$term->slug}'>{$term->name}</button>";
                    }
                ?>
            </div>
        </div>
        <div class="card-tabs--content">
            <?php
            foreach ($terms as $index => $term) {
                $hidden = $index == 0 ? '' : 'hidden';
                echo "<div role='tabpanel' id='{$term->slug}' aria-labelledby='tab-{$term->slug}' {$hidden}>";

                $args = array(
                    'post_type' => 'gpt',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'gpt_category',
                            'field' => 'slug',
                            'terms' => $term->slug,
                        ),
                    ),
                    'orderby' => 'term_order',
                    'order' => 'ASC',
                );

                $query = new WP_Query($args);
                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();

                        // get taxonomy terms and loop through each and get field "icon". Set icon to variable if it exists
                        $icon = '';
                        $terms = get_the_terms(get_the_ID(), 'gpt_category');
                        foreach ($terms as $term) {
                            $icon_id = get_term_meta($term->term_id, 'icon', true);
                            if ($icon_id) {
                                $icon = wp_get_attachment_image($icon_id, 'full');
                            }
                        }

                        $pageIcon = get_field('icon', get_the_ID());
                        $link = get_field('link', get_the_ID());
                        
                        echo '<div class="gpt-card" data-aos="fade-up">';
                            echo '<div class="gpt-card--inner">';
                                echo '<div class="gpt-card--top">';
                                    echo '<div class="gpt-card--title">';
                                        if($pageIcon) {
                                            echo wp_get_attachment_image($pageIcon['id'], 'full');
                                        }
                                        echo '<h3>' . get_the_title() . '</h3>';
                                    echo '</div>';
                                    echo '<div class="gpt-card--cat">';
                                       if($icon) {
                                            echo $icon;
                                       }
                                    echo '</div>';
                                echo '</div>';
                                echo '<div class="gpt-card--content">';
                                    echo '<p>' . get_the_excerpt() . '</p>';
                                echo '</div>';
                                echo '<div class="gpt-card--bottom">';
                                    echo svg('info', [], false);
                                    echo $link ? generateButton($link['title'], $link['url'], '', $link['target']) : '';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    }   
                }
                wp_reset_postdata();
                echo "</div>";
            }
            ?>
        </div>
    </div>
</section>