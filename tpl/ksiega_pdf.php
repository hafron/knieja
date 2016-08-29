<?php
// Include the main TCPDF library (search for installation path).
require_once('TCPDF/tcpdf.php');

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
    }
    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', '', 10);
        // Page number
        $this->Cell(0, 10, $this->getAliasNumPage(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Gandhi');
$pdf->SetTitle('Księga Czynów 1NGDH "Knieja"');
$pdf->SetSubject('');
$pdf->SetKeywords('');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 14, '', true);



// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print


function genLight($light) {
    global $czyny, $czyny_harcerze, $pdf;
    
    // Add a page
    // This method has several options, check the source code documentation for more information.
    $pdf->AddPage();
    
    $html = '';
    $result = $czyny->get_light($light);
    $kategoria = '';
    while($czyn = $result->fetchArray()) {
        if ($kategoria != $czyn['kategoria']) {
            $html .= '<h1>'.$czyn['kategoria'].'</h1>';
            $kategoria = $czyn['kategoria'];
        }
        $html .= '<table border="1" nobr="true">';
        $html .= '<tr><td colspan="2"><h2>'.$czyn['nazwa'].'</h2></td></tr>';
        $html .= '<tr>';
        $html .= ' <td width="75">';
        $html .= '   <img src="img/p'.$czyn['poziom'].'.png" width="50" height="50" />';
        $html .= ' </td>';
        $html .= ' <td width="88%">';
        $html .= '   <p>'.nl2br($czyn['opis']).'</p>';
        $html .= '   <strong>Zdobywcy: </strong>';
		$zdobywcy = $czyny_harcerze->get($czyn['id']);
		while($zdobywca = $zdobywcy->fetchArray()) {
			$html .= $zdobywca['pseudonim']. ', ';
		}
		//remove last ', ';
		$html = substr($html, 0, -2);
        $html .= ' </td>';
        $html .= '</tr></table>';
    }
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
}

$pdf->AddPage();
$html = '';

$html .= '<img src="img/tipi.png"><br><br>';
$html .= '<h1 align="center">Księga Czynów 1NGDH "Knieja"</h1>';
$html .= '<p align="center" style="font-size:80%;">Stan na dzień: '.date('d.m.Y').'r.</p>';
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

$pdf->AddPage();
$html = '';
$html .= '<img src="img/s1.png" width="300" height="300"><br><br>';
$html .= '<strong>Pierwsze Światło jest światłem Piękna:</strong><br>';
$html .= '<em>Zachowaj czystość siebie i miejsca, w którym żyjesz.</em><br>';
$html .= '<em>Znaj i szanuj swoje ciało, jest bowiem siedzibą Twego Ducha.</em><br>';
$html .= '<em>Bądź przyjacielem wszystkich nieszkodliwych stworzeń.</em><br>';
$html .= '<em>Chroń drzewa i kwiaty oraz bądź gotów na walkę z pożarem w lesie i w mieście.</em><br>';
$html .= '<p>Czyny tego Światła ukierunkowane są na sprawniść fizyczną, umiejętności sportowe, podróżnicze, kondycyjne.</p>';
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
genLight(1);

$pdf->AddPage();
$html = '';
$html .= '<img src="img/s2.png" width="300" height="300"><br><br>';
$html .= '<strong>Drugie Światło jest światłem Prawdy:</strong><br>';
$html .= '<em>Słowo honoru jest święte.</em><br>';
$html .= '<em>Graj uczciwie. Nieuczciwa gra jest zdradą.</em><br>';
$html .= '<em>Bądź pokorny. Czcij Wielkiego Ducha i respektuj wiarę innych.</em><br>';
$html .= '<p>Czynt tego Światła ukierunkowane są na wiedzę i umiejętności umysłowe: znajomość dziedziny nauk przyrodniczych i humanistycznych, umiejętności porozuimewania się.</p>';
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
genLight(2);

$pdf->AddPage();
$html = '';
$html .= '<img src="img/s3.png" width="300" height="300"><br><br>';
$html .= '<strong>Trzecie Światło jest światłem Siły:</strong><br>';
$html .= '<em>Bądź odważny. Odwaga należt do najwspanialszych cnót.</em><br>';
$html .= '<em>Milcz, kiedy mówią starsi i okazuj im szacunek również w inny sposób.</em><br>';
$html .= '<em>Bądź posłuszny. Posłuszeństwo jest podstawowym obowiązkiem na drodze leśnej mądrości.</em><br>';
$html .= '<p>Czyny tego Światła ukierunkowane są na uczucie, wyobraźnię, zmysł estetyczny, sztykę, zręczność, wytwarzanie różnych wyrobów, posiadanie różnych umiejętności, realizowanie działań artystycznych.</p>';
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
genLight(3);

$pdf->AddPage();
$html = '';
$html .= '<img src="img/s4.png" width="300" height="300"><br><br>';
$html .= '<strong>Czwarte Światło jest światłem Miłości:</strong><br>';
$html .= '<em>Bądź uprzejmy. Codziennie rób chociaż jeden dobry uczynek.</em><br>';
$html .= '<em>Chętnie pomagaj innym. Pełnij swoje obowiązki.</em><br>';
$html .= '<em>Bądź dobrej myśli. Ciesz się z tego, że żyjesz.</em><br>';
$html .= '<p>Czyny tego Światła ukierunkowane są na służbę i pomoc (służba innym, drużynie, środowisku życia).</p>';
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
genLight(4);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('ksiega_czynow.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
