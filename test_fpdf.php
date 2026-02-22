<?php
// test_fpdf.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Testing FPDF Paths</h2>";

// Test different paths
$paths = [
    './fpdf/fpdf.php',
    '../fpdf/fpdf.php',
    'fpdf/fpdf.php',
    '../../fpdf/fpdf.php'
];

foreach ($paths as $path) {
    echo "Testing path: $path - ";
    if (file_exists($path)) {
        echo "<span style='color: green;'>FOUND</span><br>";
    } else {
        echo "<span style='color: red;'>NOT FOUND</span><br>";
    }
}

// Test FPDF inclusion
echo "<h3>Testing FPDF Inclusion</h3>";
$correctPath = '../fpdf/fpdf.php'; // Try this first
if (file_exists($correctPath)) {
    try {
        require_once($correctPath);
        $pdf = new FPDF();
        echo "<span style='color: green;'>✓ FPDF loaded successfully!</span><br>";
        
        // Test simple PDF generation
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(40,10,'Hello World!');
        
        // Save to file first to test
        $testFile = 'test_output.pdf';
        $pdf->Output('F', $testFile);
        
        if (file_exists($testFile)) {
            echo "<span style='color: green;'>✓ PDF created successfully: $testFile</span><br>";
            echo "<a href='$testFile' download>Download Test PDF</a><br>";
        }
        
    } catch (Exception $e) {
        echo "<span style='color: red;'>Error: " . $e->getMessage() . "</span><br>";
    }
} else {
    echo "<span style='color: red;'>FPDF not found at $correctPath</span><br>";
}
?>