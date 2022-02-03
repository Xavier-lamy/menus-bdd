/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************!*\
  !*** ./resources/js/script.js ***!
  \********************************/
//Add new ingredient row
var modifyRecipeTable = document.getElementById('modifyRecipeTable');
var addRecipeTable = document.getElementById('addRecipeTable');

if (modifyRecipeTable || addRecipeTable) {
  var checkClickedButton = function checkClickedButton() {
    if (document.getElementById("modifyRecipeTable")) {
      document.getElementById("modifyRecipeTable").onclick = clickedButton;
    } else {
      document.getElementById("addRecipeTable").onclick = clickedButton;
    }
  };

  var clickedButton = function clickedButton(e) {
    if (e.target.name == 'deleteRow') {
      targetId = e.target.id;
      var elementToDelete = document.getElementById(targetId);
      elementToDelete.closest('tr').remove();
    }
  };

  var addIngredientButton = document.getElementById('addIngredientButton');
  var ingredientOptions = document.getElementById('selectIngredientOptions').innerHTML;
  var incrementedId = document.getElementsByName('ingredientRow').length + 1;
  addIngredientButton.addEventListener('click', function () {
    var buttonRow = document.getElementById('addIngredientRow');
    var newRow = '<tr>' + '<td class="text--center p--1">' + '<select name="ingredient[' + incrementedId + '][command_id]" id="ingredient_id_' + incrementedId + '" aria-label="Ingredient (unit)" form="add_recipe_form" class="text--center input--inset" title="Ingredient (unit)" required>' + ingredientOptions + '</select>' + '</td>' + '<td>' + '<input type="number" aria-label="Quantity" min="0" name="ingredient[' + incrementedId + '][quantity]" form="add_recipe_form" class="text--center input--inset" placeholder="Quantity" required>' + '</td>' + '<td class="text--center p--1">' + '<button type="button" name="deleteRow" id="deleteRow' + incrementedId + '" class="button--sm">Delete row</button>' + '</td>' + '</tr>';

    if (modifyRecipeTable) {
      newRow = '<tr>' + '<td class="text--center p--1">' + '<select name="ingredient[' + incrementedId + '][command_id]" id="ingredient_id_' + incrementedId + '" aria-label="Ingredient (unit)" form="update_recipe_form" class="text--center input--inset" title="Ingredient (unit)" required>' + ingredientOptions + '</select>' + '</td>' + '<td>' + '<input type="number" aria-label="Quantity" min="0" name="ingredient[' + incrementedId + '][quantity]" form="update_recipe_form" class="text--center input--inset" placeholder="Quantity" required>' + '</td>' + '<td class="text--center p--1">' + '<button type="button" name="deleteRow" id="deleteRow' + incrementedId + '" class="button--sm">Delete row</button>' + '</td>' + '</tr>';
    }

    incrementedId++;
    buttonRow.insertAdjacentHTML('beforebegin', newRow);
  }); //Delete an ingredient row

  window.onload = checkClickedButton();
} //Add recipe row


var modifyMenuTable = document.getElementById('modifyMenuTable');
var addMenuTable = document.getElementById('addMenuTable');

