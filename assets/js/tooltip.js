 jQuery(window).ready(function(){
    /**Tool tip**/
    var follower = jQuery(".wilo-tooltip-area");

    if(jQuery('.wilo-tooltip-area').length){
            
        jQuery(document).mousemove(function(e) {
            // Update the position of the follower element
            
            var mouseX = e.clientX;
            var mouseY = e.clientY;
            var hovered_element = jQuery(e.target);
            var window_width = jQuery(window).width();
            jQuery(".wilo-tooltip-area").removeClass('reversed reversed-vertical');
            var tooltip_pos = follower.offset().left + jQuery(follower).width() + 50;
            var tooltip_top_pos = follower.offset().top - 50 - jQuery(window).scrollTop();

            if(hovered_element.hasClass('wilo-tooltip')){

                var about_issue = hovered_element.attr('data-about-issue');
                var how_to_improve = hovered_element.attr('data-how-to-improve');
                var notice = hovered_element.attr('data-notice');

                jQuery(".wilo-tooltip-area").addClass('active');
                if(about_issue && how_to_improve){

                    var html = `
                    <div class="wilo-col wilo-about">
                        <div class="wilo-tooltip-title">About this</div>
                        <div class="wilo-tooltip-content">${about_issue}</div>
                    </div>
                    <div class="wilo-col wilo-fix">
                        <div class="wilo-tooltip-title">How to improve</div>
                        <div class="wilo-tooltip-content">${how_to_improve}</div>
                    </div>
                    `;

                }else{
                    var html = `
                    <div class="wilo-col wilo-notice">
                        <div class="wilo-tooltip-title">Information</div>
                        <div class="wilo-tooltip-content">${notice}</div>
                    </div>
                    `;
                }

                jQuery('.wilo-tooltip-area').html(html);

            }else{
            jQuery(".wilo-tooltip-area").removeClass('active');
            }
            
            // Update the position of the follower element
            follower.css({
                left: mouseX + "px",
                top: mouseY + "px"
            });

            if(tooltip_pos > window_width){
                follower.addClass('reversed');
            }else{
                follower.removeClass('reversed');
            }

            if(tooltip_top_pos < 0){
                follower.addClass('reversed-vertical');
            }else{
                follower.removeClass('reversed-vertical');
            }

        });

    }

})