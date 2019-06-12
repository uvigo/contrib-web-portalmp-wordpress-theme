<?php if ($uvigo_eventgroup->have_posts()) : ?>
    <?php while ($uvigo_eventgroup->have_posts()) : $uvigo_eventgroup->the_post(); ?>

        <?php $place = get_post_meta(get_the_ID(), 'uvigo_news_event_place', true); ?>
        <?php $place_url = get_post_meta(get_the_ID(), 'uvigo_news_event_place_url', true); ?>
        <?php $date = get_post_meta(get_the_ID(), 'uvigo_news_event_start_date', true); ?>
        <?php $speaker = get_post_meta(get_the_ID(), 'uvigo_news_event_speaker', true); ?>
        <?php $has_videos = have_rows('uvigo_event_videos'); ?>

        <article <?php post_class('mb-10') ?>>
            <div class="row">
                <div class="col-4">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php echo get_permalink(); ?>" class="d-block mb-2 <?php echo $has_videos ? 'has-video' : ''; ?>">
                            <?php echo CIUVigoApp::getThumbnailBackground('featured-thumbnail'); ?>
                            <?php if ($has_videos) : ?>
                                <div class="has-video-icon"><span class="sr-only">Tiene vídeos</span></div>
                            <?php endif; ?>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="col-8">
                    <p class="entry-title mb-2"><a class="font-weight-normal" href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></p>
                    <div class="entry-meta mb-0">
                        <time class="updated sr-only" datetime="{{ get_post_time('c', true) }}">{{ get_the_date() }}</time>
                        <p class="entry-meta-item d-block mb-2 pt-0" style="font-size: 1rem;">
                            <?php echo $speaker; ?>
                        </p>
                        <p class="entry-meta-item d-block mb-1 pt-0">
                            <span class="icon_clock_alt" aria-hidden="true"></span> <?php echo $date; ?>
                        </p>
                        <p class="entry-meta-item d-block pt-0">
                            <span class="icon_pin_alt" aria-hidden="true"></span>
                            <?php if ($place_url) : ?>
                                <a target="_blank" class="font-weight-regular" href="<?php echo $place_url; ?>"><?php echo $place; ?></a>
                            <?php else : ?>
                                <?php echo $place; ?>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        </article>

    <?php endwhile; ?>

    <?php echo get_the_posts_pagination(['type' => 'list', 'mid_size' => 4]) ?>

<?php endif; ?>
