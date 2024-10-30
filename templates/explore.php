<div class="wilo-content-area" data-id="explorer">

    <div class="wilo-grid">
        <div class="wilo-page-overview wilo-grid">
            <div class="wilo-col">
                <div class="wilo-title"><?php the_title(); ?></div>
                <div class="wilo-link-reference"><?php the_permalink(); ?></div>
            </div>
            <div class="wilo-col wilo-align-right">
                <div class="wilo-refresh-explorer wilo-overview-button"><?php echo file_get_contents(WILO_PATH . 'assets/images/refresh.svg'); ?> Refresh</div>
            </div>
        </div>

        <div class="wilo-explorer wilo-grid">

            <form class="wilo-explorer-form wilo-data-box">
                <div class="wilo-title">Page Keywords</div>
                <div class="wilo-keyword-description">
                    Add the keywords associated<br> with this URL below.
                </div>

                <?php 
            
                $keywords = get_post_meta(get_the_ID(), 'wilo_keywords', true);
                if(! $keywords):
                    $keywords = array();
                endif;
                ?>

                
                <div class="wilo-line-numbered-textarea">
                    <?php if($keywords): ?>
                    <?php $keyword_count = count($keywords); ?>
                    <?php else: ?>
                        <?php $keyword_count = 0; ?>
                    <?php endif; ?>
                    <div class="wilo-line-numbers">
                        <div class="wilo-ln">1.</div>
                        <div class="wilo-ln">2.</div>
                        <div class="wilo-ln">3.</div>
                        <div class="wilo-ln">4.</div>
                        <div class="wilo-ln">5.</div>
                        <?php foreach($keywords as $index => $keyword): ?>
                            <?php if($index > 4): ?>
                                <div class="wilo-ln"><?php echo $index + 1; ?></div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <textarea class="wilo-keyword-input"><?php $count = 0; ?><?php foreach($keywords as $keyword): ?><?php $count++; ?><?php echo $keyword; ?><?php if($keyword_count > $count): ?>&#13;<?php endif; ?><?php endforeach; ?></textarea>
                </div>

                <a class="wilo-load-explorer" data-post-id="<?php echo get_the_id(); ?>">Save and reload results</a>
            </form>

            <div class="wilo-explorer-results wilo-data-box">
                <div class="wilo-title">Linking Opportunities <small class="wilo-explorer-count"></small></div>
                <div class="wilo-explorer-container" data-wilo-load="explorer"></div>
            </div>

        </div>
    </div>

</div>