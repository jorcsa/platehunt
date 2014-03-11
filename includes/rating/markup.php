<?php

	//////////////////////
	//// RATINGS
	//////////////////////
	
	////////////////////// IF USER HAS CHOSEN TO DISPLAY IT
	
	if(ddp('rating_frontend') == 'on') { get_template_part('includes/rating/markup', 'list'); }

?>


<?php

	///////////////////////
	//// REVIEW FORM
	///////////////////////
	
	get_template_part('includes/rating/markup', 'form');
	
?>