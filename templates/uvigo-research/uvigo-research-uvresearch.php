<div class="research floor primary">
  <div class="container">
	<?php if ($uvresearch_title) : ?>
      <h2 class="research__title h2 text-center"><?php echo $uvresearch_title; ?></h2>
    <?php else : ?>
      <h2 class="research__title h2 text-center"><?php echo __('Research lines', 'uvigothemewp'); ?></h2>
    <?php endif; ?>
    <?php if (count($uvresearch_terms) > 0) : ?>
        <div class="research__terms">
            <?php foreach ($uvresearch_terms as $term) : ?>
                <div class="research__term">
                    <a href="<?php echo get_term_link($term->term_id) ?>">
                        <?php $image = Uvigo_Research_Shortcodes::get_research_line_image_url($term->term_id); ?>
                        <img src="<?php echo $image; ?>" width="108" height="95" alt="<?php echo $term->name ?>">
                        <span><?php echo $term->name; ?></span>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
  </div>
</div>
