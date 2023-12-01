<?php

//call the FPDF library
require('fpdf/fpdf.php');
include_once '../API/connectdb.php';

$id = $_GET["id"];

$font_fam = "Helvetica";
// Fetch invoice details from the new 'invoice' table
$select = $pdo->prepare("SELECT * FROM invoice WHERE invoice_id = :id");
$select->bindParam(":id", $id);
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);

$pdf = new FPDF('P', 'mm', array(80, 220));
$pdf->SetMargins(0, 0);
$pdf->SetY(0);


$pdf->AddPage();
// Company Details
$pdf->Image('../images/bill_icon.png', 35, 0, 10);
$pdf->Ln(8);


$pdf->SetFont($font_fam, 'B', 12);
$pdf->Cell(80, 5, 'SALAA SUPER', 0, 1, 'C');

$pdf->SetFont($font_fam, '', 8);
$pdf->Cell(80, 5, 'Matale Junction, Anuradhapura', 0, 1, 'C');
$pdf->Cell(80, 5, 'Contact : 076 6821877/ 071 0129888', 0, 1, 'C');
$pdf->Ln(5);

// Bill Details
// Set the X position for 5mm from left
$pdf->SetX(0);

$pdf->SetFont($font_fam, '', 8);
// Concatenate "Bill No" and the actual invoice ID, then display in one cell.
$billInfo = 'Bill No: ' . $row->invoice_id;
$pdf->Cell(30, 2, $billInfo, 0, 0);  // Adjust the width to 30 or as per your requirement

// Set the X position such that "Date" starts 5mm from the right edge
$pdf->SetX(60); // 80mm (total width) - 5mm (right margin) - 20mm (width of Date cell) = 55mm

// Concatenate "Date" and the actual date, then display in one cell.
$date_time_info = 'Date Time: ' . $row->date_time;
$pdf->Cell(20, 2, $date_time_info, 0, 1, 'R');  // Adjust width to 20, right-align it, and add line break
//$pdf->Ln(5);

$pdf->SetX(0);
$pdf->SetFont($font_fam, '', 8);

$dotted_line = "_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _";
$pdf->Cell(70, 1, $dotted_line, 0, 0, 'L');

$pdf->SetX(0);
$pdf->Ln(4);
// Table Headers
$pdf->SetFont($font_fam, 'B', 7);
// Adjust the widths to match the item rows
$pdf->SetX(0);
$pdf->Cell(26, 4, 'Item', 0, 0, 'L'); // Adjust the width as needed
$pdf->Cell(10, 4, 'Qty', 0, 0, 'C'); // Adjust the width as needed
$pdf->Cell(15, 4, 'Price', 0, 0, 'R'); // Adjust the width as needed
$pdf->Cell(15, 4, 'Our Price', 0, 0, 'R'); // Adjust the width as needed
$pdf->Cell(14, 4, 'Amt', 0, 1, 'R'); // Adjust the width as needed

// Draw a dotted line for header
$pdf->SetX(0);
$pdf->SetFont($font_fam, '', 8);
$pdf->Cell(70, 1, $dotted_line, 0, 0, 'L');
$pdf->Ln(3);

