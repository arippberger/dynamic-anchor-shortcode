<?php
/**
 * Plugin Name: Dynamic Anchor Shortcode
 * Plugin URI: https://github.com/arippberger/dns-lorem-ipsum-generator
 * Description: Adds lorem ipsum text via the [dns-ipsum] shortcode and a TinyMCE button 
 * Version: 1.1
 * Author: arippberger, duenorthstudios
 * Author URI: http://DueNorthStudios.com
 * License: GPL2
*/
/*  Copyright 2014  Due North Studios, LLC  (email : alec@duenorthstudios.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
class dynamicAnchorShortcode {
    public function __construct() {
    	add_filter('widget_text', 'do_shortcode'); // allow shortcodes in widgets
        add_shortcode('a' , array($this, 'html_anchor' ));
    }

	public function html_anchor($atts) {
		
		//extract attributes and set default values
		extract( shortcode_atts( array(
			'class' => '',
			'id' => '',
			'href' => '',
			'pid' => '', 
			'target' => '',	
			'rel' => '',
			'hreflang' => '', 
			'media' => '', 
			'type' => '',
			'style' => $style		
		), $atts ) );

		$anchor_attributes = array( //give attributes nice key/value pairs
			'class'=>$class, 
			'id'=>$id, 
			'href'=>$href, 
			'target' => $target,	
			'rel' => $rel,
			'hreflang' => $hreflang, 
			'media' => $media, 
			'type' => $type, 
			'style' => $style		
		); 

		$sanitized_attributes = '';
		$pid = intval($pid); //convert post/page id to integer
		if (!empty($pid) && is_int($pid)) { //if the post id isn't empty make it's URL the href - overrides href attribute, if any
			$anchor_attributes['href'] =  get_permalink( $pid );
		}
		foreach ($anchor_attributes as $attribute_key => $attribute) { //loop through attributes
			//var_dump($attribute);
			if ($attribute_key == 'href') {
				$attribute = esc_url($attribute);
			} else {
				$attribute = esc_attr( $attribute ); //sanitize
			}
			if (!empty($attribute) && is_string($attribute)) {
				$sanitized_attributes .= $attribute_key . '="' . $attribute . '" '; 
			}
		}
	    $return = '<a ' . $sanitized_attributes . '>';
	    $return .= '</a>';
	    return $return;
	}    
     

}
 
$dynamicAnchorShortcode = new dynamicAnchorShortcode();

?>
