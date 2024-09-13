<?php

// homepage router

$router->get('/', 'HomeController@homePage');
$router->get('/index', 'HomeController@index');
$router->get('/homepage', 'HomeController@homePage');

// bmi router
$router->get('/check-bmi', 'BmiController@index');

// user router
$router->get('/login', 'UserController@loginUI');
$router->post('/login', 'UserController@login');
$router->get('/registery', 'UserController@registeryUI');
$router->post('/registery', 'UserController@registery');
$router->get('/logout', 'UserController@logout');
// $router->get('/user/profile','UserController@profile');
// $router->get('/user/edit','UserController@editUI');
// $router->post('/user/edit','UserController@edit');

/*
    Admin
*/
//User
$router->get('/manager', 'AdminController@index');
$router->get('/manager/user', 'AdminController@userManager');
$router->post('/manager/user', 'AdminController@setUserLevel');
$router->get('/manager/user/update', 'AdminController@userManagerUpdateUI');
$router->post('/manager/user/update', 'AdminController@userManagerUpdate');
$router->post('/manager/user/add', 'AdminController@userManagerAdd');
//Recipe
$router->get('/manager/recipe', 'AdminController@recipeManager');
$router->post('/manager/recipe', 'AdminController@setRecipeActive');
$router->get('/manager/recipe/update', 'AdminController@recipeManagerUpdateUI');
$router->post('/manager/recipe/update', 'AdminController@recipeManagerUpdate');
$router->get('/manager/recipe/add', 'AdminController@addRecipeUI');
//Ingredient
$router->get('/manager/ingredient', 'AdminController@ingredientManager');
$router->post('/manager/ingredient', 'AdminController@setIngredientActive');
$router->get('/manager/ingredient/update', 'AdminController@ingredientManagerUpdateUI');
$router->post('/manager/ingredient/update', 'AdminController@ingredientManagerUpdate');
$router->post('/manager/ingredient/delete', 'AdminController@ingredientManagerDelete');


// ingredient router
$router->get('/ingredient', 'IngredientController@index');
$router->get('/ingredients/{page}', 'PaginationController@getIngredients');
$router->get('/ingredients-all/{page}', 'PaginationController@getAllIngredients');
$router->get('/ingredient/find-by-id', 'IngredientController@findByName');
$router->get('/ingredient/list-by-category', 'IngredientController@listByCategory');
$router->get('/ingredient/add', 'IngredientController@addUI');
$router->post('/ingredient/add', 'IngredientController@add');
$router->get('/ingredient/find', 'IngredientController@findByName');
$router->get('/ingredient/edit', 'IngredientController@editUI');
$router->post('/ingredient/edit', 'IngredientController@edit');
$router->get('/ingredient/delete', 'IngredientController@delete');

// recipe router

$router->get('/recipe', 'RecipeController@index');
$router->get('/recipes/{page}', 'PaginationController@getRecipes');
$router->get('/recipes-all/{page}', 'PaginationController@getAllRecipes');
$router->get('/recipe/find-by-name', 'RecipeController@findByName');

$router->get('/recipe/list', 'RecipeController@listByName');
$router->get('/recipe/list-by-category', 'RecipeController@listByCategory');
$router->get('/recipe/add', 'RecipeController@addUI');
$router->post('/recipe/add', 'RecipeController@add');
$router->get('/recipe/filter/{course}', 'RecipeController@tempView');


$router->get('/recipe/find-result', 'RecipeController@findResult');
$router->get('/recipe/find', 'RecipeController@find');


$router->get('/recipe/edit', 'RecipeController@editUI');
$router->post('/recipe/edit', 'RecipeController@edit');
$router->get('/recipe/delete', 'RecipeController@delete');
$router->get('/recipe/detail', 'RecipeController@viewDetail');
$router->get('/recipe/search', 'RecipeController@search');

$router->get('/test', 'IngredientController@test');