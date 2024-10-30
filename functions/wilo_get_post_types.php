<?php 
function wilo_get_post_types(){

	$post_types = get_post_types();
	unset($post_types['attachment']);

	return $post_types;
}