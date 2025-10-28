<?php
include '../php/db_connect.php';
$type = $_GET['type'] ?? 'excel';

$query = $conn->query("
  SELECT p.name, SUM(oi.quantity) AS qty, SUM(oi.quantity * oi.price) AS revenue
  FROM order_items oi
  JOIN products p ON oi.product_id = p.id
  GROUP BY oi.product_id
  ORDER BY qty DESC
");

if ($type === 'excel') {
  header("Content-Type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=sales_report.xls");
  echo "Product\tQuantity Sold\tRevenue (KSh)\n";
  while ($row = $query->fetch_assoc()) {
    echo "{$row['name']}\t{$row['qty']}\t{$row['revenue']}\n";
  }
} else {
  require('../php/fpdf/fpdf.php');
  $pdf = new FPDF();
  $pdf->AddPage();
  $pdf->SetFont('Arial','B',14);
  $pdf->Cell(0,10,'Sales Summary Report',0,1,'C');
  $pdf->Ln(5);
  $pdf->SetFont('Arial','B',12);
  $pdf->Cell(80,10,'Product',1);
  $pdf->Cell(40,10,'Qty Sold',1);
  $pdf->Cell(60,10,'Revenue (KSh)',1);
  $pdf->Ln();
  $pdf->SetFont('Arial','',12);
  while ($row = $query->fetch_assoc()) {
    $pdf->Cell(80,10,$row['name'],1);
    $pdf->Cell(40,10,$row['qty'],1);
    $pdf->Cell(60,10,number_format($row['revenue'],2),1);
    $pdf->Ln();
  }
  $pdf->Output('D','sales_report.pdf');
}
exit;
?>
