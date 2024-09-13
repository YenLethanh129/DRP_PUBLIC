$(document).ready(function () {
  $("#recipe-form").validate({
      rules: {
          name: {
              required: true
          },
          preparation_time: {
              required: true,
              digits: true
          },
          cooking_time: {
              required: true,
              digits: true
          },
          meal_recipe_1: {
              required: true
          },
          meal: {
              required: true
          },
          method: {
              required: true
          },
          directions: {
              required: true
          },
          description: {
              required: true
          }
      },
      messages: {
          name: {
              required: "Please enter the recipe name."
          },
          preparation_time: {
              required: "Please enter the preparation time.",
              digits: "Please enter a valid number for preparation time."
          },
          cooking_time: {
              required: "Please enter the cooking time.",
              digits: "Please enter a valid number for cooking time."
          },
          meal_recipe_1: {
              required: "Please select a meal recipe."
          },
          meal: {
              required: "Please select a meal type."
          },
          method: {
              required: "Please select a meal category."
          },
          directions: {
              required: "Please enter the directions."
          },
          description: {
              required: "Please enter the description."
          }
      },
      errorElement: 'div',
      errorPlacement: function(error, element) {
          error.addClass('error-message');
          error.insertAfter(element);
      }
  });
});