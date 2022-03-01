/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************!*\
  !*** ./resources/js/script.js ***!
  \********************************/
/**
 * Add new ingredient row
 */
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

  var ingredientOptions = document.getElementById('select_ingredient_options').innerHTML; //Define form name depending on situation

  var formName = 'add_recipe_form';

  if (modifyRecipeTable) {
    formName = 'update_recipe_form';
  }

  var addIngredientButton = document.getElementById('add_ingredient_button');
  var incrementedId = document.getElementsByName('ingredient_row').length + 1;
  addIngredientButton.addEventListener('click', function () {
    var buttonRow = document.getElementById('add_ingredient_row');
    var newRow = "<tr name=\"ingredient_row\">\n        <td class=\"text--center p--1\">\n          <select name=\"ingredient[".concat(incrementedId, "][command_id]\" id=\"ingredient_id_").concat(incrementedId, "\" aria-label=\"Ingredient (unit)\" form=\"").concat(formName, "\" class=\"text--center input--inset\" title=\"Ingredient (unit)\" required>\n            ").concat(ingredientOptions, "\n          </select>\n        </td>\n        <td>\n          <input type=\"number\" aria-label=\"Quantity\" min=\"0\" name=\"ingredient[").concat(incrementedId, "][quantity]\" form=\"").concat(formName, "\" class=\"text--center input--inset\" placeholder=\"Quantity\" required>\n        </td>\n        <td class=\"text--center p--1\">\n          <button type=\"button\" name=\"delete_row\" id=\"delete_row").concat(incrementedId, "\" class=\"button--sm\">Delete row</button>\n        </td>\n      </tr>");
    incrementedId++;
    buttonRow.insertAdjacentHTML('beforebegin', newRow);
  }); //Delete an ingredient row

  window.onload = checkClickedButton();
}
/**
 * Add recipe row in menu
 */


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

  var recipeOptions = document.getElementById('select_recipe_options').innerHTML; //Define form name depending on situation

  var _formName = 'add_menu_form';

  if (modifyMenuTable) {
    _formName = 'update_menu_form';
  } //Loop through all buttons with attribute data-moment


  var addRecipeButtons = document.querySelectorAll('[data-moment]');
  addRecipeButtons.forEach(function (addRecipeButton) {
    var moment = addRecipeButton.dataset.moment;
    var incrementId = document.getElementsByName("".concat(moment, "_recipe_row")).length + 1;
    addRecipeButton.addEventListener('click', function () {
      var buttonRow = document.getElementById("add_".concat(moment, "_recipe_row"));
      var newRow = "<tr name=\"".concat(moment, "_recipe_row\">\n        <td class=\"text--center p--1\">\n          <select name=\"").concat(moment, "[").concat(incrementId, "][recipe]\" id=\"recipe_").concat(moment, "_").concat(incrementId, "\" aria-label=\"Recipe\" form=\"").concat(_formName, "\" class=\"text--center input--inset\" title=\"Recipe\" required>\n            ").concat(recipeOptions, "\n          </select>\n        </td>\n        <td>\n          <input type=\"number\" aria-label=\"Portions\" min=\"0\" name=\"").concat(moment, "[").concat(incrementId, "][portion]\" form=\"").concat(_formName, "\" class=\"text--center input--inset\" placeholder=\"Portions\" required>\n        </td>\n        <td class=\"text--center p--1\">\n          <button type=\"button\" name=\"delete_row\" id=\"delete_").concat(moment, "_row").concat(incrementId, "\" class=\"button--sm\">Delete row</button>\n        </td>\n      </tr>");
      incrementId++;
      buttonRow.insertAdjacentHTML('beforebegin', newRow);
    });
  }); //Delete a recipe row

  window.onload = _checkClickedButton();
}
/******/ })()
;