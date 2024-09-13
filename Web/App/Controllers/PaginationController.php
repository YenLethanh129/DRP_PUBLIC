<?php

namespace App\Controllers;

use App\Operations\RecipeReadOperation;
use App\Operations\IngredientReadOperation;

class PaginationController
{
    private $config = [
        'total' => 0,
        'limit' => 0
    ];

    public function __construct($config = [])
    {
        $condition1 = isset($config['limit']) && $config['limit'] < 0;
        $condition2 = isset($config['total']) && $config['total'] < 0;

        if ($condition1 && $condition2) {
            $e = 'Limit và total page không được nhỏ hơn 0';
            handleException($e);
            die();
        }
        if (!isset($config['querystring'])) {
            $config['querystring'] = 'page';
        }

        $this->config = $config;
    }

    private function getTotalPage()
    {
        $total = $this->config['total'];
        $limit = $this->config['limit'];
        
        return ceil($total / $limit);
    }

    /* Method Common for Get Data */
    private function getData($operation, $limit = 15,$page, $ignoreActive = true)
    {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        if ($page <= 0) {
            $page = 1;
        }

        $this->config['limit'] = $limit; 
        $offset = ($page - 1) * $this->config['limit'];

        $data = $operation::getPaging($offset, $this->config['limit'], $ignoreActive);

        $totalData = $operation::getAllObjects($ignoreActive);
        $this->config['total'] = count($totalData);

        $totalPage = $this->getTotalPage();
      
        return ['data' => $data, 'totalPage' => $totalPage];
    }



    /* Get Recipes Actived Data for Ajax */
    public function getRecipes($page = 1)
    {
        $limit = 10;
        $recipes = $this->getData(RecipeReadOperation::class, $limit, $page);

        // Return Recipes as JSON to Ajax request
        echo json_encode($recipes['data']);
    }

    /* Get All Recipes Data for Ajax of Manager Recipe */
    public function getAllRecipes($page = 1)
    {
        $limit = 10;
        $ignoreActice = true;
        $allRecipes = $this->getData(RecipeReadOperation::class, $limit, $page, $ignoreActice);

        // Return All Recipes as JSON to Ajax request
        echo json_encode(['recipes' => $allRecipes['data'], 'totalPage' => $allRecipes['totalPage']]);
    }
    

    /*Get Ingredients Actived Data for Ajax */
    public function getIngredients($page = 1)
    {
        $limit = 15;
        $ingredients = $this->getData(IngredientReadOperation::class, $limit, $page);

        // Return Ingredients as JSON to Ajax request
        echo json_encode(['ingredients' => $ingredients['data'], 'totalPage' => $ingredients['totalPage']]);
    }

    /* Get All Ingredients Data for Ajax of Manager Ingredients */
    public function getAllIngredients($page = 19)
    {
        $limit = 15;
        $ignoreActice = true;
        $allIngredients = $this->getData(IngredientReadOperation::class, $limit, $page, $ignoreActice);

        // Return All Ingredients as JSON to Ajax request
        echo json_encode(['ingredients' => $allIngredients['data'], 'totalPage' => $allIngredients['totalPage']]);
    }
    
    
}
