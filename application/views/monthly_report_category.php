<?php
    require_once 'includes/header.php';

    $orderRows = 0;
?>

<script>
	$(document).ready(function() {
    var table = $('#example').DataTable( {
        scrollY:        "400px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
        fixedColumns:   {
            leftColumns: 1,
            rightColumns: 1
        }
    } );
} );
</script>

<?php
    $url_month = '';
    $url_year = '';

    if (isset($_GET['report'])) {
        $url_month = $_GET['month'];
        $url_year = $_GET['year'];
    }
?>


<script type="text/javascript" src="<?=base_url()?>assets/cdn/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/cdn/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/cdn/datatables/dataTables.fixedColumns.min.js"></script>
<link href="<?=base_url()?>assets/cdn/datatables/fixedColumns.dataTables.min.css" rel="stylesheet">
<link href="<?=base_url()?>assets/cdn/datatables/jquery.dataTables.min.css" rel="stylesheet">


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
			<h1 class="page-header"><?php echo $lang_monthly_report_category; ?></h1>
		</div>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					
					<form action="<?=base_url()?>reports/monthly_report_category" method="get">
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label><?php echo $lang_month; ?></label>
								<select name="month" class="form-control" required>
                                    <option value="01">January</option>
                                    <option value="02">February</option>
                                    <option value="03">March</option>
                                    <option value="04">April</option>
                                    <option value="05">May</option>
                                    <option value="06">June</option>
                                    <option value="07">July</option>
                                    <option value="08">August</option>
                                    <option value="09">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label><?php echo $lang_year; ?></label>
								<select name="year" class="form-control" required>
                                    <?php
                                    for($i=date('Y'); $i>=2018; $i--) {
                                    $selected = '';
                                    if ($tahun == $i) $selected = ' selected="selected"';
                                    print('<option value="'.$i.'"'.$selected.'>'.$i.'</option>'."\n");
                                    }?>
                                </select>  
							</div>
                        </div>
                        
						<div class="col-md-3">
							<div class="form-group">
								<label>&nbsp;</label><br />
								<input type="hidden" name="report" value="1" />
								<input type="submit" class="btn btn-success" value="<?php echo $lang_get_report; ?>" />
							</div>
						</div>
					</div>
					</form>

            <?php
                if (isset($_GET['report'])) { ?>       
					<div class="row" style="margin-top: 10px;">                    
						<div class="col-md-12">
                        
							<div class="table-responsive">
                                <table  id="example" class="stripe row-border order-column" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th><?php echo 'Category / '.$url_month.' - '.$url_year ?></th>
                                            <th><?php echo '01'; ?></th>
                                            <th><?php echo '02'; ?></th>
                                            <th><?php echo '03'; ?></th>
                                            <th><?php echo '04'; ?></th>
                                            <th><?php echo '05'; ?></th>
                                            <th><?php echo '06'; ?></th>
                                            <th><?php echo '07'; ?></th>
                                            <th><?php echo '08'; ?></th>
                                            <th><?php echo '09'; ?></th>
                                            <th><?php echo '10'; ?></th>
                                            <th><?php echo '11'; ?></th>
                                            <th><?php echo '12'; ?></th>
                                            <th><?php echo '13'; ?></th>
                                            <th><?php echo '14'; ?></th>
                                            <th><?php echo '15'; ?></th>
                                            <th><?php echo '16'; ?></th>
                                            <th><?php echo '17'; ?></th>
                                            <th><?php echo '18'; ?></th>
                                            <th><?php echo '19'; ?></th>
                                            <th><?php echo '20'; ?></th>                                          
                                            <th><?php echo '21'; ?></th>
                                            <th><?php echo '22'; ?></th>
                                            <th><?php echo '23'; ?></th>
                                            <th><?php echo '24'; ?></th>
                                            <th><?php echo '25'; ?></th>
                                            <th><?php echo '26'; ?></th>
                                            <th><?php echo '27'; ?></th>
                                            <th><?php echo '28'; ?></th>
                                            <th><?php echo '29'; ?></th>
                                            <th><?php echo '30'; ?></th>
                                            <th><?php echo '31'; ?></th>
                                            <th><?php echo 'Status'; ?></th>
                                        </tr>
                                    </thead>                                    
                                    <tbody>
                                <?php                                   
                                     
                                        $month = $url_month;
                                        $year = $url_year;
                                        $orderResult = $this->db->query("SELECT ifnull(c.name,'~ Grand Total') as category, 
                                        (SELECT sum(if(o.ordered_datetime BETWEEN '$year-$month-01 00:00:00' AND '$year-$month-01 23:59:59', oi.price*oi.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-01 00:00:00' AND '$year-$month-01 23:59:59', (oi.price * oi.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)) + sum(if(o.ordered_datetime BETWEEN '$year-$month-01 00:00:00' AND '$year-$month-01 23:59:59', ri.price*ri.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-01 00:00:00' AND '$year-$month-01 23:59:59', (ri.price * ri.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2))) 
                                        AS 'd01',
                                        (SELECT sum(if(o.ordered_datetime BETWEEN '$year-$month-02 00:00:00' AND '$year-$month-02 23:59:59', oi.price*oi.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-02 00:00:00' AND '$year-$month-02 23:59:59', (oi.price * oi.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)) + sum(if(o.ordered_datetime BETWEEN '$year-$month-02 00:00:00' AND '$year-$month-02 23:59:59', ri.price*ri.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-02 00:00:00' AND '$year-$month-02 23:59:59', (ri.price * ri.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2))) 
                                        AS 'd02',
                                        (SELECT sum(if(o.ordered_datetime BETWEEN '$year-$month-03 00:00:00' AND '$year-$month-03 23:59:59', oi.price*oi.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-03 00:00:00' AND '$year-$month-03 23:59:59', (oi.price * oi.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)) + sum(if(o.ordered_datetime BETWEEN '$year-$month-03 00:00:00' AND '$year-$month-03 23:59:59', ri.price*ri.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-03 00:00:00' AND '$year-$month-03 23:59:59', (ri.price * ri.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2))) 
                                        AS 'd03',
                                        (SELECT sum(if(o.ordered_datetime BETWEEN '$year-$month-04 00:00:00' AND '$year-$month-04 23:59:59', oi.price*oi.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-04 00:00:00' AND '$year-$month-04 23:59:59', (oi.price * oi.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)) + sum(if(o.ordered_datetime BETWEEN '$year-$month-04 00:00:00' AND '$year-$month-04 23:59:59', ri.price*ri.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-04 00:00:00' AND '$year-$month-04 23:59:59', (ri.price * ri.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2))) 
                                        AS 'd04',
                                        (SELECT sum(if(o.ordered_datetime BETWEEN '$year-$month-05 00:00:00' AND '$year-$month-05 23:59:59', oi.price*oi.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-05 00:00:00' AND '$year-$month-05 23:59:59', (oi.price * oi.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)) + sum(if(o.ordered_datetime BETWEEN '$year-$month-05 00:00:00' AND '$year-$month-05 23:59:59', ri.price*ri.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-05 00:00:00' AND '$year-$month-05 23:59:59', (ri.price * ri.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2))) 
                                        AS 'd05',
                                        (SELECT sum(if(o.ordered_datetime BETWEEN '$year-$month-06 00:00:00' AND '$year-$month-06 23:59:59', oi.price*oi.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-06 00:00:00' AND '$year-$month-06 23:59:59', (oi.price * oi.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)) + sum(if(o.ordered_datetime BETWEEN '$year-$month-06 00:00:00' AND '$year-$month-06 23:59:59', ri.price*ri.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-06 00:00:00' AND '$year-$month-06 23:59:59', (ri.price * ri.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2))) 
                                        AS 'd06',
                                        (SELECT sum(if(o.ordered_datetime BETWEEN '$year-$month-07 00:00:00' AND '$year-$month-07 23:59:59', oi.price*oi.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-07 00:00:00' AND '$year-$month-07 23:59:59', (oi.price * oi.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)) + sum(if(o.ordered_datetime BETWEEN '$year-$month-07 00:00:00' AND '$year-$month-07 23:59:59', ri.price*ri.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-07 00:00:00' AND '$year-$month-07 23:59:59', (ri.price * ri.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2))) 
                                        AS 'd07',
                                        (SELECT sum(if(o.ordered_datetime BETWEEN '$year-$month-08 00:00:00' AND '$year-$month-08 23:59:59', oi.price*oi.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-08 00:00:00' AND '$year-$month-08 23:59:59', (oi.price * oi.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)) + sum(if(o.ordered_datetime BETWEEN '$year-$month-08 00:00:00' AND '$year-$month-08 23:59:59', ri.price*ri.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-08 00:00:00' AND '$year-$month-08 23:59:59', (ri.price * ri.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2))) 
                                        AS 'd08',
                                        (SELECT sum(if(o.ordered_datetime BETWEEN '$year-$month-09 00:00:00' AND '$year-$month-09 23:59:59', oi.price*oi.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-09 00:00:00' AND '$year-$month-09 23:59:59', (oi.price * oi.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)) + sum(if(o.ordered_datetime BETWEEN '$year-$month-09 00:00:00' AND '$year-$month-09 23:59:59', ri.price*ri.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-09 00:00:00' AND '$year-$month-09 23:59:59', (ri.price * ri.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2))) 
                                        AS 'd09',
                                        (SELECT sum(if(o.ordered_datetime BETWEEN '$year-$month-10 00:00:00' AND '$year-$month-10 23:59:59', oi.price*oi.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-10 00:00:00' AND '$year-$month-10 23:59:59', (oi.price * oi.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)) + sum(if(o.ordered_datetime BETWEEN '$year-$month-10 00:00:00' AND '$year-$month-10 23:59:59', ri.price*ri.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-10 00:00:00' AND '$year-$month-10 23:59:59', (ri.price * ri.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2))) 
                                        AS 'd10',
                                        (SELECT sum(if(o.ordered_datetime BETWEEN '$year-$month-11 00:00:00' AND '$year-$month-11 23:59:59', oi.price*oi.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-11 00:00:00' AND '$year-$month-11 23:59:59', (oi.price * oi.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)) + sum(if(o.ordered_datetime BETWEEN '$year-$month-11 00:00:00' AND '$year-$month-11 23:59:59', ri.price*ri.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-11 00:00:00' AND '$year-$month-11 23:59:59', (ri.price * ri.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)))
                                        AS 'd11',
                                        (SELECT sum(if(o.ordered_datetime BETWEEN '$year-$month-12 00:00:00' AND '$year-$month-12 23:59:59', oi.price*oi.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-12 00:00:00' AND '$year-$month-12 23:59:59', (oi.price * oi.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)) + sum(if(o.ordered_datetime BETWEEN '$year-$month-12 00:00:00' AND '$year-$month-12 23:59:59', ri.price*ri.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-12 00:00:00' AND '$year-$month-12 23:59:59', (ri.price * ri.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)))
                                        AS 'd12',
                                        (SELECT sum(if(o.ordered_datetime BETWEEN '$year-$month-13 00:00:00' AND '$year-$month-13 23:59:59', oi.price*oi.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-13 00:00:00' AND '$year-$month-13 23:59:59', (oi.price * oi.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)) + sum(if(o.ordered_datetime BETWEEN '$year-$month-13 00:00:00' AND '$year-$month-13 23:59:59', ri.price*ri.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-13 00:00:00' AND '$year-$month-13 23:59:59', (ri.price * ri.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)))
                                        AS 'd13',
                                        (SELECT sum(if(o.ordered_datetime BETWEEN '$year-$month-14 00:00:00' AND '$year-$month-14 23:59:59', oi.price*oi.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-14 00:00:00' AND '$year-$month-14 23:59:59', (oi.price * oi.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)) + sum(if(o.ordered_datetime BETWEEN '$year-$month-14 00:00:00' AND '$year-$month-14 23:59:59', ri.price*ri.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-14 00:00:00' AND '$year-$month-14 23:59:59', (ri.price * ri.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)))
                                        AS 'd14',
                                        (SELECT sum(if(o.ordered_datetime BETWEEN '$year-$month-15 00:00:00' AND '$year-$month-15 23:59:59', oi.price*oi.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-15 00:00:00' AND '$year-$month-15 23:59:59', (oi.price * oi.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)) + sum(if(o.ordered_datetime BETWEEN '$year-$month-15 00:00:00' AND '$year-$month-15 23:59:59', ri.price*ri.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-15 00:00:00' AND '$year-$month-15 23:59:59', (ri.price * ri.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)))
                                        AS 'd15',
                                        (SELECT sum(if(o.ordered_datetime BETWEEN '$year-$month-16 00:00:00' AND '$year-$month-16 23:59:59', oi.price*oi.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-16 00:00:00' AND '$year-$month-16 23:59:59', (oi.price * oi.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)) + sum(if(o.ordered_datetime BETWEEN '$year-$month-16 00:00:00' AND '$year-$month-16 23:59:59', ri.price*ri.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-16 00:00:00' AND '$year-$month-16 23:59:59', (ri.price * ri.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)))
                                        AS 'd16',
                                        (SELECT sum(if(o.ordered_datetime BETWEEN '$year-$month-17 00:00:00' AND '$year-$month-17 23:59:59', oi.price*oi.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-17 00:00:00' AND '$year-$month-17 23:59:59', (oi.price * oi.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)) + sum(if(o.ordered_datetime BETWEEN '$year-$month-17 00:00:00' AND '$year-$month-17 23:59:59', ri.price*ri.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-17 00:00:00' AND '$year-$month-17 23:59:59', (ri.price * ri.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)))
                                        AS 'd17',
                                        (SELECT sum(if(o.ordered_datetime BETWEEN '$year-$month-18 00:00:00' AND '$year-$month-18 23:59:59', oi.price*oi.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-18 00:00:00' AND '$year-$month-18 23:59:59', (oi.price * oi.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)) + sum(if(o.ordered_datetime BETWEEN '$year-$month-18 00:00:00' AND '$year-$month-18 23:59:59', ri.price*ri.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-18 00:00:00' AND '$year-$month-18 23:59:59', (ri.price * ri.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)))
                                        AS 'd18',
                                        (SELECT sum(if(o.ordered_datetime BETWEEN '$year-$month-19 00:00:00' AND '$year-$month-19 23:59:59', oi.price*oi.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-19 00:00:00' AND '$year-$month-19 23:59:59', (oi.price * oi.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)) + sum(if(o.ordered_datetime BETWEEN '$year-$month-19 00:00:00' AND '$year-$month-19 23:59:59', ri.price*ri.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-19 00:00:00' AND '$year-$month-19 23:59:59', (ri.price * ri.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)))
                                        AS 'd19',
                                        (SELECT sum(if(o.ordered_datetime BETWEEN '$year-$month-20 00:00:00' AND '$year-$month-20 23:59:59', oi.price*oi.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-20 00:00:00' AND '$year-$month-20 23:59:59', (oi.price * oi.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)) + sum(if(o.ordered_datetime BETWEEN '$year-$month-20 00:00:00' AND '$year-$month-20 23:59:59', ri.price*ri.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-20 00:00:00' AND '$year-$month-20 23:59:59', (ri.price * ri.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)))
                                        AS 'd20',
                                        (SELECT sum(if(o.ordered_datetime BETWEEN '$year-$month-21 00:00:00' AND '$year-$month-21 23:59:59', oi.price*oi.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-21 00:00:00' AND '$year-$month-21 23:59:59', (oi.price * oi.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)) + sum(if(o.ordered_datetime BETWEEN '$year-$month-21 00:00:00' AND '$year-$month-21 23:59:59', ri.price*ri.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-21 00:00:00' AND '$year-$month-21 23:59:59', (ri.price * ri.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)))
                                        AS 'd21',
                                        (SELECT sum(if(o.ordered_datetime BETWEEN '$year-$month-22 00:00:00' AND '$year-$month-22 23:59:59', oi.price*oi.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-22 00:00:00' AND '$year-$month-22 23:59:59', (oi.price * oi.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)) + sum(if(o.ordered_datetime BETWEEN '$year-$month-22 00:00:00' AND '$year-$month-22 23:59:59', ri.price*ri.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-22 00:00:00' AND '$year-$month-22 23:59:59', (ri.price * ri.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)))
                                        AS 'd22',
                                        (SELECT sum(if(o.ordered_datetime BETWEEN '$year-$month-23 00:00:00' AND '$year-$month-23 23:59:59', oi.price*oi.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-23 00:00:00' AND '$year-$month-23 23:59:59', (oi.price * oi.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)) + sum(if(o.ordered_datetime BETWEEN '$year-$month-23 00:00:00' AND '$year-$month-23 23:59:59', ri.price*ri.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-23 00:00:00' AND '$year-$month-23 23:59:59', (ri.price * ri.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)))
                                        AS 'd23',
                                        (SELECT sum(if(o.ordered_datetime BETWEEN '$year-$month-24 00:00:00' AND '$year-$month-24 23:59:59', oi.price*oi.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-24 00:00:00' AND '$year-$month-24 23:59:59', (oi.price * oi.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)) + sum(if(o.ordered_datetime BETWEEN '$year-$month-24 00:00:00' AND '$year-$month-24 23:59:59', ri.price*ri.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-24 00:00:00' AND '$year-$month-24 23:59:59', (ri.price * ri.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)))
                                        AS 'd24',
                                        (SELECT sum(if(o.ordered_datetime BETWEEN '$year-$month-25 00:00:00' AND '$year-$month-25 23:59:59', oi.price*oi.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-25 00:00:00' AND '$year-$month-25 23:59:59', (oi.price * oi.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)) + sum(if(o.ordered_datetime BETWEEN '$year-$month-25 00:00:00' AND '$year-$month-25 23:59:59', ri.price*ri.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-25 00:00:00' AND '$year-$month-25 23:59:59', (ri.price * ri.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)))
                                        AS 'd25',
                                        (SELECT sum(if(o.ordered_datetime BETWEEN '$year-$month-26 00:00:00' AND '$year-$month-26 23:59:59', oi.price*oi.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-26 00:00:00' AND '$year-$month-26 23:59:59', (oi.price * oi.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)) + sum(if(o.ordered_datetime BETWEEN '$year-$month-26 00:00:00' AND '$year-$month-26 23:59:59', ri.price*ri.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-26 00:00:00' AND '$year-$month-26 23:59:59', (ri.price * ri.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)))
                                        AS 'd26',
                                        (SELECT sum(if(o.ordered_datetime BETWEEN '$year-$month-27 00:00:00' AND '$year-$month-27 23:59:59', oi.price*oi.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-27 00:00:00' AND '$year-$month-27 23:59:59', (oi.price * oi.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)) + sum(if(o.ordered_datetime BETWEEN '$year-$month-27 00:00:00' AND '$year-$month-27 23:59:59', ri.price*ri.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-27 00:00:00' AND '$year-$month-27 23:59:59', (ri.price * ri.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)))
                                        AS 'd27',
                                        (SELECT sum(if(o.ordered_datetime BETWEEN '$year-$month-28 00:00:00' AND '$year-$month-28 23:59:59', oi.price*oi.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-28 00:00:00' AND '$year-$month-28 23:59:59', (oi.price * oi.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)) + sum(if(o.ordered_datetime BETWEEN '$year-$month-28 00:00:00' AND '$year-$month-28 23:59:59', ri.price*ri.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-28 00:00:00' AND '$year-$month-28 23:59:59', (ri.price * ri.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)))
                                        AS 'd28',
                                        (SELECT sum(if(o.ordered_datetime BETWEEN '$year-$month-29 00:00:00' AND '$year-$month-29 23:59:59', oi.price*oi.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-29 00:00:00' AND '$year-$month-29 23:59:59', (oi.price * oi.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)) + sum(if(o.ordered_datetime BETWEEN '$year-$month-29 00:00:00' AND '$year-$month-29 23:59:59', ri.price*ri.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-29 00:00:00' AND '$year-$month-29 23:59:59', (ri.price * ri.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)))
                                        AS 'd29',
                                        (SELECT sum(if(o.ordered_datetime BETWEEN '$year-$month-30 00:00:00' AND '$year-$month-30 23:59:59', oi.price*oi.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-30 00:00:00' AND '$year-$month-30 23:59:59', (oi.price * oi.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)) + sum(if(o.ordered_datetime BETWEEN '$year-$month-30 00:00:00' AND '$year-$month-30 23:59:59', ri.price*ri.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-30 00:00:00' AND '$year-$month-30 23:59:59', (ri.price * ri.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)))
                                        AS 'd30',
                                        (SELECT sum(if(o.ordered_datetime BETWEEN '$year-$month-31 00:00:00' AND '$year-$month-31 23:59:59', oi.price*oi.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-31 00:00:00' AND '$year-$month-31 23:59:59', (oi.price * oi.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)) + sum(if(o.ordered_datetime BETWEEN '$year-$month-31 00:00:00' AND '$year-$month-31 23:59:59', ri.price*ri.qty,0)) - cast(sum(if(o.ordered_datetime BETWEEN '$year-$month-31 00:00:00' AND '$year-$month-31 23:59:59', (ri.price * ri.qty) * (SELECT TRIM( '%' from o.discount_percentage))/100,0))as double(11,2)))
                                        AS 'd31', c.status  as status                                 
                                            FROM orders as o
                                            LEFT JOIN order_items as oi on oi.order_id = o.id
                                            LEFT JOIN return_items as ri on ri.order_id = o.id 	
                                            LEFT JOIN category as c on c.id = oi.product_category  or c.id = ri.product_category                                            
                                            GROUP BY  c.name with ROLLUP");
                                        $orderRows = $orderResult->num_rows();

                                        if ($orderRows > 0) {
                                            $orderData = $orderResult->result();
                                            for ($od = 0; $od < count($orderData); ++$od) {
                                                $category = $orderData[$od]->category;
                                                     $d01 = $orderData[$od]->d01;
                                                     $d02 = $orderData[$od]->d02;
                                                     $d03 = $orderData[$od]->d03;
                                                     $d04 = $orderData[$od]->d04;
                                                     $d05 = $orderData[$od]->d05;
                                                     $d06 = $orderData[$od]->d06;
                                                     $d07 = $orderData[$od]->d07;
                                                     $d08 = $orderData[$od]->d08;
                                                     $d09 = $orderData[$od]->d09;
                                                     $d10 = $orderData[$od]->d10;
                                                     $d11 = $orderData[$od]->d11;
                                                     $d12 = $orderData[$od]->d12;
                                                     $d13 = $orderData[$od]->d13;
                                                     $d14 = $orderData[$od]->d14;
                                                     $d15 = $orderData[$od]->d15;
                                                     $d16 = $orderData[$od]->d16;
                                                     $d17 = $orderData[$od]->d17;
                                                     $d18 = $orderData[$od]->d18;
                                                     $d19 = $orderData[$od]->d19;
                                                     $d20 = $orderData[$od]->d20;
                                                     $d21 = $orderData[$od]->d21;
                                                     $d22 = $orderData[$od]->d22;
                                                     $d23 = $orderData[$od]->d23;
                                                     $d24 = $orderData[$od]->d24;
                                                     $d25 = $orderData[$od]->d25;
                                                     $d26 = $orderData[$od]->d26;
                                                     $d27 = $orderData[$od]->d27;
                                                     $d28 = $orderData[$od]->d28;
                                                     $d29 = $orderData[$od]->d29;
                                                     $d30 = $orderData[$od]->d30;
                                                     $d31 = $orderData[$od]->d31;
                                                     $status = $orderData[$od]->status;

                                                     
                                                 ?>
                                            <tr>     
                                                <td>
                                                    <?php echo $category; ?>
                                                </td>                                       
                                                <td>
                                                    <?php echo number_format($d01); ?>
                                                </td>
                                                <td>
                                                    <?php echo number_format($d02); ?>
                                                </td>
                                                <td>
                                                    <?php echo number_format($d03); ?>
                                                </td>
                                                <td>
                                                    <?php echo number_format($d04); ?>
                                                </td>
                                                <td>
                                                    <?php echo number_format($d05); ?>
                                                </td>
                                                <td>
                                                    <?php echo number_format($d06); ?>
                                                </td>
                                                <td>
                                                    <?php echo number_format($d07); ?>
                                                </td>
                                                <td>
                                                    <?php echo number_format($d08); ?>
                                                </td>
                                                <td>
                                                    <?php echo number_format($d09); ?>
                                                </td>
                                                <td>
                                                    <?php echo number_format($d10); ?>
                                                </td>
                                                <td>
                                                    <?php echo number_format($d11); ?>
                                                </td>
                                                <td>
                                                    <?php echo number_format($d12); ?>
                                                </td>
                                                <td>
                                                    <?php echo number_format($d13); ?>
                                                </td>
                                                <td>
                                                    <?php echo number_format($d14); ?>
                                                </td>
                                                <td>
                                                    <?php echo number_format($d15); ?>
                                                </td>
                                                <td>
                                                    <?php echo number_format($d16); ?>
                                                </td>
                                                <td>
                                                    <?php echo number_format($d17); ?>
                                                </td>
                                                <td>
                                                    <?php echo number_format($d18); ?>
                                                </td>
                                                <td>
                                                    <?php echo number_format($d19); ?>
                                                </td>
                                                <td>
                                                    <?php echo number_format($d20); ?>
                                                </td>
                                                <td>
                                                    <?php echo number_format($d21); ?>
                                                </td>
                                                <td>
                                                    <?php echo number_format($d22); ?>
                                                </td>
                                                <td>
                                                    <?php echo number_format($d23); ?>
                                                </td>
                                                <td>
                                                    <?php echo number_format($d24); ?>
                                                </td>
                                                <td>
                                                    <?php echo number_format($d25); ?>
                                                </td>
                                                <td>
                                                    <?php echo number_format($d26); ?>
                                                </td>
                                                <td>
                                                    <?php echo number_format($d27); ?>
                                                </td>
                                                <td>
                                                    <?php echo number_format($d28); ?>
                                                </td>
                                                <td>
                                                    <?php echo number_format($d29); ?>
                                                </td>
                                                <td>
                                                    <?php echo number_format($d30); ?>
                                                </td>
                                                <td>
                                                    <?php echo number_format($d31); ?>
                                                </td>
                                                <td>
                                                    <?php if($status  == '1'){
                                                        echo "Active"; }
                                                    else if($status == '0'){
                                                        echo "Inactive";
                                                    }
                                                    ?>
                                                </td>  
                                                
                                               
                                               
                                            </tr>
                                            <?php	          
                                                    }
                                                    unset($orderData);
                                                 }
                                             unset($orderResult); ?>
                                    </tbody>
                                </table>

							</div>
						</div>
					</div>
<?php

    }
?>



					
					
				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
			
			
			
		</div><!-- Col md 12 // END -->
	</div><!-- Row // END -->
	
	
	
	
	
	<br /><br /><br />
	
</div><!-- Right Colmn // END -->
	
	
	
<?php
    require_once 'includes/footer.php';
?>