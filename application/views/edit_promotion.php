<?php
	require_once 'includes/header.php';	

    $promoDtaData = $this->Constant_model->getDataOneColumn('promotion', 'id', $promo_id);

    if (count($promoDtaData) == 0) {
        redirect(base_url());
    }

    $promotion_name = $promoDtaData[0]->promotion_name;
	$discount = $promoDtaData[0]->discount_percentage;
	$start_date = $promoDtaData[0]->actived_datetime;
	$end_date = $promoDtaData[0]->deactived_datetime;
	$status = $promoDtaData[0]->status;
    
?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script>
	$( function() {
		$( "#startDate" ).datepicker({
			format: "<?php echo $dateformat; ?>",
			autoclose: true
		});
		
		$("#endDate").datepicker({
			format: "<?php echo $dateformat; ?>",
			autoclose: true
		});
	} );
</script>


<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo $lang_edit_promotion; ?> : <?php echo $promotion_name; ?></h1>
		</div>
	</div><!--/.row-->
	
	
	<div class="row">
		<div class="col-md-12">
			
			<div class="panel panel-default">
				<div class="panel-body">
					
					<?php
                        if (!empty($alert_msg)) {
                            $flash_status = $alert_msg[0];
                            $flash_header = $alert_msg[1];
                            $flash_desc = $alert_msg[2];

                            if ($flash_status == 'failure') {
                                ?>
							<div class="row" id="notificationWrp">
								<div class="col-md-12">
									<div class="alert bg-warning" role="alert">
										<i class="icono-exclamationCircle" style="color: #FFF;"></i> 
										<?php echo $flash_desc; ?> <i class="icono-cross" id="closeAlert" style="cursor: pointer; color: #FFF; float: right;"></i>
									</div>
								</div>
							</div>
					<?php	
                            }
                            if ($flash_status == 'success') {
                                ?>
							<div class="row" id="notificationWrp">
								<div class="col-md-12">
									<div class="alert bg-success" role="alert">
										<i class="icono-check" style="color: #FFF;"></i> 
										<?php echo $flash_desc; ?> <i class="icono-cross" id="closeAlert" style="cursor: pointer; color: #FFF; float: right;"></i>
									</div>
								</div>
							</div>
					<?php

                            }
                        }
                    ?>
					
					<?php
                        if ($user_role == 1) {
                            ?>
					<div class="row">
						<div class="col-md-12" style="text-align: right;">
							<form action="<?=base_url()?>promotion/deletePromotion" method="post" onsubmit="return confirm('Do you want to delete this Promotion?')">
								<input type="hidden" name="promo_id" value="<?php echo $promo_id; ?>" />
								<input type="hidden" name="promotion_name" value="<?php echo $promotion_name; ?>" />
								<?php
									//IF($promo_id == 1){?>
										
								<?php	//}ELSE{ ?>
								
								<!--<button type="submit" class="btn btn-primary" style="border: 0px; background-color: #c72a25;">
									<?php // echo $lang_delete_promotion; ?>
								</button>-->
								<?php // } ?>
							</form>
						</div>
					</div>
					<br/>
					<?php

                        }
                    ?>
					
					<form action="<?=base_url()?>promotion/updatePromotion" method="post">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label><?php echo $lang_promotion_name; ?> <span style="color: #F00">*</span></label>
								<input type="text" name="promotion_name" class="form-control"  maxlength="499" required autocomplete="off" value="<?php echo $promotion_name; ?>" />
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label><?php echo $lang_discount; ?> </label>
								<input type="text" name="discount" class="form-control" maxlength="254" autocomplete="off" required value="<?php echo $discount; ?>"/>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label><?php echo $lang_actived_promotion; ?></label>
								<input type="text" name="start_date" class="form-control" id="startDate" autocomplete="off" required value="<?php echo date($site_dateformat, strtotime($start_date)); ?>""/>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label><?php echo $lang_deactived_promotion; ?></label>
								<input type="text" name="end_date" class="form-control" id="endDate" autocomplete="off" required value="<?php echo date($site_dateformat, strtotime($end_date)); ?>""/>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Status <span style="color: #F00">*</span></label>
								<select name="status" class="form-control">
									<option value="1" <?php if ($status == '1') {
                                    echo 'selected="selected"';
                                } ?>><?php echo $lang_active; ?></option>
									<option value="0" <?php if ($status == '0') {
                                    echo 'selected="selected"';
                                } ?>><?php echo $lang_inactive; ?></option>
								</select>
							</div>
						</div>
						<div class="col-md-4"></div>
						<div class="col-md-4"></div>
					</div>
										
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<input type="hidden" name="promo_id" value="<?php echo $promo_id; ?>" />
								<button class="btn btn-primary">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $lang_update; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
							</div>
						</div>
						<div class="col-md-4"></div>
						<div class="col-md-4"></div>
					</div>
					</form>
					
					
				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
			
			
			
			<a href="<?=base_url()?>promotion/view" style="text-decoration: none;">
				<div class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;"> 
					<i class="icono-caretLeft" style="color: #FFF;"></i><?php echo $lang_back; ?>
				</div>
			</a>
			
		</div><!-- Col md 12 // END -->
	</div><!-- Row // END -->
	
	
	<br /><br /><br /><br /><br />
	
</div><!-- Right Colmn // END -->
	
	
	
<?php
    require_once 'includes/footer.php';
?>