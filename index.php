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

<?php
if(@$_REQUEST['act']=="category")
{
?>
<figure class="highcharts-figure">
    <div id="container"></div>
</figure>

<script>
Highcharts.chart('container', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Category and Gender wise student data'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: [
		<?php
		$pi = mysqli_query($conn,"SELECT DISTINCT(`category`) as category FROM `student_details` where `category`!='' ");
		while($pie=mysqli_fetch_array($pi))
		{
		?>
		'<?php echo @$pie[category]; ?>', <?php } ?>],
        title: {
            text: null
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Students',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        }
    },
    tooltip: {
        valueSuffix: ' millions'
    },
    plotOptions: {
        bar: {
            dataLabels: {
                enabled: true
            }
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'top',
        x: -40,
        y: 80,
        floating: true,
        borderWidth: 1,
        backgroundColor:
            Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
        shadow: true
    },
    credits: {
        enabled: false
    },
    series: [{
        name: 'Male',
        data: [
		<?php
		$pi2 = mysqli_query($conn,"SELECT `category` as cat, count(*) as totmalecnt FROM `student_details` WHERE `category`!='' and `gender`='Male' GROUP BY `category` ");
		
		while($pie2=mysqli_fetch_array($pi2))
		{
			echo $pie2['totmalecnt'].",";
		}
		?>
		]
    }, {
        name: 'Female',
        data: [<?php
		$pi2 = mysqli_query($conn,"SELECT `category` as cat, count(*) as totfemalecnt FROM `student_details` WHERE `category`!='' and `gender`='Female' GROUP BY `category` ");
		
		while($pie2=mysqli_fetch_array($pi2))
		{
			echo $pie2['totfemalecnt'].",";
		}
		?>]
    }, {
        name: 'Others',
        data: [<?php
		$pi2 = mysqli_query($conn,"SELECT `category` as cat, count(*) as tototherscnt FROM `student_details` WHERE `category`!='' and `gender`='Others' GROUP BY `category` ");
		
		while($pie2=mysqli_fetch_array($pi2))
		{
			echo $pie2['tototherscnt'].",";
		}
		?>]
    }]
});
</script>
<?php } 
if(@$_REQUEST['act']=="institute")
{
?>
<figure class="highcharts-figure">
    <div id="container2"></div>
</figure>

<script>
Highcharts.chart('container2', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Institute Type wise Institute data'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: true
        }
    },
    series: [{
        name: 'Institute',
        colorByPoint: true,
        data: [
		<?php
			$sqlQuery = "SELECT `Institution Type`, count(`Institution Type`) as totinst FROM `institute` WHERE `Institution Type` IS NOT null GROUP BY `Institution Type`";
			$result = mysqli_query($conn,$sqlQuery);
			while($chr = mysqli_fetch_array($result))
			{
			?>
			{
			name: "<?php echo $chr['Institution Type'];?>",
			y: <?php echo $chr['totinst'];?>
		},
			<?php } ?>
		]
    }]
});
</script>
<?php } 
if(@$_REQUEST['act']=="region")
{
?>		

<figure class="highcharts-figure">
    <div id="container3"></div>
</figure>

<script>
Highcharts.chart('container3', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Region Wise Data'
    },
    xAxis: {
        categories: [
		<?php
		$rg = mysqli_query($conn,"SELECT DISTINCT(`Region`) as region FROM `institute` where `Region`!='Region' ");
		while($reg=mysqli_fetch_array($rg))
		{
		?>
		'<?php echo @$reg[region]; ?>', <?php } ?>
		]
		//'Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Institute Count'
        }
    },
    tooltip: {
        pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
        shared: true
    },
    plotOptions: {
        column: {
            stacking: 'percent'
        }
    },
    series: [
	<?php
	$ins = mysqli_query($conn,"SELECT DISTINCT(`Institution Type`) as inst FROM `institute` where `Institution Type`!='Institution Type' ");
	while($inst=mysqli_fetch_array($ins))
	{
	?>
	{
        name: '<?php echo @$inst[inst]; ?>',
        data: [
		<?php
		$dt = mysqli_fetch_array(mysqli_query($conn,"SELECT COUNT(*) as totcnt FROM `institute` where `Institution Type`='".$inst['inst']."' and `Region`='Southern' "));
		echo @$dt['totcnt'].",";
		?>
		<?php
		$dt2 = mysqli_fetch_array(mysqli_query($conn,"SELECT COUNT(*) as totcnt FROM `institute` where `Institution Type`='".$inst['inst']."' and `Region`='Western' "));
		echo @$dt2['totcnt'].",";
		?>
		<?php
		$dt3 = mysqli_fetch_array(mysqli_query($conn,"SELECT COUNT(*) as totcnt FROM `institute` where `Institution Type`='".$inst['inst']."' and `Region`='Eastern' "));
		echo @$dt3['totcnt'].",";
		?>
		<?php
		$dt4 = mysqli_fetch_array(mysqli_query($conn,"SELECT COUNT(*) as totcnt FROM `institute` where `Institution Type`='".$inst['inst']."' and `Region`='Central' "));
		echo @$dt4['totcnt'].",";
		?>
		<?php
		$dt5 = mysqli_fetch_array(mysqli_query($conn,"SELECT COUNT(*) as totcnt FROM `institute` where `Institution Type`='".$inst['inst']."' and `Region`='Northern' "));
		echo @$dt5['totcnt'].",";
		?>
		]
    },
	<?php } ?>
	]
});
</script>
<?php } ?>
</div>

</body>
</html>