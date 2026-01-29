<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_id'])) {
    die("Please log in.");
}

require_once __DIR__ . '/../fpdf/fpdf.php';

// Database connection
$mysqli = new mysqli('localhost', 'root', '', 'kibweziwest');
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

// Get user details
$user_id = $_SESSION['user_id'];
$stmt = $mysqli->prepare("
    SELECT id_number, first_name, middle_name, last_name, ward, pollingstation, email, phone, created_at
    FROM applicants WHERE id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows !== 1) die("Applicant not found.");
$user = $result->fetch_assoc();
$stmt->close();
$mysqli->close();

/* ---------------- PDF CLASS ---------------- */
class ApplicationPDF extends FPDF {

    function Header() {

    // Logo
    $logoPath = __DIR__ . '/image/cdflogo.png';
    if (file_exists($logoPath)) {
        $this->Image($logoPath, 10, 10, 30); // left, top, width
    }

    // Move cursor to the right of logo
$this->SetXY(45, 10);

// Content (LEFT aligned, height = 4)
$this->SetFont('Arial', '', 10);
$this->SetTextColor(0, 0, 0);

$this->Cell(0, 4, 'National Government Constituencies Development Fund', 0, 1, 'R');
$this->Cell(0, 4, 'Kibwezi West Constituency', 0, 1, 'R');
$this->Ln(1);

$this->Cell(0, 4, 'Kibwezi West NG-CDF Building Makindu', 0, 1, 'R');
$this->Cell(0, 4, 'Makindu Sub-County Headquarter.', 0, 1, 'R');
$this->Cell(0, 4, 'P.O Box 136-90138', 0, 1, 'R');
$this->Cell(0, 4, 'Makindu, Kenya', 0, 1, 'R');
$this->Ln(1);

$this->Cell(0, 4, 'Cell: 0722445495', 0, 1, 'R');
$this->Cell(0, 4, 'Email: cdfkibweziwest@cdf.go.ke | Website: www.cdf.go.ke', 0, 1, 'R');

   
    // Divider line
    $this->Ln(4);
    $this->SetDrawColor(0, 51, 102);
    $this->SetLineWidth(0.5);
    $this->Line(10, $this->GetY(), 200, $this->GetY());

    // Space before content
    $this->Ln(10);
}


    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->SetTextColor(128,128,128);
        $this->Cell(0,10,'Page '.$this->PageNo().' of {nb}',0,0,'C');
        $this->SetX(-45);
        $this->Cell(0,10,date('Y-m-d H:i:s'),0,0,'R');
    }
}

/* --------- SECTION TITLE HELPER --------- */
/* --------- SECTION TITLE HELPER --------- */
function sectionTitle($pdf, $title) {
    $pdf->Ln(8);
    $pdf->SetFont('Arial','B',12);
    $pdf->SetFillColor(230,230,230);
    $pdf->Cell(0,10,strtoupper($title),1,1,'L',true);
    $pdf->Ln(4);
}

/* --------- TABLE ROW HELPER --------- */
function tableRow($pdf, $label, $value) {
    $labelWidth = 55;
    $valueWidth = 135;
    $lineHeight = 8;

    $x = $pdf->GetX();
    $y = $pdf->GetY();

    // Label cell
    $pdf->SetFont('Arial','B',11);
    $pdf->MultiCell($labelWidth, $lineHeight, $label, 1, 'L');

    // Value cell
    $pdf->SetXY($x + $labelWidth, $y);
    $pdf->SetFont('Arial','',11);
    $pdf->MultiCell($valueWidth, $lineHeight, $value, 1, 'L');

    // Move to next row
    $pdf->SetY(max($pdf->GetY(), $y + $lineHeight));
}

/* ---------------- PDF CONTENT ---------------- */
$pdf = new ApplicationPDF();
$pdf->AliasNbPages();
$pdf->AddPage();

/* ---- PERSONAL INFORMATION ---- */
sectionTitle($pdf, 'Personal Information');

tableRow($pdf, 'ID Number', $user['id_number']);
tableRow(
    $pdf,
    'Full Name',
    trim($user['first_name'].' '.$user['middle_name'].' '.$user['last_name'])
);
tableRow($pdf, 'Email', $user['email']);
tableRow($pdf, 'Phone', $user['phone']);

/* ---- LOCATION INFORMATION ---- */
sectionTitle($pdf, 'Location Information');

tableRow($pdf, 'Ward', $user['ward']);
tableRow($pdf, 'Polling Station', $user['pollingstation']);

/* ---- REGISTRATION INFORMATION ---- */
sectionTitle($pdf, 'Registration Information');

tableRow($pdf, 'Registration Date', $user['created_at']);
tableRow($pdf, 'Document Generated', date('Y-m-d H:i:s'));

/* ---- FOOT NOTE ---- */
$pdf->Ln(12);
$pdf->SetFont('Arial','I',10);
$pdf->MultiCell(
    0,
    8,
    'This document is an official record of your application with Kibwezi West Constituency. Please keep it for your records.',
    0,
    'C'
);

$pdf->Ln(12);
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,8,'________________________________',0,1,'C');
$pdf->Cell(0,5,'Official Stamp / Signature',0,1,'C');

/* ---- DOWNLOAD ---- */
$filename = 'Application_'.$user['id_number'].'_'.date('Ymd').'.pdf';
$pdf->Output('D', $filename);
exit;


/* ---- FOOT NOTE ---- */
$pdf->Ln(12);
$pdf->SetFont('Arial','I',10);
$pdf->MultiCell(
    0,
    8,
    'This document is an official record of your application with Kibwezi West Constituency. Please keep it for your records.',
    0,
    'C'
);

$pdf->Ln(12);
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,8,'________________________________',0,1,'C');
$pdf->Cell(0,5,'Official Stamp / Signature',0,1,'C');

/* ---- DOWNLOAD ---- */
$filename = 'Application_'.$user['id_number'].'_'.date('Ymd').'.pdf';
$pdf->Output('D', $filename);
exit;
