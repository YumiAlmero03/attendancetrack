<?php 
require_once 'db.php';
include_once('pdf/fpdf.php');

$date_from = isset($_GET['date_from']) ? $_GET['date_from'] : date('Y-m-d');
$date_to =  strtotime($date_from);
$date_to =  strtotime("-7 day", $date_to);
$date_to =  date('Y-m-d',$date_to);

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('../assets/logo.png',10,-1,70);
    $this->SetFont('Arial','B',13);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(80,10,'Attendance for 7 days',1,0,'C');
    // Line break
    $this->Ln(20);
}
 
// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}
 
$display_heading = array('ID', 'Name');
$period = new DatePeriod(
new DateTime($date_to),
new DateInterval('P1D'),
new DateTime($date_from)
);
foreach ($period as $key => $value) {
array_push($display_heading, $value->format('Y/m/d'));
}
$result = mysqli_query($conn, "SELECT firstname,lastname,id FROM registered") or die("database error:". mysqli_error($conn));
if (isset($_GET['year'])&&isset($_GET['section'])&&isset($_GET['course'])) {
$year= $_GET['year'];
$section=$_GET['section'];
$course=$_GET['course'];
$result = mysqli_query($conn, "SELECT firstname,lastname,id FROM registered where course = '".$course."' and year = '".$year."' and section = '".$section."'") or die("database error:". mysqli_error($conn));
}
$header = mysqli_query($conn, "SHOW columns FROM employee");
 
$pdf = new PDF();
//header
$pdf->AddPage('L');
//foter page
$pdf->AliasNbPages();
$pdf->SetFont('Arial','B',12);
foreach($display_heading as $heading) {
if ($heading === 'Name') {
$pdf->Cell(40,12,$heading,1);
}else{
$pdf->Cell(30,12,$heading,1);
}
}
foreach($result as $row) {
$pdf->Ln();
$data = [$row['id'],$row['firstname'].' '.$row['lastname']];
$id = $row['id'];
foreach ($period as $key => $value) {
$the_date = $value->format('Y-m-d');
$show = mysqli_query($conn, "SELECT subj FROM login where reg_id=".$id." and `date` = '".$the_date."' ") or die("database error:". mysqli_error($connString));
$fetch = $show->fetch_assoc();
if (isset($fetch['subj'])) {
array_push($data,'IN');

} else {
array_push($data,' - ');
}
}
foreach($data as $column)
if (strlen($column) > 5) {
$pdf->Cell(40,12,$column,1);
}else{
$pdf->Cell(30,12,$column,1);
}
}
$pdf->Output();
?>