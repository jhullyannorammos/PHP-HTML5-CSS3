<?php 

include "../database/dbconn.php";
include "../database/sql.php";
if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
{
	$method=$_POST['method'];
	$dtbs = new sql();
	$retval = [];

	if($method == 'list_customer'){
		$list = $dtbs->list_customer();
		$retval['status'] = $list[0];
		$retval['message'] = $list[1];
		$retval['data'] = $list[2];
		echo json_encode($retval);
	}

	if($method == 'new_customer'){
		$name = $_POST['name'];
		$country = $_POST['country'];
		$phone = $_POST['phone'];
		$gender = $_POST['gender'];

		$new = $dtbs->new_customer($name,$country,$phone,$gender);
		$retval['status'] = $new[0];
		$retval['message'] = $new[1];
		echo json_encode($retval);
	}

	if($method == 'edit_customer'){
		$id_cust = $_POST['id_cust'];
		$name = $_POST['name'];
		$country = $_POST['country'];
		$phone = $_POST['phone'];
		$gender = $_POST['gender'];

		$edit = $dtbs->edit_customer($id_cust,$name,$country,$phone,$gender);
		$retval['status'] = $edit[0];
		$retval['message'] = $edit[1];
		echo json_encode($retval);
	}

	if($method == 'delete_customer'){
		$id_cust = $_POST['id_cust'];
		$delete = $dtbs->delete_customer($id_cust);
		$retval['status'] = $delete[0];
		$retval['message'] = $delete[1];
 		echo json_encode($retval);
	}



}else{
	header("HTTP/1.1 401 Unauthorized");
    exit;
}