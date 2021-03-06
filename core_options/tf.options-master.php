<?php

/*
 * TF OPTIONS: MASTER FUNCTIONS
 * 
 */

// Register Menu Pages

require_once( TF_PATH . '/core_options/tf.options-of-uploader.php' );

require_once( TF_PATH . '/core_options/tf.options-business-general.php' );
require_once( TF_PATH . '/core_options/tf.options-business-location.php' );
require_once( TF_PATH . '/core_options/tf.options-business-logo.php' );

require_once( TF_PATH . '/core_options/tf.options-social-media.php' );
require_once( TF_PATH . '/core_options/tf.options-social-facebook.php' );
require_once( TF_PATH . '/core_options/tf.options-social-twitter.php' );

require_once( TF_PATH . '/core_options/tf.options-social-overview.php' );
require_once( TF_PATH . '/core_options/tf.options-social-gowalla.php' );
require_once( TF_PATH . '/core_options/tf.options-social-yelp.php' );
require_once( TF_PATH . '/core_options/tf.options-social-qype.php' );
require_once( TF_PATH . '/core_options/tf.options-social-foursquare.php' );
require_once( TF_PATH . '/core_options/tf.options-mailchimp.php' );

require_once( TF_PATH . '/core_options/tf.options-mobile.php' );

// Register Pages
// -----------------------------------------

function themeforce_business_options() {
    add_menu_page( 'Business Overview', 'Your Business', 'edit_posts', 'themeforce_business_options','', TF_URL . '/assets/images/general_16.png', 25); // $function, $icon_url, $position 
    add_submenu_page('themeforce_business_options', 'Business Details', 'Business Details', 'edit_posts', 'themeforce_business', 'themeforce_business_page');
    add_submenu_page('themeforce_business_options', 'Logo', 'Logo', 'edit_posts', 'themeforce_logo', 'themeforce_logo_page');   
    add_submenu_page('themeforce_business_options', 'Your Location', 'Location', 'edit_posts', 'themeforce_location', 'themeforce_location_page');
	add_submenu_page('themeforce_business_options', 'Newsletter', 'Newsletter', 'edit_posts', 'themeforce_mailchimp', 'themeforce_mailchimp_page');
}
add_action('admin_menu','themeforce_business_options');

function themeforce_socialmedia_options() {
    add_menu_page( 'Social Media Overview', 'Social Media', 'manage_options', 'themeforce_socialmedia_options','themeforce_social_media_overview_page', TF_URL . '/assets/images/socialmedia_16.png', 30); // $function, $icon_url, $position 
    add_submenu_page('themeforce_socialmedia_options', 'Facebook', 'Facebook', 'manage_options', 'themeforce_facebook', 'themeforce_social_facebook_page');
    add_submenu_page('themeforce_socialmedia_options', 'Twitter', 'Twitter', 'manage_options', 'themeforce_twitter', 'themeforce_social_twitter_page');
}
add_action('admin_menu','themeforce_socialmedia_options');

function themeforce_social_options() {
    add_menu_page( 'Social Proof Overview', 'Social Proof', 'manage_options', 'themeforce_social_options','themeforce_social_overview_page', TF_URL . '/assets/images/social_16.png', 35); // $function, $icon_url, $position 
    add_submenu_page('themeforce_social_options', 'Yelp', 'Yelp', 'manage_options', 'themeforce_yelp', 'themeforce_social_yelp_page');
    add_submenu_page('themeforce_social_options', 'Qype', 'Qype', 'manage_options', 'themeforce_qype', 'themeforce_social_qype_page');
    add_submenu_page('themeforce_social_options', 'Foursquare', 'Foursquare', 'manage_options', 'themeforce_foursquare', 'themeforce_social_foursquare_page');   
    add_submenu_page('themeforce_social_options', 'Gowalla', 'Gowalla', 'manage_options', 'themeforce_gowalla', 'themeforce_social_gowalla_page');
}
add_action('admin_menu','themeforce_social_options');

// Load jQuery & relevant CSS
// -----------------------------------------

// js
function themeforce_business_options_scripts() {
    wp_enqueue_script( 'tfoptions', TF_URL . '/assets/js/themeforce-options.js', array('jquery'));
    wp_enqueue_script( 'iphone-checkbox', TF_URL . '/assets/js/jquery.iphone-style-checkboxes.js', array('jquery'));
    wp_enqueue_script( 'farbtastic', TF_URL . '/assets/js/jquery.farbtastic.js', array('jquery'));
    wp_enqueue_script( 'chosen', TF_URL . '/assets/js/jquery.chosen.min.js', array('jquery'));
}

add_action( 'admin_print_scripts', 'themeforce_business_options_scripts' );

// css
function themeforce_business_options_styles() {
    wp_enqueue_style( 'tfoptions', TF_URL . '/assets/css/themeforce-options.css');
    wp_enqueue_style( 'farbtastic', TF_URL . '/assets/css/farbtastic.css');
}

add_action( 'admin_print_styles', 'themeforce_business_options_styles' );

// Validation

function tf_settings_validate($input) {
    
	$newinput['text_string'] = trim($input['text_string']);
    
    if(!preg_match('/^[a-z0-9]{32}$/i', $newinput['text_string'])) {
        $newinput['text_string'] = '';
    }

	return $newinput;
}

// Display Settings

