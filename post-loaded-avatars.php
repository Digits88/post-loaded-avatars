<?php
/*
Plugin Name: Post Loaded Avatars
Plugin URI: http://www.wptheming.com
Description: Delays the load of avatar images to help speed up the rest of your content.
Version: 0.1
Author: Devin Price
Author URI: http://www.wptheming.com
License: GPLv2
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

/* Basic plugin definitions */

define('POST_LOADED_AVATARS', '0.1');

/* Make sure we don't expose any info if called directly */

if ( !function_exists( 'add_action' ) ) {
	echo "Hi there!  I'm just a little plugin, don't mind me.";
	exit;
}

function post_loaded_avatars() {
	if (!is_admin()) {
		wp_enqueue_script('jquery');
		add_filter('get_avatar','post_load_avatar',10,5);
		add_action('wp_print_footer_scripts', 'post_load_avatar_scripts');
	}
}

add_action('init', 'post_loaded_avatars' );

function post_load_avatar($avatar, $id_or_email, $size, $default, $alt) {
	$avatar = str_replace('src','src="' . $default . '" data-src', $avatar);
	return $avatar;
}

function post_load_avatar_scripts() {
	if ( get_comments_number($post->ID) > 0 ) {
	?>
	<script>
        jQuery(window).load(function() {
                jQuery('.avatar').each(function(index) {
                    jQuery(this).hide().attr("src",jQuery(this).attr("data-src")).fadeIn();
                });
        });
    </script>
<?php }
}