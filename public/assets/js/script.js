/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************!*\
  !*** ./resources/js/script.js ***!
  \********************************/
//Add new ingredient row
var addIngredientButton = document.getElementById('addIngredientButton');
var ingredientOptions = document.getElementById('ingredient_id_1').innerHTML;
var incrementedId = 2;
addIngredientButton.addEventListener('click', function () {
  var buttonRow = document.getElementById('addIngredientRow');
  var newRow = '<tr>' + '<td class="text--center p--1">' + '<select name="ingredient[' + incrementedId + '][command_id]" id="ingredient_id_' + incrementedId + '" aria-label="Ingredient (unit)" form="add_recipe_form" class="text--center input--inset" title="Ingredient (unit)" required>' + ingredientOptions + '</select>' + '</td>' + '<td>' + '<input type="number" aria-label="Quantity" min="0" name="ingredient[' + incrementedId + '][quantity]" form="add_recipe_form" class="text--center input--inset" placeholder="Quantity" required>' + '</td>' + '<td class="text--center p--1">' + '<button type="button" name="deleteRow" id="deleteRow' + incrementedId + '" class="button--sm">Delete row</button>' + '</td>' + '</tr>';
  incrementedId++;
  buttonRow.insertAdjacentHTML('beforebegin', newRow);
}); //Delete an ingredient row

window.onload = checkClickedButton();

function checkClickedButton() {
  document.getElementById("addRecipeTable").onclick = clickedButton;
}

function clickedButton(e) {
  if (e.target.name == 'deleteRow') {
    targetId = e.target.id;
    var elementToDelete = document.getElementById(targetId);
    elementToDelete.closest('tr').remove();
  }
}
/******/ })()
;