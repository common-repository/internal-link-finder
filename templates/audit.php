<div class="wilo-content-area wilo-content-area-active" data-id="audit">
   <div class="wilo-grid">
      <div class="wilo-page-overview wilo-grid">
         <div class="wilo-col">
            <div class="wilo-title"><?php the_title(); ?></div>
            <div class="wilo-link-reference"><?php the_permalink(); ?></div>
         </div>
         <div class="wilo-col wilo-align-right">
            <div class="wilo-refresh-audit wilo-overview-button"><?php echo file_get_contents(WILO_PATH . 'assets/images/refresh.svg'); ?> Refresh</div>
         </div>
      </div>

      <div class="wilo-audit-profile wilo-data-box wilo-grid">
         <div class="wilo-col">
            <div class="wilo-title">Page profile</div>
            <div class="wilo-page-profile wilo-grid">
               <div class="wilo-ils wilo-grid">
                  <div class="wilo-col">
                     <?php echo file_get_contents(WILO_PATH . 'assets/images/score.svg'); ?>
                  </div>
                  <div class="wilo-col">
                     <div class="wilo-body">Internal Linking Score <div class="wilo-tooltip" data-how-to-improve="This score considers all errors and factors in the count of both incoming and outgoing links to provide a comprehensive assessment of the post's internal linking quality." data-about-issue="This represents the overall internal linking score for the inspected post, which is determined through intricate algorithms. Fix all notices and increase the number of incoming internal links to improve the score.">?</div></div>
                     <div class="wilo-large-body" data-wilo-load="internal_linking_score"></div>
                  </div>
               </div>
               <div class="wilo-col">
                  <div class="wilo-body">Incoming Internal Links <div class="wilo-tooltip" data-notice="This is the number of incoming internal links to this page. The more incoming link to a page usually positively impacts its ranking.">?</div></div>
                  <div class="wilo-large-body" data-wilo-load="incoming_internal_links_count"></div>
               </div>
            </div>
         </div>
         <div class="wilo-col">
            <div class="wilo-title">Warnings</div>
            <div class="wilo-warnings wilo-grid">
               <div class="wilo-col">
                  <div class="wilo-body">Stuffed links <div class="wilo-tooltip" data-how-to-improve="Remove any unnecessary links from the highlighted posts, leaving only the essential links." data-about-issue="The number of Incoming URLs that are connected to this page through multiple links. This practice can have adverse effects. When a single URL is linked to a page multiple times, it may divert the authority and ranking value that those links carry, resulting in a less effective SEO strategy. The distribution of link equity becomes less focused, potentially diminishing the page's overall search engine performance.">?</div></div>
                  <div class="wilo-large-body" data-wilo-load="stuffed_links"></div>
               </div>
               <div class="wilo-col">
                  <div class="wilo-body">Duplicate anchors <div class="wilo-tooltip" data-about-issue="The number of incoming links that share an identical anchor text with another. Search engines rely on anchor text to understand the relevance of a link to the content it points to. When multiple links have the same anchor text, it can create confusion and reduce the effectiveness of your SEO efforts." data-how-to-improve="To maximize the effectiveness of your inbound links, strive to create unique anchor texts while maintaining their relevance. Unique and contextually fitting anchor texts not only contribute to better search engine optimization but also enhance the user experience.">?</div></div>
                  <div class="wilo-large-body" data-wilo-load="duplicate_anchors_count"></div>
               </div>
            </div>
         </div>
      </div>

      <div class="wilo-data-box">
         <div class="wilo-title">Incoming Internal Links <small class="wilo-incoming-count"></small></div>
         <div class="wilo-incoming">
            <div class="wilo-incoming-container" data-wilo-load="incoming"></div>
         </div>
      </div>
   </div>

</div>