// Fetch product details from the new 'invoice_details' and related tables
$select = $pdo->prepare("SELECT
    product.product as product_name,
    invoice_details.qty as qty,
    invoice_details.unit_price as rate,
    invoice_details.ourprice as ourprice
FROM invoice_details
JOIN product ON invoice_details.product_id = product.pid
WHERE invoice_details.invoice_id = :id");

$select->bindParam(":id", $id);
$select->execute();

$lastY = $pdf->GetY();  // Store the Y position after the last product line for the dotted line

$char_limit = 20; // Adjust the limit as needed
$line_height = 3; // Adjust the line height as needed

while ($product = $select->fetch(PDO::FETCH_OBJ)) {
  // Calculate the starting Y position for this row
  $startY = $pdf->GetY();
  $pdf->SetX(0);

  // Print the product name, using MultiCell if it's longer than the char limit
  $pdf->SetFont($font_fam, '', 6);
  $pdf->MultiCell(26, $line_height, $product->product_name, 0, 'L');

  // Get the Y position after printing the product name
  $endY = $pdf->GetY();

  // The height of the next cells depends on whether the product name was wrapped
  $cell_height = $endY - $startY;

  $pdf->SetFont($font_fam, '', 7);

  // Set the X and Y position for the Qty cell
  $pdf->SetXY(26, $startY);
  $pdf->Cell(10, $cell_height, $product->qty, 0, 0, 'C');

  // Set the X and Y position for the Price cell
  $pdf->SetXY(36, $startY);
  $pdf->Cell(15, $cell_height, number_format($product->rate, 2), 0, 0, 'R');

  $pdf->SetXY(51, $startY); // Adjust the X position for Our Price
  $pdf->Cell(15, $cell_height, number_format($product->ourprice, 2), 0, 0, 'R');

  // Set the X and Y position for the Amount cell
  $pdf->SetXY(66, $startY);
  $pdf->Cell(14, $cell_height, number_format($product->qty * $product->ourprice, 2), 0, 0, 'R');

  // Update the lastY position to the endY for the next row
  $lastY = $endY;

  // Move the cursor to the next line with a small margin below
  $pdf->SetY($lastY + 1); // Adjust this value as needed to increase space between rows
}


// Draw a dotted line for header
$pdf->SetX(0);
$pdf->SetFont($font_fam, '', 8);
$pdf->Cell(70, 0, $dotted_line, 0, 0, 'L');
$pdf->Ln(5);

$pdf->SetFont($font_fam, '', 8);

//// Subtotal
//$pdf->SetX(0);
//$pdf->Cell(53, 5, 'Subtotal', 0, 0, 'L');
//$pdf->SetX(60);
//$pdf->Cell(20, 5, number_format($row->subtotal, 2), 0, 1, 'R');

// Discount
$pdf->SetX(0);
$pdf->Cell(53, 5, 'Total Discount', 0, 0, 'L');
$pdf->SetX(60);
$pdf->Cell(20, 5, number_format($row->discount, 2), 0, 1, 'R');

// Total
$pdf->SetFont($font_fam, 'B', 8);
$pdf->SetX(0);
$pdf->Cell(53, 5, 'Total After Applying Discount', 0, 0, 'L');
$pdf->SetX(60);
$pdf->Cell(20, 5, number_format($row->total, 2), 0, 1, 'R');

// Paid
$pdf->SetFont($font_fam, '', 8);
$pdf->SetX(0);
$pdf->Cell(53, 5, 'Paid', 0, 0, 'L');
$pdf->SetX(60);
$pdf->Cell(20, 5, number_format($row->paid, 2), 0, 1, 'R');

// Due
$pdf->SetFont($font_fam, 'B', 8);
$pdf->SetX(0);
$pdf->Cell(53, 5, 'Balance', 0, 0, 'L');
$pdf->SetX(60);
$pdf->Cell(20, 5, number_format($row->due * -1, 2), 0, 1, 'R');

// Draw a dotted line for header
$pdf->SetX(0);
$pdf->SetFont($font_fam, '', 8);
$pdf->Cell(70, 0, $dotted_line, 0, 0, 'L');
$pdf->Ln(3);
$pdf->Ln(1);

$pdf->SetX(15);
$pdf->SetFont($font_fam, 'B', 8);
$pdf->Cell(50, 5, 'Important Notice', 0, 1, 'C');

$pdf->SetX(10);
$pdf->SetFont($font_fam, '', 7);
$pdf->Cell(60, 3, "No product will be replaced or refunded if you don't have bill with", 0, 2, 'C');
$pdf->Cell(50, 3, 'you. You can refund within 2 days of purchase.', 0, 2, 'L');

$pdf->Output();

?>

