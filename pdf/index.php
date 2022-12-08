<?php
require('vendor/autoload.php');
require('fpdf/fpdf.php');

$conn=mysqli_connect('localhost','root','','webinor');
$id=$_GET['invoice_id'];
$res=mysqli_query($conn,"SELECT * FROM create_order_list WHERE ID='$id'");

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

$html = 'You can now easily print text mixing different styles: <b>bold</b>, <i>italic</i>,
<u>underlined</u>, or <b><i><u>all at once</u></i></b>!<br><br>You can also insert links on
text, such as <a href="https://www.zixdo.com">www.fpdf.org</a>, or on an image: click on the logo.';

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
$mpdf->WriteHTML($html);
$mpdf->Output();

if(mysqli_num_rows($res)>0){
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
</style><img src="media/ZIXDO.png" >


<table class="table1">';

		$html.='<tr class="trr"><td>S No.</td><td>Full Name</td></tr><tr><td>Name</td><td>Email</td></tr>';
		while($row=mysqli_fetch_assoc($res)){
			$html.='<tr><td>'.$row['ID'].'</td><td>'.$row['Name'].'</td><td>'.$row['Email'].'</td></tr>';
		}
	$html.='</table>';
}else{
	$html="Data not found";
}
$html.='<br><br><table class="table1">';

		$html.='<tr class="trr"><td colspan="3">Full Name</td><td>ID</td></tr><tr><td>Name</td><td>Email</td></tr>';
		//while($row=mysqli_fetch_assoc($res)){
			$html.='<tr><td>1</td><td>Ravindra</td><td>ravindrayadav170@yahoo.com</td><td>hjh</td></tr>';
		//}
	$html.='</table>';

$mpdf=new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);
$file='media/'.time().'.pdf';
//echo time();
$mpdf->output($file,'I');
//D
//I
//F
//S
?>