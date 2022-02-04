/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************!*\
  !*** ./resources/js/script.js ***!
  \********************************/
//Add new ingredient row
var modifyRecipeTable = document.getElementById('modify_recipe_table');
var addRecipeTable = document.getElementById('add_recipe_table');

if (modifyRecipeTable || addRecipeTable) {
  var checkClickedButton = function checkClickedButton() {
    if (document.getElementById("modify_recipe_table")) {
      document.getElementById("modify_recipe_table").onclick = clickedButton;
    } else {
      document.getElementById("add_recipe_table").onclick = clickedButton;
    }
  };

  var clickedButton = function clickedButton(e) {
    if (e.target.name == 'delete_row') {
      targetId = e.target.id;
      var elementToDelete = document.getElementById(targetId);
      elementToDelete.closest('tr').remove();
    }
  };

  var addIngredientButton = document.getElementById('add_ingredient_button');
  var ingredientOptions = document.getElementById('select_ingredient_options').innerHTML;
  var incrementedId = document.getElementsByName('ingredient_row').length + 1;
  addIngredientButton.addEventListener('click', function () {
    var buttonRow = document.getElementById('add_ingredient_row');
    var newRow = '<tr>' + '<td class="text--center p--1">' + '<select name="ingredient[' + incrementedId + '][command_id]" id="ingredient_id_' + incrementedId + '" aria-label="Ingredient (unit)" form="add_recipe_form" class="text--center input--inset" title="Ingredient (unit)" required>' + ingredientOptions + '</select>' + '</td>' + '<td>' + '<input type="number" aria-label="Quantity" min="0" name="ingredient[' + incrementedId + '][quantity]" form="add_recipe_form" class="text--center input--inset" placeholder="Quantity" required>' + '</td>' + '<td class="text--center p--1">' + '<button type="button" name="delete_row" id="delete_row' + incrementedId + '" class="button--sm">Delete row</button>' + '</td>' + '</tr>';

    if (modifyRecipeTable) {
      newRow = '<tr>' + '<td class="text--center p--1">' + '<select name="ingredient[' + incrementedId + '][command_id]" id="ingredient_id_' + incrementedId + '" aria-label="Ingredient (unit)" form="update_recipe_form" class="text--center input--inset" title="Ingredient (unit)" required>' + ingredientOptions + '</select>' + '</td>' + '<td>' + '<input type="number" aria-label="Quantity" min="0" name="ingredient[' + incrementedId + '][quantity]" form="update_recipe_form" class="text--center input--inset" placeholder="Quantity" required>' + '</td>' + '<td class="text--center p--1">' + '<button type="button" name="delete_row" id="delete_row' + incrementedId + '" class="button--sm">Delete row</button>' + '</td>' + '</tr>';
    }

    incrementedId++;
    buttonRow.insertAdjacentHTML('beforebegin', newRow);
  }); //Delete an ingredient row

  window.onload = checkClickedButton();
} //Add recipe row


var modifyMenuTable = document.getElementById('modify_menu_table');
var addMenuTable = document.getElementById('add_menu_table');

