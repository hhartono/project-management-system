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
    $this->fpdf->SetFont('Arial','B',18);

    /* Kita akan membuat header dari halaman pdf yang kita buat
    ————– Header Halaman dimulai dari baris ini —————————–
    */
    $this->fpdf->Cell(19,0.7,'',0,0,'C');
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
    $this->fpdf->Cell(19,0.5,'',0,0,'C');

    $this->fpdf->Ln();
    $this->fpdf->Ln();
    $this->fpdf->Cell(19,0.5,'Pattern Warna',0,0,'C');

    /* Fungsi Line untuk membuat garis */
    $this->fpdf->Line(1,5,19,5);
    $this->fpdf->Line(1,5.05,19,5.05);

    /* ————– Header Halaman selesai ————————————————*/

        $this->fpdf->Ln(3);
        $this->fpdf->SetFont('Arial','B',12);
        $this->fpdf->Cell(4,1,'Sub Project : ',0,0,'L');
        $this->fpdf->SetFont('Arial','',12);
    foreach ($subproject as $subprojects) {
        $this->fpdf->Cell(7,1,$subprojects['name'],0,0,'L');
    }
        
    /* setting header table */
    $this->fpdf->Ln(1);
    $this->fpdf->SetFont('Arial','B',12);
    /*$this->fpdf->Cell(9 , 1, 'Pattern' , 1, 'LR', 'C');
    $this->fpdf->Cell(4 , 1, 'Kode Warna' , 1, 'LR', 'C');
    $this->fpdf->Cell(6 , 1, 'Nama' , 1, 'LR', 'C');*/
    foreach($pattern as $pattern){
        $this->fpdf->Ln();
        $this->fpdf->SetFont('Arial','',12);
        $hex = str_replace("#", "", $pattern['hexadecimal']);

           if(strlen($hex) == 3) {
              $r = hexdec(substr($hex,0,1).substr($hex,0,1));
              $g = hexdec(substr($hex,1,1).substr($hex,1,1));
              $b = hexdec(substr($hex,2,1).substr($hex,2,1));
           } else {
              $r = hexdec(substr($hex,0,2));
              $g = hexdec(substr($hex,2,2));
              $b = hexdec(substr($hex,4,2));
           }
        
        $this->fpdf->SetFillColor($r,$g,$b);
        $this->fpdf->Cell(9 , 2, $r,$g,$b , 0, 'LR', 'C');
        $this->fpdf->Cell(4 , 2, $pattern['kode'] , 0, 'LR', 'L');
        $this->fpdf->Cell(6 , 2, $pattern['nama'] , 0, 'LR', 'L');
    }
    
    $this->fpdf->Ln();

    

    /* setting cell untuk waktu pencetakan */
    //$this->fpdf->Cell(9.5, 0.5, 'Printed on : '.date('d/m/Y H:i'));

    /* setting cell untuk page number */
    //$this->fpdf->Cell(18, 0.5, 'Page '.$this->fpdf->PageNo().'/{nb}',0,0,'R');

    /* generate pdf jika semua konstruktor, data yang akan ditampilkan, dll sudah selesai */
    $this->fpdf->Output("eksport_pattern.pdf","I");
?>