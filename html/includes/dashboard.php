
      <!-- Page Heading/Breadcrumbs -->
      <div class="row">
        <div class="col-lg-12">
          <h1 class="page-header">Visualize your Sensordata!
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php">Sensor Monitoring</a>
            </li>
            <li class="active">Visualize Data</li>
          </ol>
        </div>
      </div>
      <!-- table to select different Nodes -->
<form id="nodes" type="POST" action="">
	<input type="hidden" name="nodeformsend" value="true">
	<div class="conatiner-fluid">
	  <div class="row">
	    <div class="col-md-12">
	      <div class="panel panel-custom panel-default text-center">
	        <div class="panel-heading panel-heading-custom">
	          <h3 class="panel-title">Select a Device</h3>
	        </div>
	        <div class="col-md">
	          <select class="form-control" id="location" name="location" title="Choosing one Wireless Sensor Node takes effect to all shown Elements">
	          <?php for($i = 1; $i <= $numberNodes; $i++) : ?>
	              <option  name="location[<?php echo $i ?>]" value="<?php echo $i ?>">Wireless Sensor Node <?php echo $i ?></option>
	          <?php endfor; ?>
	          </select>
	        </div>
	      </div>
	    </div>
	  </div>
	  <div class="row equal">
	    <div class="col-md-12 col-sm-12 col-xs-12" >
	      <div class="panel panel-default text-center" style="height: 100%">
	        <div class="panel-heading">
	          <h3 class="panel-title">Current Measures</h3>
	        </div>
	        <div class="panel-body">
	          <p class="text-info">The different gauges presenting current measures and battery charge</p>
						<div class="gauges">
	            <div class="col col-md-3">
								<div id="jg1"></div>
							</div>
	            <div class="col col-md-3" >
								<div id="jg4"> </div>
							</div>
	            <div class="col col-md-3" >
								<div id="jg3"> </div>
							</div>
	            <div class="col col-md-3" >
								<div id="jg2"> </div>
							</div>
						</div>
	        </div>
	      </div>
	    </div>
	  </div>
	</br>
	<div class="row equal">
	  <div class="col-md-12; col-xs-12">
	    <div class="panel panel-default text-center" style="height: 100%">
	      <div class="panel-heading">
	        <h3 class="panel-title">Average Values of last Days</h3>
	      </div>
	      <div class="panel-body">
	        <table class="table table-striped text-center" id="table2" >
	        </table>
	      </div>
	    </div>
	  </div>
	</div>
	</br>

	<div class="row">

		<!-- table to select different parameters -->
		<div class="col col-md-6">
			<div class="panel panel-default panel-custom text-center">
				<div class="panel-heading panel-heading-custom">
					<h3 class="panel-title">Select Starttime</h3>
				</div>
				<div class="input-group date" id="datetimestart">
					<div class="input-group-addon">
						<i class="glyphicon glyphicon-calendar"></i>
					</div>
						<input class="form-control" name="datetimestart" type="text" title="Selecting a Startime takes effect to Max & Min Table and Chart" >
				</div>
			</div>
		</div>
		<!-- table to select Timestamps-->
		<div class="col col-md-6">
			<div class="panel panel-default panel-custom text-center">
				<div class="panel-heading panel-heading-custom">
					<h3 class="panel-title">Select Endtime</h3>
				</div>
				<div class="input-group date" id="datetimeend">
					<div class="input-group-addon">
						<i class="glyphicon glyphicon-calendar"></i>
					</div>
					<input class="form-control" name="datetimeend" type="text" title="Selecting an Endtime takes effect to Max & Min Table and Chart">
				</div>
			</div>

		</div>
	</div>
	<button class="btn btn-primary btn-block" type="button" id="submitdate" title="Press button if you already choosed a timeinterval">Confirm your selected Timeinterval</button>
</div>
	   <div class="row equal">
	  		<div class="col-md-12; col-xs-12">
	  			<div class="panel panel-default text-center" style="height: 100%">
	  				<div class="panel-heading">
	  					<h3 class="panel-title">Max and Min</h3>
	  				</div>
	  				<div class="panel-body">
	  					<p class="text-info">This table shows the max and min values with associated time depending on the selected interval</p>
							<div style="text-align:center;">
								<table class="table table-striped text-center" id="table1" >
		  					</table>
							</div>
	          </div>
	        </div>
	      </div>
	    </div>
	</br>
	  <div class="row equal hide-on-portrait">
			<div class="col-md-12">
				<div class="panel panel-default text-center"style="width:100%">
					<div class="panel-heading">
						<h3 class="panel-title">Chart with selected Parameter</h3>
						<p class="text-info">The chart shows the selected parameter depending on the selected interval</p>
					</div>
					<div class="panel-body">
						<div class="col-xs-12; col-md-3">
							<div class="panel panel-default panel-custom text-center">
								<div class="panel-heading panel-heading-custom">
									<h3 class="panel-title">Select a parameter</h3>
								</div>
								<div class="col-md">
									<select class="form-control" id="parameter" name="parameter" title="Selecting a Parameter takes effect only to Chart">
										<option  name="parameter[0]" value="temperature">Temperature</option>
										<option  name="parameter[1]" value="humidity">Humidity</option>
										<option  name="parameter[2]" value="pressure">Pressure</option>
									</select>
								</div>
							</div>
						</div>
						<canvas id="mychart" style="width:100%; height:100%;"></canvas>
					</div>
				</div>
			</div>
	  </diV>
	  <div class="row equal hide-on-landscape">
		<div class="col-md-12">
			<img class="displayed"src="fonts/rotate.png" title="To show the Chart rotate your Display" align="middle" />
		</div>
	 </div>
	</div>
	<div class="loading-overlay">
		<div class="inner">
			<div id='loading' style='display: none'>
				<img src="fonts/loading.gif" title="Loading" class="img-responsive center-block"/>
			</div>
		</div>
	</div>
	</form>
	</div>
