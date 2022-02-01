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
}
/******/ })()
;