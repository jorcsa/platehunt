<?php

	//// TERM ID
	$t_id = $term->term_id;
	
	//// TERM VALUES
	$term_meta = get_option('taxonomy_'.$t_id);

?>

<tr class="form-field">

	<th scope="row" valign="top"><label for="term_meta[header_bg]">Category Header Background</label></th>
	
	<td>
	
		<input type="text" name="term_meta[header_bg]" id="term_meta[header_bg]" value="<?php echo esc_attr( $term_meta['header_bg'] ) ? esc_attr( $term_meta['header_bg'] ) : ''; ?>" />
		<p class="description">Header Background for your category page.</p>
		
	</td>
		
</tr>