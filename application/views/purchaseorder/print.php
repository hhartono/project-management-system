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
    $this->fpdf->SetAutoPageBreak(true,0);

    // Setting Font : String Family, String Style, Font size
    $this->fpdf->SetFont('Arial','',12);

    /* Kita akan membuat header dari halaman pdf yang kita buat
    ————– Header Halaman dimulai dari baris ini —————————–
    */
    $this->fpdf->Cell(19,0.7,'P.O Reference    : '.$detail['reference'],0,0,'R');
    $this->fpdf->Ln();
    $this->fpdf->Cell(19,0.7,'P.O Date : '.$detail['date'],0,0,'R');
    $this->fpdf->Image('assets/images/INERRE_Logo.png', 2,1,3,3.5);
    // fungsi Ln untuk membuat baris baru
    $this->fpdf->Ln();
    $this->fpdf->SetFont('Arial','',16);
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
    $this->fpdf->Cell(19,0.5,'PURCHASE ORDER',0,0,'C');

    /* Fungsi Line untuk membuat garis */
    $this->fpdf->SetDrawColor(200,127,40);
    $this->fpdf->Line(1,5,20,5);

    /* ————– Header Halaman selesai ————————————————*/

    $this->fpdf->Ln(2.5);
    $this->fpdf->SetFont('Arial','B',12);
   
    $this->fpdf->Cell(12,1,'Order To ',0,0,'L');
    $this->fpdf->Cell(10,1,'Deliver To ',0,0,'L');
    $this->fpdf->Ln(1);
    if($deliver == 'project' || $deliver == ''){
        $this->fpdf->Cell(12,1,$detail['name'],0,0,'L');
        $this->fpdf->Cell(10,1,$detail['project'],0,0,'L');
        $this->fpdf->Ln(0.5);
        $this->fpdf->SetFont('Arial','',12);
        if (!empty($detail['address'])){
        $this->fpdf->Cell(12,1,$detail['address'],0,0,'L');
        $this->fpdf->Cell(10,1,$detail['alamat'],0,0,'L');
        $this->fpdf->Ln(0.5);
        }else{}
        if (!empty($detail['city'])){
        $this->fpdf->Cell(10,1,$detail['city'].', '. $detail['province'].' '. $detail['postal_code'],0,0,'L');
        $this->fpdf->Ln(1);
        }else{}
        $this->fpdf->Cell(3,1,'Phone',0,0,'L');
        $this->fpdf->Cell(9,1,': '.$detail['phone_number_1'].'',0,0,'L');
        $this->fpdf->Ln(0.5);
        $this->fpdf->Cell(3,1,'e-mail',0,0,'L');
        $this->fpdf->Cell(9,1,': '.$detail['email'].'',0,0,'L');
        $this->fpdf->Ln(0.5);
        $this->fpdf->Cell(3,1,'Attn',0,0,'L');
        $this->fpdf->Cell(9,1,': '.$attn.'',0,0,'L');
    }else{
        $this->fpdf->Cell(12,1,$detail['name'],0,0,'L');
        $this->fpdf->Cell(10,1,'INERRE Interior',0,0,'L');
        $this->fpdf->Ln(0.5);
        $this->fpdf->SetFont('Arial','',12);
        if (!empty($detail['address'])){
        $this->fpdf->Cell(12,1,$detail['address'],0,0,'L');
        $this->fpdf->Cell(10,1,'Jl. Pasteur 11',0,0,'L');
        $this->fpdf->Ln(0.5);
        }else{}
        if (!empty($detail['city'])){
        $this->fpdf->Cell(12,1,$detail['city'].', '. $detail['province'].' '. $detail['postal_code'],0,0,'L');
        $this->fpdf->Cell(10,1,'Bandung, 40116',0,0,'L');
        $this->fpdf->Ln(1);
        }else{}
        $this->fpdf->Cell(3,1,'Phone',0,0,'L');
        $this->fpdf->Cell(9,1,': '.$detail['phone_number_1'].'',0,0,'L');
        $this->fpdf->Cell(3,1,'Phone',0,0,'L');
        $this->fpdf->Cell(7,1,': +62 22 4232200',0,0,'L');
        $this->fpdf->Ln(0.5);
        $this->fpdf->Cell(3,1,'e-mail',0,0,'L');
        $this->fpdf->Cell(9,1,': '.$detail['email'].'',0,0,'L');
        $this->fpdf->Cell(3,1,'e-mail',0,0,'L');
        $this->fpdf->Cell(7,1,': hans@inerre.com',0,0,'L');
        $this->fpdf->Ln(0.5);
        $this->fpdf->Cell(3,1,'Attn',0,0,'L');
        $this->fpdf->Cell(9,1,': '.$attn.'',0,0,'L');
        $this->fpdf->Cell(3,1,'Attn',0,0,'L');
        $this->fpdf->Cell(7,1,': Hans Hartono',0,0,'L');
    }
    
    
    /* setting header table */
    $this->fpdf->Ln(1.5);
    $this->fpdf->SetFont('Arial','B',12);
    $this->fpdf->Cell(10 , 1, 'Nama Barang' , 1, 'LR', 'C');
    $this->fpdf->Cell(5 , 1, 'Jumlah Dipesan' , 1, 'LR', 'C');
    $this->fpdf->Cell(4 , 1, 'Satuan' , 1, 'LR', 'C');
    foreach($po as $po){
        $this->fpdf->Ln();
        $this->fpdf->SetFont('Arial','',12);
        $this->fpdf->Cell(10 , 0.7, $po['item_name'] , 1, 'LR', 'L');
        $this->fpdf->Cell(5 , 0.7, $po['quantity'] , 1, 'LR', 'L');
        $this->fpdf->Cell(4 , 0.7, $po['unit_name'] , 1, 'LR', 'L');
    }
    $this->fpdf->Ln();
    $this->fpdf->Cell(10,1,'',0,0,'L');
    $this->fpdf->Cell(12,1,'Authorized by : ',0,0,'L');
    $this->fpdf->Ln(2);
    $this->fpdf->Cell(10,1,'',0,0,'L');
    $this->fpdf->Cell(5,1,'Hans Hartono',0,0,'L');
    $this->fpdf->Cell(7,1,date('M d, Y'),0,0,'L');
    $this->fpdf->Ln(0.8);
    $this->fpdf->Cell(10,0,'',0,0,'L');
    $this->fpdf->Cell(12,0,'_______________________________________',0,0,'L');
    $this->fpdf->Ln(0.5);
    $this->fpdf->Cell(10,0,'',0,0,'L');
    $this->fpdf->Cell(5,0,'Name',0,0,'L');
    $this->fpdf->Cell(7,0,'Date',0,0,'L');
    /* setting posisi footer 3 cm dari bawah */

    

    /* setting font untuk footer */
    $this->fpdf->SetY(-2.5);
    $this->fpdf->SetFont('Arial','',9);
    $this->fpdf->Cell(19,1,'a. Jl. Pasteur 11, Bandung 40116, West Java - Indonesia',0,0,'C');
    $this->fpdf->Ln();
    $this->fpdf->Cell(8,0,'t. +6222 423 2200     //',0,0,'R');
    $this->fpdf->Cell(3,0,'f. +6222 426 6618',0,0,'C');
    $this->fpdf->Cell(8,0,'//     e. info@inerre.com',0,0,'L');
    $this->fpdf->Ln();
    $this->fpdf->Cell(19,1,'www.inerre.com',0,0,'C');
    /* setting cell untuk waktu pencetakan */
    //$this->fpdf->Cell(9.5, 0.5, 'Printed on : '.date('d/m/Y H:i'));

    /* setting cell untuk page number */
    //$this->fpdf->Cell(9.5, 0.5, 'Page '.$this->fpdf->PageNo().'/{nb}',0,0,'R');
    

    /* generate pdf jika semua konstruktor, data yang akan ditampilkan, dll sudah selesai */
    $this->fpdf->Output("project_detail.pdf","I");
?>