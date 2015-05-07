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
        $this->load->model('printbarcode_model');
    }

	public function index()
	{
        if(!empty($this->input->get('po_id'))){
            $po_id = $this->input->get('po_id');
            if(isset($po_id)){
                $barcode_detail = $this->printbarcode_model->get_barcode_detail_by_po_id($po_id);

                if($barcode_detail){
                    //Create a ClientPrintJob obj that will be processed at the client side by the WCPP
                    $cpj = new ClientPrintJob();
                    $cpj->clientPrinter = new InstalledPrinter('SATO-CG208'); //set the installed printer's name on the client machine
                    $printer_command = "";

                    foreach($barcode_detail as $each_barcode){
                        $temp_name = substr($each_barcode['label_name'], 0, 16);
                        $description_line1 = ""; // max 16 character
                        if($temp_name){
                            $description_line1 = $temp_name;
                        }

                        $temp_name = substr($each_barcode['label_name'], 16, 16);
                        $description_line2 = ""; // max 16 character
                        if($temp_name){
                            $description_line2 = $temp_name;
                        }

                        $code_to_encode = $each_barcode['label_code'];; // max 7 character
                        $quantity = $each_barcode['label_quantity'];;

                        $printer_command .=
                            '0x1BA0x0D0x0A' .
                            '0x1BV100x1BH1200x1BP20x0D0x0A' .
                            '0x1BRDB00,P08,P08,' . $description_line1 . '0x0D0x0A' .
                            '0x1BV300x1BH1200x1BP20x0D0x0A' .
                            '0x1BRDB00,P08,P08,' . $description_line2 . '0x0D0x0A' .
                            '0x1BV500x1BH1200x1BBG02080>H' . $code_to_encode . '0x0D0x0A' .
                            '0x1BV1500x1BH1800x1BP20x0D0x0A' .
                            '0x1BRDB00,P08,P08,' . $code_to_encode . '0x0D0x0A' .
                            '0x1BQ' . $quantity . '0x0D0x0A' .
                            '0x1BZ0x0D0x0A';
                    }

                    //Send ClientPrintJob back to the client
                    $cpj->printerCommands = $printer_command;
                    $cpj->formatHexValues = true;
                    echo $cpj->sendToClient();

                    //echo $printer_command;
                }else{
                    echo FALSE;
                }
            }
        }
    }

    public function stock()
    {
        if(!empty($this->input->get('id'))){
            $id = $this->input->get('id');
            if(isset($id)){
                $barcode_detail = $this->printbarcode_model->get_barcode_stock_by_id($id);

                if($barcode_detail){
                    //Create a ClientPrintJob obj that will be processed at the client side by the WCPP
                    $cpj = new ClientPrintJob();
                    $cpj->clientPrinter = new InstalledPrinter('SATO-CG208'); //set the installed printer's name on the client machine
                    $printer_command = "";

                    foreach($barcode_detail as $each_barcode){
                        $temp_name = substr($each_barcode['item'], 0, 16);
                        $description_line1 = ""; // max 16 character
                        if($temp_name){
                            $description_line1 = $temp_name;
                        }

                        $temp_name = substr($each_barcode['item'], 16, 16);
                        $description_line2 = ""; // max 16 character
                        if($temp_name){
                            $description_line2 = $temp_name;
                        }

                        $code_to_encode = $each_barcode['item_stock_code'];; // max 7 character
                        $quantity = $each_barcode['label_quantity'];;

                        $printer_command .=
                            '0x1BA0x0D0x0A' .
                            '0x1BV100x1BH1200x1BP20x0D0x0A' .
                            '0x1BRDB00,P08,P08,' . $description_line1 . '0x0D0x0A' .
                            '0x1BV300x1BH1200x1BP20x0D0x0A' .
                            '0x1BRDB00,P08,P08,' . $description_line2 . '0x0D0x0A' .
                            '0x1BV500x1BH1200x1BBG02080>H' . $code_to_encode . '0x0D0x0A' .
                            '0x1BV1500x1BH1800x1BP20x0D0x0A' .
                            '0x1BRDB00,P08,P08,' . $code_to_encode . '0x0D0x0A' .
                            '0x1BQ' . $quantity . '0x0D0x0A' .
                            '0x1BZ0x0D0x0A';
                    }

                    //Send ClientPrintJob back to the client
                    $cpj->printerCommands = $printer_command;
                    $cpj->formatHexValues = true;
                    echo $cpj->sendToClient();

                    //echo $printer_command;
                }else{
                    echo FALSE;
                }
            }
        }
    }
}
/* End of file printbarcode.php */
/* Location: ./application/controllers/printbarcode.php */