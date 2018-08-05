<?php

 class connectToDB
 {
	private $conn;
	public function __construct()
	{
		$config = include 'config.php';
		$this->conn = new mysqli( $config['db']['server'], $config['db']['user'], $config['db']['pass'], $config['db']['dbname']);
		// var_dump($config, $this->conn);
	}

	function __destruct()
	{
		$this->conn->close();
	}
	public function addCompany( $company, $details, $latitude, $longitude, $telephone, $keywords)
	{
		  $statement = $this->conn->prepare("INSERT INTO companies( company, details, latitude, longitude, telephone, keywords) VALUES( ?, ?, ?, ?, ?, ?)");
		  $statement->bind_param('ssssss', $company, $details, $latitude, $longitude, $telephone, $keywords);
		  $statement->execute();
		  $statement->close();
		  $this->conn->close();
	}
	public function getCompaniesList()
	{
		  $arr = array();
		  $statement = $this->conn->prepare( "SELECT id, company, details, latitude, longitude, telephone, keywords from companies order by company ASC");
		  $statement->bind_result( $id, $company, $details, $latitude, $longitude, $telephone, $keywords);
		  $statement->execute();
		  while ($statement->fetch()) {
			$arr[] = [ "id" => $id, "company" => $company, "details" => $details, "latitude" => $latitude, "longitude" => $longitude, "telephone" => $telephone, "keywords" => $keywords];
		  }
		  $statement->close();

		  return $arr;
	}
	public function updateCompany( $id, $details, $latitude, $longitude, $telephone, $keywords)
	{
		  $statement = $this->conn->prepare("UPDATE companies SET details = ?,latitude = ?,longitude = ?,telephone = ?,keywords = ? where id = ?");
		  $statement->bind_param( 'sssssi', $details, $latitude, $longitude, $telephone, $keywords, $id);
		  $statement->execute();
		  $statement->close();

	}
	public function deleteCompany($id)
	{
		 $statement = $this->conn->prepare("Delete from companies where id = ?");
		 $statement->bind_param('i', $id);
		 $statement->execute();
		 $statement->close();

	}
	public function addStreet( $street, $geo, $keywords)
	{
		 $statement = $this->conn->prepare("INSERT INTO streets( name, geolocations, keywords) VALUES( ?, ?, ?)");
		 $statement->bind_param( 'sss', $street, $geo, $keywords);
		 $statement->execute();
		 $statement->close();

	}
	public function getStreetsList()
	{
		$arr = array();
		$statement = $this->conn->prepare( "SELECT id, name, geolocations, keywords from streets order by name ASC");
		$statement->bind_result( $id, $name, $geolocations, $keywords);
		$statement->execute();
		while ($statement->fetch()) {
		$arr[] = [ "id" => $id, "name" => $name, "geolocations" => $geolocations, "keywords" => $keywords];
		}
		$statement->close();

		return $arr;
	}
	public function updateStreet( $id, $geo, $keywords)
	{
		  $statement = $this->conn->prepare( "UPDATE streets SET geolocations = ?, keywords = ? where id = ?");
		  $statement->bind_param( 'ssi', $geo, $keywords, $id);
		  $statement->execute();
		  $statement->close();

	}
	public function deleteStreet($id)
	{
		 $statement = $this->conn->prepare("Delete from streets where id = ?");
		 $statement->bind_param('i', $id);
		 $statement->execute();
		 $statement->close();

	}
	public function addArea( $area, $geo, $keywords)
	{
		  $statement = $this->conn->prepare( "INSERT INTO areas( name, geolocations, keywords ) VALUES(?,?,?)");
		  $statement->bind_param( 'sss', $area, $geo,$keywords);
		  $statement->execute();
		  $statement->close();

	}
	public function getAreasList()
	{
		  $arr = array();
		  $statement = $this->conn->prepare( "SELECT id, name, geolocations, keywords from areas order by name ASC");
		  $statement->bind_result( $id, $name, $geolocations, $keywords);
		  $statement->execute();
		  while ($statement->fetch()) {
			$arr[] = [ "id" => $id, "name" => $name, "geolocations" => $geolocations, "keywords" => $keywords];
		  }
		  $statement->close();

		  return $arr;
	}
	public function updateArea( $id, $geo, $keywords)
	{
		  $statement = $this->conn->prepare("UPDATE areas SET geolocations = ?, keywords = ? where id = ?");
		  $statement->bind_param( 'ssi', $geo, $keywords, $id);
		  $statement->execute();
		  $statement->close();

	}
	public function deleteArea($id)
	{
		 $statement = $this->conn->prepare("Delete from areas where id = ?");
		 $statement->bind_param('i', $id);
		 $statement->execute();
		 $statement->close();

	}
	public function getSearchResults($keyword)
	{
		  $arr = array();
		  $jsonData = '{"results":[';
		  $this->conn->query( "SET NAMES 'UTF8'" );
		  $statement = $this->conn->prepare("SELECT company, latitude, longitude FROM `companies` where keywords REGEXP ? or company REGEXP ?");
		  $statement->bind_param( 'ss', $keyword, $keyword);
		  $statement->execute();
		  $statement->bind_result( $name, $lat, $lng);
		  while ($statement->fetch()) {
			$arr[] = '{"name":"' . $name. '","latitude":"' . $lat. '","longitude":"' . $lng. '"}';
		  }
		  $statement->close();

		  $statement = $this->conn->prepare( "SELECT name, geolocations FROM `streets` where keywords REGEXP ? or name REGEXP ?");
		  $statement->bind_param( 'ss', $keyword, $keyword);
		  $statement->execute();
		  $statement->bind_result( $name, $geolocations);
		  while ($statement->fetch()) {
			$temp = explode(",",$geolocations);
			$arr[] = '{"name":"' . $name. '","latitude":"' . $temp[1]. '","longitude":"' . $temp[0]. '"}';
		  }
		  $statement->close();

		  $statement = $this->conn->prepare( "SELECT name, geolocations FROM `areas` where keywords REGEXP ? or name REGEXP ?");
		  $statement->bind_param( 'ss', $keyword, $keyword);
		  $statement->execute();
		  $statement->bind_result( $name, $geolocations);
		  while ($statement->fetch()) {
			$temp = explode(",",$geolocations);
			$arr[] = '{"name": "' . $name. '", "latitude": "' . $temp[1]. '","longitude":"' . $temp[0]. '"}';
		  }
		  $statement->close();


		  $jsonData .= implode(",", $arr);
		  $jsonData .= ']}';
		  return $jsonData;
	}

  public function getCompaniesList() {
 $arr = array();
 $statement = $this->conn->prepare("Select id, company, details, latitude, longitude, telephone from companies order by company ASC");
 $statement->bind_result( $id, $company, $details, $latitude, $longitude, $telephone);
 $statement->execute();
 while ($statement->fetch()) {
  $arr[] = [ "id" => $id, "company" => $company, "details" => $details, "latitude" => $latitude, "longitude" => $longitude, "telephone" => $telephone];
 }
 $statement->close();
 return $arr;
}

public function addStreet($street,$geo) {
 $statement = $this->conn->prepare("Insert INTO streets( name, geolocations ) VALUES(?,?)");
 $statement->bind_param('ss', $street, $geo);
 $statement->execute();
 $statement->close();
}


public function updateStreet($id, $geo) {
 $statement = $this->conn->prepare("Update streets SET geolocations = ? where id = ?");
 $statement->bind_param('si', $geo, $id);
 $statement->execute();
 $statement->close();
}

public function deleteStreet($id) {
 $statement = $this->conn->prepare("Delete from streets where id = ?");
 $statement->bind_param('i', $id);
 $statement->execute();
 $statement->close();
}
public function addArea($area,$geo) {
 $statement = $this->conn->prepare("Insert INTO areas( name, geolocations ) VALUES(?,?)");
 $statement->bind_param('ss', $area, $geo);
 $statement->execute();
 $statement->close();
}
public function getAreasList() {
 $arr = array();
 $statement = $this->conn->prepare("Select id, name, geolocations from areas order by name ASC");
 $statement->bind_result( $id, $name, $geolocations);
 $statement->execute();
 while ($statement->fetch()) {
  $arr[] = [ "id" => $id, "name" => $name, "geolocations" => $geolocations];
 }
 $statement->close();

 return $arr;
}
public function updateArea($id,$geo) {
 $statement = $this->conn->prepare("Update areas SET geolocations = ? where id = ?");
 $statement->bind_param('si', $geo, $id);
 $statement->execute();
 $statement->close();
}
public function deleteArea($id) {
 $statement = $this->conn->prepare("Delete from areas where id = ?");
 $statement->bind_param('i', $id);
 $statement->execute();
 $statement->close();
}
 }

 $conn = new connectToDB();
