<?php
require 'cek_session.php';
require 'koneksi.php';

// Include library FPDF
require('fpdf/fpdf.php'); // Sesuaikan path jika perlu

// Query data
$data = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY id DESC");

// Create PDF
class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Logo - DIKOMENTARI atau DIGANTI dengan gambar lokal
        // $this->Image('https://via.placeholder.com/30x30/667eea/ffffff?text=INV', 10, 6, 30);
        
        // Atau gunakan gambar lokal jika ada:
        // $this->Image('logo.png', 10, 6, 30);
        
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30, 10, 'LAPORAN DATA BARANG INVENTARIS', 0, 0, 'C');
        // Line break
        $this->Ln(20);
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    // Colored table
    function FancyTable($header, $data)
    {
        // Colors, line width and bold font
        $this->SetFillColor(102, 126, 234);
        $this->SetTextColor(255);
        $this->SetDrawColor(102, 94, 162);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');
        
        // Header
        $w = array(10, 30, 40, 25, 25, 20, 20, 20, 40);
        for($i=0; $i<count($header); $i++)
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        $this->Ln();
        
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        
        // Data
        $fill = false;
        $no = 1;
        
        while($row = mysqli_fetch_assoc($data)) {
            $this->Cell($w[0], 6, $no, 'LR', 0, 'C', $fill);
            $this->Cell($w[1], 6, $row['kode_brg'], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, $row['nama'], 'LR', 0, 'L', $fill);
            $this->Cell($w[3], 6, $row['kategori'], 'LR', 0, 'L', $fill);
            $this->Cell($w[4], 6, $row['merk'], 'LR', 0, 'L', $fill);
            $this->Cell($w[5], 6, $row['kondisi'], 'LR', 0, 'C', $fill);
            $this->Cell($w[6], 6, $row['jumlah'], 'LR', 0, 'C', $fill);
            $this->Cell($w[7], 6, $row['satuan'], 'LR', 0, 'C', $fill);
            $this->Cell($w[8], 6, substr($row['keterangan'], 0, 20) . '...', 'LR', 0, 'L', $fill);
            $this->Ln();
            $fill = !$fill;
            $no++;
        }
        
        // Closing line
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

// Instanciation of inherited class
$pdf = new PDF('L'); // Landscape orientation
$pdf->AliasNbPages();
$pdf->AddPage();

// Judul Laporan
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Sistem Inventaris Barang - ' . date('d/m/Y'), 0, 1, 'C');
$pdf->Ln(5);

// Kolom header tabel
$header = array('No', 'Kode Barang', 'Nama', 'Kategori', 'Merk', 'Kondisi', 'Jumlah', 'Satuan', 'Keterangan');

// Data untuk tabel
$pdf->FancyTable($header, $data);

// Info tambahan
$pdf->Ln(10);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 10, 'Total Data: ' . mysqli_num_rows($data), 0, 1, 'L');
$pdf->Cell(0, 10, 'Dicetak oleh: ' . $_SESSION['nama'] . ' (' . $_SESSION['username'] . ')', 0, 1, 'L');
$pdf->Cell(0, 10, 'Tanggal Cetak: ' . date('d-m-Y H:i:s'), 0, 1, 'L');

// Output PDF
$pdf->Output('D', 'Laporan_Inventaris_' . date('Ymd_His') . '.pdf');

// Close connection
mysqli_close($koneksi);
?>