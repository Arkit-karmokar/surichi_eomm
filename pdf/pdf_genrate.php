<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>How to make pdf in php</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
	<div class="container">
		<table class="table table-hover table-bordered table-striped table-responsive">
			<tr>
				<th>S No.</th>
				<th>Name</th>
				<th>Email</th>
				<th>Mobile</th>
				<th>City</th>
				<th>Address</th>
				<th>Date</th>
				<th>Zip Code</th>
				<th>Amount</th>
				<th>Download Invoice</th>
			</tr>
			<tr>
				<tbody id="showData" class="show_data"></tbody>
			</tr>
		</table>
	</div>
</body>
<script type="text/javascript">
		$(document).ready(function(){
		$.ajax({
			type:'post',
			url:'ajax_table.php',
			//data:{id:id},
			success:function(response){
				$("#showData").html(response);
				//console.log(response);
				event.preventDefault();
			}
		});
	})
</script>
</html>