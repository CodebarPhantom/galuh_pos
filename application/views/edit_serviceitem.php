<?php
	require_once 'includes/header.php';
	
	$serviceDtaData = $this->Constant_model->getDataOneColumn('service_center', 'id_service', $id_service);

    if (count($serviceDtaData) == 0) {
        redirect(base_url());
    }

    $id_cust= $serviceDtaData[0]->id_customer;
	$start_date = $serviceDtaData[0]->created_datetime;
	$technician = $serviceDtaData[0]->technician;
	$price= $serviceDtaData[0]->price;
	$qty = $serviceDtaData[0]->qty;
	$remark = $serviceDtaData[0]->remark;
	
?>



<!-- Select2 -->
<link href="<?=base_url()?>assets/css/select2.min.css" rel="stylesheet">
<script src="<?=base_url()?>assets/js/select2.full.min.js"></script>


<script>
	$(document).ready(function(){
		
		$( "#startDate" ).datepicker({
			format: "<?php echo $dateformat; ?>",
			autoclose: true
		});
		
		

		$("#customer").select2({
			minimumInputLength: 3
		});
	} );
</script>
<style type="text/css">
	.typeahead, .tt-query, .tt-hint {
		border: 1px solid #CCCCCC;
		border-radius: 4px;
		font-size: 14px;
		height: 40px;
		line-height: 30px;
		outline: medium none;
		padding: 8px 12px;
		width: 312px;
	}
	.typeahead {
		background-color: #FFFFFF;
	}
	.typeahead:focus {
		border: 2px solid #0097CF;
	}
</style>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo $lang_edit_service_item; ?></h1>
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
							<form action="<?=base_url()?>service_center/deleteserviceitem" method="post" onsubmit="return confirm('Do you want to delete this Service Item?')">
								<input type="hidden" name="id_service" value="<?php echo $id_service; ?>" />
								<input type="hidden" name="remark" value="<?php echo $remark; ?>" />								
								<button type="submit" class="btn btn-primary" style="border: 0px; background-color: #c72a25;">
									<?php  echo $lang_delete_service_item; ?>
								</button>
								
							</form>
						</div>
					</div>
					<br/>
					<?php

                        }
                    ?>
					<form action="<?=base_url()?>service_center/updateserviceitem" method="post">
					<input type="hidden" name="id_service" value="<?php echo $id_service; ?>" />
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label><?php echo $lang_customer_name; ?> <span style="color: #F00">*</span></label>
								<select name="cust_id" id="customer" class="form-control" autofocus required autocomplete="off">
									<option value=""><?php echo $lang_customer_name; ?></option>
								<?php
                                    $custData = $this->Constant_model->getDataAll('customers', 'id', 'DESC');
                                    for ($p = 0; $p < count($custData); ++$p) {
                                        $cust_id = $custData[$p]->id;
										$cust_name = $custData[$p]->fullname;
										$cust_mobile = $custData[$p]->mobile; ?>
										<option  value="<?php echo $cust_id; ?>" <?php if ($id_cust == $cust_id) {
                                            echo 'selected="selected"';
                                        } ?>>
											<?php echo $cust_name.' ['.$cust_mobile.']'; ?>
										</option>
								<?php
                                        unset($cust_id);
										unset($cust_name);
										unset($cust_mobile);
                                    }
                                ?>
								</select>
								
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label><?php echo $lang_date_of_entry; ?></label>
								<input type="text" name="start_date" class="form-control" id="startDate" autocomplete="off" required value="<?php echo date($site_dateformat, strtotime($start_date)); ?>"/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label><?php echo $lang_technician; ?></label>
								<input type="text" name="technician" class="form-control" value="<?php echo $technician; ?>"  required/>
							</div>
						</div>						
					</div>
					<div class="row">						
						
						<div class="col-md-4">
							<div class="form-group">
								<label><?php echo $lang_price; ?></label>
								<input type="number" name="price" class="form-control" autocomplete="off" value="<?php echo $price; ?>" required/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label><?php echo $lang_qty; ?></label>
								<input type="number" name="qty" class="form-control" autocomplete="off" value="<?php echo $qty; ?>" required/>
							</div>
						</div>
					</div>
					<div class="row">						
						<div class="col-md-8">
							<div class="form-group">
								<label><?php echo $lang_remark; ?></label>
								<textarea name="remark" class="form-control" style="height: 70px;"><?php echo $remark;?></textarea>
							</div>
						</div>
						
					</div>

		
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<button class="btn btn-primary">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $lang_update; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
							</div>
						</div>
						<div class="col-md-4"></div>
						<div class="col-md-4"></div>
					</div>
					</form>
					
					
				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
			
			<a href="<?=base_url()?>service_center/list_service" style="text-decoration: none;">
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