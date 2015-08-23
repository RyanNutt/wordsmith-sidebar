<?php
/**
 * Plugin Name:     WordSmith Sidebar Widget
 * Plugin URI:      https://www.github.com/RyanNutt/wordsmith-sidebar
 * Description:     Adds the word of the day from Wordsmith.org to your site
 * Version:         1.0
 * Author:          Ryan Nutt
 * Author URI:      http://www.nutt.net
 * License:         GPLv3
 */

class Wordsmith_Sidebar extends WP_Widget {
    
    const TRANSIENT_LENGTH = 3600;  // 1 hour 
    const RSS_FEED = 'http://wordsmith.org/awad/rss1.xml'; 
    
    public function __construct() {
        parent::__construct(false, __('Word of the Day', 'wordsmith-sidebar'), array('description' => __('Display a word of the day from Wordsmith.org', 'wordsmith-sidebar'))); 
    }
    
    public function form($instance) {
        _e('<p>There are not any options for this widget</p>', 'wordsmith-sidebar'); 
    }
    
    public function update($new_instance, $old_instance) {
        return $old_instance; 
    }
    
    public function widget($args, $instance) {
        $word = $this->get_word(); 
        
        if ($word === false) {
            return; 
        }
        
        echo '<div class="widget-text ws-wrapper">';
        
        echo '<h3>' . $word->word . '</h3>';
        echo '<p>' . $word->definition . '</p>'; 
        
        echo '</div>'; // .ws-wrapper
    }
    
    private function get_word() {
        
        $word = get_transient('wordsmith_word');
         
        if ($word === false) {
            require_once(ABSPATH . WPINC . '/feed.php'); 
            
            $rss = fetch_feed(self::RSS_FEED);
            
            if (is_wp_error($rss)) {
                return false; 
            }
            
            $rss_item = $rss->get_items(0, 1);
            if (count($rss_item) < 1) {
                return false; 
            }
            
            $word = new stdClass();

            $word->word = $rss_item[0]->get_title();
            $word->definition = $rss_item[0]->get_description(); 
            
            set_transient('wordsmith_word', $word, self::TRANSIENT_LENGTH); 
        }
        
        return $word;
    }
    
}

add_action('widgets_init', 'wordsmith_register_sidebar');
function wordsmith_register_sidebar() {
    register_widget('Wordsmith_Sidebar'); 
}