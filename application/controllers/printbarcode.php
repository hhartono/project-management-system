<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include FCPATH . "/assets/barcodeprint/WebClientPrint.php";
use Neodynamic\SDK\Web\WebClientPrint;
use Neodynamic\SDK\Web\ClientPrintJob;
use Neodynamic\SDK\Web\InstalledPrinter;

class Printbarcode extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
    public function __construct()
    {
        parent::__construct();
    }

	public function index()
	{
        if(!empty($this->input->get('poid'))){
            $poid = $this->input->get('poid');
            if(isset($poid)){
                $description_line11 = 'ABCDEFGHAIJKLMNO'; // max 16 character
                $description_line21 = 'ABCDEFGHAIJKLMNO'; // max 16 character
                $code_to_encode1 = 'AKB9876'; // max 7 character
                $quantity1 = '1';

                //Create a ClientPrintJob obj that will be processed at the client side by the WCPP
                $cpj = new ClientPrintJob();
                $cpj->clientPrinter = new InstalledPrinter('SATO-CG208'); //set the installed printer's name on the client machine
                $cpj->printerCommands =
                    '0x1BA0x0D0x0A' .
                    '0x1BV100x1BH1200x1BP20x0D0x0A' .
                    '0x1BRDB00,P08,P08,' . $description_line11 . '0x0D0x0A' .
                    '0x1BV300x1BH1200x1BP20x0D0x0A' .
                    '0x1BRDB00,P08,P08,' . $description_line21 . '0x0D0x0A' .
                    '0x1BV500x1BH1200x1BBG02080>H' . $code_to_encode1 . '0x0D0x0A' .
                    '0x1BV1500x1BH1800x1BP20x0D0x0A' .
                    '0x1BRDB00,P08,P08,' . $code_to_encode1 . '0x0D0x0A' .
                    '0x1BQ' . $quantity1 . '0x0D0x0A' .
                    '0x1BZ0x0D0x0A';
                $cpj->formatHexValues = true;

                //Send ClientPrintJob back to the client
                echo $cpj->sendToClient();
            }
        }
    }
}
/* End of file printbarcode.php */
/* Location: ./application/controllers/printbarcode.php */