<?php function wilo_initialise(){ ?>

     <?php if(current_user_can('administrator') && in_array(get_post_type(), wilo_get_post_types()) && is_singular()): ?>

        <?php $post_url = get_the_permalink(); ?>
        <?php $stripped_post_url = str_replace(get_site_url(), '', $post_url); ?>

        <div class="wilo">

            <div class="wilo-box-background"></div>
            <div class="wilo-box">
                <div class="wilo-toggle">
                    <div class="wilo-toggle-score"></div>
                    <?php echo file_get_contents(WILO_PATH . 'assets/images/wilo.svg'); ?>
                </div>
                <div class="wilo-box-container">
                    <div class="wilo-header">
                        <div class="wilo-header-logo">
                            <?php echo file_get_contents(WILO_PATH . 'assets/images/logo.svg'); ?>
                        </div>
                        <ul class="wilo-nav">
                            <li class="wilo-nav-item wilo-nav-active" data-id="audit">Page Audit</li>
                            <li class="wilo-nav-item" data-id="explorer">Link Explorer</li>
                        </ul>
                    </div>
                    <div class="wilo-content">
                        <div class="wilo-overflow-area">
                            <?php include WILO_PATH . '/templates/audit.php'; ?>
                            <?php include WILO_PATH . '/templates/explore.php'; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="wilo-tooltip-area"></div>
        </div>
            
    <?php endif; ?>

<?php }
add_action('wp_footer', 'wilo_initialise'); ?>