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
	$hari_ini = date('Y-m-d');

	//Eryan Fauzan
    /*$orderData = $this->Constant_model->getDataOneColumn('orders', 'id', $order_id);*/
	/*$orderData = $this->Pos_model->invoice_print($order_id);
    if (count($orderData) == 0) {
        $this->session->set_flashdata('alert_msg', array('success', 'Error', 'Something Wrong!'));
        redirect(base_url().'pos');

        die();
    }

    $ordered_dtm = date("$setting_dateformat H:i A", strtotime($orderData[0]->ordered_datetime));
    $cust_fullname = $orderData[0]->customer_name;
    $cust_mobile = $orderData[0]->customer_mobile;
    $outlet_id = $orderData[0]->outlet_id;
    $subTotal = $orderData[0]->subtotal;
    $dis_amt = $orderData[0]->discount_total;
    $tax_amt = $orderData[0]->tax;
    $grandTotal = $orderData[0]->grandtotal;
	//$us_id = $orderData[0]->created_user_id;
	$cashier = $orderData[0]->cashier;
    $pay_method_id = $orderData[0]->payment_method;
    $pay_method_name = $orderData[0]->payment_method_name;
    $paid_amt = $orderData[0]->paid_amt;
    $return_change = $orderData[0]->return_change;
    $cheque_numb = $orderData[0]->cheque_number;
    $dis_percentage = $orderData[0]->discount_percentage;

    $outlet_name = $orderData[0]->outlet_name;
    $outlet_address = $orderData[0]->outlet_address;
    $outlet_contact = $orderData[0]->outlet_contact;
    $card_numb = $orderData[0]->gift_card;

    $addi_card_numb = $orderData[0]->card_number;

    $receipt_header = '';
    $receipt_footer = $orderData[0]->outlet_receipt_footer;

    $unpaid_amt = 0;
    //if ( ($pay_method_id == '6') || ($pay_method_id == '7') ) {
    if (($pay_method_id == '6')) {
        $unpaid_amt = $paid_amt - $grandTotal;
	}/*
/*
    $staff_name = '';
    $staffData = $this->Constant_model->getDataOneColumn('users', 'id', $us_id);

    $staff_name = $staffData[0]->fullname;

    $outlet_name = '';
    $outlet_address = '';
    $outlet_contact = '';

    $receipt_header = '';
    $receipt_footer = '';

    $outletNameData = $this->Constant_model->getDataOneColumn('outlets', 'id', $outlet_id);
    if (count($outletNameData) == 1) {
        $outlet_name = $outletNameData[0]->name;
        $outlet_address = $outletNameData[0]->address;
        $outlet_contact = $outletNameData[0]->contact_number;

        $receipt_header = $outletNameData[0]->receipt_header;
        $receipt_footer = $outletNameData[0]->receipt_footer;
    }
*/

