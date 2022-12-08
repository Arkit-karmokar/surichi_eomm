<?php 
$conn= new mysqli('localhost','root','','Webinor');
$select_data=$conn->query("SELECT *FROM create_order_list");
while ($fetch_data=$select_data->fetch_array()) {

?>
<tr>
	<td><?=$fetch_data['ID'];?></td>
	<td><?=$fetch_data['Name'];?></td>
	<td><?=$fetch_data['Email'];?></td>
	<td><?=$fetch_data['Mobile'];?></td>
	<td><?=$fetch_data['City'];?></td>
	<td><?=$fetch_data['Address'];?></td>
	<td><?=date('Y-m-d',strtotime($fetch_data['Create_Date']));?></td>
	<td><?=$fetch_data['Zip_Code'];?></td>
	<td><?=$fetch_data['Total_Amount'];?></td>
	<td><a href="indexback.php?invoice_id=<?=$fetch_data['ID'];?>"><button class="btn btn-primary">Download Now</button></a></td>
</tr>
 <?php }?>