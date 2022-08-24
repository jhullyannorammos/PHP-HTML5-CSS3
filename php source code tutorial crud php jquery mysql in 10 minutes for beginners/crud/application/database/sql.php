<?php
class sql extends dbconn {
	public function __construct()
	{
		$this->initDBO();
	}

	public function new_customer($name,$country,$phone,$gender)
	{
		$db = $this->dblocal;
		try
		{
			$stmt = $db->prepare("insert into customer(name,country,phone,gender) values (:name,:country,:phone,:gender)");
			$stmt->bindParam("name",$name);
			$stmt->bindParam("country",$country);
			$stmt->bindParam("phone",$phone);
			$stmt->bindParam("gender",$gender);
			$stmt->execute();
			$stat[0] = true;
			$stat[1] = "Success save customer";
			return $stat;
		}
		catch(PDOException $ex)
		{
			$stat[0] = false;
			$stat[1] = $ex->getMessage();
			return $stat;
		}
	}

	public function list_customer()
	{
		$db = $this->dblocal;
		try
		{
			$stmt = $db->prepare("select * from customer");
			$stmt->execute();
			$stat[0] = true;
			$stat[1] = "List customer";
			$stat[2] = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $stat;
		}
		catch(PDOException $ex)
		{
			$stat[0] = false;
			$stat[1] = $ex->getMessage();
			$stat[2] = [];
			return $stat;
		}
	}

	public function edit_customer($id,$name,$country,$phone,$gender)
	{
		$db = $this->dblocal;
		try
		{
			$stmt = $db->prepare("update customer set name = :name, country = :country, phone = :phone , gender = :gender where id_cust = :id ");
			$stmt->bindParam("id",$id);
			$stmt->bindParam("name",$name);
			$stmt->bindParam("country",$country);
			$stmt->bindParam("phone",$phone);
			$stmt->bindParam("gender",$gender);
			$stmt->execute();
			$stat[0] = true;
			$stat[1] = "Success edit customer";
			return $stat;
		}
		catch(PDOException $ex)
		{
			$stat[0] = false;
			$stat[1] = $ex->getMessage();
			return $stat;
		}
	}

	public function delete_customer($id)
	{
		$db = $this->dblocal;
		try
		{
			$stmt = $db->prepare("delete from customer where id_cust = :id");
			$stmt->bindParam("id",$id);
			$stmt->execute();
			$stat[0] = true;
			$stat[1] = "Success delete customer";
			return $stat;
		}
		catch(PDOException $ex)
		{
			$stat[0] = false;
			$stat[1] = $ex->getMessage();
			return $stat;
		}
	}

}