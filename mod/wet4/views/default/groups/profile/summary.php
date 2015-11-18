<?php
/**
 * Group profile summary
 *
 * Icon and profile fields
 *
 * @uses $vars['group']
 */

if (!isset($vars['entity']) || !$vars['entity']) {
	echo elgg_echo('groups:notfound');
	return true;
}

$group = $vars['entity'];
$owner = $group->getOwnerEntity();

$buttonTitle = 'Member';

if (!$owner) {
	// not having an owner is very bad so we throw an exception
	$msg = "Sorry, '" . 'group owner' . "' does not exist for guid:" . $group->guid;
	throw new InvalidParameterException($msg);
}

?>
<div class="groups-profile panel panel-custom clearfix elgg-image-block">

        
    
    
        <div class="panel-heading col-xs-12 mrgn-lft-sm"> 
            
            <div class="btn-group pull-right mrgn-rght-sm">
                
                
                
                <?php 
                    if(elgg_is_logged_in()){ 
                    $user = get_loggedin_user()->getGUID();
                           
                    //see if user is a member
                    if($group->isFriendOf($user)){
            
                        //load action buttons in dropdown
                        $buttons = elgg_view_menu('title', array(
                            'sort_by' => 'priority',
                            'class' => 'dropdown-menu pull-right',
                            'item_class' => ' ',

                        ));

                        //display different title on button for group owner/mods
                        if($owner == get_loggedin_user()){
                            $buttonTitle = "Settings";
                        }
                ?>
                

                <button type="button" class="btn btn-custom dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo $buttonTitle ?> <span class="caret"></span>
                </button>
            
                        <?php 
                            
                                //action buttons
                                echo $buttons; 
                        
                            } else {
                        
                            //if only join group option, display as button not in dropdown
                        $buttons = elgg_view_menu('title', array(
                            'sort_by' => 'priority',
                            'class' => '',
                            'item_class' => 'btn btn-primary',

                        ));
                        
                        echo $buttons;
                    }
                    }
                    
                        ?>
                
            </div>

                
            <h2 class="pull-left"><?php echo $group->name; ?></h2>
        </div>
    
		<div class="groups-profile-icon pull-left mrgn-lft-md">
			<?php
				// we don't force icons to be square so don't set width/height
				echo elgg_view_entity_icon($group, 'medium', array(
					'href' => '',
					'width' => '',
					'height' => '',
				)); 
			?>
		</div>
        
    
    
    
		<div class="groups-info pull-left mrgn-lft-md">
            
            
			<p class="mrgn-bttm-sm">
				<b><?php echo elgg_echo("groups:owner"); ?>: </b>
				<?php
					echo elgg_view('output/url', array(
						'text' => $owner->name,
						'value' => $owner->getURL(),
						'is_trusted' => true,
					));  
				?>
			</p>
            
            
			<p class="mrgn-bttm-sm">
			<?php
				$num_members = $group->getMembers(array('count' => true));
				echo '<b>' . elgg_echo('groups:members') . ':</b> ' . $num_members;
			?>
			</p>
            
            
            <?php

            //Add tags for new layout to profile stats

            $profile_fields = elgg_get_config('group');

            foreach ($profile_fields as $key => $valtype) {
                
                $options = array('value' => $group->$key, 'list_class' => 'mrgn-bttm-sm',);
                
                if ($valtype == 'tags') {
                    $options['tag_names'] = $key;
                    $tags .= elgg_view("output/$valtype", $options);
                }   
            }   

            
            //check to see if tags have been made
            //dont list tag header if no tags
            if(!$tags){
                
            } else {
                echo '<b>' . elgg_echo('profile:field:tags') . '</b>';
                echo $tags;
            }

            ?>
            
            <div class="groups-stats mrgn-tp-0 mrgn-bttm-sm"></div>
           
		</div>
    


</div>
