<?php
	$monthlyArray = array(
		'Jan-2016' => 'January - 2016',
		'Feb-2016'	=> 'February - 2016',
		'Mar-2016'	=> 'March - 2016',
		'Apr-2016'  => 'April - 2016',
		'May-2016'  => 'May - 2016',
		'Jun-2016'  => 'June - 2016',
		'Jul-2016'  => 'July - 2016',
		'Aug-2016'  => 'August - 2016',
		'Sep-2016'  => 'September - 2016',
		'Oct-2016'  => 'October - 2016',
		'Nov-2016'  => 'November - 2016',
		'Dec-2016'  => 'December - 2016',
	);
?>
<style>
.font-26 {
	font-size: 26px;
}
</style>
<section class="content">
	<div class="col-md-12">
	<div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
	        <div class="info-box">
	          	<span class="info-box-icon bg-aqua"><i class="ion ion-android-print"></i></span>
	          	<div class="info-box-content">
	            	<span class="info-box-text">Today Jobs</span>
	            	<span class="info-box-number font-26"><?php echo $todayReport->todayJobs;?></span>
	            </div>
	        </div>
        </div>
        
        <div class="col-md-3 col-sm-6 col-xs-12">
	        <div class="info-box">
	            <span class="info-box-icon bg-red"><i class="ion ion-cash"></i></span>
	           	<div class="info-box-content">
	            	<span class="info-box-text">Today Cash</span>
	              	<span class="info-box-number font-26"><?php echo $todayReport->todayJobsAdvance;?></span>
	            </div>
	        </div>
        </div>
        
        <div class="col-md-3 col-sm-6 col-xs-12">
        	<div class="info-box">
            	<span class="info-box-icon bg-green"><i class="fa fa-hourglass-end"></i></span>
            	<div class="info-box-content">
                	<span class="info-box-text">Today Due</span>
                	<span class="info-box-number font-26"><?php echo $todayReport->todayJobsDue;?></span>
            	</div>
          	</div>
        </div>
        
        <div class="col-md-3 col-sm-6 col-xs-12">
        	<div class="info-box">
	            <span class="info-box-icon bg-yellow"><i class="ion ion-calculator"></i></span>
	            <div class="info-box-content">
	             	<span class="info-box-text">Total Business</span>
	              	<span class="info-box-number font-26"><?php echo $todayReport->todayJobsTotal;?></span>
	            </div>
         	</div>
       	</div>
    </div>	
    </div>

<div class="col-md-12">
	<div class="row text-center">
		<h3> <?php echo date('M - Y');?> Report </h3>
	</div>
</div>

    <div class="col-md-12">
	<div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
	        <div class="info-box">
	          	<span class="info-box-icon bg-aqua"><i class="ion ion-android-print"></i></span>
	          	<div class="info-box-content">
	            	<span class="info-box-text">Monthly Jobs</span>
	            	<span class="info-box-number font-26"><?php echo $monthlyReport->monthlyJobs;?></span>
	            </div>
	        </div>
        </div>
        
        <div class="col-md-3 col-sm-6 col-xs-12">
	        <div class="info-box">
	            <span class="info-box-icon bg-red"><i class="ion ion-cash"></i></span>
	           	<div class="info-box-content">
	            	<span class="info-box-text">Monthly Cash</span>
	              	<span class="info-box-number font-26"><?php echo $monthlyReport->monthlyJobsAdvance;?></span>
	            </div>
	        </div>
        </div>
        
        <div class="col-md-3 col-sm-6 col-xs-12">
        	<div class="info-box">
            	<span class="info-box-icon bg-green"><i class="fa fa-hourglass-end"></i></span>
            	<div class="info-box-content">
                	<span class="info-box-text">Monthly Due</span>
                	<span class="info-box-number font-26"><?php echo $monthlyReport->monthlyJobsDue;?></span>
            	</div>
          	</div>
        </div>
        
        <div class="col-md-3 col-sm-6 col-xs-12">
        	<div class="info-box">
	            <span class="info-box-icon bg-yellow"><i class="ion ion-calculator"></i></span>
	            <div class="info-box-content">
	             	<span class="info-box-text">Monthly Total Business</span>
	              	<span class="info-box-number font-26"><?php echo $monthlyReport->monthlyJobsTotal;?></span>
	            </div>
         	</div>
       	</div>
    </div>		
    </div>
</section>
<hr>
<div class="clearfix"></div>
<section class="content">
<div class="col-md-12">
<div class="row">
	<div class="box">
	<div class="box-body">
<?php
$attributes = array('class' => 'form', 'id' => 'filter_report');
echo form_open('report/index', $attributes);
?>
	<div class="col-md-3">
		<label>Filter</label>
	</div>

	<div class="col-md-6">
		<select name="job_month" class="form-control">
		<?php foreach($monthlyArray as $key => $value)
		{
			$selected = '';
			if(isset($filterMonth) && $filterMonth == $key)
			{
				$selected = 'selected="selected"';
			}
			echo '<option '. $selected .'  value="' .$key. '">' .$value. '</option>';
		}
		?>		
		</select>
	</div>

	<div class="col-md-3">
		<input type="submit" name="filter" value="Filter" class="btn btn-primary btn-sm">
	</div>
	</div>
</div>
</div>
</div>

<?php
if(isset($filterMonth))
{
?>
<div class="col-md-12">
<div class="row">

	<div class="col-md-12">
		<h2 class="text-center">
			<?php echo $monthlyArray[$filterMonth];?> Report
		</h2>
	</div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          	<span class="info-box-icon bg-aqua"><i class="ion ion-android-print"></i></span>
          	<div class="info-box-content">
            	<span class="info-box-text">Monthly Jobs</span>
            	<span class="info-box-number font-26"><?php echo $filterReport->monthlyJobs;?></span>
            </div>
        </div>
    </div>
        
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-red"><i class="ion ion-cash"></i></span>
           	<div class="info-box-content">
            	<span class="info-box-text">Monthly Cash</span>
              	<span class="info-box-number font-26"><?php echo $filterReport->monthlyJobsAdvance;?></span>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6 col-xs-12">
    	<div class="info-box">
        	<span class="info-box-icon bg-green"><i class="fa fa-hourglass-end"></i></span>
        	<div class="info-box-content">
            	<span class="info-box-text">Monthly Due</span>
            	<span class="info-box-number font-26"><?php echo $filterReport->monthlyJobsDue;?></span>
        	</div>
      	</div>
    </div>
    
    <div class="col-md-3 col-sm-6 col-xs-12">
    	<div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-calculator"></i></span>
            <div class="info-box-content">
             	<span class="info-box-text">Monthly Business</span>
              	<span class="info-box-number font-26"><?php echo $filterReport->monthlyJobsTotal;?></span>
            </div>
     	</div>
   	</div>
</div>	
</div>
<?php
}
?>
</section>