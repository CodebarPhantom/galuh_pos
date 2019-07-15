<?php
	/*$user_id = $this->session->userdata('user_id');
	$login_name = '';
    $this->db->where('id', $user_id);
    $query = $this->db->get('users');
    $result = $query->result();

	$login_name = $result[0]->fullname;*/

    $settingResult = $this->db->get_where('site_setting');
    $settingData = $settingResult->row();

    $setting_dateformat = $settingData->datetime_format;
	$setting_site_logo = $settingData->site_logo;
	$setting_site_name = $settingData->site_name;

    
	$serviceData = $this->Servicecenter_model->invoice_print($id_service);
    if (count($serviceData) == 0) {
        $this->session->set_flashdata('alert_msg', array('success', 'Error', 'Something Wrong!'));
        redirect(base_url().'service_center');

        die();
    }

   
    $id_service= $serviceData[0]->id_service;
    $name= $serviceData[0]->fullname;
    $created_datetime = date("$setting_dateformat ", strtotime($serviceData[0]->created_datetime));
	$updated_datetime = $serviceData[0]->updated_datetime;
	IF($updated_datetime == '0000-00-00 00:00:00'){
		$date_of_completion = "-";
	}ELSE{
		$date_of_completion =  date("$setting_dateformat H:i ", strtotime($serviceData[0]->updated_datetime)); 
	}
	$phone = $serviceData[0]->mobile;
	$technician = $serviceData[0]->technician;
	$qty = $serviceData[0]->qty;
	$remark= $serviceData[0]->remark;
	$price= $serviceData[0]->price;
	$status= $serviceData[0]->status;
            IF($status==1){ 
                $info = $lang_new;
            }ELSE IF ($status==2){
                $info = $lang_process;
            }ELSE IF ($status==3){
                $info = $lang_done;
            }
  
	

?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Service No : <?php echo $id_service; ?></title>
		<script src="<?=base_url()?>assets/js/jquery-1.7.2.min.js"></script>
		
<style type="text/css" media="all">
	body { 
		max-width: 300px; 
		margin:0 auto; 
		text-align:center; 
		color:#000; 
		font-family: Arial, Helvetica, sans-serif; 
		font-size:12px; 
	}
	#wrapper { 
		min-width: 250px; 
		margin: 0px auto; 
	}
	#wrapper img { 
		max-width: 150px; 
		width: auto; 
	}

	h2, h3, p { 
		margin: 5px 0;
	}
	.left { 
		width:100%; 
		float:right; 
		text-align:right; 
		margin-bottom: 3px;
		margin-top: 3px;
	}
	.right { 
		width:40%; 
		float:right; 
		text-align:right; 
		margin-bottom: 3px; 
	}
	.table, .totals { 
		width: 100%; 
		margin:10px 0; 
	}
	.table th { 
		border-top: 1px solid #000; 
		border-bottom: 1px solid #000; 
		padding-top: 4px;
		padding-bottom: 4px;
	}
	.table td { 
		padding:0; 
	}
	.totals td { 
		width: 24%; 
		padding:0; 
	}
	.table td:nth-child(2) { 
		overflow:hidden; 
	}

	@media print {
		body { text-transform: uppercase; }
		#buttons { display: none; }
		#wrapper { width: 95%; font-size:12px; }
		#wrapper img { max-width:300px; width: 80%; }
		#bkpos_wrp{
			display: none;
		}
	}
</style>
</head>

