<?php
    require_once 'includes/header.php';
	
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>


<script type="text/javascript" src="<?=base_url()?>assets/cdn/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/cdn/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/cdn/datatables/dataTables.fixedColumns.min.js"></script>
<link href="<?=base_url()?>assets/cdn/datatables/fixedColumns.dataTables.min.css" rel="stylesheet">
<link href="<?=base_url()?>assets/cdn/datatables/jquery.dataTables.min.css" rel="stylesheet">



<script>
	$(document).ready(function() {
    var table = $('#example').DataTable( {
        scrollY:        "700px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         true,
		
        fixedColumns:   {
            leftColumns: 1,
            rightColumns: 2
        }
		
    } );
} );
</script>
<script type="text/javascript">
	function openReceipt(ele){
		var myWindow = window.open(ele, "", "width=380, height=550");
	}	
</script>
<style>
     th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 1050px;        
        margin: 0 auto;
    }
</style>




<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo $lang_list_service; ?></h1>
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
					
					
					<div class="row" >
						<div class="col-md-6">
							<a href="<?=base_url()?>service_center/add_serviceitem" style="text-decoration: none">
								<button class="btn btn-primary" style="padding: 0px 12px;"><i class="icono-plus"></i>
									<?php echo $lang_add_service_item; ?>
								</button>
							</a>
						</div>
						<div class="col-md-6" style="text-align: right;">
							<a href="<?=base_url()?>service_center/export_listservice" style="text-decoration: none;">
								<button type="button" class="btn btn-success" style="background-color: #5cb85c; border-color: #4cae4c;">
									<?php echo $lang_export; ?>
								</button>
							</a>
						</div>
					</div>
					
					
					<div class="row" style="margin-top: 20px;">
						<div class="col-md-12">
						<div class="table-responsive">
							<table id="example" class="stripe row-border order-column" style="width:100%">
							    <thead>
							    	<tr>
								    	<th><?php echo $lang_service_code; ?></th>
								    	<th><?php echo $lang_name; ?></th>
								    	<th><?php echo $lang_date_of_entry; ?></th>
								    	<th><?php echo $lang_date_of_completion; ?></th>
                                        <th><?php echo $lang_phone; ?></th>
								    	<th><?php echo $lang_technician; ?></th>
                                        <th><?php echo $lang_qty; ?></th>
								    	<th><?php echo $lang_remark; ?></th>									    
                                        <th><?php echo $lang_price; ?></th>
										<th><?php echo $lang_status; ?></th>
										<th><?php echo $lang_action; ?></th>
									</tr>
							    </thead>
								<tbody>
								<?php
                                    
                                        foreach ($results as $data) {
                                            $id_service = $data->id_service;                                            
											$cust_id = $data->id_customer;
											$created = date("$setting_dateformat", strtotime($data->created_datetime)); 
											$updated = $data->updated_datetime;
											IF($updated == '0000-00-00 00:00:00'){
												$date_of_completion = "-";
											}ELSE{
												$date_of_completion = date("$setting_dateformat H:i ", strtotime($data->updated_datetime));      
											}                                         
                                            $technician = $data->technician;
                                            $qty = $data->qty;
                                            $remark = $data->remark;
                                            $status = $data->status;
                                            $price = $data->price;

                                            $customer_name = '-';
                                            $customerData = $this->Constant_model->getDataOneColumn('customers', 'id', $cust_id);
                                            if (count($customerData) > 0) {
												$customer_name = $customerData[0]->fullname;
												$customer_phone = $customerData[0]->mobile;
                                            }
                                            ?>
											<tr>
												<td><?php echo $id_service; ?></td>	
												<td><?php echo $customer_name; ?></td>
                                                <td align="center"><?php echo $created; ?></td>
                                                <td align="center"><?php echo $date_of_completion; ?></td>
                                                <td><?php echo $customer_phone; ?></td>
                                                <td><?php echo $technician; ?></td>
                                                <td><?php echo $qty; ?></td>
                                                <td><?php echo $remark; ?></td>
												<td><?php echo number_format($price); ?></td>
                                                <td>
                                                    <form action="<?=base_url()?>service_center/updateStatusitem" method="post">
                                                    <div class="form-group">
                                                    <?php 
                                                        if ($status == 1 ){ ?>
															<input type="hidden" name="id_service" value="<?php echo $id_service; ?>" />
                                                            <input type="hidden" name="update_status" value="2" />
                                                            <input type="submit" class="btn-xs btn-danger" style="background-color: #d9534f; border-color: #d43f3a;" value="<?php echo $lang_new; ?>" />                                                        
                                                       <?php  } else if ($status == 2 ) {  ?>    
                                                       <!-- <button class="btn btn-warning" style="width: 100%;">&nbsp;&nbsp;<?php //echo $lang_search_product; ?>&nbsp;&nbsp;</button>-->
													   		<input type="hidden" name="id_service" value="<?php echo $id_service; ?>" />
															<input type="hidden" name="update_status" value="3" />
                                                            <input type="submit" class="btn-xs  btn-warning" style=" background-color: #f0ad4e; border-color: #eea236;" value="<?php echo $lang_process; ?>" />  
                                                       <?php } else if ($status == 3 ) {  ?>
                                                            <button class="btn-xs btn-success" style="background-color: #5cb85c; border-color: #4cae4c;" disabled><?php echo $lang_done; ?></button>
                                                       <?php } ?>
                                                    </div>

                                                   
                                                    </form>
                                                </td>        
												<td>
												<a onclick="openReceipt('<?=base_url()?>service_center/view_invoice?id_service=<?php echo $id_service; ?>')" style="text-decoration: none; cursor: pointer;" title="Print Receipt">
													<i class="icono-document" style="color: #005b8a;"></i>
												</a>
													<a href="<?=base_url()?>service_center/edit_serviceitem?id_service=<?php echo $id_service; ?>" style="text-decoration: none;" cursor: pointer;" title="Edit Service Item">
														<i class="icono-rename" style="color: #005b8a;"></i>
													</a>
												
												</td>
											</tr>
								<?php
                                            unset($id_service);
                                            unset($customer_name);
                                            unset($created);
                                            unset($updated);
                                            unset($customer_phone);
                                            unset($technician);
                                            unset($qty);
											unset($remark);
											unset($price);
											unset($status);
                                        }
                                 
                                ?>
								</tbody>
							</table>
						</div>
							
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