if (modifyMenuTable || addMenuTable) {
  var _checkClickedButton = function _checkClickedButton() {
    if (document.getElementById("modifyMenuTable")) {
      document.getElementById("modifyMenuTable").onclick = _clickedButton;
    } else {
      document.getElementById("addMenuTable").onclick = _clickedButton;
    }
  };

  var _clickedButton = function _clickedButton(e) {
    if (e.target.name == 'deleteRow') {
      targetId = e.target.id;
      var elementToDelete = document.getElementById(targetId);
      elementToDelete.closest('tr').remove();
    }
  };

  var recipeOptions = document.getElementById('selectRecipeOptions').innerHTML; //Morning

  var addMorningRecipeButton = document.getElementById('addMorningRecipeButton');
  var incrementedMorningId = document.getElementsByName('recipeMorningRow').length + 1;
  addMorningRecipeButton.addEventListener('click', function () {
    var buttonRow = document.getElementById('addMorningRecipeRow');
    var newRow = '<tr>' + '<td class="text--center p--1">' + '<select name="morning[' + incrementedMorningId + '][recipe]" id="recipe_morning_' + incrementedMorningId + '" aria-label="Recipe" form="add_menu_form" class="text--center input--inset" title="Recipe" required>' + recipeOptions + '</select>' + '</td>' + '<td>' + '<input type="number" aria-label="Portions" min="0" name="morning[' + incrementedMorningId + '][quantity]" form="add_menu_form" class="text--center input--inset" placeholder="Portions" required>' + '</td>' + '<td class="text--center p--1">' + '<button type="button" name="deleteRow" id="deleteMorningRow' + incrementedMorningId + '" class="button--sm">Delete row</button>' + '</td>' + '</tr>';

    if (modifyRecipeTable) {
      newRow = '<tr>' + '<td class="text--center p--1">' + '<select name="morning[' + incrementedMorningId + '][recipe]" id="recipe_morning_' + incrementedMorningId + '" aria-label="Recipe" form="update_menu_form" class="text--center input--inset" title="Recipe" required>' + recipeOptions + '</select>' + '</td>' + '<td>' + '<input type="number" aria-label="Portions" min="0" name="morning[' + incrementedMorningId + '][quantity]" form="update_menu_form" class="text--center input--inset" placeholder="Portions" required>' + '</td>' + '<td class="text--center p--1">' + '<button type="button" name="deleteRow" id="deleteMorningRow' + incrementedMorningId + '" class="button--sm">Delete row</button>' + '</td>' + '</tr>';
    }

    incrementedMorningId++;
    buttonRow.insertAdjacentHTML('beforebegin', newRow);
  }); //Noon

  var addNoonRecipeButton = document.getElementById('addNoonRecipeButton');
  var incrementedNoonId = document.getElementsByName('recipeNoonRow').length + 1;
  addNoonRecipeButton.addEventListener('click', function () {
    var buttonRow = document.getElementById('addNoonRecipeRow');
    var newRow = '<tr>' + '<td class="text--center p--1">' + '<select name="noon[' + incrementedNoonId + '][recipe]" id="recipe_noon_' + incrementedNoonId + '" aria-label="Recipe" form="add_menu_form" class="text--center input--inset" title="Recipe" required>' + recipeOptions + '</select>' + '</td>' + '<td>' + '<input type="number" aria-label="Portions" min="0" name="noon[' + incrementedNoonId + '][quantity]" form="add_menu_form" class="text--center input--inset" placeholder="Portions" required>' + '</td>' + '<td class="text--center p--1">' + '<button type="button" name="deleteRow" id="deleteNoonRow' + incrementedNoonId + '" class="button--sm">Delete row</button>' + '</td>' + '</tr>';

    if (modifyRecipeTable) {
      newRow = '<tr>' + '<td class="text--center p--1">' + '<select name="noon[' + incrementedNoonId + '][recipe]" id="recipe_noon_' + incrementedNoonId + '" aria-label="Recipe" form="update_menu_form" class="text--center input--inset" title="Recipe" required>' + recipeOptions + '</select>' + '</td>' + '<td>' + '<input type="number" aria-label="Portions" min="0" name="noon[' + incrementedNoonId + '][quantity]" form="update_menu_form" class="text--center input--inset" placeholder="Portions" required>' + '</td>' + '<td class="text--center p--1">' + '<button type="button" name="deleteRow" id="deleteNoonRow' + incrementedNoonId + '" class="button--sm">Delete row</button>' + '</td>' + '</tr>';
    }

    incrementedNoonId++;
    buttonRow.insertAdjacentHTML('beforebegin', newRow);
  }); //Evening

  var addEveningRecipeButton = document.getElementById('addEveningRecipeButton');
  var incrementedEveningId = document.getElementsByName('recipeEveningRow').length + 1;
  addEveningRecipeButton.addEventListener('click', function () {
    var buttonRow = document.getElementById('addEveningRecipeRow');
    var newRow = '<tr>' + '<td class="text--center p--1">' + '<select name="evening[' + incrementedEveningId + '][recipe]" id="recipe_evening_' + incrementedEveningId + '" aria-label="Recipe" form="add_menu_form" class="text--center input--inset" title="Recipe" required>' + recipeOptions + '</select>' + '</td>' + '<td>' + '<input type="number" aria-label="Portions" min="0" name="evening[' + incrementedEveningId + '][quantity]" form="add_menu_form" class="text--center input--inset" placeholder="Portions" required>' + '</td>' + '<td class="text--center p--1">' + '<button type="button" name="deleteRow" id="deleteEveningRow' + incrementedEveningId + '" class="button--sm">Delete row</button>' + '</td>' + '</tr>';

    if (modifyRecipeTable) {
      newRow = '<tr>' + '<td class="text--center p--1">' + '<select name="evening[' + incrementedEveningId + '][recipe]" id="recipe_evening_' + incrementedEveningId + '" aria-label="Recipe" form="update_menu_form" class="text--center input--inset" title="Recipe" required>' + recipeOptions + '</select>' + '</td>' + '<td>' + '<input type="number" aria-label="Portions" min="0" name="evening[' + incrementedEveningId + '][quantity]" form="update_menu_form" class="text--center input--inset" placeholder="Portions" required>' + '</td>' + '<td class="text--center p--1">' + '<button type="button" name="deleteRow" id="deleteEveningRow' + incrementedEveningId + '" class="button--sm">Delete row</button>' + '</td>' + '</tr>';
    }

    incrementedEveningId++;
    buttonRow.insertAdjacentHTML('beforebegin', newRow);
  }); //Delete a recipe row

  window.onload = _checkClickedButton();
}
/******/ })()
;