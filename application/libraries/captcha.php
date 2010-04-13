<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
/**
	Original Source : Pavel Tzonkov <pavelc@users.sourceforge.net>
	Source Link : http://gscripts.net/free-php-scripts/Anti_Spam_Scripts/Image_Validator/details.html
	
	CodeIgniter library created by : 
		Mohammad Amzad Hossain
		http://tohin.wordpress.com
		
	
	License: Have Fun 
	
	# How To Use In CodeIgniter 
	
		// First Store Some fonts in fonts folder 
		// You can choose a font_name by overriding default value or this 
		// will randomly select a font.
		
	
		// In Controller 
		
			$this->load->library('captcha');
			$configs = array(
					'img_path' => './captcha/',
					'img_url' => base_url() . 'captcha/',
					'img_height' => '50',
				);			
			$captcha = $this->antispam->get_antispam_image($configs);
			
		// $captcha is an array exmaple
		//  array('word' => 'sfsdf', 'time' => time , 'image' => '<img .... ');
		
		
		// In View Print the $captcha['image'] to show captcha image.
		
		
	// Future Extension 
	
		Generated Captcha images always stored in captcha folder which is memory consuming
		unless you clear them out manually. 
		
		Looking for a feasible idea to delete them all.
		
	
*/
 
class Captcha {
 
 
	/*
		You can overrite All this variables during initialization
	*/
 
	var $img_url		=   '' ; 	// Image URL
	var $img_path 		=   './img/captcha/'; // Image path
	var $img_width 		= 	85;   	// CODE_WIDTH
	var $img_height 	= 	30;		// CODE_HEIGHT	
 
	var $font_name		= 	TRUE;		// test.ttf
	var $font_path 		= 	'./system/fonts';  // PATH_TTF	
	var $fonts 			=   array();  	// Collect fonts name from fonts folder
	var $font_size		=  	15; 	// CODE_FONT_SIZE
 
	var $char_set 		= "0123456789";	//CODE_ALLOWED_CHARS
	var $char_length 	= 	4;		// CODE_CHARS_COUNT
 
	var $char_color 	=   "#258dcf,#3fa1df,#3e3e3e,#292929,#223a4f";  // CODE_CHAR_COLORS
	var $char_colors	= 	array();  // array from $char_color
 
 
	var $line_count		=	10;		// CODE_LINES_COUNT
	var $line_color		=  "#fff3ca,#b6af98,#bfa57a,#cecb9b,#eeea93"; 	// CODE_LINE_COLORS
	var $line_colors 	= 	array();  // array from $line_color
 
	var $bg_color		=	'#FFFFFF';		// CODE_BG_COLOR
 
 
	// Initialization for Captcha Image
 
	function get_antispam_image( $override = array() ) {
 
		if( is_array( $override) )
		{
			foreach ( $override as  $key => $value) {
 
				if( isset( $this->$key ))
					$this->$key = $value;
			}			
		}
 	   
		$this->line_colors = preg_split("/,\s*?/", $this->line_color );
		$this->char_colors = preg_split("/,\s*?/", $this->char_color );
 
		$this->fonts = $this->collect_files( $this->font_path, "ttf");
 
 
		$img = imagecreatetruecolor( $this->img_width, $this->img_height);
		imagefilledrectangle($img, 0, 0, $this->img_width - 1, $this->img_height - 1, $this->gd_color( $this->bg_color ));
 
 
		// Draw lines
		for ($i = 0; $i < $this->line_count; $i++)
			imageline($img,
				rand(0, $this->img_width  - 1),
				rand(0, $this->img_height - 1),
				rand(0, $this->img_width  - 1),
				rand(0, $this->img_height - 1),
				$this->gd_color($this->line_colors[rand(0, count($this->line_colors) - 1)])
			);
 
		// Draw code
 
		$code = "";
		$y = ($this->img_height / 2) + ( $this->font_size / 2);
 
		for ($i = 0; $i < $this->char_length ; $i++) {
 
			$color = $this->gd_color( $this->char_colors[rand(0, count($this->char_colors) - 1)] );
			$angle = rand(-30, 30);
			$char = substr( $this->char_set, rand(0, strlen($this->char_set) - 1), 1);
 
 
			$sel_font = $this->font_name;
			if( $this->font_name == FALSE )
				$sel_font = $this->fonts[rand(0, count($this->fonts) - 1)];
 
 
 
			$font = $this->font_path . "/" . $sel_font;
 
			$x = (intval(( $this->img_width / $this->char_length) * $i) + ( $this->font_size / 2));
			$code .= $char;
 
			imagettftext($img, $this->font_size, $angle, $x, $y, $color, $font, $char);
 
		}
 
		// Storing Image 
 
		list($usec, $sec) = explode(" ", microtime());
		$now = ((float)$usec + (float)$sec);
 
		$img_name =  $now . '.jpg';
 
		ImageJPEG( $img,  $this->img_path.$img_name);
 
		$img_markup = '<img src="' . $this->img_url . $img_name . '" width=" ' . $this->img_width
					. '" height="' . $this->img_height . '" class="captcha" alt=" " />';
 	   
		ImageDestroy($img);
 
		return array('word' => $code, 'time' => $now, 'image' => $img_markup);
 
	}	
 
 
	function gd_color($html_color) {
		return preg_match('/^#?([\dA-F]{6})$/i', $html_color, $rgb)
		  ? hexdec($rgb[1]) : false;
	}
 
 
	function collect_files($dir, $ext) {
		if (false !== ($dir = opendir($dir))) {
			$files = array();
 
			while (false !== ($file = readdir($dir)))
				if (preg_match("/\\.$ext\$/i", $file))
					$files[] = $file;
 
			return $files;
 
		} else
			return false;
	}
 
 
 
}
