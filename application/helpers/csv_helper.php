<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------
if ( ! function_exists('exportExcel')){
	function exportExcel($clientRows,$status){
		$CI =& get_instance();
		//load our new PHPExcel library
		$CI->load->library('Excel');
		$CI->load->model('Client_model');


		//activate worksheet number 1
		$CI->excel->setActiveSheetIndex(0);
		//name the worksheet
		$CI->excel->getActiveSheet()->setTitle('Clients');
		//set cell A1 content with some text
		$CI->excel->setActiveSheetIndex(0)
					->setCellValue('A1', 'Name')
					->setCellValue('B1', 'Email')
					->setCellValue('C1', 'Username')
					->setCellValue('D1', 'Password')
					->setCellValue('E1', 'Mac Address')
					->setCellValue('F1', 'Subscription Start Date')
					->setCellValue('G1', 'Subscription End date')
					->setCellValue('H1', 'Subscription Period')
					->setCellValue('I1', 'Amount')
					->setCellValue('J1', 'Note')
					->setCellValue('K1', 'Status')
					->setCellValue('L1', 'Address')
					->setCellValue('M1', 'Number')
					->setCellValue('N1', 'System')
					->setCellValue('O1', 'Agent')
					->setCellValue('P1', 'Referer');
		$i=2;
		foreach($clientRows as $row){
		$CI->excel->setActiveSheetIndex(0)
					->setCellValue('A'.$i, $row->name)
					->setCellValue('B'.$i, $row->email)
					->setCellValue('C'.$i, $row->username)
					->setCellValue('D'.$i, $row->password)
					->setCellValue('E'.$i, $row->mac_address)
					->setCellValue('F'.$i, $row->subscription_start_date)
					->setCellValue('G'.$i, $row->subscription_end_date)
					->setCellValue('H'.$i, $row->subscription_period)
					->setCellValue('I'.$i, $row->amount)
					->setCellValue('J'.$i, $row->note)
					->setCellValue('K'.$i, $row->status)
					->setCellValue('L'.$i, $row->address)
					->setCellValue('M'.$i, $row->number)
					->setCellValue('N'.$i, $row->system)
					->setCellValue('O'.$i, $row->agent)
					->setCellValue('P'.$i, $row->referer);
					$i++;
		}
		// Clone worksheet
		$donationSheet = $CI->excel->createSheet();
		
		


		$filename=$status.'_clients.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		            
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($CI->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save(dirname(__FILE__)."/assets"."/".$filename);
		exit();
	}
}

if ( ! function_exists('array_to_csv'))
{
	function array_to_csv($array, $download = "")
	{
		if ($download != "")
		{	
			header('Content-Type: application/csv');
			header('Content-Disposition: attachement; filename="' . $download . '"');
		}		

		ob_start();
		$f = fopen('php://output', 'w') or show_error("Can't open php://output");
		$n = 0;		
		foreach ($array as $line)
		{
			$n++;
			if ( ! fputcsv($f, $line))
			{
				show_error("Can't write line $n: $line");
			}
		}
		fclose($f) or show_error("Can't close php://output");
		$str = ob_get_contents();
		ob_end_clean();

		if ($download == "")
		{
			return $str;	
		}
		else
		{	
			echo $str;
		}		
	}
}

// ------------------------------------------------------------------------

/**
 * Query to CSV
 *
 * download == "" -> return CSV string
 * download == "toto.csv" -> download file toto.csv
 */
if ( ! function_exists('query_to_csv'))
{
	function query_to_csv($query, $headers = TRUE, $download = "")
	{
		if ( ! is_object($query) OR ! method_exists($query, 'list_fields'))
		{
			show_error('invalid query');
		}
		
		$array = array();
		
		if ($headers)
		{
			$line = array();
			foreach ($query->list_fields() as $name)
			{
				$line[] = $name;
			}
			$array[] = $line;
		}
		
		foreach ($query->result_array() as $row)
		{
			$line = array();
			foreach ($row as $item)
			{
				$line[] = $item;
			}
			$array[] = $line;
		}

		echo array_to_csv($array, $download);
	}
}

/* End of file csv_helper.php */
/* Location: ./system/helpers/csv_helper.php */