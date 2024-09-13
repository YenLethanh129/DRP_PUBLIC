<?php

namespace App\Controllers;

use App\Operations\IngredientReadOperation;
use App\Operations\IngredientUpdateOperation;
use App\Operations\IngredientDeleteOperation;
use App\Operations\UserOperation;
use App\Operations\RecipeReadOperation;
use App\Operations\RecipeUpdateOperation;
use App\Operations\UploadImageOperation;
use App\Operations\ValidateIngredientDataHolder;
use App\Operations\ValidataRecipeDataHolder;

class AdminController extends BaseController
{
    public function index()
    {
        if (!UserController::isAdmin()) {
            return parent::loadError('404');
        }
        return $this->loadView('admin.index');
    }

    // User
    public function userManager()
    {
        if (!UserController::isAdmin()) {
            return parent::loadError('404');
        }

        if (isset($_GET['id'])) {
            $users = UserOperation::getUserById($_GET['id']);
        } else if (isset($_GET['username'])) {
            $users = UserOperation::getUserByUsername($_GET['username']);
        } else if (isset($_GET['email'])) {
            $users = UserOperation::getUserByEmail($_GET['email']);
        } else {
            $users = UserOperation::getAllUser();
        }

        return $this->loadView('admin.user', ['users' => $users]);
    }

    public function userManagerUpdateUI()
    {
        if (!UserController::isAdmin()) {
            return parent::loadError('404');
        }
        $users = UserOperation::getUserById($_GET['id']);
        return $this->loadView('admin.userUpdate', ['user' => $users]);
    }

    public function userManagerUpdate()
    {
        if (!UserController::isAdmin()) {
            return parent::loadError('404');
        }
        $data = $_POST;
        UserOperation::update($data);
        header("Location: /manager/user");
    }

    public function userManagerAdd()
    {
        if (!UserController::isAdmin()) {
            return parent::loadError('404');
        }
        $data = $_POST;

        if (UserOperation::checkEmail($data['email'])) {
            echo '<script>
            alert("Email already exist!");
            window.location.href = "/manager/user";
            </script>';
        } else if (UserOperation::checkUserName($data['username'])) {
            echo '<script>
            alert("Username Already Existed");
            window.location.href = "/manager/user";
            </script>';
        } else if (UserOperation::addUser($data)) {
            echo '<script>
                alert("Register Success!");
                window.location.href = "/manager/user";
            </script>';
            exit();
        } else {
            echo '<script>
                alert("Register Fail!, Please try again!");
                window.location.href = "/manager/user";
            </script>';
            exit();
        }

        header("Location: /manager/user");
    }

    public function setUserLevel()
    {
        if (!UserController::isAdmin()) {
            return parent::loadError('404');
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
            $data = $_POST;
            UserOperation::setLevel($data);
            header("Location: /manager/user");
        }
    }

    /*
        Quản lý recipe
    */
    public function recipeManager()
    {
        if (!UserController::isAdmin()) {
            return parent::loadError('404');
        }

        $recipes = RecipeReadOperation::getAllObjectsWithoutIngre(true);

        $dataHolder['recipes'] = $recipes;

        return $this->loadView('admin.recipe', $dataHolder);
    }

    public function setRecipeActive()
    {
        if (!UserController::isAdmin()) {
            return parent::loadError('404');
        }
        $data = $_POST;
        RecipeUpdateOperation::setRecipeActive($data);

    }

    public function recipeManagerUpdateUI()
    {
        if (!UserController::isAdmin()) {
            return parent::loadError('404');
        }
        $recipe = RecipeReadOperation::getSingleObjectById($_GET['id'], true);
        $dataHolder['courses'] = RecipeReadOperation::getCat(1);
        $dataHolder['meals'] = RecipeReadOperation::getCat(2);
        $dataHolder['methods'] = RecipeReadOperation::getCat(3);

        $dataHolder['recipes'] = $recipe;

        return $this->loadView('admin.recipeUpdate', $dataHolder);
    }

    public function recipeManagerUpdate()
    {
        if (!UserController::isAdmin()) {
            return parent::loadError('404');
        }
        $data = $_POST;

        if ($_FILES['file']['name'] != null) {
            $data['image_url'] = UploadImageOperation::process();
        }
        RecipeUpdateOperation::execute($data);


    }

    /*
        Quản lý ingredient
    */
    public function ingredientManager()
    {
        if (!UserController::isAdmin()) {
            return parent::loadError('404');
        }

        $dataHolder['categories'] = IngredientReadOperation::getCat(1);
        $dataHolder['measurement_unit'] = IngredientReadOperation::getCat(2);

        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $ingredients = IngredientReadOperation::getSingleObjectByIdWithoutNutri($_GET['id'], true);
        } else if (isset($_GET['name']) && !empty($_GET['name'])) {
            $ingredients = IngredientReadOperation::getObjectForSearchingWithoutNutri('ingredients.name', $_GET['name'], true);
        } else if (isset($_GET['category']) && !empty($_GET['category'])) {
            $ingredients = IngredientReadOperation::getAllObjectsByFieldAndValueWithoutNutri('ingredient_categories.id', $_GET['category'], true);
        } else if (isset($_GET['measurement_unit']) && !empty($_GET['measurement_unit'])) {
            $ingredients = IngredientReadOperation::getAllObjectsByFieldAndValueWithoutNutri('ingredient_measurement_unit.id', $_GET['measurement_unit'], true);
        }
        if (!isset($ingredients))
            $ingredients = IngredientReadOperation::getAllObjects(true);
        $dataHolder['ingredients'] = $ingredients;

        return $this->loadView('admin.ingredient', $dataHolder);
    }

    public function setIngredientActive()
    {
        if (!UserController::isAdmin()) {
            return parent::loadError('404');
        }
        $data = $_POST;
        IngredientUpdateOperation::setIngredientActive($data);
    }

    public function ingredientManagerUpdateUI()
    {
        if (!UserController::isAdmin()) {
            return parent::loadError('404');
        }

        $ingredientOpt = ValidateIngredientDataHolder::getInstance();
        $data = $_GET;
        $ingredient = IngredientReadOperation::getSingleObjectById($data['id'], true);

        return $this->loadView('admin.ingredientUpdate', ['ingredient' => $ingredient, 'opts' => $ingredientOpt]);
    }

    public function ingredientManagerUpdate()
    {
        if (!UserController::isAdmin()) {
            return parent::loadError('404');
        }
        $data = $_POST;
        IngredientUpdateOperation::execute($data);
    }

    public function ingredientManagerDelete()
    {
        $data = $_POST;
        IngredientDeleteOperation::deleteById($data['id']);
    }
}