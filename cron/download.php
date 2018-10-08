<?
	include_once('config.php');
	include('Database.php');
	//include_once('downfunction2.php');
	error_reporting(E_ALL);
	set_time_limit(600);
	
	
	//$readdir = laci.'/';
	//$movedir = laci.'/archive/';
	//$readdir = "d:/interface/dashboard/";
	//$movedir = "d:/interface/dashboard/archive/";
	$readdir = "/mnt/winnt/";
	$movedir = "/mnt/winnt/archive/";
	
	
	$arfile  = scandir($readdir);

	//print_r($arfile);	
		
	foreach($arfile as $arsip){
		if ($arsip!='.' && $arsip!='..') {
			$prefix=explode('_', $arsip);
			$kode = array('Margin', 'StockSO', 'CR','WR', 'HR', 'HRPO');
			
			if (in_array($prefix[0],$kode)){
				$file_handle = fopen($readdir.$arsip, "rb");
				$i = 1;
				
				while (!feof($file_handle)) {
					$line_of_text = fgets($file_handle);
					if ($i>1){
						if (strlen($line_of_text)>0) {
							//echo $i.'  '.strlen($line_of_text).'  -  '.$line_of_text.'<br>'; //$i.'  '.strlen($line_of_text).'  -  '.
							tulisfile ($prefix[0],$line_of_text,$prefix[1]);
						}	
					}
					$i++;
				}			
				fclose($file_handle);						
			
					
			copy($readdir.$arsip, $movedir.$arsip);
			//echo "processing $arsip";
			unlink($readdir.$arsip);
			}
		}
	}
	
	set_time_limit(30);
	
	
	//echo 'Waiting...Release PR..';
function toNumber($teks){
	$hsl	= str_replace(".","",$teks);
	$hsl	= str_replace(",",".",$hsl);
	return $hsl;
	
}
function tulisfile($tabel, $teks, $lastupdate){
	$lastupdate = substr($lastupdate,0,8);
	$lastuptime = substr($lastupdate,-2).':00:00';
	switch($tabel){
	
		case 'Margin':			
			$delimiter = "|";		
			$splitcontents = explode($delimiter, $teks);
			$sql = "insert into kontribusi_margin values (null, 
					'".$lastupdate.' '.$lastuptime."', 
					'".$splitcontents[0]."',
					'".$splitcontents[1]."',
					'".toNumber($splitcontents[2])."',
					'".toNumber($splitcontents[3])."',
					'".toNumber($splitcontents[4])."',
					'".toNumber($splitcontents[5])."',
					'".$lastuptime."'
					)";
			//echo $sql.'<br>';;		
			$db 	= new Database();
			$db->query($sql);	
			$log	= "insert into log_down (isinya, stat) values ('".$sql."', '')";
			$id 	= $db->query($log);			
					
			//print_r($splitcontents);
	
			
		break;
		case 'WR':	
		case 'CR':	
		case 'HR':	
		case 'HRPO':
			if ($tabel=='HR'){
				$id = '1';
			}elseif ($tabel=='CR'){
				$id = '2';
			}elseif ($tabel=='HRPO'){
				$id = '3';
			}elseif ($tabel=='WR'){
				$id = '4';
			}
			$delimiter = "\t";		
			$splitcontents = explode($delimiter, $teks);
		
			$sql = "insert into finishgoods values (
					'".$id."', 
					'".$lastupdate."', 
					'".$splitcontents[0]."',
					'".$splitcontents[1]."',
					'".($splitcontents[2])."',
					'".($splitcontents[3])."',
					'".($splitcontents[4])."',
					'".($splitcontents[5])."',
					'".toNumber($splitcontents[6])."',
					'".($splitcontents[7])."',
					'".($splitcontents[8])."',
					'".$lastuptime."'
					)";
			//echo $sql.'<br>';;		
			$db 	= new Database();
			$db->query($sql);	
			
			$log	= "insert into log_down (isinya, stat) values ('".$sql."', '".$id."')";
			$db 	= new Database();
			$id 	= $db->query($log);		
		
		break;
		
		//========================================= CARGO DAN RTS ===============================
		case 'StockSO':
			$delimiter = "|";		
			$splitcontents = explode($delimiter, $teks);
			$tgl = explode("/", $splitcontents[4]);
			//$tgl[2].'-'.$tgl[1].'-'.$tgl[0]c
			$sql = "insert into rtscargos values (
					'".$splitcontents[0]."',
					'".$splitcontents[1]."',
					'".($splitcontents[2])."',
					'".($splitcontents[3])."',
					'".($splitcontents[4])."',
					'".($splitcontents[5])."',
					'".toNumber($splitcontents[6])."',
					'".($splitcontents[7])."',
					'".($splitcontents[8])."',
					'".($splitcontents[9])."',
					'".($splitcontents[10])."',
					'".$lastupdate."',
					'".$lastuptime."'
					)";
			echo $sql.'<br>';;		
			$db 	= new Database();
			$id		= $db->query($sql);	
			
			$log	= 'insert into log_down (isinya, stat) values ("'.$sql.'", "")';
			$db1 	= new Database();
			$db1->query($log);	
		
		break;
	}	
}
?>