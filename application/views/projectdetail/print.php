<?php
    
    date_default_timezone_set('Asia/Jakarta');
    $this->fpdf->FPDF("L","cm","A4");

    // kita set marginnya dimulai dari kiri, atas, kanan. jika tidak diset, defaultnya 1 cm
    $this->fpdf->SetMargins(1,1,1);
    /* AliasNbPages() merupakan fungsi untuk menampilkan total halaman
    di footer, nanti kita akan membuat page number dengan format : number page / total page
    */
    $this->fpdf->AliasNbPages();

    // AddPage merupakan fungsi untuk membuat halaman baru
    $this->fpdf->AddPage();

    // Setting Font : String Family, String Style, Font size
    $this->fpdf->SetFont('Times','B',12);

    /* Kita akan membuat header dari halaman pdf yang kita buat
    ————– Header Halaman dimulai dari baris ini —————————–
    */
    $this->fpdf->Cell(29,0.7,'',0,0,'C');
    $this->fpdf->Image('assets/images/INERRE_Logo.png', 2,1,3,3.5);
    // fungsi Ln untuk membuat baris baru
    $this->fpdf->Ln();

    /* Setting ulang Font : String Family, String Style, Font size
    kenapa disetting ulang ???
    jika tidak disetting ulang, ukuran font akan mengikuti settingan sebelumnya.
    tetapi karena kita menginginkan settingan untuk penulisan alamatnya berbeda,
    maka kita harus mensetting ulang Font nya.
    jika diatas settingannya : helvetica, 'B', '12'
    khusus untuk penulisan alamat, kita setting : helvetica, ", 10
    yang artinya string stylenya normal / tidak Bold dan ukurannya 10
    */
    $this->fpdf->Cell(29,0.5,'',0,0,'C');

    $this->fpdf->Ln();
    $this->fpdf->Ln();
    $this->fpdf->Cell(29,0.5,'PROJECT DETAIL',0,0,'C');

    /* Fungsi Line untuk membuat garis */
    $this->fpdf->Line(1,5,29,5);
    $this->fpdf->Line(1,5.05,29,5.05);

    /* ————– Header Halaman selesai ————————————————*/

    $this->fpdf->Ln(3);
    $this->fpdf->SetFont('Times','B',12);
    $pr='' ;
    foreach($pro as $proj){                        
        if($pr!=$proj['project'])
            {
                $pr=$proj['project'];
                $sp=$proj['name'];
            }
            else
            {
                $pr='';
                $sp='';
            }
    $this->fpdf->Cell(14,1,'Nama Project     : '.$pr.'',0,0,'L');
    $this->fpdf->Ln(1);
    $this->fpdf->Cell(14,1,'Sub Project        : '.$sp.'',0,0,'L');
    }
    /* setting header table */
    $this->fpdf->Ln(1);
    $this->fpdf->SetFont('Times','B',12);
    $this->fpdf->Cell(5 , 1, 'Kategori' , 1, 'LR', 'C');
    $this->fpdf->Cell(9 , 1, 'Nama Barang' , 1, 'LR', 'C');
    $this->fpdf->Cell(2 , 1, 'Quantity' , 1, 'LR', 'C');
    $this->fpdf->Cell(2 , 1, 'Satuan' , 1, 'LR', 'C');
    $this->fpdf->Cell(2 , 1, 'Tukang' , 1, 'LR', 'C');
    $this->fpdf->Cell(4 , 1, 'Harga Satuan' , 1, 'LR', 'C');
    $this->fpdf->Cell(4 , 1, 'Total Harga' , 1, 'LR', 'C');
$category ='';
$total_sum = 0;
    foreach($detail as $details){
        if($category!=$details['category'])
            {
                $category=$details['category'];
            }
            else
            {
            $category='';
            }
        $total=number_format($details['total'],2,',','.'); 
        $harga=number_format($details['harga'],2,',','.');
$this->fpdf->Ln();
$this->fpdf->SetFont('Times','',12);
$this->fpdf->Cell(5 , 0.7, $category , 1, 'LR', 'L');
$this->fpdf->Cell(9 , 0.7, $details['barang'] , 1, 'LR', 'L');
$this->fpdf->Cell(2 , 0.7, $details['quantity'] , 1, 'LR', 'L');
$this->fpdf->Cell(2 , 0.7, $details['satuan'] , 1, 'LR', 'L');
$this->fpdf->Cell(2 , 0.7, $details['tukang'] , 1, 'LR', 'L');
$this->fpdf->Cell(4 , 0.7, $harga , 1, 'LR', 'L');
$this->fpdf->Cell(4 , 0.7, $total , 1, 'LR', 'L');
                            
        $category=$details['category'];
        $total_sum+=$details['total'];
    }
        $jumlah = number_format($total_sum,2,',','.');
$this->fpdf->Ln();
$this->fpdf->Cell(24 , 0.7, 'Total Biaya', 1, 'LR', 'L');
$this->fpdf->Cell(4 , 0.7, $jumlah, 1, 'LR', 'L');

    /* setting posisi footer 3 cm dari bawah */

    $this->fpdf->SetY(-3);

    /* setting font untuk footer */
    $this->fpdf->SetFont('Times','',10);

    /* setting cell untuk waktu pencetakan */
    $this->fpdf->Cell(9.5, 0.5, 'Printed on : '.date('d/m/Y H:i'));

    /* setting cell untuk page number */
    $this->fpdf->Cell(18, 0.5, 'Page '.$this->fpdf->PageNo().'/{nb}',0,0,'R');

    /* generate pdf jika semua konstruktor, data yang akan ditampilkan, dll sudah selesai */
    $this->fpdf->Output("project_detail.pdf","I");
?>