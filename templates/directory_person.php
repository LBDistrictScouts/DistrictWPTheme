<?php 
// Template name: District Directory (Person)
	if(!is_user_logged_in()){
		header('Location: ' . get_bloginfo('url') . '/district-directory');
	}

	if( !isset($_GET['action'])) {
		$_GET['action'] = null;
	}
	
	if($_GET['action'] == 'new' && !canEdit()){
		header('Location: ' . get_bloginfo('url') . '/district-directory');
	}
	
	
	get_header();
	$id = 'user_'.$_GET['sid'];
	
	$editGlobal = false;
	if(get_current_user_id() == $_GET['sid']){
		$editGlobal = true;
	}
	
	if($_GET['action'] == 'delete' && $_GET['rid']){
		if(canEdit()){
			kolodoDeletePlacement($_GET['rid']);
		}
	} else if($_GET['action'] == 'delete' && $_GET['cid']){
		if(canEdit()){
			kolodoDeleteContact($_GET['cid']);
		}
	}
	
	function canEdit(){
		if(get_current_user_id() == $_GET['sid'] || current_user_can('edit_users')){
			return true;
		} else if(in_array(get_field('group_id', 'user_'.get_current_user_id()), kolodoGetAssociatedGroups($_GET['sid']))){
			return true;
		} else {
			return false;
		}
	}
	
	function canAddPlacement(){
		$ret = false;
		if(current_user_can('edit_users') === true){
			$grID = get_field('group_id', 'user_'.get_current_user_id());
			if($grID){
				$ret = $grId;
			} else {
				$ret = false;
			}
			if(get_current_user_id() == $_GET['sid'] || current_user_can('administrator')){
				$ret = true;
			}
		} else if(get_current_user_id() == $_GET['sid']) {
			$ret = true;	
		} else {
			$ret = false;
		}
		return $ret;
	}