function tf_display_settings($options) {

    foreach ($options as $value) {
        switch ( $value['type'] ) {

        case "title":
        ?>
        <h3><?php echo $value['name']; ?></h3>

        <?php break;    

        case "open":
        ?>

        <table>

        <?php break;

        case "close":
        ?>

        </table>

        <?php break;

        case 'text':
        ?>

        <tr>
            <th><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
            <td>
                <input name="<?php echo $value['id'] ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id'])  ); } else { echo $value['std']; } ?>">
                <br /><span class="desc"><?php echo $value['desc'] ?></span>
            </td>
        </tr>

        <?php
        break;

        case 'textarea':
        ?>

        <tr>
            <th><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
            <td><textarea name="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id']) ); } else { echo $value['std']; } ?></textarea>
            <br /><span class="desc"><?php echo $value['desc'] ?></span></td>
        </tr>

        <?php
        break;

        case 'select':
        ?>

        <tr>
            <th><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
            <td>
                <select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
                <?php foreach ($value['options'] as $option) { ?>
                    <option <?php selected( $option, get_option( $value['id'] ) ) ?>><?php echo $option; ?></option><?php } ?>
                </select>
                <br /><span class="desc"><?php echo $value['desc'] ?></span>
            </td>
        </tr>
         <?php
        break;
        
        case 'multiple-select':
        	
        	$current_values = (array) get_option( $value['id'], array() );
        	?>
			
        	<tr>
        	    <th><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
        	    <td>
        	        <select name="<?php echo $value['id']; ?>[]" class="chzn-select" multiple id="<?php echo $value['id']; ?>">
        	        <?php foreach ($value['options'] as $option) { ?>
        	            <option <?php selected( in_array( $option, $current_values ) ) ?>><?php echo $option; ?></option><?php } ?>
        	        </select>
        	        <br /><span class="desc"><?php echo $value['desc'] ?></span>
        	    </td>
        	</tr>
			
        	<?php
        	
        	
        	break;

        case "checkbox":
        
        	$std = $value['std'];     
        	    
        	$saved_std = get_option( $value['id'] );
			
        	$checked = '';
			
        	if(!empty($saved_std)) {
        	        if($saved_std == 'true') {
        	        $checked = 'checked="checked"';
        	        }
        	        else{
        	           $checked = '';
        	        }
        	}
        	elseif( $std == 'true') {
        	   $checked = 'checked="checked"';
        	}
        	else {
        	        $checked = '';
        	}
        	    
        	?>
			
        	<tr>
        	    <th><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
        	    <td>
        	        <input type="checkbox" name="<?php echo $value['id']; ?>" class="iphone" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
        	        <br /><span class="desc"><?php echo $value['desc'] ?></span>
        	    </td>
        	</tr>
			
        	<?php break;

        case "radio":
        ?>

        <tr>
            <th><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
            <td>
            <?php foreach ($value['options'] as $option) { ?>
                <div><input type="radio" name="<?php echo $value['id']; ?>" <?php if (get_option( $value['id'] ) == $option) { echo 'checked'; } ?> /><?php echo $option; ?></div><?php } ?>
                <br /><span class="desc"><?php echo $value['desc'] ?></span>
            </td>
        </tr>
        
        <?php break;
        
        case "image":
        ?>

        <tr>
            <th><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>

            </th>
            <td>
            <?php
            if ( get_option( $value['id'] ) != "") { $val = stripslashes(get_option( $value['id'])  ); } else { $val =  $value['std']; }
            ?>
            <?php echo tf_optionsframework_medialibrary_uploader( $value['id'], $val ); ?>
            <br /><span class="desc"><?php echo $value['desc'] ?></span>
            </td>
        </tr>
        
        <?php break;
        
        case "images":
        ?>
        <tr class="image-radio">
            <th><label><?php echo $value['name']; ?></label>

         </th>
        <td>
        <?php
        
        $i = 0;
        $select_value = get_option($value['id']);

        foreach ($value['options'] as $key => $option) 
         { 
         $i++;

                 $checked = '';
                 $selected = '';
                   if($select_value != '') {
                                if ( $select_value == $key) { $checked = ' checked'; $selected = 'tf-radio-img-selected'; } 
                    } else {
                                if ($value['std'] == $key) { $checked = ' checked'; $selected = 'tf-radio-img-selected'; }
                                elseif ($i == 1  && !isset($select_value)) { $checked = ' checked'; $selected = 'tf-radio-img-selected'; }
                                elseif ($i == 1  && $value['std'] == '') { $checked = ' checked'; $selected = 'tf-radio-img-selected'; }
                                else { $checked = ''; }
                        }	

                echo '<span>';
                echo '<input type="radio" id="' . $value['id'] . $i . '" class="tf-radio-img-radio" value="'.$key.'" name="'. $value['id'].'"'.$checked.' tabindex="'.$i .'" />';
                echo '<label for="'. $value['id'] . $i . '"><img src="'.$option.'" alt="" class="tf-radio-img-img '. $selected .'" /></label>';
                echo '</span>';

        } ?>
        </td>
        </tr> 
         
        <?php
        break;
        
        case "open-farbtastic":
        ?>
        
        </table>
        <div style="clear:both;"></div>
        <div class="tf-settings-wrap tf-farbtastic">
        <div id="farbtastic-picker"><div id="picker-bg"></div></div>
        <table> 
        
        
        <?php break;
        
        case "colorpicker":
        ?>

        <tr>
            <th><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
            <td>
            <input class="colorwell" name="<?php echo $value['id'] ?>" type="text" value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id'])  ); } else { echo $value['std']; } ?>">
            </td>
        </tr>
        
         <?php break;
        
        case "close-farbtastic":
        ?>
            
        </table>
        </div>
        <div style="clear:both;"></div>
        <table>      
        
        <?php break;
        }
	}
	
	foreach( $options as $option ) 
		if( !empty( $option['id'] ) )
			$option_ids[] = $option['id'];
	
	?>
	
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="page_options" value="<?php echo implode(',', $option_ids) ?>" />
    <?php wp_nonce_field( 'update-options' ); ?>
	    
    <?php
}?>