<body>
<div id="wrapper">
	<table border="0" style="border-collapse: collapse; width: 100%; height: auto;">
	    <tr>
		    <td width="100%" align="center">
			    <center>
			    	<img src="<?=base_url()?>assets/img/logo/<?php echo $setting_site_logo; ?>" style="width: 100px;" />
			    </center>
		    </td>
	    </tr>
	    <tr>
		    <td width="100%" align="center">
			    <h2 style="padding-top: 0px; font-size: 20px;"><strong><?php echo $setting_site_name; ?></strong></h2>
		    </td>
	    </tr>
		<tr>
			<td width="100%">
							
				<span class="left" style="text-align: left;"><?php echo $lang_service_code; ?> : <?php echo $id_service; ?></span>
				<span class="left" style="text-align: left;"><?php echo $lang_date_of_entry; ?> : <?php echo $created_datetime; ?></span>
				<span class="left" style="text-align: left;"><?php echo $lang_technician; ?> : <?php echo $technician; ?></span>
				
			</td>
		</tr>   
    </table>
    
	
	    
	<div style="clear:both;"></div>
    
	<table class="table" cellspacing="0"  border="0"> 
		<thead> 
			<tr> 				
				<th width="35%" align="left"><?php echo $lang_service_item; ?></th>
				<th width="10%"><?php echo $lang_qty; ?></th>				
				<th width="15%"><?php echo $lang_status; ?></th>		
				<th width="20%" align="right"><?php echo $lang_total; ?></th> 
			</tr> 
		</thead> 
		<tbody> 
		
				<tr>	            	
	                <td style="text-align:left; width:130px; padding-bottom: 10px" valign="top"><?php echo $remark; ?></td>
	                <td style="text-align:center; width:50px;" valign="top"><?php echo $qty; ?></td>
					<td style="text-align:center; width:50px;" valign="top"><?php echo $info; ?></td>
	                <td style="text-align:right; width:50px;" valign="top"><?php echo number_format($price); ?></td>
				</tr>	
		<?php
               

               
           
        ?>
			 
    	</tbody> 
	</table> 
	
    
    <table class="totals" cellspacing="0" border="0" style="margin-bottom:5px; border-top: 1px solid #000; border-collapse: collapse;">
    	<tbody>
			
			<tr>
				<td colspan="2" style="text-align:left; font-weight:bold; border-top:1px solid #000; padding-top:5px;"><?php echo $lang_grand_total; ?></td>
				<td colspan="2" style="border-top:1px solid #000; padding-top:5px; text-align:right; font-weight:bold;"><?php echo number_format($price); ?></td>
    		</tr>
			<tr>
				<td colspan="2" style="text-align:left; font-weight:bold; border-top:1px solid #000; padding-top:5px;"><?php echo $lang_date_of_completion; ?></td>
				<td colspan="2" style="border-top:1px solid #000; padding-top:5px; text-align:right; font-weight:bold;"><?php echo $date_of_completion; ?></td>
    		</tr>
    		
			 <?php 
				unset($remark);
            	unset($qty);
				unset($price); 
				unset($info)
				?>
    		
            
	    	
    </tbody>
    </table>
    
    <div style="border-top:1px solid #000; padding-top:10px;">
    	<?php
            echo "Thank You";
        ?>    
    </div>
<!--
        <div id="buttons" style="padding-top:10px; text-transform:uppercase;">
    <span class="left"><a href="#" style="width:90%; display:block; font-size:12px; text-decoration: none; text-align:center; color:#000; background-color:#4FA950; border:2px solid #4FA950; padding: 10px 1px; font-weight:bold;" id="email">Email</a></span>
    <span class="right"><button type="button" onClick="window.print();return false;" style="width:100%; cursor:pointer; font-size:12px; background-color:#FFA93C; color:#000; text-align: center; border:1px solid #FFA93C; padding: 10px 1px; font-weight:bold;">Print</button></span>
    <div style="clear:both;"></div>
-->
   
    
    
	
    <div id="bkpos_wrp">
    	<button type="button" onClick="window.print();return false;" style="width:101%; cursor:pointer; font-size:12px; background-color:#FFA93C; color:#000; text-align: center; border:1px solid #FFA93C; padding: 10px 0px; font-weight:bold;"><?php echo $lang_print_small_receipt; ?></button>
    </div>
    
	<!-- <div id="bkpos_wrp" style="margin-top: 8px;">
    	<span class="left"><a href="#" style="width:100%; display:block; font-size:12px; text-decoration: none; text-align:center; color:#000; background-color:#4FA950; border:2px solid #4FA950; padding: 10px 0px; font-weight:bold;" id="email"><?php // echo $lang_email; ?></a></span>
    </div> 
    
    <div id="bkpos_wrp">
    	<span class="left">
    		<a href="<? // =base_url()?>pos/view_invoice_a4?id=<?php //echo $order_id; ?>" style="width:100%; display:block; font-size:12px; text-decoration: none; text-align:center; color:#000; background-color:#4FA950; border:2px solid #4FA950; padding: 10px 0px; font-weight:bold; margin-top: 6px;">
	    		<?php //echo $lang_print_a4; ?>
	    	</a>
	    </span>
    </div> -->
    
    <input type="hidden" id="id_service" value="<?php echo $id_service; ?>" />
    
</div>


<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script type="text/javascript">
	
	$(window).load(function() { window.print(); });
</script>



</body>
</html>
