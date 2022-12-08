<?php
require('vendor/autoload.php');
require('fpdf/fpdf.php');
//require('TCPDF/tcpdf.php');
$conn=mysqli_connect('localhost','root','','webinor');
$id=$_GET['invoice_id'];
$sql="SELECT *FROM create_order_list WHERE ID= '$id'";
$runsql=mysqli_query($conn,$sql);
$fetch_data=mysqli_fetch_array($runsql);
//print_r($fetch_data);die();
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

$html = '<img src="zixdo-logo.jpg" class="lgg"><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b class="est">Estimate</b><span>';

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
    <th colspan="4">Customer Details &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Center-</b></th>
    
  </tr>
  <tr>
    <th>-ID-</th>
    <td>'.$fetch_data['ID'].'</td>
    <th>Email-</th>
	 <td>'.$fetch_data['Name'].'</td>
  </tr>
  <tr>
    <th>Email-</th>
    <td>'.$fetch_data['Email'].'</td>
    <th>City-</th>
	 <td>New Delhi</td>
  </tr>
   <tr>
    <th>Mobile No</th>
    <td>'.$fetch_data['Mobile'].'</td>
   
	
  </tr>
  
  
 
  
</table>
';
$html.='
<table>
    <fieldset>
        <label for="fname">First name:</label>
  <input type="text" id="fname" name="fname"><br><br>
  <label for="lname">Last name:</label>
  <input type="text" id="lname" name="lname"><br><br>
  <label for="email">Email:</label>
  <input type="email" id="email" name="email"><br><br>
  <label for="birthday">Birthday:</label>
  <input type="date" id="birthday" name="birthday"><br><br>
  <input type="submit" value="Submit">
    </fieldset>
    <tr>
        <td></td>
    </tr>
</table>
';
}	
		

		

$mpdf=new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);
$file='media/'.time().'.pdf';
//echo time();
$mpdf->output($file,'I');
//D-Download
//I-View
//F-download in server folder
//S
?>