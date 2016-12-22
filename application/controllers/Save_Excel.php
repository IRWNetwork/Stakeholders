<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Save_Excel extends CI_Controller
{
	function __construct()
    {
        parent::__construct();
			$this->load->model('Excel_model');
	
    }

    
	
	
	public function index()
	{
		
		
			 $this->load->library('Excel');
			
		//	echo FCPATH;
			$inputFileName =FCPATH.'\assets\xls\file.xlsx';

			
			try {
    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($inputFileName);
} catch(Exception $e) {
    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}

//  Get worksheet dimensions
$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow(); 
$highestColumn = $sheet->getHighestColumn();
$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

//  Loop through each row of the worksheet in turn
for ($row = 1; $row <= $highestRow; $row++){ 
    //  Read a row of data into an array
  /*  $rowData[] = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                    NULL,
                                    TRUE,
                                    FALSE);
									print_r($rowData);*/
									for ($col = 0; $col <= $highestColumnIndex; ++$col) {
    $rowData[$col] = $sheet->getCellByColumnAndRow($col, $row)->getValue();
  }
  	$data	= array(
	"from_entity"=>$rowData[0],
	"from_bank" =>$rowData[1],
	"from_account" => $rowData[2],
	"from_key" => $rowData[3],
	"type" =>$rowData[4],
	"to_entity" => $rowData[5],
	"to_bank" =>$rowData[6],
	"method" =>$rowData[7],
	"sort_by" => $rowData[8],
	"teller"=>$rowData[9],
	"to_account" =>$rowData[10],
	"to_key" => $rowData[11],
	"rdate"=>$rowData[12],
	"amount" =>$rowData[13],
	"memo" => $rowData[14],
	"notes"=>$rowData[15]
								
							);
							$audio1= $this->Excel_model->save($data);
// echo $rowData[0].','.$rowData[1].','.$rowData[2].'<br>';
    //  Insert row data array into your database of choice here
	
}
echo "DATA imported Successfully";
	}

	public function logout()
	{
		$this->session->sess_destroy();
		$this->session->set_flashdata('success', 'Logout Successfully');
		redirect(base_url()."user");
	}

	public function map()
	{
		$data['page_title'] 	= 'Map';
		$data['page_heading'] 	= 'Map';
		$parser['content']		=  $this->load->view('map/map-view',$data,TRUE);
        $this->parser->parse('template', $parser);
		// $this->load->view('map/map-view',TRUE);
	}
	
	public function mainpopup()
	{
		$this->session->set_userdata(array('websiteloaded'=>'yes'));
		$data['page_title'] 	= 'Po';
		$data['page_heading'] 	= 'Map';
		$parser['content']		=  $this->load->view('popup',$data);		
	}
}