<?php
/*
Plugin Name: Really Simple CAPTCHA
Plugin URI: http://ideasilo.wordpress.com/2009/03/14/really-simple-captcha/
Description: Really Simple CAPTCHA is a CAPTCHA module intended to be called from other plugins. It is originally created for my Contact Form 7 plugin.
Author: Takayuki Miyoshi
Version: 1.1
Author URI: http://ideasilo.wordpress.com/
*/

/*  Copyright 2007-2009 Takayuki Miyoshi (email: takayukister at gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

class wpdevReallySimpleCaptcha {

	function wpdevReallySimpleCaptcha() {

		/* Characters available in images */
		$this->chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';

		/* Length of a word in an image */
		$this->char_length = 4;

		/* Array of fonts. Randomly picked up per character */
		$this->fonts = array(
			dirname( __FILE__ ) . '/gentium/GenAI102.TTF',
			dirname( __FILE__ ) . '/gentium/GenAR102.TTF',
			dirname( __FILE__ ) . '/gentium/GenI102.TTF',
			dirname( __FILE__ ) . '/gentium/GenR102.TTF' );

		/* Directory temporary keeping CAPTCHA images and corresponding codes */
		$this->tmp_dir = dirname( __FILE__ ) . '/tmp/';

		/* Array of CAPTCHA image size. Width and height */
		$this->img_size = array( 72, 24 );

		/* Background color of CAPTCHA image. RGB color 0-255 */
		$this->bg = array( 255, 255, 255 );

		/* Foreground (character) color of CAPTCHA image. RGB color 0-255 */
		$this->fg = array( 0, 0, 0 );

		/* Coordinates for a text in an image. I don't know the meaning. Just adjust. */
		$this->base = array( 6, 18 );

		/* Font size */
		$this->font_size = 14;

		/* Width of a character */
		$this->font_char_width = 15;

		/* Image type. 'png', 'gif' or 'jpeg' */
		$this->img_type = 'png';

		/* Mode of temporary files */
		$this->file_mode = 0755;
	}

	/* Generate and return random word with $chars characters x $char_length length */

	function generate_random_word() {
		$word = '';
		for ( $i = 0; $i < $this->char_length; $i++ ) {
			$pos = mt_rand( 0, strlen( $this->chars ) - 1 );
			$char = $this->chars[$pos];
			$word .= $char;
		}
		return $word;
	}

	/* Generate CAPTCHA code and corresponding code and save them into $tmp_dir directory.
	$prefix is file prefix for both files.
	$captcha is a random word usually generated by generate_random_word()
	This function returns the filename of the CAPTCHA image temporary file */

	function generate_image( $prefix, $word ) {
		$filename = null;

		if ( $im = imagecreatetruecolor( $this->img_size[0], $this->img_size[1] ) ) {
			$bg = imagecolorallocate( $im, $this->bg[0], $this->bg[1], $this->bg[2] );
			$fg = imagecolorallocate( $im, $this->fg[0], $this->fg[1], $this->fg[2] );

			imagefill( $im, 0, 0, $bg );

			$x = $this->base[0] + mt_rand( -2, 2 );

			for ( $i = 0; $i < strlen( $word ); $i++ ) {
				$font = $this->fonts[array_rand( $this->fonts )];
				imagettftext( $im, $this->font_size, mt_rand( -2, 2 ), $x,
					$this->base[1] + mt_rand( -2, 2 ), $fg, $font, $word[$i] );
				$x += $this->font_char_width;
			}

			switch ( $this->img_type ) {
				case 'jpeg':
					$filename = $prefix . '.jpeg';
					imagejpeg( $im, $this->tmp_dir . $filename );
					break;
				case 'gif':
					$filename = $prefix . '.gif';
					imagegif( $im, $this->tmp_dir . $filename );
					break;
				case 'png':
				default:
					$filename = $prefix . '.png';
					imagepng( $im, $this->tmp_dir . $filename );
			}

			imagedestroy( $im );
			@chmod( $this->tmp_dir . $filename, $this->file_mode );
		}

		if ( $fh = fopen( $this->tmp_dir . $prefix . '.php', 'w' ) ) {
			@chmod( $this->tmp_dir . $prefix . '.php', $this->file_mode );
			fwrite( $fh, '<?php $captcha = "' . $word . '"; ?>' );
			fclose( $fh );
		}

		return $filename;
	}

	/* Check a $response against the code kept in the temporary file with $prefix
	Return true if the two match, otherwise return false. */

	function check( $prefix, $response ) {
		if ( is_readable( $this->tmp_dir . $prefix . '.php' ) ) {
			include( $this->tmp_dir . $prefix . '.php' );
			if ( 0 == strcasecmp( $response, $captcha ) )
				return true;
		}
		return false;
	}

	/* Remove temporary files with $prefix */

	function remove( $prefix ) {
		$suffixes = array( '.jpeg', '.gif', '.png', '.php' );

		foreach ( $suffixes as $suffix ) {
			$file = $this->tmp_dir . $prefix . $suffix;
			if ( is_file( $file ) )
				unlink( $file );
		}
	}

	/* Clean up dead files older than $minutes in the tmp folder */

	function cleanup( $minutes = 60 ) {
		$dir = $this->tmp_dir;

		if ( ! is_dir( $dir ) || ! is_readable( $dir ) || ! is_writable( $dir ) )
			return false;

		$count = 0;

		if ( $handle = @opendir( $dir ) ) {
			while ( false !== ( $file = readdir( $handle ) ) ) {
				if ( ! preg_match( '/^[0-9]+\.(php|png|gif|jpeg)$/', $file ) )
					continue;

				$stat = @stat( $dir . $file );
				if ( ( $stat['mtime'] + $minutes * 60 ) < time() ) {
					@unlink( $dir . $file );
					$count += 1;
				}
			}

			closedir( $handle );
		}

		return $count;
	}

}

?>