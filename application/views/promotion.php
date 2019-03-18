<?php
    require_once 'includes/header.php';
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo $lang_promotion; ?></h1>
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
                        if ($user_role < 3) {
                            ?>
					<div class="row" style="border-bottom: 1px solid #e0dede; padding-bottom: 8px; margin-top: -5px;">
						<div class="col-md-6">
							<a href="<?=base_url()?>promotion/addPromotion" style="text-decoration: none;">
								<button type="button" class="btn btn-primary" style="padding-top: 2px; padding-bottom: 2px; border: 0px;">
									<i class="icono-plus"></i> <?php echo $lang_add_promotion; ?>
								</button>
							</a>
						</div>
						<!--<div class="col-md-6" style="text-align: right;">
							<a href="<? //=base_url()?>customers/exportCustomer" style="text-decoration: none;">
								<button type="button" class="btn btn-success" style="background-color: #5cb85c; border-color: #4cae4c;">
									<?php //echo $lang_export; ?>
								</button>
							</a>
						</div> -->
					</div>
					<?php

                        }
                    ?>
					
				<!--	<form action="<? //=base_url()?>customers/searchcustomer" method="get">
						<div class="row" style="margin-top: 10px;">
							<div class="col-md-4">
								<div class="form-group">
									<label><?php //echo $lang_promotion_name; ?> </label>
									<input type="text" name="promotion_name" class="form-control" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label><?php // echo $lang_discount; ?> </label>
									<input type="text" name="discount" class="form-control" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label><?php // echo $lang_mobile; ?> </label>
									<input type="text" name="mobile" class="form-control" />
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>&nbsp;</label><br />
									<button class="btn btn-primary" style="width: 100%;">&nbsp;&nbsp;<?php // echo $lang_search; ?>&nbsp;&nbsp;</button>
								</div>
							</div>
						</div>
					</form> -->
					
					
					
					<div class="row" style="margin-top: 0px;">
						<div class="col-md-12">
							
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
									    	<th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="26%">
										    	<?php echo $lang_promotion_name; ?>
									    	</th>
									    	<th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="26%">
										    	<?php echo $lang_discount; ?>
									    	</th>
										    <th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="20%">
											    <?php echo $lang_actived_promotion; ?>
										    </th>
                                            <th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="20%">
											    <?php echo $lang_deactived_promotion; ?>
										    </th>
                                            <th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="20%">
											    <?php echo $lang_status; ?>
										    </th>
										    <th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd; border-right: 1px solid #ddd;" width="25%"><?php echo $lang_action; ?></th>
										</tr>
									</thead>
									<tbody>
									<?php
                                        if (count($results) > 0) {
                                            foreach ($results as $data) {
                                                $promo_id = $data->id;
                                                $promo_name = $data->promotion_name;
                                                $promo_disc = $data->discount_percentage;
                                                $promo_ad = $data->actived_datetime;
                                                $promo_dd = $data->deactived_datetime;
                                                $promo_st = $data->status;
                                                
                                                ?>
												<tr>
													<td style="border-bottom: 1px solid #ddd;"><?php echo $promo_name; ?></td>
                                                    <td style="border-bottom: 1px solid #ddd;"><?php echo $promo_disc; ?></td>
                                                    <td style="border-bottom: 1px solid #ddd;"><?php echo date($site_dateformat, strtotime($promo_ad));?></td>
                                                    <td style="border-bottom: 1px solid #ddd;"><?php echo date($site_dateformat, strtotime($promo_dd));?></td>
                                                    <td style="border-bottom: 1px solid #ddd;">
													<?php if ($promo_st == 1){ ?>
														<font color="green"><?php echo $lang_active ; ?> </font>
													<?php }ELSE{ ?>
														<font color="red"><?php echo $lang_inactive;
													}?></font>
														</td>
													
													<td style="border-bottom: 1px solid #ddd;">
													<?php
														IF($promo_id == 1){?>
															
													<?php	}ELSE{ ?>
														<a href="<?=base_url()?>promotion/edit_promotion?promo_id=<?php echo $promo_id; ?>" style="text-decoration: none;">
															<button class="btn btn-primary" style="padding: 4px 12px;">&nbsp;&nbsp;<?php echo $lang_edit; ?>&nbsp;&nbsp;</button>
														</a>
													<?php } ?>	
													</td>
												</tr>
									<?php

                                            }
                                        } else {
                                            ?>
											<tr>
												<td colspan="4"><?php echo $lang_no_match_found; ?></td>
											</tr>
									<?php

                                        }
                                    ?>
									</tbody>
								</table>
							</div>
							
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-6" style="float: left; padding-top: 10px;">
							<?php echo $displayshowingentries; ?>
						</div>
						<div class="col-md-6" style="text-align: right;">
							<?php echo $links; ?>
						</div>
					</div>
					
				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
		</div><!-- Col md 12 // END -->
	</div><!-- Row // END -->
	
	<br /><br /><br />
	
</div><!-- Right Colmn // END -->
	
	
	
<?php
    require_once 'includes/footer.php';
?>