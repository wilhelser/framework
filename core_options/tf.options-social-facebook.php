<?php

/*
 * TF OPTIONS: FACEBOOK
 * 
 * Provide easy to use options for Theme Force users.
 * 
 */

// Create Page
// -----------------------------------------
// TODO Add functionality to edit existing slides.

function themeforce_social_facebook_page() {
    ?>
    <div class="wrap" id="tf-options-page">
    <div id="tf-options-panel">
    <form class="form-table" action="options.php" method="post">
   
    <?php 
    
    // List of Options used within Dropdowns, etc.
    
    $shortname = "tf";
    
    // Options
    
    $options = array (
 
        array( "name" => "Facebook Settings", "type" => "title"),

        array( "type" => "open"),   

	array( "name" => "Facebook Link",
                "desc" => "The link to your Facebook fan page/profile.",
                "id" => $shortname."_facebook",
                "std" => "",
                "type" => "text"),     
      
	array( "type" => "close"), 
 
);

    tf_display_settings($options);
    ?> 
        
	 <input type="submit" id="tf-submit" name="options_submit" value=" <?php _e( 'Save Changes' )  ?>" />
         <div style="clear:both;"></div>
    </form>
        <!--
        <div id="tf-tip">
            <h3>Did you know?</h3>
            <p>Having a Yelp profile can increase your exposure to various plenty of new customers. In May 2011, they recorded the following numbers:</p>
            <ul>
                <li>A whopping 27% of all Yelp searches come from that iPhone application.</li>
                <li>Over half a million calls were made to local businesses directly from the iPhone App, or one in every five seconds.</li>
                <li>Nearly a million people generated point-to-point directions to a local business from their Yelp iPhone App last month.</li>
            </ul>

        </div>
        -->
    </div>
    <?php
        
}	
?>