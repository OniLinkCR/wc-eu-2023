<?php
/*
    Plugin Name: WordCamp EU 2023 Hooks Plugin
    Plugin URI: https://europe.wordcamp.org/2023/
    Description: Tnis one does it all. All in the workshop
    Author: WordCamp Enthusiasts
    Author URI: https://europe.wordcamp.org/2023/
    Version: 0.1
    License: GPLv2 or later
    License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

add_action('init', 'wc_eu_2023_register_custom_post_type');

function wc_eu_2023_register_custom_post_type() {
    do_action('wc_eu_2023_register_custom_post_type');
}

function wc_eu_2023_register_post_type($singular, $plural, $slug, $description) {
    
    $custom_post_labels = array(
		'name'          => $singular,
		'singular_name' => $singular,
		'add_new_item'  => 'Add New '.$singular,
		'edit_item'     => 'Edit '. $plural,
		'new_item'      => 'New ' .$plural,
		'view_item'     => 'View '.$plural,
		'search_items'  => 'Search ' .$plural,
		'not_found'     => 'No '.$plural,

	);

    $custom_args = array(
        'labels' => $custom_post_labels,
        'description' => $description,
        'public'      => true,
        'show_ui'     => true,
        'supports'    => array(
            'title',
            'editor',
            'excerpt',
        )

    );

    register_post_type( $slug, $custom_args );
	flush_rewrite_rules();
}


add_action('wc_eu_2023_register_custom_post_type', 'wc_eu_2023_register_session_post');

function wc_eu_2023_register_session_post() {
    wc_eu_2023_register_post_type('Session', 'Sessions', 'session', 'Session DEscription');
}

add_action('wc_eu_2023_register_custom_post_type', 'wc_eu_2023_register_speaker_post');

function wc_eu_2023_register_speaker_post() {
    // If I have 2000 attendees
    wc_eu_2023_register_post_type('Speaker', 'Speakers', 'speakers', 'speaker DEscription');
}

add_action('wc_eu_2023_register_custom_post_type', 'wc_eu_2023_register_attendees_post');

function wc_eu_2023_register_attendees_post() {
    // If I have 2000 attendees
    wc_eu_2023_register_post_type('Attendee', 'Attendees', 'attendee', 'Attendee DEscription');
}

// add_filter( 'option_comment_previously_approved', 'option_comment_approved_always' );

// function option_comment_approved_always($option) {
//     return true;
// }

add_filter( 'option_comment_previously_approved', '__return_true' );

add_filter( 'option_thread_comments_depth', function ($option) {
	return 2;
});


add_filter( 'comment_text', 'wc_eu_2023_naughty_filter' );

function wc_eu_2023_naughty_filter($comment_text) {

    $naughtyWords       = array('malaka', 'pula', 'picha', 'youknow');
    $naughtyWordsCount  = sizeof($naughtyWords);
    
	for($i=0; $i < $naughtyWordsCount; $i++) {
        $comment_text = str_ireplace( $naughtyWords[$i], '<strong>*****</strong>', $comment_text );
    } 
    
    return $comment_text;

}

// add_action( 'all', 'show_all_hooks' );  // All is all...lol
	
// function show_all_hooks( $tag ) {
// 	if(! ( is_admin() ) ){ // Display Hooks in front end pages only
// 		$debug_tags = array();
// 		global $debug_tags;
// 		if ( in_array( $tag, $debug_tags ) ) {
// 			return;
// 		}
// 		echo "<pre>" . $tag . "</pre>";
// 		$debug_tags[] = $tag;
// 	}
// }

add_action('wp_enqueue_scripts', 'load_my_scripts'); 

function load_my_scripts() {
//You add your scripts here using the register_script function
//https://developer.wordpress.org/reference/functions/wp_register_script/
}


add_action( 'pre_get_posts', 'my_modify_main_query' );
function my_modify_main_query( $query ) {

	if((!is_admin() ) && ($query -> is_main_query() ) ) :
  
		if (is_front_page()) { // Run only on blog
		
			$query->query_vars['posts_per_page'] = 1; 
		   
		}


	endif;
}





