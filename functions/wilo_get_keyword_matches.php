<?php 
function wilo_get_keyword_matches($content, $keywords){

    $content = strip_tags($content);
    $keywords_return = array();
     $search_position = 0;
     $keyword_positions = array();
     foreach($keywords as $keyword):
        while (($search_position = strpos($content, $keyword, $search_position)) !== false):
            $keyword_positions[] = array('position' => $search_position, 'keyword' => $keyword);
            $search_position += strlen($keyword);
        endwhile;
     endforeach;

     $count = 0;
     foreach ($keyword_positions as $keyword_position) {
        $keyword = $keyword_position['keyword'];
        $keyword_start = $keyword_position['position'] - strlen($keyword) - 100;

        if($keyword_start < 0){
            $keyword_start = 0;
        }

        $keywords_return[$count]['keyword'] = $keyword;

        if ($keyword_context_start !== false) {
            $keyword_context = substr($content, $keyword_start, 200);
            $keywords_return[$count]['context'] = '...'.$keyword_context.'...';
        }

        $count++;
        
    }

     return $keywords_return;
}