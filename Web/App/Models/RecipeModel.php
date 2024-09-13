<?php 
namespace App\Models;
// use autoload from composer
require_once($_SERVER['DOCUMENT_ROOT'] . '/App/Core/init.php');

class RecipeModel extends BaseModel {
    const TABLE = 'Recipes';

    private $user_id;
    private $recipe_id;
    private $name;
    private $preparation_time;
    private $cooking_time;
    private $course;
    private $meal;
    private $method;    
    private $direction;
    private $description;
    private $image_url;
    private $timestamp;
    private $ingredientComponets = [];

    public function __construct($recipe_id = null,$user_id = null, $name = null, $description = null, $image_url = null, 
            $preparation_time = null, $cooking_time = null, $direction = null, $course = null, 
            $meal = null, $method = null, $timestamp = null, $ingredientComponets = null) {
        $this->recipe_id = $recipe_id;
        $this->user_id = $user_id;
        $this->name = $name;
        $this->description = $description;
        $this->image_url = $image_url;
        $this->preparation_time = $preparation_time;
        $this->cooking_time = $cooking_time;
        $this->direction = $direction;
        $this->course = $course;
        $this->meal = $meal;
        $this->method = $method;
        $this->timestamp = $timestamp;
        $this->ingredientComponets = $ingredientComponets; 
    }

    // get and set 
    public function getId() { return $this->recipe_id;  }
    public function setId($recipe_id) { $this->recipe_id = $recipe_id; }
    public function getUserId() { return $this->user_id; }
    public function setUserId($user_id) { $this->user_id = $user_id; }
    public function getActive() { return $this->isActive; }
    public function setActive($condition = 1) { $this->isActive = $condition; }
    public function getName() { return $this->name; }
    public function setName($name) { $this->name = $name; }
    public function getDescription() { return $this->description; }
    public function setDescription($description) { $this->description = $description; }
    public function getImgUrl() { return $this->image_url; }
    public function setImgUrl($image_url) { $this->image_url = $image_url; }
    public function getPreparationTime() { return $this->preparation_time; }
    public function setPreparationTime($preparation_time) { 
        $this->preparation_time = $preparation_time; 
    }
    public function getCookingTime() { return $this->cooking_time; }
    public function setCookingTime($cooking_time) { 
        $this->cooking_time = $cooking_time; 
    }
    public function getDirection() { return $this->direction; }
    public function setDirection($direction) { $this->direction = $direction; }
    public function getCourse() { return $this->course; }
    public function setCourse($course) { $this->course = $course; }
    public function getMeal() { return $this->meal; }
    public function setMeal($meal) { $this->meal = $meal; }
    public function getMethod() { return $this->method; }
    public function setMethod($method) { $this->method = $method; }
    public function getTimestamp() { return $this->timestamp; }
    public function setTimestamp($timestamp) { $this->timestamp = $timestamp; }
    public function getIngredientComponets() { return $this->ingredientComponets; }
    public function setIngredientComponents($ingredientComponets) { 
        $this->ingredientComponets = $ingredientComponets; 
    }


    public static function createObjectByRawArray($data){
        $object = new RecipeModel();
        $object->setId($data['recipe_id']);
        $object->setUserId($data['user_id']);
        $object->setActive($data['isActive'] ?? 1);
        $object->setName($data['name']);
        $object->setDescription($data['description'] ?? "Unknown");
        $object->setImgUrl($data['image_url'] ?? null);
        $object->setPreparationTime($data['preparation_time'] ?? "Unknown");
        $object->setCookingTime($data['cooking_time'] ?? "Unknown");
        $object->setDirection($data['directions'] ?? "Unknown");
        $object->setCourse($data['course'] ?? "Unknown");
        $object->setMeal($data['meal'] ?? "Unknown");
        $object->setMethod($data['method'] ?? "Unknown");
        $object->setTimestamp($data['timestamp'] ?? "Unknown");
        if (empty($data['ingredientComponents']))
            $object->setIngredientComponents(($data['ingredientComponents']));
        return $object;
    }
}
