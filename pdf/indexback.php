<?php
require('vendor/autoload.php');
require('fpdf/fpdf.php');
//require('TCPDF/tcpdf.php');
$conn=mysqli_connect('localhost','root','','webinor');
$sql="SELECT * FROM create_order_list WHERE ID= '".$_GET['invoice_id']."'";
$runsql=mysqli_query($conn,$sql);
$fetch_data=mysqli_fetch_array($runsql);
$order_id=$fetch_data['Invoice_ID'];
$total_amount=$fetch_data['Total_Amount'];
$gst=$total_amount*9/100;
$sgst=$total_amount*9/100;
$totalgst=$gst+$sgst;
$discount=$fetch_data['Payment_Type'];
$netamount=$total_amount-$totalgst;
$storeid=$fetch_data['ID'];
$originalDate = $fetch_data['Create_Date'];
$newDate = date("d-m-Y", strtotime($originalDate));
$sql_store=mysqli_query($conn,"SELECT * FROM order_item WHERE ID='$storeid'");
$fetch_store=mysqli_fetch_array($sql_store);
$res=mysqli_query($conn,"SELECT * from create_order_list WHERE Order_ID='$order_id'");
class PDF extends FPDF
{
protected $B = 0;
protected $I = 0;
protected $U = 0;
protected $HREF = '';

function WriteHTML($html)
{
    // HTML parser
    $html = str_replace("\n",' ',$html);
    $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
    foreach($a as $i=>$e)
    {
        if($i%2==0)
        {
            // Text
            if($this->HREF)
                $this->PutLink($this->HREF,$e);
            else
                $this->Write(5,$e);
        }
        else
        {
            // Tag
            if($e[0]=='/')
                $this->CloseTag(strtoupper(substr($e,1)));
            else
            {
                // Extract attributes
                $a2 = explode(' ',$e);
                $tag = strtoupper(array_shift($a2));
                $attr = array();
                foreach($a2 as $v)
                {
                    if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                        $attr[strtoupper($a3[1])] = $a3[2];
                }
                $this->OpenTag($tag,$attr);
            }
        }
    }
}

function OpenTag($tag, $attr)
{
    // Opening tag
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,true);
    if($tag=='A')
        $this->HREF = $attr['HREF'];
    if($tag=='BR')
        $this->Ln(5);
}

function CloseTag($tag)
{
    // Closing tag
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,false);
    if($tag=='A')
        $this->HREF = '';
}

function SetStyle($tag, $enable)
{
    // Modify style and select corresponding font
    $this->$tag += ($enable ? 1 : -1);
    $style = '';
    foreach(array('B', 'I', 'U') as $s)
    {
        if($this->$s>0)
            $style .= $s;
    }
    $this->SetFont('',$style);
}

function PutLink($URL, $txt)
{
    // Put a hyperlink
    $this->SetTextColor(0,0,255);
    $this->SetStyle('U',true);
    $this->Write(5,$txt,$URL);
    $this->SetStyle('U',false);
    $this->SetTextColor(0);
}
}

$html ='<img src="nav-log.png" class="lgg">
<span>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<b class="est">Tax Invoice</b>
<span>';

$mpdf = new PDF();
// First page
$mpdf->AddPage();
$mpdf->SetFont('Arial','',20);
$mpdf->Write(5,"To find out what's new in this tutorial, click ");
$mpdf->SetFont('','U');
$link = $mpdf->AddLink();
$mpdf->Write(5,'here',$link);
$mpdf->SetFont('');
// Second page
$mpdf->AddPage();
$mpdf->SetLink($link);
$mpdf->Image('ZIXDO.png',10,12,30,0,'','http://www.zixdo.com');
$mpdf->SetLeftMargin(45);
$mpdf->SetFontSize(14);
//$mpdf->WriteHTML($html);
//mpdf->Output();
$i=0;
if(mysqli_num_rows($runsql)>0){
	$html.='<style>table {
  width:100%;
}
table, th, tr {
  border: 1px solid black;
  border-collapse: collapse;
}
th, tr {
  padding: 15px;
  text-align: left;
}
#t01 tr:nth-child(even) {
  background-color: #eee;
}
#t01 tr:nth-child(odd) {
 background-color: #fff;
}
#t01 th {
  background-color: black;
  color: white;
}
img{
	width:200px;";
}
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #E8E8E8;
}
.btn{
	background: red;
    border: 1px solid red;
	color:#fff;
height:20px;
width:50px;
    
 
}
.stroe_location{
	
margin-left:400px;
}
.img1{
	width:100%;
	height:100%;
}
.lgg{
	width:10%;
	height:10%;
}
.est{
	font-size: 36px;
    color: #007cc0;
}
.ppp{
	text-align:justify;
	margin-top:20px;
}
</style>




<table>
 <tr>
    <th colspan="4">Customer Details &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Center-</b>'.$fetch_data['City'].'</th>
    
  </tr>
  <tr>
    <th>Full Name-</th>
    <td>'.$fetch_data['Name'].'</td>
    <th>Email-</th>
	 <td>'.$fetch_data['Email'].'</td>
  </tr>
  <tr>
    <th>Mobile-</th>
    <td>'.$fetch_data['Mobile'].'</td>
    <th>City-</th>
	 <td>New Delhi</td>
  </tr>
   <tr>
    <th>Pin Code-</th>
    <td>'.$fetch_data['Zip_Code'].'</td>
    <th>Date-</th>
	 <td>'.$newDate.'</td>
  </tr>
  
  <tr>
    <td colspan="3"><b>Full Address-</b>&nbsp;&nbsp;&nbsp;</td><td >'.$fetch_data['Address'].'</td>
   
  </tr>
 
  