?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Daily Closing</title>
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
		max-width: 300px; 
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
		#wrapper { width: 100%; font-size:12px; }
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
			    	<img src="<?=base_url()?>assets/img/logo/<?php echo $setting_site_logo; ?>" style="width: 160px;" />
			    </center>
		    </td>
	    </tr>
	    <!--<tr>
		    <td width="100%" align="center">
			    <h2 style="padding-top: 0px; font-size: 20px;"><strong><?php //echo $outlet_name; ?></strong></h2>
		    </td>
	    </tr>
		<tr>
			<td width="100%">
				<span class="left" style="text-align: left;"><?php //echo $lang_address; ?> : <?php // echo $outlet_address; ?></span>	
				
				<span class="left" style="text-align: left;"><?php //echo $lang_sale_id; ?> : <?php // echo $order_id; ?></span>
				<span class="left" style="text-align: left;"><?php //echo $lang_date; ?> : <?php //echo $ordered_dtm; ?></span>
				<span class="left" style="text-align: left;"><?php //echo "Cashier Name"; ?> : <?php //echo $cashier; ?></span>
				
			</td>
		</tr> -->  
    </table>
    
	
	    
	<div style="clear:both;"></div>
    
	<table class="table" cellspacing="0"  border="0"> 
			<tr>
				<th width="100%" colspan="5"> Orders </th>
			</tr>
			<tr>					
				<th width="10%"><em>#</em></th> 
				<th width="35%" align="left"><?php echo $lang_products; ?></th>
				<th width="10%"><?php echo $lang_qty; ?></th>
				<th width="25%"><?php echo $lang_per_item; ?></th>
				<th width="20%" align="right"><?php echo $lang_total; ?></th> 
			</tr> 
		
		<tbody> 
		
		<?php
		//report return belum masuk diskon juga
            $o_total_item_amt = 0;
            $o_total_item_qty = 0;
			
            $orderItemResult = $this->db->query("SELECT oi.id, oi.product_code, oi.product_name, oi.price, sum(oi.qty) as qty, o.discount_percentage
			FROM order_items as oi inner join orders as o on oi.order_id = o.id
			where o.created_datetime >= '$hari_ini 00:00:00' AND o.created_datetime <= '$hari_ini 23:59:59'
			GROUP by oi.product_code  
			ORDER BY oi.product_name ASC ");
            $orderItemData = $orderItemResult->result();
            for ($i = 0; $i < count($orderItemData); ++$i) {
                $pcode = $orderItemData[$i]->product_code;
                $name = $orderItemData[$i]->product_name;
                $qty = $orderItemData[$i]->qty;
				$price = $orderItemData[$i]->price;
				$discount = $orderItemData[$i]->discount_percentage;
				
				if ($discount == 0 || NULL) {
					$dis_amt = 0;
				} elseif (strpos($discount, '%') > 0) {
					$temp_dis_Array= explode('%', $discount);                    
					$temp_dis = $temp_dis_Array[0];                            
					$temp_item_price = 0;  
					$dis_amt=0;                        
					$dis_amt = "-".($price * ($temp_dis / 100) * $qty);
				}else{
					$dis_amt = $discount;
				}
				
				//$net_price = $price + $dis_amt;

                $each_row_price = 0;
                $each_row_price = $qty * $price;

                $o_total_item_amt += $each_row_price; ?>
				<tr>
	            	<td style="text-align:center; width:30px;" valign="top"><?php echo $i + 1; ?></td>
	                <td style="text-align:left; width:130px; padding-bottom: 10px" valign="top"><?php echo $name; ?><br />[<?php echo $pcode; ?>]</td>
	                <td style="text-align:center; width:50px;" valign="top"><?php echo $qty; ?></td>
	                <td style="text-align:center; width:50px;" valign="top"><?php echo number_format($price); ?></td>
	                <td style="text-align:right; width:70px;" valign="top"><?php echo number_format($each_row_price); ?></td>
				</tr>	
		<?php
                $o_total_item_qty += $qty;

                unset($pcode);
                unset($name);
                unset($qty);
                unset($price);
            }
            unset($orderItemResult);
            unset($orderItemData);
        ?>
			 
    	</tbody> 
	</table> 
	
    
    <table class="totals" cellspacing="0" border="0" style="margin-bottom:5px; border-top: 1px solid #000; border-collapse: collapse;">
    	<tbody>
			<tr>
				<td style="text-align:left; padding-top: 5px;"><?php echo $lang_total_items; ?></td>
				<td style="text-align:right; padding-right:1.5%; border-right: 1px solid #000;font-weight:bold;"><?php echo $o_total_item_qty; ?></td>
				<td style="text-align:left; padding-left:1.5%;"><?php echo $lang_total; ?></td>
				<td style="text-align:right;font-weight:bold;"><?php echo number_format($o_total_item_amt); ?></td>
			</tr>    
			
			<!--<tr>
				<td style="text-align:left; padding-top: 5px;">&nbsp;</td>
				<td style="text-align:right; padding-right:1.5%; border-right: 1px solid #000;font-weight:bold;">&nbsp;</td>
				<td style="text-align:left; padding-left:1.5%;"><?php //echo $lang_tax; ?></td>
				
				<td style="text-align:right;font-weight:bold;"><?php
				//$tax_amt = $total_item_amt * 0.1;
				//echo number_format($tax_amt); ?></td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:left; font-weight:bold; border-top:1px solid #000; padding-top:5px;"><?php //echo $lang_grand_total; ?></td>
				<td colspan="2" style="border-top:1px solid #000; padding-top:5px; text-align:right; font-weight:bold;"><?php 
				//$grandTotal = $total_item_amt + $tax_amt;
				//echo number_format($grandTotal); ?></td>
    		</tr>-->
    		
    </tbody>
    </table>
    
    <div style="border-top:1px solid #000; padding-top:10px;">
    	  
    </div>

	<div style="clear:both;"></div>
    
	<table class="table" cellspacing="0"  border="0"> 
			<tr>
				<th width="100%" colspan="5"> Returns </th>
			</tr>
			<tr>					
				<th width="10%"><em>#</em></th> 
				<th width="35%" align="left"><?php echo $lang_products; ?></th>
				<th width="10%"><?php echo $lang_qty; ?></th>
				<th width="25%"><?php echo $lang_per_item; ?></th>
				<th width="20%" align="right"><?php echo $lang_total; ?></th> 
			</tr> 
		
		<tbody> 
		
		<?php
		//report return belum masuk diskon juga
            $r_total_item_amt = 0;
            $r_total_item_qty = 0;
			
            $returnItemResult = $this->db->query("SELECT ri.id, ri.product_code, ri.product_name, ri.price, sum(ri.qty) as qty, o.discount_percentage
			FROM return_items as ri inner join orders as o on ri.order_id = o.id
			where o.created_datetime >= '$hari_ini 00:00:00' AND o.created_datetime <= '$hari_ini 23:59:59'
			GROUP by ri.product_code  
			ORDER BY ri.product_name ASC ");
            $returnItemData = $returnItemResult->result();
            for ($i = 0; $i < count($returnItemData); ++$i) {
                $pcode = $returnItemData[$i]->product_code;
                $name = $returnItemData[$i]->product_name;
                $qty = $returnItemData[$i]->qty;
				$price = $returnItemData[$i]->price;
				$discount = $returnItemData[$i]->discount_percentage;
				
				if ($discount == 0 || NULL) {
					$dis_amt = 0;
				} elseif (strpos($discount, '%') > 0) {
					$temp_dis_Array= explode('%', $discount);                    
					$temp_dis = $temp_dis_Array[0];                            
					$temp_item_price = 0;  
					$dis_amt=0;                        
					$dis_amt = "-".($price * ($temp_dis / 100) * $qty);
				}else{
					$dis_amt = $discount;
				}

                $each_row_price = 0;
                $each_row_price = $qty * $price;

                $r_total_item_amt += $each_row_price; ?>
				<tr>
	            	<td style="text-align:center; width:30px;" valign="top"><?php echo $i + 1; ?></td>
	                <td style="text-align:left; width:130px; padding-bottom: 10px" valign="top"><?php echo $name; ?><br />[<?php echo $pcode; ?>]</td>
	                <td style="text-align:center; width:50px;" valign="top"><?php echo $qty; ?></td>
	                <td style="text-align:center; width:50px;" valign="top"><?php echo number_format($price); ?></td>
	                <td style="text-align:right; width:70px;" valign="top"><?php echo number_format($each_row_price); ?></td>
				</tr>	
		<?php
                $r_total_item_qty += $qty;

                unset($pcode);
                unset($name);
                unset($qty);
                unset($price);
            }
            unset($returnItemResult);
            unset($returnItemData);
        ?>
			 
    	</tbody> 
	</table> 
	
    
    <table class="totals" cellspacing="0" border="0" style="margin-bottom:5px; border-top: 1px solid #000; border-collapse: collapse;">
    	<tbody>
			<tr>
				<td style="text-align:left; padding-top: 5px;"><?php echo $lang_total_items; ?></td>
				<td style="text-align:right; padding-right:1.5%; border-right: 1px solid #000;font-weight:bold;"><?php echo $r_total_item_qty; ?></td>
				<td style="text-align:left; padding-left:1.5%;"><?php echo $lang_total; ?></td>
				<td style="text-align:right;font-weight:bold;"><?php echo number_format($r_total_item_amt); ?></td>
			</tr>  
			    		
    </tbody>
    </table>
    

	<div style="border-top:1px solid #000; padding-top:10px;">
    	  
    </div>

	<div style="clear:both;"></div>
    
	<table class="table" cellspacing="0"  border="0"> 
			<tr>
				<th width="100%" colspan="5" style="border-bottom:2px solid #000; " > Discount </th>
			</tr>
			
		
		
		<tbody> 
		
		<?php
			$o_total_discount = 0;		
            $o_discountResult = $this->db->query("SELECT sum(discount_total) as discount_total
			FROM orders
			where created_datetime >= '$hari_ini 00:00:00' AND created_datetime <= '$hari_ini 23:59:59' AND status = '1' ");
			$o_discountData = $o_discountResult->result();
			for ($i = 0; $i < count($o_discountData); ++$i) {
				$o_discount = $o_discountData[$i]->discount_total;
				
				$o_each_row_discount = 0;
                $o_each_row_discount = $o_discount;

                $o_total_discount += $o_each_row_discount;
                ?>
				<tr>
					<td style="text-align:left; padding-top: 5px; border-right: 1px solid #000;"><?php echo "Total Orders with Discount"; ?></td>
					<td style="text-align:right;font-weight:bold;  "><?php echo "-".number_format($o_each_row_discount); ?></td>	                
				</tr>	
		<?php       
                unset($o_discount);
                
            }
            unset($o_discountResult);
            unset($o_discountItemData);
        ?>
			 

			 <?php
			$r_total_discount = 0;		
            $r_discountResult = $this->db->query("SELECT sum(discount_total) as discount_total
			FROM orders
			where created_datetime >= '$hari_ini 00:00:00' AND created_datetime <= '$hari_ini 23:59:59' AND status = '2' ");
				$r_discountData = $r_discountResult->result();
				for ($i = 0; $i < count($r_discountData); ++$i) {
				$r_discount = $r_discountData[$i]->discount_total;
				
				$r_each_row_discount = 0;
                $r_each_row_discount = $r_discount;

                $r_total_discount += $r_each_row_discount;
                ?>
				<tr>
					<td style="text-align:left; padding-top: 5px; border-bottom: 1px solid #000; border-right: 1px solid #000;"><?php echo "Total Return with Discount"; ?></td>
					<td style="text-align:right;font-weight:bold; border-bottom: 1px solid #000;  "><?php echo number_format($r_each_row_discount); ?></td>	                
				</tr>	
		<?php       
                unset($r_discount);
                
            }
            unset($r_discountResult);
            unset($r_discountItemData);
        ?>	 
    	</tbody> 
		<tbody> 
			<tr>
				<td style="text-align:left; padding-top: 5px; border-right: 1px solid #000;  "><?php echo "Total All Discount"; ?></td>
				<td style="text-align:right;font-weight:bold; "><?php 
				$total_all_discount = $o_each_row_discount -$r_each_row_discount;
				echo "-".number_format($total_all_discount); ?></td>	                
			</tr>	
		</tbody> 
		
	</table> 
	
        
	<div style="clear:both;"></div>
    
	<table class="table" cellspacing="0"  border="0"> 
			<tr>
				<th width="100%" colspan="5" style="border-bottom: 2px solid #000;"> Summary This Day </th>
			</tr>		
		<tbody> 		
		
				<tr>
					<td style="text-align:left; cols padding-right:1.5%; border-right: 1px solid #000;"><?php echo "Total Amount All Orders" ?></td>
					<td style="text-align:right;font-weight:bold;"><?php echo number_format($o_total_item_amt); ?></td>	                
				</tr>
				<tr>
					<td style="text-align:left; cols padding-right:1.5%; border-right: 1px solid #000;"><?php echo "Total Amount All Returns" ?></td>
					<td style="text-align:right;font-weight:bold;"><?php echo number_format($r_total_item_amt); ?></td>	                
				</tr>
				<tr>
					<td style="text-align:left; cols padding-right:1.5%; border-right: 1px solid #000; border-bottom: 1px solid #000;"><?php echo "Total Amount All Discount"; ?></td>
					<td style="text-align:right;font-weight:bold; border-bottom: 1px solid #000;"><?php echo "-".number_format($total_all_discount); ?></td>
	                
				</tr>
				<div style="border-top:1px solid #000; padding-top:10px;">
    	  
		 		</div>
				 <tr>
					<td style="text-align:left; cols padding-right:1.5%; border-right: 1px solid #000; border-bottom: 1px solid #000;font-weight:bold;"><?php echo "Total Amount Sales"; ?></td>
					<td style="text-align:right;font-weight:bold; border-bottom: 1px solid #000;"><?php
					$total_amount = 0;
					$total_amount = $o_total_item_amt + $r_total_item_amt - $total_all_discount;
					echo number_format($total_amount); ?></td>
	                
				</tr>

				<?php
					$o_total_tax = 0;
				
					$o_taxResult = $this->db->query("SELECT sum(tax) as tax
					FROM orders
					where created_datetime >= '$hari_ini 00:00:00' AND created_datetime <= '$hari_ini 23:59:59' AND status = '1' ");
					$o_taxData = $o_taxResult->result();
					for ($i = 0; $i < count($o_taxData); ++$i) {
						$tax_order = $o_taxData[$i]->tax;
						
						$o_each_row_tax = 0;
						$o_each_row_tax = $tax_order;

						$o_total_tax += $o_each_row_tax;
						?>
						 <tr>
							<td style="text-align:left; cols padding-right:1.5%; border-right: 1px solid #000;"><?php echo "Total Amount Tax Orders" ?></td>
							<td style="text-align:right;font-weight:bold;"><?php echo number_format($o_each_row_tax); ?></td>	                
						</tr>	
				<?php       
						unset($tax_order);						
					}
					unset($o_taxResult);
					unset($o_taxData);
				?>

				<?php
					$r_total_tax = 0;
				
					$r_taxResult = $this->db->query("SELECT sum(tax) as tax
					FROM orders
					where created_datetime >= '$hari_ini 00:00:00' AND created_datetime <= '$hari_ini 23:59:59' AND status = '2' ");
					$r_taxData = $r_taxResult->result();
					for ($i = 0; $i < count($r_taxData); ++$i) {
						$tax_return = $r_taxData[$i]->tax;
						
						$r_each_row_tax = 0;
						$r_each_row_tax = $tax_return;

						$r_total_tax += $r_each_row_tax;
						?>
						 <tr>
							<td style="text-align:left; cols padding-right:1.5%; border-right: 1px solid #000;"><?php echo "Total Amount Tax Returns" ?></td>
							<td style="text-align:right;font-weight:bold;"><?php echo number_format($r_each_row_tax); ?></td>	                
						</tr>	
				<?php       
						unset($tax_return);						
					}
					unset($r_taxResult);
					unset($r_taxData);
				?>
				
			 <tr>
					<td style="text-align:left; cols padding-right:1.5%; border-right: 1px solid #000; border-bottom: 1px solid #000;font-weight:bold; border-top: 1px solid #000;"><?php echo "Total Amount Tax"; ?></td>
					<td style="text-align:right;font-weight:bold; border-bottom: 1px solid #000; border-top: 1px solid #000;"><?php
					$total_tax = 0;
					$total_tax = $o_each_row_tax + $r_each_row_tax;
					echo number_format($total_tax); ?>
					</td>
	                
			 </tr>

			 <tr>
					<td style="text-align:left; cols padding-right:1.5%; border-right: 1px solid #000; border-bottom: 2px solid #000;font-weight:bold; border-top: 1px solid #000;"><?php echo "Grand Total Amount"; ?></td>
					<td style="text-align:right;font-weight:bold; border-bottom: 2px solid #000; border-top: 1px solid #000;"><?php
					$grandtotal_amount = 0;
					$grandtotal_amount = $total_amount + $total_tax;
					echo number_format($grandtotal_amount); ?>
					</td>
	                
			 </tr>
			 
    	</tbody> 
	</table> 
	

   
    <div id="bkpos_wrp">
    	<a href="<?=base_url()?>pos" style="width:100%; display:block; font-size:12px; text-decoration: none; text-align:center; color:#FFF; background-color:#005b8a; border:0px solid #007FFF; padding: 10px 1px; margin: 5px auto 10px auto; font-weight:bold;"><?php echo $lang_back_to_pos; ?></a>
    </div>
    
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
    
    <!--<input type="hidden" id="id" value="<?php //echo $order_id; ?>" />-->
    
</div>

<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script type="text/javascript">
	$(document).ready(function(){ 
		$('#email').click( function(){
			var email 	= prompt("Please enter email address","test@mail.com");	
			var id 		= document.getElementById("id").value;
			
			$.ajax({
				type: "POST",
				url: "<?=base_url()?>pos/send_invoice",
				data: { email: email, id: id}
			}).done(function( msg ) {
			      alert( "Successfully Sent Receipt to "+email);
			});
			
		});
	});

	$(window).load(function() { window.print(); });
</script>




</body>
</html>
