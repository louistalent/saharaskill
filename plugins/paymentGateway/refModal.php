<?php
	if(!function_exists("escape")){
		function escape($value){
		  return htmlentities($value,ENT_QUOTES,'UTF-8');
		}
	}
?>
<div id="ref-<?php echo escape($id); ?>" class="modal fade"><!-- mtcn modal fade Starts -->
	<div class="modal-dialog"><!-- modal-dialog Starts -->
		<div class="modal-content"><!-- modal-content Starts -->
			<div class="modal-header"><!-- modal-header Starts -->
				<h5 class="modal-title"> Ref Number </h5>
				<button class="close" data-dismiss="modal"> <span> &times; </span> </button>
			</div><!-- modal-header Ends -->
			<div class="modal-body text-center"><!-- modal-body Starts -->
				<p>Ref Number : <b><?= escape($row->ref_no); ?></b></p>
				<?php if(!empty($row->receipt_image)){ ?>
				<p>Receipt Image : <b><a href="plugins/paymentGateway/receipt_images/<?= escape($row->receipt_image); ?>" class="text-primary" download><i class="fa fa-download"></i> <?= escape($row->receipt_image); ?></a></b></p>
				<?php } ?>
			</div><!-- modal-body Ends -->
		</div><!-- modal-content Ends -->
	</div><!-- modal-dialog Ends -->
</div><!-- mtc-modal fade Ends -->