</table>
<br>
<table class="table1">';

		$html.='<tr><th colspan="4">Service Details</th></tr><tr><th>S No.</th><th>Product Name</th><th>Service</th><th>Cost</th>';
			$servicesql=mysqli_query($conn,"SELECT * FROM `order_item` INNER JOIN products ON products.ID=order_item.Product_ID WHERE order_item.ID='$serviceid'");
		while($row=mysqli_fetch_assoc($runsql)){
			$i++;
            $qty=$row['Qty'];
			/*$fetch_service=mysqli_fetch_array($sql_store);
            $discount_amount=$fetch_service['Discount'];
			$service_name_id=$fetch_service['service_name_id'];*/
			$html.='<tr><td>'.$i.'</td><td>'.$row['Product_Name'].'</td><td>'.$row['Qty'].'</td><td style="text-align:right;padding-right: 10px;border-top: 0px;border-left:0px;font-family: DejaVu Sans; sans-serif;font-size: 16px;padding-right: 10px; border-left: 1px solid darkred; border-right: 1px solid darkred;">&#8377;'.$row['Total_Amount'].'</td></tr>';
		}
		$html.='<tr><td colspan="3" style="border-left: 1px solid darkred; border-right: 1px solid darkred; text-align: right;font-weight: normal;border-top: 0px;border-right: 1px solid darkred; padding-right: 10px;font-size: 16px;">Net Amount : </td><td style="text-align:right;padding-right: 10px;border-top: 0px;border-left:0px;font-family: DejaVu Sans; sans-serif;font-size: 16px;padding-right: 10px; border-left: 1px solid darkred; border-right: 1px solid darkred;">&#8377; '.number_format($netamount,2).'</td></tr><tr><td colspan="3" style="border-left: 1px solid darkred; border-right: 1px solid darkred; text-align: right;font-weight: normal; border-top: 0px;border-right: 1px solid darkred; padding-right: 10px;font-size: 16px;">CGST @ 9% : </td><td style="text-align:right;padding-right: 10px;border-top: 0px;border-left:0px;font-family: DejaVu Sans; sans-serif;font-size: 16px;padding-right: 10px; border-left: 1px solid darkred; border-right: 1px solid darkred;">&#8377; '.number_format($gst,2).'</td></tr><tr><td colspan="3" style="border-left: 1px solid darkred; border-right: 1px solid darkred; text-align: right;font-weight: normal; border-top: 0px;border-right: 1px solid darkred; padding-right: 10px;font-size: 16px;">SGST @ 9% : </td><td style="text-align:right;padding-right: 10px;border-top: 0px;border-left:0px;font-family: DejaVu Sans; sans-serif;font-size: 16px;padding-right: 10px; border-left: 1px solid darkred; border-right: 1px solid darkred;">&#8377; '.number_format($sgst,2).'</td></tr><tr><td colspan="3" style="border-left: 1px solid darkred; border-right: 1px solid darkred; text-align: right;font-weight: normal; border-top: 0px;border-right: 1px solid darkred; padding-right: 10px;font-size: 16px;">GST (CGST + SGST) @ 18% : </td><td style="text-align:right;padding-right: 10px;border-top: 0px;border-left:0px;font-family: DejaVu Sans; sans-serif;font-size: 16px;padding-right: 10px;border-left: 1px solid darkred; border-right: 1px solid darkred;">&#8377; '.number_format($totalgst,2).'</td></tr><tr><td colspan="3" style="border-left: 1px solid darkred; border-right: 1px solid darkred; text-align: right;font-weight: normal;border-top: 0px;border-right: 1px solid darkred; padding-right: 10px;font-size: 16px;">Discount : </td><td style="text-align:right;padding-right: 10px;border-top: 0px;border-left:0px;font-family: DejaVu Sans; sans-serif;font-size: 16px;padding-right: 10px; border-left: 1px solid darkred; border-right: 1px solid darkred;">&#8377; '.number_format($discount_amount,2).'</td></tr><tr><td colspan="3" style="border: 2px solid darkred; text-align: right;font-weight: bold;padding-right:0px; border-right:1px solid darkred; padding-right: 10px;padding:5px;font-size: 18px;">Total Payable Amount: </td><td style="text-align:right;padding-right: 10px; border:2px solid darkred; border-left:none;padding:5px; font-family: DejaVu Sans; sans-serif;font-size: 18px;padding-right: 10px; font-weight: bold;">&#8377; '.number_format($total_amount,2).'</td></tr>';
	$html.='</table>';
}else{
	$html="Data not found";
}
$html.='<br><br>
<img src="Estimate.jpg" class="img1">
';

		

$mpdf=new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);
$file='media/'.time().'.pdf';
//echo time();
$mpdf->output($file,'I');
//D-Download
//I-View
//F-Save in Server File
//S-
?>