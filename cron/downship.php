<?
	
	$link 	= mysqli_connect("10.10.9.52", "webkit", "4dm1n", "dashboard");
	$sql  	= 'SELECT prod_id, prod_date, drp, ssp, ssp2, bsp, hsm, crc, po, wrm, prod_update FROM prod where trans_flag=0';
	$dt	  	= mysqli_query($link, $sql);
	
	include_once('config.php');
	include('Database.php');
	$db 	= new Database();
	
	while ($rdt	= mysqli_fetch_object($dt)){
		$data 	 = object2array($rdt);
		print_r($data);
		//$id = $db->insert ('prods', $data);
		echo '<br/>'.$data['prod_id'].'<br/>';
		if ($id){
			$upd = 'update prod set trans_flag=1 where prod_id='.$data['prod_id'];
			//mysqli_query($link, $upd);
		}
	}
	//=================================SHipment
	//$link 	= mysqli_connect("10.10.9.52", "webkit", "4dm1n", "dashboard");
	$sql  	= 'SELECT shipment_id, shipment_date, hr_dom, hrpo_dom, cr_dom, wr_dom, bs_dom, hr_exp, hrpo_exp, cr_exp, wr_exp, shipment_update FROM shipment  where trans_flag=0';
	$dt	  	= mysqli_query($link, $sql);
	
	while ($rdt	= mysqli_fetch_object($dt)){
		$data 	 = object2array($rdt);
		print_r($data);
		$id = $db->insert ('shipments', $data);
		echo '<br/>'.$data['shipment_id'].'<br/>';
		if ($id){
			$upd = 'update shipment set trans_flag=1 where shipment_id='.$data['shipment_id'];
			//mysqli_query($link, $upd);
		}
	}
	
	
	
	
	
function object2array($object) {
    if (is_object($object)) {
        foreach ($object as $key => $value) {
            $array[$key] = $value;
        }
    }
    else {
        $array = $object;
    }
    return $array;
}
?>