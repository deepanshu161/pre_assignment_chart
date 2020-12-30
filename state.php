<?php
include("dbh.php");
?>
<!DOCTYPE html>
<html data-ng-app="app">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Charts</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
	<script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/data.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/export-data.js"></script>
	<script src="https://code.highcharts.com/modules/accessibility.js"></script>
	<link rel="stylesheet" href="custom.css" />
<script>
function get_state_date(val) 
{
	window.location.href='state.php?state='+val.value;
}
</script> 
</head>
<body>
<div class="container" style="margin-top:20px;">
	<div class="col-sm-3 block1">
		<a href="index.php?act=institute">Instiute Type Wise Data</a>
	</div>
	<div class="col-sm-3 block2">
		<a href="index.php?act=region">Region Wise Data</a>
	</div>
	<div class="col-sm-3 block3">
		<a href="index.php?act=category">Category Wise Data</a>
	</div>
	<div class="col-sm-3 block4">
		<a href="state.php">State Wise Data</a>
	</div>
</div>
<div class="container">
<div class="col-sm-12"><br />
	<div class="col-sm-6 col-sm-offset-3 form-group">
		<select name="state" onChange="get_state_date(this)" class="form-control">
			<option value="">Select State Name</option>
			<?php
			$st = mysqli_query($conn,"SELECT DISTINCT(`State`) FROM `institute` WHERE `State`!='State' order by `State` ");
			while($state=mysqli_fetch_array($st))
			{
			?>
			<option value="<?php echo $state['State'];?>" <?php if(@$_REQUEST['state']==$state['State']) echo "selected";?>><?php echo $state['State'];?></option>
			<?php } ?>
		</select>
	</div>
</div>

<div class="col-sm-12">
<figure class="highcharts-figure">
    <div id="container"></div>
</figure>

<script>
// Create the chart
Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Institute data for the state of <?php echo @$_REQUEST[state];?>'
    },
    subtitle: {
        text: ''
    },
    accessibility: {
        announceNewData: {
            enabled: true
        }
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Total Institutes'
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{point.y}'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> of total<br/>'
    },

    series: [
        {
            name: "Browsers",
            colorByPoint: true,
            data: [
				<?php
				$sqlQuery = "SELECT `Institution Type` as inst, count(*) as totcnt FROM `institute` WHERE `Institution Type`!='Institution Type' and `State`='".$_REQUEST['state']."' GROUP BY `Institution Type` ";
				$result = mysqli_query($conn,$sqlQuery);
				while($chr = mysqli_fetch_array($result))
				{
				?>
                {
                    name: "<?php echo @$chr[inst]?>",
                    y: <?php echo $chr['totcnt'];?>,
                },
				<?php } ?>
            ]
        }
    ]
});
</script>

</div>
</div>

</body>
</html>