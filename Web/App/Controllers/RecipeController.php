<?php

namespace App\Controllers;

use App\Operations\RecipeReadOperation;
use App\Operations\RecipeCreateOperation;
use App\Operations\UploadImageOperation;
use App\Operations\ValidataRecipeDataHolder;

class RecipeController extends BaseController
{

    public function index()
    {
        $this->loadView('recipe.index');
    }

    public function viewDetail()
    {
        $id = $_GET['id'];
        $recipe = RecipeReadOperation::getSingleObjectById($id);

        $this->loadViewWithOtherExtract('recipe.recipe_detail', $recipe);
    }

    public function findByName()
    {
        $value = $_GET['value'];
        $recipe = RecipeReadOperation::getObjectForSearching('recipes.name', $value);

        $data = ['value' => $value, 'recipe' => $recipe];
        $this->loadView('recipe.view_by_name', $data);
    }



    public function listByCategory()
    {
        $category = $_GET['category'];
        $recipes = RecipeReadOperation::getAllObjectsByFieldAndValue('category', $category);
        $this->loadView('recipe.recipe', $recipes);
    }
    public function addUI()
    {
        if (!UserController::isContributer()) {
            return parent::loadError('404');
        }
        $data[] = ValidataRecipeDataHolder::getInstance();
        $this->loadView('recipe.add', $data);
    }
    public function add()
    {
        if (!UserController::isContributer()) {
            return parent::loadError('404');
        }

        // Check if an image is uploaded
        if (!empty($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Process image upload
            $data['image_url'] = UploadImageOperation::process();
            if (!$data['image_url']) {
                $message = 'Failed to upload image.';
                $success = false;

                $response = [
                    'success' => $success,
                    'message' => $message,
                ];
                header('Content-Type: application/json');
                echo json_encode($response);
                die();
            }
        }

        // Process other form data
        $data = $_POST;

        $ingredientComponents = [];
        for ($index = 0; $index < count($data['ingredient_id']); $index++) {
            $component = [
                'ingredient_id' => $data['ingredient_id'][$index],
                'unit' => $data['unit'][$index],
                'quantity' => $data['quantity'][$index]
            ];
            $ingredientComponents[] = $component;
        }

        $data['ingredientComponents'] = $ingredientComponents;
        unset($data['ingredient_id']);
        unset($data['unit']);
        unset($data['quantity']);
        
        // Execute operation
        RecipeCreateOperation::execute($data);
    }


    public function find()
    {
        RecipeReadOperation::getAllObjectsByFieldAndValue('name', $_GET['search']);
        $this->loadView('recipe.find');
    }

    public function findResult()
    {
        $id = $_GET['id'] ?? null;

        $recipe = RecipeReadOperation::getSingleObjectById($id);
        $this->loadView('recipe.recipe', $recipe);
    }

    public function tempView($course)
    {
        switch ($course) {
            case 'breakfast':
                $data = 1;
                break;

            case 'lunch':
                $data = 2;
                break;
            case 'dinner':
                $data = 3;
                break;
        }
        $recipes = RecipeReadOperation::getObjectForSearching('course', $data);
        $this->loadView('recipe.recipe_temp_view', ['recipes' => $recipes]);
    }
}
