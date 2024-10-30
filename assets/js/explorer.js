jQuery(window).ready(function(){
    
    /**Keyword line numbers**/
    jQuery('.wilo-keyword-input').on('keyup', function(){
        
        let value = jQuery(this).val();
        //count number of lines in textarea
        let lineCount = (value.match(/\n/g) || []).length + 1;

        jQuery('.wilo-line-numbers').empty();
        for(let i = 1; i <= lineCount; i++){
            jQuery('.wilo-line-numbers').append(`<div class="wilo-ln">${i}.</div>`)
        }
    });
    
    jQuery('.wilo-nav-item[data-id="explorer"]').on('click', function(){
        if(jQuery('*[data-wilo-load="explorer"]').is(':empty')){
            loadExplorerResults();   
        }
    });

    jQuery('.wilo-refresh-explorer').on('click', loadExplorerResults);

    function loadExplorerResults(){

        jQuery('.wilo-explorer-container').empty();
        jQuery('.wilo-explorer-count').empty();

        if(jQuery('.wilo-keyword-input').val().length == 0){
            var opportunies_html = `
                <div class="wilo-notice">
                    <div class="wilo-title">No keywords entered</div>
                    <div class="wilo-body">This page doesn't have any keywords associated with it.</div>
                </div>
            `;
            jQuery('*[data-wilo-load="explorer"]').html(opportunies_html);
            jQuery.ajax({
                url: '/wp-admin/admin-ajax.php',
                data: {
                    action: 'wilo_remove_keywords',
                    post_id: jQuery('.wilo-load-explorer').data('post-id'),
                },
            });
        }else{
            jQuery.ajax({
                url: '/wp-admin/admin-ajax.php',
                data: {
                    action: 'wilo_get_opportunities',
                    post_id: jQuery('.wilo-load-explorer').data('post-id'),
                    keywords: jQuery('.wilo-keyword-input').val()
                },
                success: function(opportunities) {
                    opportunities = JSON.parse(opportunities);

                    if(! opportunities || opportunities.length == 0){
                        var opportunies_html = `
                            <div class="wilo-notice">
                                <div class="wilo-title">No results</div>
                                <div class="wilo-body">No pages contain the keywords you entered.</div>
                            </div>
                        `;
                        jQuery('*[data-wilo-load="explorer"]').html(opportunies_html);
                    }else{
                        var opportunies_html = `
                        <table class="wilo-table">
                            <thead>
                                <tr>
                                    <th class="wilo-large-column">Page</th>
                                    <th class="wilo-small-column">Keyword match</th>
                                    <th >Potential impact</th>
                                </tr>
                            </thead>
                            <tbody>
                        `;

                        for (var i = 0; i < opportunities.length; i++) {
                            if(opportunities[i].post_url == '/'){
                                var post_url = opportunities[i].post_url;
                            }else{
                                var post_url = '...'+opportunities[i].post_url;
                            }

                            opportunies_html += `
                                <tr>
                                    <td class="wilo-large-column">
                                        <div class="wilo-body">${opportunities[i].post_title}</div>
                                        <a href="${ opportunities[i].post_url}" target="_blank" class="wilo-link-reference">${post_url}</a>
                                    </td>
                                    <td class="wilo-small-column"><a target="_blank" href="${opportunities[i].post_url}?wilo_anchors=${opportunities[i].keyword}" class="wilo-anchor">${opportunities[i].keyword}</a></td>
                                    <td><div class="wilo-impact-area">${opportunities[i].impact}% <div class="wilo-bar"><div class="wilo-bar-percentage" style="width: ${opportunities[i].impact}%;"></div></div></div></td>
                                </tr>
                            `
                        }
                
                        opportunies_html += `
                
                                </tbody>
                            </table>
                        `;
                    }

                    jQuery('*[data-wilo-load="explorer"]').html(opportunies_html);
                    jQuery('.wilo-explorer-count').text('('+ opportunities.length + ')');

                }
            })
        }
    }

    jQuery('.wilo-load-explorer').on('click', function(){
        loadExplorerResults(jQuery(this).attr('data-post-id'));
    })

})