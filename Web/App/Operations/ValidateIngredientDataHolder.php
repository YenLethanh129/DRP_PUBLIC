<? 
namespace  App\Operations;

class ValidateIngredientDataHolder {
    private static $instance;
    public $validCategories;
    public $validMeasurements;
    public $validNutrition;
    private function __construct() {
        $this->validCategories = IngredientReadOperation::getCat(1);
        $this->validMeasurements = IngredientReadOperation::getCat(2);
        $this->validNutrition = IngredientReadOperation::getCat(3);
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
