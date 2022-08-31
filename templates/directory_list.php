<?php 
// Template name: District Directory (List)

	get_header();
	
	$user;
	if(isset($_POST['login_username']) && isset($_POST['login_password'])){
		$creds = array( 'user_login' =>  $_POST['login_username'], 'user_password' => $_POST['login_password'] );
		wp_logout();
		$user = wp_signon( $creds, true );
		if ( !is_wp_error($user) ){ 
			wp_set_current_user($user->ID);
			echo '<meta http-equiv=refresh content="1; '.get_bloginfo('url').'/district-directory/?action=success">';
		}
	}
	
	function canEdit(){
		if(current_user_can('edit_users')){
			return true;
		} else {
			return false;
		}
	}
?>
	
	<div class="wrapper">
		
		<div class="columns cf">
			
			<div class="col col_2 cf">
				<?php if(!is_user_logged_in()) { ?>
					<?php wp_login_form( array( 'redirect' => get_bloginfo('url').'/district-directory/' )); ?>
				<?php } else { ?>
					<?php if(is_user_logged_in()){ ?>
						<p>Logged in as <strong><?php echo ucwords(implode(', ', get_userdata(get_current_user_id())->roles)); ?></strong></p>
						<?php if(canEdit() === true){ ?>
							<a href="<?php bloginfo('url'); ?>/district-directory/person/?action=new" class="btn green huge">add person<?php if(current_user_can('administrator')) { ?> / administrator<?php } ?></a>
						<?php } ?>
						<div class="directory_list cf">
							<?php if(isset($_GET['query'])) { ?>
								<?php 
									$people = kolodoSearchDirectory(['leader', 'directory_adminstrator', 'publisher', 'group_administrator', 'administrator'], $_GET['query']);
									if(sizeof($people) < 1){
										?><p>Your search returned no results.</p><?php	
									} ?>
									<p>You searched for <strong><?php echo $_GET['query']; ?></strong></p>
									<?php foreach($people as $person){ 
								?>
									<a href="<?php bloginfo('url'); ?>/district-directory/person/?sid=<?php echo $person->ID; ?>">
										<p><?php the_field('first_name', 'user_'.$person->ID); ?> <?php the_field('last_name', 'user_'.$person->ID); ?></p>
										<small>Email: <?php the_field('email', 'user_'.$person->ID); ?></small>
										<span class="arrow">&raquo;</span>
									</a>
								<?php } ?>
							<?php } else { ?>
								<?php 
									$people = kolodoGetPeople(array('leader', 'directory_administrator', 'publisher', 'group_administrator', 'administrator')); 
									foreach($people as $person){ 
								?>
									<a href="<?php bloginfo('url'); ?>/district-directory/person/?sid=<?php echo $person->ID; ?>">
										<p><?php the_field('first_name', 'user_'.$person->ID); ?> <?php the_field('last_name', 'user_'.$person->ID); ?></p>
										<small>Email: <?php the_field('email', 'user_'.$person->ID); ?></small>
										<span class="arrow">&raquo;</span>
									</a>
								<?php } ?>
							
							<?php } ?>
						</div><!-- directory_list -->
					<?php } else { ?>
						<a href="./?action=login" class="btn green huge">login</a>
					<?php } ?>
				<?php } ?>
			</div><!-- col_2 -->
			
			<div class="col col_1 cf">
				<?php get_sidebar(); ?>
			</div><!-- col_1 -->
			
		</div><!-- columns -->
		
	</div><!-- wrapper -->
	
<?php	
	get_footer();
?>