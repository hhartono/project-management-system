<?php
    
    date_default_timezone_set('Asia/Jakarta');
    $this->fpdf->FPDF("P","cm","A4");

    // kita set marginnya dimulai dari kiri, atas, kanan. jika tidak diset, defaultnya 1 cm
    $this->fpdf->SetMargins(1,1,1);
    /* AliasNbPages() merupakan fungsi untuk menampilkan total halaman
    di footer, nanti kita akan membuat page number dengan format : number page / total page
    */
    $this->fpdf->AliasNbPages();

    // AddPage merupakan fungsi untuk membuat halaman baru
    $this->fpdf->AddPage();

    // Setting Font : String Family, String Style, Font size
    $this->fpdf->SetFont('Times','',12);

    /* Kita akan membuat header dari halaman pdf yang kita buat
    ————– Header Halaman dimulai dari baris ini —————————–
    */
    $this->fpdf->Cell(19,0.7,'P.O Reference     : '.$detail['reference'],0,0,'R');
$this->fpdf->Ln();
    $this->fpdf->Cell(19,0.7,'P.O Date : '.$detail['date'],0,0,'R');
    $this->fpdf->Image('assets/images/INERRE_Logo.png', 2,1,3,3.5);
    // fungsi Ln untuk membuat baris baru
    $this->fpdf->Ln();
    $this->fpdf->SetFont('Times','',16);
    /* Setting ulang Font : String Family, String Style, Font size
    kenapa disetting ulang ???
    jika tidak disetting ulang, ukuran font akan mengikuti settingan sebelumnya.
    tetapi karena kita menginginkan settingan untuk penulisan alamatnya berbeda,
    maka kita harus mensetting ulang Font nya.
    jika diatas settingannya : helvetica, 'B', '12'
    khusus untuk penulisan alamat, kita setting : helvetica, ", 10
    yang artinya string stylenya normal / tidak Bold dan ukurannya 10
    */
    $this->fpdf->Cell(21,0.5,'',0,0,'C');

    $this->fpdf->Ln();
    $this->fpdf->Ln();
    $this->fpdf->Cell(21,0.5,'PURCHASE ORDER',0,0,'C');

    /* Fungsi Line untuk membuat garis */
    $this->fpdf->Line(1,5,20,5);
    $this->fpdf->Line(1,5.05,20,5.05);

    /* ————– Header Halaman selesai ————————————————*/

    $this->fpdf->Ln(3);
    $this->fpdf->SetFont('Times','B',12);
   
    $this->fpdf->Cell(12,1,'Supplier : '.$detail['name'].'',0,0,'L');
    $this->fpdf->Cell(10,1,'Project : '.$detail['project'].'',0,0,'L');
    $this->fpdf->Ln();
    $this->fpdf->SetFont('Times','',12);
    $this->fpdf->Cell(10,1,$detail['address'],0,0,'L');
    $this->fpdf->Ln();
    $this->fpdf->Cell(10,1,$detail['city'].', '. $detail['province'].' '. $detail['postal_code'],0,0,'L');
    $this->fpdf->Ln(2);
    $this->fpdf->Cell(10,1,'Phone : '.$detail['phone_number_1'].', '.$detail['phone_number_2'],0,0,'L');
    $this->fpdf->Ln();
    $this->fpdf->Cell(10,1,'e-mail : '.$detail['email'].'',0,0,'L');
    $this->fpdf->Ln(1);
    
   
    /* setting header table */
    $this->fpdf->Ln(2);
    $this->fpdf->SetFont('Times','B',12);
    $this->fpdf->Cell(10 , 1, 'Nama Barang' , 1, 'LR', 'C');
    $this->fpdf->Cell(5 , 1, 'Jumlah Dipesan' , 1, 'LR', 'C');
    $this->fpdf->Cell(4 , 1, 'Satuan' , 1, 'LR', 'C');
    foreach($po as $po){
        $this->fpdf->Ln();
        $this->fpdf->SetFont('Times','',12);
        $this->fpdf->Cell(10 , 0.7, $po['item_name'] , 1, 'LR', 'L');
        $this->fpdf->Cell(5 , 0.7, $po['quantity'] , 1, 'LR', 'L');
        $this->fpdf->Cell(4 , 0.7, $po['unit_name'] , 1, 'LR', 'L');
    }
    $this->fpdf->Ln();

    /* setting posisi footer 3 cm dari bawah */

    $this->fpdf->SetY(-3);

    /* setting font untuk footer */
    $this->fpdf->SetFont('Times','',10);

    /* setting cell untuk waktu pencetakan */
    $this->fpdf->Cell(9.5, 0.5, 'Printed on : '.date('d/m/Y H:i'));

    /* setting cell untuk page number */
    $this->fpdf->Cell(9.5, 0.5, 'Page '.$this->fpdf->PageNo().'/{nb}',0,0,'R');

    /* generate pdf jika semua konstruktor, data yang akan ditampilkan, dll sudah selesai */
    $this->fpdf->Output("project_detail.pdf","I");
?>