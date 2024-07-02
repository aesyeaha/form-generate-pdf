<?php
// Configuration
$pdf_font = 'Helvetica';
$pdf_font_size = 12;
$pdf_paper_size = 'F4';
$pdf_orientation = 'P'; // Portrait

// Get form data
$nomor_surat = $_POST['nomor_surat'];
$tanggal_surat = $_POST['tanggal_surat'];
$perihal = $_POST['perihal'];
$penerima_alamat_surat = $_POST['penerima_alamat_surat'];
$salam_pembuka = $_POST['salam_pembuka'];
$paragraf_pertama = $_POST['paragraf_pertama'];
$tabel_data = json_decode($_POST['tabel_data'], true);
$isi_nomor_data = json_decode($_POST['isi_nomor_data'], true);
$paragraf_kedua = $_POST['paragraf_kedua'];
$penutup = $_POST['penutup'];
$isi_lampiran = $_POST['isi_lampiran'];

// Create PDF
require_once 'tcpdf/tcpdf.php';
$pdf = new TCPDF($pdf_orientation, PDF_UNIT, $pdf_paper_size, true, 'UTF-8', false);

// Set font and font size
$pdf->SetFont($pdf_font, '', $pdf_font_size);

$pdf->SetMargins(20, 20, 20); // set margins to 20 units
$pdf->SetAutoPageBreak(true, 20); // set auto page break with a margin of 20 units

// Add page
$pdf->AddPage();

// Header
$pdf->Image('permata-logo.jpg', 20, 20, 20, 20); 
$pdf->SetFont($pdf_font, '', $pdf_font_size);
$pdf->SetTextColor(69, 143, 157); // Set font color to #458F9D
$pdf->Cell(0, 10, 'YAYASAN PERMATA MOJOKERTO', 0, 1, 'C');
$pdf->SetFont($pdf_font, 'B', $pdf_font_size);
$pdf->Cell(0, 10, 'SEKOLAH DASAR ISLAM TERPADU PERMATA', 0, 2, 'C');
$pdf->SetFont($pdf_font, '', $pdf_font_size);
$pdf->Cell(0, 10, 'LINGK. KUWUNG RT. 02 RW. 03 MERI, KEC. KRANGGAN', 0, 1, 'C');
$pdf->Cell(0, 10, 'TELP. (0321) 5885631 KOTA MOJOKERTO', 0, 1, 'C');

// Add a line separator
$pdf->SetLineWidth(1);
$pdf->SetDrawColor(69, 143, 157); 
$pdf->Line(20, $pdf->GetY(), 190, $pdf->GetY()); // Draw a line from x=20 to x=190 at the current y position

// Reset font color to black
$pdf->SetTextColor(0, 0, 0);

// Content
$pdf->Ln(2);
$pdf->SetFont($pdf_font, '', $pdf_font_size);
$pdf->Cell(0, 10, 'Nomor Surat: '. $nomor_surat, 0, 1, 'L');
$pdf->Cell(0, 10, 'Tanggal Surat: '. $tanggal_surat, 0, 1, 'L');
$pdf->Cell(0, 10, 'Perihal: '. $perihal, 0, 1, 'L');

// Add a line break
$pdf->Ln(2);

// Isi Surat
$pdf->SetFont($pdf_font, '', $pdf_font_size);
$pdf->MultiCell(0, 10, 'Penerima dan Alamat Surat: '. $penerima_alamat_surat, 0, 'L');
$pdf->MultiCell(0, 10, $salam_pembuka, 0, 'L');
$pdf->MultiCell(0, 10, $paragraf_pertama, 0, 'L');

// print the isi nomor list
$pdf->Ln(1);
$pdf->Cell(0, 10, '', 0, 1, 'L');
foreach ($isi_nomor_data as $i => $isi_nomor) {
    $pdf->Cell(0, 10, ($i + 1). '. '. $isi_nomor, 0, 1, 'L');
}

// print the table
$pdf->Ln(1);
$pdf->Cell(0, 10, '', 0, 1, 'L');

// get the number of columns and rows
$num_cols = count($tabel_data[0]);
$num_rows = count($tabel_data);

// set the table headers
$headers = array_keys($tabel_data[0]);

// print the table headers with borders
$pdf->SetFont('helvetica', 'B', 12);
$widths = array(30, 50, 50, 50); // adjust the widths to fit your table
for ($j = 0; $j < $num_cols; $j++) {
    $pdf->Cell($widths[$j], 10, $headers[$j], 1, 0, 'C', false);
}
$pdf->Ln(10);
$pdf->SetFont('helvetica', '', 12);

// print the table data with borders
for ($i = 0; $i < $num_rows; $i++) {
    $row = $tabel_data[$i];
    for ($j = 0; $j < $num_cols; $j++) {
        $pdf->Cell($widths[$j], 10, $row[$headers[$j]], 1, 0, 'L', false);
    }
    $pdf->Ln(10);
}

// Add a line break
$pdf->Ln(2);

// Paragraf Kedua
$pdf->SetFont($pdf_font, '', $pdf_font_size);
$pdf->MultiCell(0, 10, $paragraf_kedua, 0, 'L');

// Add a line break
$pdf->Ln(2);

// Penutup
$pdf->SetFont($pdf_font, '', $pdf_font_size);
$pdf->MultiCell(0, 10, $penutup, 0, 'L');

// Add a line break
$pdf->Ln(2);

// Isi Lampiran
$pdf->SetFont($pdf_font, '', $pdf_font_size);
$pdf->MultiCell(0, 10, $isi_lampiran, 0, 'L');

// Footer
$pdf->SetFont($pdf_font, '', $pdf_font_size);
$pdf->Cell(0, 10, 'Kepala Sekolah', 0, 1, 'R');
$pdf->Cell(0, 20, '', 0, 1, 'R');
$pdf->Cell(0, 10, 'ANDIKA SETYOBUDI, S.Si.', 0, 1, 'R');

// Output PDF
$pdf->Output('invoice.pdf', 'I');
?>