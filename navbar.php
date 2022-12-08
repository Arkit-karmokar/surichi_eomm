<?php 
function navbar(){
include('conn.php');
?>
<nav class="header__menu--navigation">
	<ul class="d-flex">
	<?php 
		$select_category_vise="SELECT * FROM categories";
		$select_categoryvise=mysqli_query($conn,$select_category_vise);
		while ($fetch_category_vise=$select_categoryvise->fetch_array()) {
				$category_id=$fetch_category_vise['ID'];
				$select_subcategory_vise=mysqli_query($conn,"SELECT * FROM sub_categories WHERE Category_ID='$category_id'");
					$numrows=mysqli_num_rows($select_subcategory_vise);
	?>
		<li class="header__menu--items mega__menu--items style2">
			<img src="assets/img/category_images/<?=$fetch_category_vise['Category_Image'];?>" style="width: 60px; height: 50px;" class="d-flex">
			<a class="header__menu--link text-white" href="shop.php"><?=$fetch_category_vise['Category_Name'];?>
				<?php if($numrows>0){?>
				<svg class="menu__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12" height="7.41" viewBox="0 0 12 7.41">
					<path  d="M16.59,8.59,12,13.17,7.41,8.59,6,10l6,6,6-6Z" transform="translate(-6 -8.59)" fill="currentColor" opacity="0.7"/>
				</svg>
				<?php }?>
			</a>
			<?php if($numrows>0){?>
			<ul class="header__mega--menu d-flex">
				<?php while($fetch_subcategory_vise=$select_subcategory_vise->fetch_array()){
					$sub_categoryid=$fetch_subcategory_vise['ID'];
					$select_wearble_category=mysqli_query($conn,"SELECT *FROM wearable_category WHERE Sub_CategoryID='$sub_categoryid'");
					?>
				<li class="header__mega--menu__li">
					<span class="header__mega--subtitle"><?=$fetch_subcategory_vise['SubCategory_Name'];?></span>
					<?php 
						while ($fetch_wearble_category=$select_wearble_category->fetch_array()) {
					 ?>
					<ul class="header__mega--sub__menu">
						<li class="header__mega--sub__menu_li"><a class="header__mega--sub__menu--title" href="shop.php"><?=$fetch_wearble_category['Wearable_Name'];?></a></li>
					</ul>
					<?php }?>
				</li>
				<?php }?>
			</ul>
			<?php }?>
		</li>
<?php }?> 
	</ul>
</nav>
<?php }?>