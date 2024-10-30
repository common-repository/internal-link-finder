jQuery(window).ready(function(){

    jQuery('body').on('click', '.wilo .wilo-content-scroll *[data-id]:not(.wilo-nav-item)', function() {
        var new_tab = jQuery(this).attr('data-id');
        jQuery('.wilo-nav-item[data-id="' + new_tab + '"]').trigger('click');

    })

    if(jQuery('.wilo-nav-active').length){

        //OPEN WILO UI
        jQuery('.wilo-toggle').on('click', function(){
            if(jQuery('.wilo').hasClass('wilo-box-active')){
                jQuery('.wilo').removeClass('wilo-box-active');
            }else{
                jQuery('.wilo').addClass('wilo-box-active');
            }
        })

        //CLOSE WILO UI
        jQuery('.wilo-box-background').on('click', function(){
            jQuery('.wilo').removeClass('wilo-box-active');
        })

        //TAB CHANGE
        jQuery('.wilo .wilo-nav-item').on('click', function() {
            if(jQuery(this).attr('data-id').length > 0){
                var tab_id = jQuery(this).attr('data-id');
                jQuery('.wilo-nav-item').removeClass('wilo-nav-active');
                jQuery('.wilo .wilo-content-area').removeClass('wilo-content-area-active');
                jQuery(this).addClass('wilo-nav-active');
                jQuery('.wilo .wilo-content-area[data-id="' + tab_id + '"]').addClass('wilo-content-area-active');
            }
        });

    }

    function wiloLoadData(){

        jQuery('*[data-id="audit"] *[data-wilo-load]').empty();
        jQuery('*[data-id="audit"] .wilo-incoming-count').empty();
        jQuery('*[data-id="audit"] .wilo-ils-graphic-percentage').css({'stroke-dashoffset': 1170});


        jQuery.ajax({
            url: '/wp-admin/admin-ajax.php',
            data: {
                action: 'wilo_ajax_endpoint',
                url: window.location.href
            },
            success: function(page_data) {
                page_data = JSON.parse(page_data);
                wiloPopulateUI(page_data);

            }
        })
    }

    wiloLoadData();

    jQuery('.wilo-refresh-audit').on('click', wiloLoadData);

    function wiloPopulateUI(page_data) {

        //UPDATE ICON TOGGLE ICON COLOUR
        if(page_data.internal_linking_score > 70){
            jQuery('.wilo-toggle-score').addClass('good');
        }else if(page_data.internal_linking_score > 40){
            jQuery('.wilo-toggle-score').addClass('okay');
        }else{
            jQuery('.wilo-toggle-score').addClass('poor');
        }


        //UPDATE WILO LOAD ENTRY POINTS
        jQuery('*[data-id="audit"] *[data-wilo-load]').each(function(){
            var load = jQuery(this).attr('data-wilo-load');
            jQuery(this).text(page_data[load]);
        })


        //Prepare Incoming Links Data for Frontend
        var incoming_pages =  page_data.incoming_pages;
        var incoming_links = [];
        if(incoming_pages){
            for (var i = 0; i < incoming_pages.length; i++) {
                var stuffed = false;
                var post_url = incoming_pages[i].post_url;
                var post_title = incoming_pages[i].post_title;
                var impact = incoming_pages[i].impact;
                var edit_url = incoming_pages[i].edit_url;
                if(incoming_pages[i].outgoing_links_to_current_page.length > 1){
                    stuffed = true;
                }
                for (var j = 0; j < incoming_pages[i].outgoing_links_to_current_page.length; j++) {

                    var anchor = incoming_pages[i].outgoing_links_to_current_page[j].anchor;
                    var context = incoming_pages[i].outgoing_links_to_current_page[j].context;
                    var duplicate_anchor = false;

                    if(page_data.duplicate_anchors && page_data.duplicate_anchors.includes(anchor)){
                        duplicate_anchor = true;
                    }
                    
                    incoming_links.push({
                        post_url: post_url,
                        post_title: post_title,
                        impact: impact,
                        edit_url: edit_url,
                        anchor: anchor,
                        context: context,
                        stuffed: stuffed,
                        duplicate_anchor: duplicate_anchor
                    });


                }   
            }
        }

        if(! incoming_links || incoming_links.length == 0){
            var incoming_html = `
                <div class="wilo-notice">
                    <div class="wilo-title">There are no internal links currently pointing to this page.</div>
                    <div class="wilo-body">Use the link explorer tool to identify potential internal linking opportunities for this page.</div>
                </div>
            `;
            jQuery('*[data-wilo-load="incoming"]').html(incoming_html);
        }else{
            //Build Incoming Links HTML
            var incoming_html = `
                <table class="wilo-table">
                    <thead>
                        <tr>
                            <th class="wilo-large-column">Page</th>
                            <th class="wilo-small-column">Anchor</th>
                            <th>Warnings</th>
                            <th>Impact <div class="wilo-tooltip" data-how-to-improve="To increase the impact, consider minimizing the number of internal links present on the incoming post." data-about-issue="Each page begins with a impact rating of 100%, this is then diluted based on the number of internal links on the page. A higher quantity of internal links on a single page dilutes the overall impact.">?</div></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
            for (var i = 0; i < incoming_links.length; i++) {
                if(incoming_links[i].post_url == '/'){
                    var post_url = incoming_links[i].post_url;
                }else{
                    var post_url = '...'+incoming_links[i].post_url;
                }

                incoming_html += `
                    <tr>
                        <td class="wilo-large-column">
                            <div class="wilo-body">${incoming_links[i].post_title}</div>
                            <a href="${ incoming_links[i].post_url}" target="_blank" class="wilo-link-reference">${post_url}</a>
                        </td>
                        <td class="wilo-small-column"><a target="_blank" href="${incoming_links[i].post_url}?wilo_anchors=${incoming_links[i].anchor}&links_only=1" class="wilo-anchor">${incoming_links[i].anchor}</a></td>
                        <td>
                            ${incoming_links[i].duplicate_anchor ? '<div class="wilo-incoming-link-warning">Duplicate anchor <div class="wilo-tooltip" data-how-to-improve="To maximize the effectiveness of your inbound links, strive to create unique anchor texts while maintaining their relevance. Unique and contextually fitting anchor texts not only contribute to better search engine optimization but also enhance the user experience." data-about-issue="This post shares an identical anchor text with another incoming link directed towards the same post. Search engines rely on anchor text to understand the relevance of a link to the content it points to. When multiple links have the same anchor text, it can create confusion and reduce the effectiveness of your SEO efforts.">?</div></div>' : ''}
                            ${incoming_links[i].stuffed ? '<div class="wilo-incoming-link-warning">Stuffed link <div class="wilo-tooltip" data-how-to-improve="Remove any unnecessary links from the incoming post, leaving only one essential link." data-about-issue="The incoming URL is connected to this page through multiple links. This practice can have adverse effects. When a single URL is linked to a page multiple times, it may divert the authority and ranking value that those links carry, resulting in a less effective SEO strategy. The distribution of link equity becomes less focused, potentially diminishing the page\'s overall search engine performance.">?</div></div>' : ''}
                        </td>
                        <td><div class="wilo-impact-area">${incoming_links[i].impact}% <div class="wilo-bar"><div class="wilo-bar-percentage" style="width: ${incoming_links[i].impact}%;"></div></div></div></td>
                        <td>
                            <a href="${incoming_links[i].edit_url}" class="wilo-table-button" target="_blank">Edit page</a>
                        </td>
                    </tr>
                `
            }

            incoming_html += `

                    </tbody>
                </table>
            `;
        }

        jQuery('*[data-wilo-load="incoming"]').html(incoming_html);
        jQuery('.wilo-incoming-count').text('('+ page_data.incoming_internal_links_count + ')');
        var score_dashoffset = 1170 - ((1170 / 100) * page_data.internal_linking_score);
        if(page_data.internal_linking_score > 70){
            jQuery('.wilo-ils-graphic-percentage').css({'stroke':'#54D835'});
        }else if(page_data.internal_linking_score > 40){
            jQuery('.wilo-ils-graphic-percentage').css({'stroke':'#ED8D0B'});
        }else{
            jQuery('.wilo-ils-graphic-percentage').css({'stroke':'#E21654'});
        }
        jQuery('.wilo-ils-graphic-percentage').css({'stroke-dashoffset': score_dashoffset});

        
    }

    var url = new URL(window.location.href);
    var wilo_open = url.searchParams.get('wilo');
    if(wilo_open){
        setTimeout(function(){
            jQuery('.wilo-toggle').trigger('click');
        }, 500);
    }

});