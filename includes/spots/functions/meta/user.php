<h3>Other Info</h3>
		
		<table class="form-table">
			<tr>
				<th>
					<label for="phone"><?php _e('Telephone Number', 'btoa'); ?>
				</label></th>
				<td>
					<input type="text" name="phone" id="phone" value="<?php echo esc_attr( get_the_author_meta( 'phone', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"><?php _e('Please enter your contact number.', 'btoa'); ?></span>
				</td>
			</tr>
			<tr>
				<th>
					<label for="position"><?php _e('Position or Company Name', 'btoa'); ?>
				</label></th>
				<td>
					<input type="text" name="position" id="position" value="<?php echo esc_attr( get_the_author_meta( 'position', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"><?php _e('Please enter your staff position or company name (ie Property Manager).', 'btoa'); ?></span>
				</td>
			</tr>
		</table>
		
		<table class="form-table">
			<tr>
				<th>
					<label for="profile_pic"><?php _e('Profile Picture - Attachment ID', 'btoa'); ?>
				</label></th>
				<td>
					<input type="text" name="profile_pic" id="profile_pic" value="<?php echo esc_attr( get_the_author_meta( 'profile_pic', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description"><?php _e('Profile Picture - Attachment ID', 'btoa'); ?></span>
				</td>
			</tr>
		</table>
		
		<table class="form-table">
			<tr>
				<th>
					<label for="public_profile"><?php _e('Public Profile', 'btoa'); ?>
				</label></th>
				<td>
					<input type="checkbox" name="public_profile" id="public_profile" <?php if(get_the_author_meta( 'public_profile', $user->ID ) == 'on') { echo 'checked="checked"'; } ?> /><br />
					<span class="description"><?php _e('Whether the user has chosen to make his profile public', 'btoa'); ?></span>
				</td>
			</tr>
		</table>