if (modifyMenuTable || addMenuTable) {
  var _checkClickedButton = function _checkClickedButton() {
    if (document.getElementById("modify_menu_table")) {
      document.getElementById("modify_menu_table").onclick = _clickedButton;
    } else {
      document.getElementById("add_menu_table").onclick = _clickedButton;
    }
  };

  var _clickedButton = function _clickedButton(e) {
    if (e.target.name == 'delete_row') {
      targetId = e.target.id;
      var elementToDelete = document.getElementById(targetId);
      elementToDelete.closest('tr').remove();
    }
  };

  var recipeOptions = document.getElementById('select_recipe_options').innerHTML; //Morning

  var addMorningRecipeButton = document.getElementById('add_morning_recipe_button');
  var incrementedMorningId = document.getElementsByName('recipe_morning_row').length + 1;
  addMorningRecipeButton.addEventListener('click', function () {
    var buttonRow = document.getElementById('add_morning_recipe_row');
    var newRow = '<tr>' + '<td class="text--center p--1">' + '<select name="morning[' + incrementedMorningId + '][recipe]" id="recipe_morning_' + incrementedMorningId + '" aria-label="Recipe" form="add_menu_form" class="text--center input--inset" title="Recipe" required>' + recipeOptions + '</select>' + '</td>' + '<td>' + '<input type="number" aria-label="Portions" min="0" name="morning[' + incrementedMorningId + '][portion]" form="add_menu_form" class="text--center input--inset" placeholder="Portions" required>' + '</td>' + '<td class="text--center p--1">' + '<button type="button" name="delete_row" id="delete_morning_row' + incrementedMorningId + '" class="button--sm">Delete row</button>' + '</td>' + '</tr>';

    if (modifyMenuTable) {
      newRow = '<tr>' + '<td class="text--center p--1">' + '<select name="morning[' + incrementedMorningId + '][recipe]" id="recipe_morning_' + incrementedMorningId + '" aria-label="Recipe" form="update_menu_form" class="text--center input--inset" title="Recipe" required>' + recipeOptions + '</select>' + '</td>' + '<td>' + '<input type="number" aria-label="Portions" min="0" name="morning[' + incrementedMorningId + '][portion]" form="update_menu_form" class="text--center input--inset" placeholder="Portions" required>' + '</td>' + '<td class="text--center p--1">' + '<button type="button" name="delete_row" id="delete_morning_row' + incrementedMorningId + '" class="button--sm">Delete row</button>' + '</td>' + '</tr>';
    }

    incrementedMorningId++;
    buttonRow.insertAdjacentHTML('beforebegin', newRow);
  }); //Noon

  var addNoonRecipeButton = document.getElementById('add_noon_recipe_button');
  var incrementedNoonId = document.getElementsByName('recipe_noon_row').length + 1;
  addNoonRecipeButton.addEventListener('click', function () {
    var buttonRow = document.getElementById('add_noon_recipe_row');
    var newRow = '<tr>' + '<td class="text--center p--1">' + '<select name="noon[' + incrementedNoonId + '][recipe]" id="recipe_noon_' + incrementedNoonId + '" aria-label="Recipe" form="add_menu_form" class="text--center input--inset" title="Recipe" required>' + recipeOptions + '</select>' + '</td>' + '<td>' + '<input type="number" aria-label="Portions" min="0" name="noon[' + incrementedNoonId + '][portion]" form="add_menu_form" class="text--center input--inset" placeholder="Portions" required>' + '</td>' + '<td class="text--center p--1">' + '<button type="button" name="delete_row" id="delete_noon_row' + incrementedNoonId + '" class="button--sm">Delete row</button>' + '</td>' + '</tr>';

    if (modifyMenuTable) {
      newRow = '<tr>' + '<td class="text--center p--1">' + '<select name="noon[' + incrementedNoonId + '][recipe]" id="recipe_noon_' + incrementedNoonId + '" aria-label="Recipe" form="update_menu_form" class="text--center input--inset" title="Recipe" required>' + recipeOptions + '</select>' + '</td>' + '<td>' + '<input type="number" aria-label="Portions" min="0" name="noon[' + incrementedNoonId + '][portion]" form="update_menu_form" class="text--center input--inset" placeholder="Portions" required>' + '</td>' + '<td class="text--center p--1">' + '<button type="button" name="delete_row" id="delete_noon_row' + incrementedNoonId + '" class="button--sm">Delete row</button>' + '</td>' + '</tr>';
    }

    incrementedNoonId++;
    buttonRow.insertAdjacentHTML('beforebegin', newRow);
  }); //Evening

  var addEveningRecipeButton = document.getElementById('add_evening_recipe_button');
  var incrementedEveningId = document.getElementsByName('recipe_evening_row').length + 1;
  addEveningRecipeButton.addEventListener('click', function () {
    var buttonRow = document.getElementById('add_evening_recipe_row');
    var newRow = '<tr>' + '<td class="text--center p--1">' + '<select name="evening[' + incrementedEveningId + '][recipe]" id="recipe_evening_' + incrementedEveningId + '" aria-label="Recipe" form="add_menu_form" class="text--center input--inset" title="Recipe" required>' + recipeOptions + '</select>' + '</td>' + '<td>' + '<input type="number" aria-label="Portions" min="0" name="evening[' + incrementedEveningId + '][portion]" form="add_menu_form" class="text--center input--inset" placeholder="Portions" required>' + '</td>' + '<td class="text--center p--1">' + '<button type="button" name="delete_row" id="delete_evening_row' + incrementedEveningId + '" class="button--sm">Delete row</button>' + '</td>' + '</tr>';

    if (modifyMenuTable) {
      newRow = '<tr>' + '<td class="text--center p--1">' + '<select name="evening[' + incrementedEveningId + '][recipe]" id="recipe_evening_' + incrementedEveningId + '" aria-label="Recipe" form="update_menu_form" class="text--center input--inset" title="Recipe" required>' + recipeOptions + '</select>' + '</td>' + '<td>' + '<input type="number" aria-label="Portions" min="0" name="evening[' + incrementedEveningId + '][portion]" form="update_menu_form" class="text--center input--inset" placeholder="Portions" required>' + '</td>' + '<td class="text--center p--1">' + '<button type="button" name="delete_row" id="delete_evening_row' + incrementedEveningId + '" class="button--sm">Delete row</button>' + '</td>' + '</tr>';
    }

    incrementedEveningId++;
    buttonRow.insertAdjacentHTML('beforebegin', newRow);
  }); //Delete a recipe row

  window.onload = _checkClickedButton();
}
/******/ })()
;