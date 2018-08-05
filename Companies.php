<?php
/**
 *
 */
require_once 'Configuration.php';
class Companies
{
  private $id;
  private $company;
  private $details;
  private $latitude;
  private $longitude;
  private $telephone;

  /**
   * Article constructor.
   * @param $id
   * @param $company
   * @param $details
   * @param $latitude
   * @param $longitude
   * @param $telephone
   *
   */

  function __construct($id,$company,$details,$latitude,$longitude,$telephone)
  {
    $this->id=$id;
    $this->company=$company;
    $this->details=$details;
    $this->latitude=$latitude;
    $this->longitude=$longitude;
    $this->telephone=$telephone;
  }

  /**
   * @return mixed
   */
  public function getId()
  {
      return $this->id;
  }

  /**
   * @param mixed $id
   */
  public function setId($id)
  {
      $this->id= $id;
  }

  /**
   * @return mixed
   */
  public function getCompany()
  {
      return $this->company;
  }

  /**
   * @param mixed $company
   */
  public function setCompany($company)
  {
      $this->company = $company;
  }

  /**
   * @return mixed
   */
  public function getDetails()
  {
      return $this->details;
  }

  /**
   * @param mixed $details
   */
  public function setDetails($details)
  {
      $this->details = $details;
  }


  /**
   * @return mixed
   */
  public function getLatitude()
  {
      return $this->latitude;
  }

  /**
   * @param mixed $latitude
   */
  public function setLatitude($latitude)
  {
      $this->latitude = $latitude;
  }

  /**
   * @return mixed
   */
  public function getLongitude()
  {
      return $this->longitude;
  }

  /**
   * @param mixed $longitude
   */
  public function setLongitude($longitude)
  {
      $this->longitude = $longitude;
  }


  /**
   * @return mixed
   */
  public function getTelephone()
  {
      return $this->telephone;
  }

  /**
   * @param mixed $telephone
   */
  public function setTelephone($telephone)
  {
      $this->telephone = $telephone;
  }

public static function getCompaniesList()
{
  $connexion=Configuration::getConnexion();
  $tableau=array();
  $sql="SELECT * FROM companies";
  if($connexion!=null)
  {
      $resultat=$connexion->prepare($sql);
      $resultat->execute();
      while($object = $resultat->fetch(PDO::FETCH_OBJ))
      {
          $tableau[] = new Companies
          (
              $object->id,
              $object->company,
              $object->details,
              $object->latitude,
              $object->longitude,
              $object->telephone

          );
      }
  }
  return $tableau;
}

}







?>
