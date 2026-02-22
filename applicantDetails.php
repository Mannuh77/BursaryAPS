<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ensure user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['email'])) {
    echo "<p>Please log in to view your details.</p>";
    exit();
}

// Database connection
$mysqli = new mysqli('localhost', 'root', '', 'kibweziwest');
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

// Fetch applicant details
$user_id = $_SESSION['user_id'];
$stmt = $mysqli->prepare("SELECT id_number, first_name, middle_name, last_name, ward, pollingstation, email, phone, created_at FROM applicants WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo "<p>Applicant details not found.</p>";
    exit();
}

$user = $result->fetch_assoc();
$stmt->close();
$mysqli->close();

// ---------------------------
// PDF DOWNLOAD HANDLER
// ---------------------------
if (isset($_POST['download_pdf'])) {
    require_once __DIR__ . '/../fpdf/fpdf.php';

    class ApplicationPDF extends FPDF {
        function Header() {
            $logoPath = __DIR__ . '/logo.png';
            if(file_exists($logoPath)) $this->Image($logoPath, 10, 8, 25);

            $this->SetFont('Arial', 'B', 16);
            $this->SetTextColor(0, 51, 102);
            $this->Cell(0, 10, 'KIBWEZI WEST CONSTITUENCY', 0, 1, 'C');

            $this->SetFont('Arial', 'B', 14);
            $this->Cell(0, 10, 'APPLICATION DETAILS', 0, 1, 'C');

            $this->SetDrawColor(0, 51, 102);
            $this->SetLineWidth(0.5);
            $this->Line(10, 30, 200, 30);
            $this->Ln(10);
        }

        function Footer() {
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            $this->SetTextColor(128, 128, 128);
            $this->Cell(0, 10, 'Page '.$this->PageNo().' of {nb}', 0, 0, 'C');
            $this->SetX(-40);
            $this->Cell(0, 10, date('Y-m-d H:i:s'), 0, 0, 'R');
        }
    }

    $pdf = new ApplicationPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();

    // PERSONAL INFO
    $pdf->SetFont('Arial','B',12);
    $pdf->SetFillColor(230,230,230);
    $pdf->Cell(0,10,'PERSONAL INFORMATION',0,1,'L',true);
    $pdf->Ln(5);

    $pdf->SetFont('Arial','',11);
    $personalDetails = [
        ['ID Number', $user['id_number']],
        ['Full Name', $user['first_name'].' '.$user['middle_name'].' '.$user['last_name']],
        ['Email', $user['email']],
        ['Phone', $user['phone']]
    ];
    foreach($personalDetails as $d){
        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(50,8,$d[0],0,0);
        $pdf->SetFont('Arial','',11);
        $pdf->MultiCell(0,8,$d[1],0,1);
    }

    // LOCATION INFO
    $pdf->Ln(5);
    $pdf->SetFont('Arial','B',12);
    $pdf->SetFillColor(230,230,230);
    $pdf->Cell(0,10,'LOCATION INFORMATION',0,1,'L',true);
    $pdf->Ln(5);

    $locationDetails = [
        ['Ward', $user['ward']],
        ['Polling Station', $user['pollingstation']]
    ];
    foreach($locationDetails as $d){
        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(50,8,$d[0],0,0);
        $pdf->SetFont('Arial','',11);
        $pdf->MultiCell(0,8,$d[1],0,1);
    }

    // REGISTRATION INFO
    $pdf->Ln(5);
    $pdf->SetFont('Arial','B',12);
    $pdf->SetFillColor(230,230,230);
    $pdf->Cell(0,10,'REGISTRATION INFORMATION',0,1,'L',true);
    $pdf->Ln(5);

    $registrationDetails = [
        ['Registration Date', $user['created_at']],
        ['Document Generated', date('Y-m-d H:i:s')]
    ];
    foreach($registrationDetails as $d){
        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(50,8,$d[0],0,0);
        $pdf->SetFont('Arial','',11);
        $pdf->MultiCell(0,8,$d[1],0,1);
    }

    $pdf->Ln(10);
    $pdf->SetFont('Arial','I',10);
    $pdf->MultiCell(0,8,'This document is an official record of your application with Kibwezi West Constituency. Please keep it for your records.',0,'C');

    $pdf->Ln(10);
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(0,8,'________________________________',0,1,'C');
    $pdf->Cell(0,5,'Official Stamp/Signature',0,1,'C');

    $filename = 'Application_'.$user['id_number'].'_'.date('Ymd').'.pdf';
    $pdf->Output('D', $filename);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Applicant Details - Kibwezi West</title>
<style>
body{font-family:'Segoe UI',sans-serif;background:#f5f7fa;padding:20px;}
.details-container{background:#fff;border-radius:12px;max-width:900px;margin:0 auto;padding:30px;box-shadow:0 10px 30px rgba(0,0,0,0.1);}
.header-section{display:flex;justify-content:space-between;align-items:center;margin-bottom:25px;padding-bottom:20px;border-bottom:3px solid #003366;}
.logo-title{display:flex;align-items:center;gap:15px;}
.logo-img{height:60px;width:auto;}
.title-text{font-size:28px;font-weight:700;color:#003366;text-transform:uppercase;letter-spacing:1px;}
.subtitle{color:#666;font-size:16px;margin-top:5px;font-weight:normal;}
.download-btn{background:#28a745;color:#fff;border:none;padding:12px 25px;border-radius:8px;cursor:pointer;font-size:15px;transition:all 0.3s ease;font-weight:600;}
.download-btn:hover{background:#218838;}
.details-table{width:100%;border-collapse:separate;border-spacing:0;background:#fff;border-radius:8px;overflow:hidden;margin:25px 0;box-shadow:0 2px 10px rgba(0,0,0,0.05);}
.details-table tr:nth-child(even){background:#f8f9fa;}
.details-table td{padding:16px 20px;border-bottom:1px solid #e0e0e0;font-size:15px;}
.details-label{font-weight:600;color:#003366;width:35%;border-right:1px solid #e0e0e0;}
.details-value{color:#333;font-weight:500;}
.action-buttons{display:flex;justify-content:center;gap:20px;margin-top:40px;padding-top:30px;border-top:1px solid #e0e0e0;}
.btn-print{background:#17a2b8;color:#fff;border:none;padding:12px 25px;border-radius:8px;cursor:pointer;font-size:15px;transition:all 0.3s ease;font-weight:600;}
.btn-print:hover{background:#138496;}
/* Media Queries for Responsiveness */
/* Tablets */
@media (max-width: 992px) {
    .details-container {
        padding: 20px;
    }
    .title-text {
        font-size: 24px;
    }
    .subtitle {
        font-size: 14px;
    }
    .download-btn, .btn-print {
        padding: 10px 20px;
        font-size: 14px;
    }
    .details-table td {
        padding: 12px 15px;
        font-size: 14px;
    }
    .details-label {
        width: 40%;
    }
}

/* Mobile Phones */
@media (max-width: 600px) {
    .header-section {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
    .logo-title {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    .title-text {
        font-size: 20px;
    }
    .subtitle {
        font-size: 12px;
    }
    .download-btn, .btn-print {
        width: 100%;
        padding: 10px;
        font-size: 14px;
    }
    .details-table td {
        display: block;
        width: 100%;
        box-sizing: border-box;
    }
    .details-label {
        border-right: none;
        padding-bottom: 5px;
        font-weight: 700;
        color: #003366;
    }
    .details-value {
        padding-bottom: 15px;
    }
    .action-buttons {
        flex-direction: column;
        gap: 15px;
    }
}
</style>
</head>
<body>
<div class="details-container">
    <div class="header-section">
        <div class="logo-title">
            <?php if(file_exists(__DIR__.'/logo.png')): ?>
                <img src="logo.png" class="logo-img" alt="Logo">
            <?php endif; ?>
            <div>
                <div class="title-text">Applicant Details</div>
                <div class="subtitle">Kibwezi West Constituency</div>
            </div>
        </div>

        <form method="POST" action="downloadPDF.php" style="display:inline;">
        <button type="submit" class="download-btn">Download PDF</button>
        </form>
    </div>

    <table class="details-table">
        <tr><td class="details-label">ID Number</td><td class="details-value"><?= htmlspecialchars($user['id_number']) ?></td></tr>
        <tr><td class="details-label">Full Name</td><td class="details-value"><?= htmlspecialchars($user['first_name'].' '.$user['middle_name'].' '.$user['last_name']) ?></td></tr>
        <tr><td class="details-label">Email</td><td class="details-value"><?= htmlspecialchars($user['email']) ?></td></tr>
        <tr><td class="details-label">Phone</td><td class="details-value"><?= htmlspecialchars($user['phone']) ?></td></tr>
        <tr><td class="details-label">Ward</td><td class="details-value"><?= htmlspecialchars($user['ward']) ?></td></tr>
        <tr><td class="details-label">Polling Station</td><td class="details-value"><?= htmlspecialchars($user['pollingstation']) ?></td></tr>
        <tr><td class="details-label">Registration Date</td><td class="details-value"><?= htmlspecialchars($user['created_at']) ?></td></tr>
    </table>

    <div class="action-buttons">
        <button onclick="window.print()" class="btn-print">Print This Page</button>
    </div>
</div>
</body>
</html>
