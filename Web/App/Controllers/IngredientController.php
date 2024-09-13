<?php 
namespace App\Controllers;
use App\Operations\IngredientReadOperation;
use App\Operations\IngredientCreateOperation;
use App\Operations\IngredientDeleteOperation;
use App\Operations\IngredientUpdateOperation;
use App\Operations\ValidateIngredientDataHolder;

class IngredientController extends BaseController
{
    public function index() {
        return $this->loadView('ingredient.index');
    }

    public function listByCategory() {
        $category = $_GET['category'];
        $ingredients = IngredientReadOperation::getAllObjectsByFieldAndValue('category', $category);
        if(! $ingredients == null) 
            return $this->loadView('ingredient.list_all', $ingredients);
        else
            echo \App\Views\ViewRender::errorViewRender('410');
    }
    public function listByCategoryWithOffset() {
        $category = $_GET['category'];
        $offset = $_GET['offset'];
        $limit = $_GET['limit'];
        $ingredients = IngredientReadOperation::getObjectWithOffsetByFielAndValue('category', $category, $offset, $limit);
        if ($ingredients == null) {
            echo \App\Views\ViewRender::errorViewRender('410');
        }
        else
            return $this->loadView('ingredient.list_all', $ingredients);
    }
    public function addUI() {
        if (!UserController::isContributer()) {
            return parent::loadError('404');
        }
        $optionVal = ValidateIngredientDataHolder::getInstance();
        $data[] = $optionVal;
        return $this->loadView('ingredient.add', $data);
    }
    public function add() {
        if (!UserController::isContributer()) {
            return parent::loadError('404');
        }
        $data = $_POST;
        IngredientCreateOperation::execute($data);
    }
    public function findByName(){
        return $this->loadView('ingredient.find_ingredient');
    }
    public function editUI() {
        if (!UserController::isContributer()) {
            return parent::loadError('404');
        }
        try {
            $ingredient = IngredientReadOperation::getSingleObjectById(1);
            $data[] = $ingredient; 
            return $this->loadView('ingredient.update', $data);
        } catch (\PDOException $PDOException) {
            handlePDOException($PDOException);
            echo \App\Views\ViewRender::errorViewRender('500');
        } catch (\Exception $exception) {
            handleException($exception);
        } catch (\Throwable $throwable) {
            handleError($throwable->getCode(), $throwable->getMessage(), $throwable->getFile(), $throwable->getLine());
        }
        echo \App\Views\ViewRender::errorViewRender('404');
        return null;
    }
    public function edit() {
        if (!UserController::isContributer()) {
            return parent::loadError('404');
        }
        $data = $_POST;
        IngredientUpdateOperation::execute($data);
    }

    public function test() {
        if (!UserController::isContributer()) {
            return parent::loadError('404');
        }
        $ingredients = IngredientReadOperation::getAllObjects();
        $ingredientss[] = $ingredients; 
        $this->loadView('pages.test', $ingredientss);

    }

}