?>

	<div class="wrapper">
		
		<div class="columns cf no_hero">
			
			<div class="col dd_person col_2 cf">

				<div class="container standard_form directory_person">
					<div class="row">
						<div class="col-md">
							<h1><?php the_field('first_name', $id); ?> <?php the_field('last_name', $id); ?></h1>
						</div>
					</div>
					<div class="row">
						<div class="col-md">
							<div class="card" style="padding: 10px">
								<div class="card-title">
									<h4 class="field_label">Email</h4>
								</div>
								<div class="card-text">
									<a href="mailto:<?php the_field('email', $id); ?>" class="card-link btn green wide"><?php the_field('email', $id); ?></a>
								</div>
							</div>
							<br/>
							<div class="card" style="padding: 10px">
								<div class="card-title">
									<h4>Membership number</h4>
								</div>
								<div class="card-text">
									<p class="field_value"><?php the_field('membership_number', $id); ?></p>
								</div>
							</div>
							<br/>
						</div>
						<div class="col-md">
							<div class="card" style="padding: 10px">
								<div class="card-title">
									<h4>Address</h4>
								</div>
								<div class="card-text">
									<span class="address_line"><?php the_field('address_1', $id); ?></span><br/>
									<?php if (!empty(the_field('address_2', $id)) && !is_null(the_field('address_2', $id))) : ?>
										<span class="address_line"><?php the_field('address_2', $id); ?></span><br/>
									<?php endif; ?>
									<span class="address_line"><?php the_field('city', $id); ?></span><br/>
									<span class="address_line"><?php the_field('county', $id); ?></span><br/>
									<span class="postcode_line" style="font-weight: bold;"><?php the_field('postcode', $id); ?></span>
								</div>								
							</div>
							<br/>
						</div>
					</div>
					<div class="row">
						<div class="col-sm">
							<?php 
								$numbers = kolodoGetNumbers($_GET['sid'] ?: -1); 
								foreach($numbers as $idx => $n): 
							?>
								<div class="card" style="padding: 10px">
									<div class="row card-text">
										<div class="col-md">
											<h4 class="field_label">Phone Number #<?php echo $idx + 1; ?></h4>
										</div>
										<div class="col-md">
											<p class="field_value"><?php echo $n->phone_number; ?></p>
										</div>
									</div>
								</div>
								<br/>
							<?php endforeach; ?>
						</div>
					</div>

				</div>

				<?php if(isset($id)){ 
					if($_GET['action'] == 'new'){
						$ajax_url = get_bloginfo('template_url')."/district-directory/addToDirectory.php";
						$post_submit = "redirect";
					} else {
						$ajax_url = get_bloginfo('template_url')."/district-directory/updateDirectory.php";
						$post_submit = "reload";
					}
				?>
				<div class="standard_form directory_person">
				<!-- <form action="<?php //echo $ajax_url; ?>" data-post_submit="<?php //echo $post_submit; ?>" class="standard_form directory_person">
					<div class="fields cf"> -->
						<!--  <div class="field">
							<label>First name</label>
							<input type="text" class="text" id="first_name" value="<?php //the_field('first_name', $id); ?>" <?php //if(canEdit() === false) { echo 'disabled'; } ?>>
						</div>
						<div class="field">	
							<label>Last name</label>
							<input type="text" class="text" id="last_name" value="<?php //the_field('last_name', $id); ?>" <?php //if(!canEdit()) { echo 'disabled'; } ?>>
						</div>  
						<div class="field">
							<label>Email</label>
							<input type="text" class="text" id="email" value="<?php //the_field('email', $id); ?>" <?php //if(!canEdit()) { echo 'disabled'; } ?> required>
						</div>
						<div class="field">
							<label>Address 1</label>
							<input type="text" class="text" id="address_1" value="<?php //the_field('address_1', $id); ?>" <?php //if(!canEdit()) { echo 'disabled'; } ?>>
						</div>
						<div class="field">
							<label>Address 2</label>
							<input type="text" class="text" id="address_2" value="<?php //the_field('address_2', $id); ?>" <?php //if(!canEdit()) { echo 'disabled'; } ?>>
						</div>
						<div class="field">
							<label>City</label>
							<input type="text" class="text" id="city" value="<?php // the_field('city', $id); ?>" <?php //if(!canEdit()) { echo 'disabled'; } ?>>
						</div>
						<div class="field">
							<label>Country</label>
							<input type="text" class="text" id="county" value="<?php //the_field('county', $id); ?>" <?php //if(!canEdit()) { echo 'disabled'; } ?>>
						</div>
						<div class="field">
							<label>Postcode</label>
							<input type="text" class="text" id="postcode" value="<?php //the_field('postcode', $id); ?>" <?php //if(!canEdit()) { echo 'disabled'; } ?>>
						</div>
						<div class="field">
							<label>Membership number</label>
							<input type="text" class="text" id="membership_number" value="<?php //the_field('membership_number', $id); ?>" <?php // if(!canEdit()) { echo 'disabled'; } ?>>
						</div>
						<?php 
							//if($_GET['action'] === 'new'){
								//if(current_user_can('administrator')){
						?>
								<div class="field">
									<label>Administrator for group: </label>
									<select id="admin_group">
										<option value="-1">None</option>
									<?php // $groups = kolodoGetGroups(); foreach($groups as $g) { ?>
										<option value="<?php //echo $g['id']; ?>"><?php //echo $g['name']; ?></option>
									<?php //} ?>
									</select>
								</div>
								<div class="field full">
									<input type="checkbox" id="show_in_dd" checked> Show in Directory
								</div>
						<?php
								//}
							//}
						?>
					</div>
					<div class="fields cf">
						<h3 class="center top_spacing">Contact numbers</h3>
						<?php 
							//$numbers = kolodoGetNumbers($_GET['sid'] ?: -1); 
							//foreach($numbers as $n) { 
						?>
							<div class="field row contact cf">
								<input type="hidden" class="contact_id" value="<?php //echo $n->id; ?>" />
								<input type="text" class="text phone_number" value="<?php //echo $n->phone_number; ?>" <?php //if(!canEdit()) { echo 'disabled'; } ?>>
								<?php //if(canAddPlacement()){ ?>
									<a href="?sid=<?php //echo $_GET['sid']; ?>&action=delete&cid=<?php //echo $n->id; ?>" class="btn red wide">delete</a>
								<?php // } ?>
							</div>
						<?php // } ?>
					</div>-->
					<?php 
						$editableGroup = canAddPlacement();
						if($editableGroup !== false || canEdit()) {
					?>
						<div class="fields cf">
							<h3 class="center top_spacing">Add additional contact number</h3>
							<div class="field row contact cf">
								<input type="hidden" class="contact_id" value="-1" />
								<input type="text" class="text phone_number" placeholder="Contact number" <?php if(!canEdit()) { echo 'disabled'; } ?>>
							</div>
							<div class="field full">
								<a id="addContactButton" href="#!" class="btn purple wide">add contact number</a>
							</div><!-- field -->
						</div><!-- fields -->
					<?php } ?>

					<div class="fields cf">
						<h3 class="centre top_spacing">Roles</h3>
						<?php $placements = kolodoGetPlacements($_GET['sid'] ?: -1); foreach($placements as $p) { ?>
						<?php $edit = ''; $user_group = get_field('group_id', 'user_'.get_current_user_id()); if($user_group != $p->group && !canAddPlacement()) { $edit = 'disabled'; } ?>
							<div class="field row placement cf">
								<input type="hidden" class="placement_id" value="<?php echo $p->id; ?>" <?php echo $edit; ?> />
								<select class="placement_role" <?php echo $edit; ?>>
								<?php $roles = kolodoGetRoles(); foreach($roles as $r) { ?>
									<option value="<?php echo $r['id']; ?>" <?php if($p->role == $r['id']) { echo 'selected'; } ?>><?php echo $r['title']; ?></option>
								<?php } ?>
								</select>
								<select class="placement_section" <?php echo $edit; ?>>
								<?php $sections = kolodoGetSections(); foreach($sections as $s) { ?>
									<option value="<?php echo $s['id']; ?>" <?php if($p->section == $s['id']) { echo 'selected'; } ?>><?php echo $s['name']; ?></option>
								<?php } ?>
								</select>
								<select class="placement_group" <?php echo $edit; ?>>
								<?php $groups = kolodoGetGroups(); foreach($groups as $g) { ?>
									<option value="<?php echo $g['id']; ?>" <?php if($p->group == $g['id']) { echo 'selected'; } ?>><?php echo $g['name']; ?></option>
								<?php } ?>
								</select>
								<?php if($edit !== 'disabled'){ ?>
									<a href="?sid=<?php echo $_GET['sid']; ?>&action=delete&rid=<?php echo $p->id; ?>" class="btn red wide">delete</a>
								<?php } ?>
							</div>
						<?php } ?>
					</div><!-- fields -->
					
					<?php 
					$editableGroup = canAddPlacement();
					if($editableGroup !== false || canEdit()) { ?>
						<div class="fields cf">
							<h3 class="center top_spacing">Add additional role</h3>
							<div class="field row placement cf">
								<input type="hidden" class="placement_id" value="-1" />
								<select class="placement_role">
									<option value="-1">Please select</option>
								<?php $roles = kolodoGetRoles(); foreach($roles as $r) { ?>
									<option value="<?php echo $r['id']; ?>"><?php echo $r['title']; ?></option>
								<?php } ?>
								</select>
								<select class="placement_section">
									<option value="-1">Please select</option>
									<?php $sections = kolodoGetSections(); foreach($sections as $s) { ?>
										<option value="<?php echo $s->id; ?>"><?php echo $s->name; ?></option>
									<?php } ?>
								</select>
								<select class="placement_group" <?php if($editableGroup !== true) { echo 'disabled'; } ?>>
									<option value="-1">Please select</option>
									<?php $groups = kolodoGetGroups(); foreach($groups as $g) { ?>
										<option data-d="<?php echo $editableGroup; ?>" value="<?php echo $g['id']; ?>" <?php if($editableGroup === true) { echo ''; } else if($editableGroup === $g['id'] || get_field('group_id', 'user_'.get_current_user_id()) == $g['id']) { echo 'selected'; } else { echo 'disabled'; } ?>><?php echo $g['name']; ?></option>
									<?php } ?>
								</select>
							</div>
							<small class="error" id="error_message"></small>
							<div class="field">
								<a id="addPlacementButton" href="#!" class="btn purple wide">new role</a>
							</div><!-- field -->
							<div class="field">
								<button class="btn green wide">save</button>
							</div><!-- field -->
						</div><!-- fields -->
					<?php } ?>
				</div>
	
				</form>
				<?php } else { ?>
					<p>Person does not exist or you do not have permission to view this page</p>
				<?php } ?>
			</div><!-- col_2 -->
			
			<div class="col col_1 cf">
				<?php get_sidebar(); ?>
			</div><!-- col_1 -->
			
		</div><!-- columns -->
		
	</div><!-- wrapper -->
	
	<script>
		$(function(){
			$('#addPlacementButton').click(function(e){
				e.preventDefault();
				$('.row.placement:last').clone().insertBefore('.row.placement:last');
			})
			
			$('#addContactButton').click(function(e){
				e.preventDefault();
				$('.row.contact:last').clone().insertBefore('.row.contact:last');
			})
			
			$('form.directory_person').submit(function(e){
				e.preventDefault();
				
				var placements = [];
				$('.row.placement').each(function(){
					if($(this).children('.placement_section').val() != -1 && $(this).children('.placement_group').val() != -1 && $(this).children('.placement_role').val() != -1){
						placements.push({
							placement_id: $(this).children('.placement_id').val(),
							role: $(this).children('.placement_role').val(),
							section: $(this).children('.placement_section').val(),
							group: $(this).children('.placement_group').val()
						});
					}
				})
				
				var contacts = [];
				$('.row.contact').each(function(){
					if($(this).children('.phone_number').val().length > 1){
						contacts.push({
							contact_id: $(this).children('.contact_id').val(),
							phone_number: $(this).children('.phone_number').val()
						});
					}
				})
				
				var data = {
					first_name: $('#first_name').val(),
					last_name: $('#last_name').val(),
					email: $('#email').val(),
					address_1: $('#address_1').val(),
					address_2: $('#address_2').val(),
					city: $('#city').val(),
					county: $('#county').val(),
					postcode: $('#postcode').val(),
					membership_number: $('#membership_number').val(),
					admin_group: $('#admin_group').val() == '-1' ? null : $('#admin_group').val(),
					show_in_dd: $('#show_in_dd').val() == 'on' ? 1 : 0,
					sid: <?php echo $_GET['sid'] ?: -1; ?>,
					placements: JSON.stringify(placements),
					contact_numbers: JSON.stringify(contacts)
				};

				$.ajax({
					url: $(this).attr('action'),
					type: 'POST',
					data: data,
					success: function(msg){
						console.log(msg)
						if($(this).data('post_submit') === 'reload'){
							window.location.reload();
						} else {
							window.location.replace(msg);
						}

					},
					error: function(xhr, status, error) {
						$('#error_message').html(xhr.responseText);
					}
				})

			})
		})
		
	</script>
<?php	
	get_footer();
?>