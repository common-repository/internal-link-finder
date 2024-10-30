jQuery(window).ready(function(){
    setTimeout(function(){
        var url = new URL(window.location.href);
        var wilo_anchors = url.searchParams.get('wilo_anchors');
        var links_only = url.searchParams.get('links_only');
        if(wilo_anchors){
            wilo_anchors = wilo_anchors.trim().split(",");
            wilo_anchors.forEach(function(anchor){

                element = 'body';
                if(links_only == '1'){
                    element = 'a';
                }

                jQuery(element).mark(anchor, {
                    'separateWordSearch': false,
                    done: function(){
                        var marked_pos = jQuery('body').find('mark[data-markjs="true"]').eq(0).offset().top - 150;
                        jQuery('html, body').animate({'scrollTop': marked_pos});

                    }
                });
            });
        }
    }, 250);
})