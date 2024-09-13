<?

namespace App\Models;
// use autoload from composer
require($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

class IngredientModel extends BaseModel {
  private $id;
  private $name;
  private $category;
  private $measurementUnit;
  private $nutritionComponents ;

  /**
   * Class constructor for IngredientModel.
   *
   * @param int|null $id The ingredient ID (optional, default is null).
   * @param string|null $name The ingredient name (optional, default is null).
   * @param string|null $category The ingredient category (optional, default is null).
   * @param string|null $measurementUnit The ingredient measurement description (optional, default is null).
   * @param array|null $nutritionComponents The ingredient nutrition components (optional, default is null).
   */
  public function __construct($id = null, $name = null, $category = null, $measurementUnit = null, $nutritionComponents = null) {
    $this->id = $id ?? 0;
    $this->name = $name ?? '';
    $this->category = $category ?? '';
    $this->measurementUnit = $measurementUnit ?? '';
    $this->nutritionComponents = $nutritionComponents;
  }
  public function getId() { return $this->id; }
  public function getActive() { return $this->isActive; }
  public function getName() { return $this->name; }
  public function getCategory() { return $this->category; }
  public function getMeasurementUnit() { return $this->measurementUnit; }
  public function getNutritionComponents() { return $this->nutritionComponents; }
  public function setId($id) { $this->id = $id; }
  public function setActive($condition = 1) { $this->isActive = $condition; }
  public function setName($name) { $this->name = $name; }
  public function setCategory($category) { $this->category = $category; }
  public function setMeasurementUnit($measurementUnit) { 
    $this->measurementUnit = $measurementUnit; 
  }
  public function setNutritionComponents($nutritionComponents) {
    $this->nutritionComponents = $nutritionComponents;
  }
  
  /**
   * Creates an IngredientModel object from a raw array of data.
   *
   * @param array $data The raw array of data containing ingredient information.
   * @return IngredientModel The created IngredientModel object.
   */
  static public function createObjectByRawArray($data) {
    $ingredient = new self();
    $ingredient->setID($data['id']);
    $ingredient->setActive($data['isActive']);
    $ingredient->setName($data['name']);
    $ingredient->setCategory($data['category']);
    $ingredient->setMeasurementUnit($data['measurementUnit']);
    if(!empty($data['nutritionComponents']))
      $ingredient->setNutritionComponents($data['nutritionComponents']);
    
    return $ingredient;
  }
}