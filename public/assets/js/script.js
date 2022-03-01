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

  var addIngredientButton = document.getElementById('add_ingredient_button');
  var ingredientOptions = document.getElementById('select_ingredient_options').innerHTML;
  var incrementedId = document.getElementsByName('ingredient_row').length + 1;
  addIngredientButton.addEventListener('click', function () {
    var buttonRow = document.getElementById('add_ingredient_row');
    var newRow = "<tr name=\"ingredient_row\">\n        <td class=\"text--center p--1\">\n          <select name=\"ingredient[".concat(incrementedId, "][command_id]\" id=\"ingredient_id_").concat(incrementedId, "\" aria-label=\"Ingredient (unit)\" form=\"add_recipe_form\" class=\"text--center input--inset\" title=\"Ingredient (unit)\" required>\n            ").concat(ingredientOptions, "\n          </select>\n        </td>\n        <td>\n          <input type=\"number\" aria-label=\"Quantity\" min=\"0\" name=\"ingredient[").concat(incrementedId, "][quantity]\" form=\"add_recipe_form\" class=\"text--center input--inset\" placeholder=\"Quantity\" required>\n        </td>\n        <td class=\"text--center p--1\">\n          <button type=\"button\" name=\"delete_row\" id=\"delete_row").concat(incrementedId, "\" class=\"button--sm\">Delete row</button>\n        </td>\n      </tr>");

    if (modifyRecipeTable) {
      newRow = "<tr name=\"ingredient_row\">\n          <td class=\"text--center p--1\">\n            <select name=\"ingredient[".concat(incrementedId, "][command_id]\" id=\"ingredient_id_").concat(incrementedId, "\" aria-label=\"Ingredient (unit)\" form=\"update_recipe_form\" class=\"text--center input--inset\" title=\"Ingredient (unit)\" required>\n              ").concat(ingredientOptions, "\n            </select>\n          </td>\n          <td>\n            <input type=\"number\" aria-label=\"Quantity\" min=\"0\" name=\"ingredient[").concat(incrementedId, "][quantity]\" form=\"update_recipe_form\" class=\"text--center input--inset\" placeholder=\"Quantity\" required>\n          </td>\n          <td class=\"text--center p--1\">\n            <button type=\"button\" name=\"delete_row\" id=\"delete_row").concat(incrementedId, "\" class=\"button--sm\">Delete row</button>\n          </td>\n        </tr>");
    }

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

  var formName = 'add_menu_form';

  if (modifyMenuTable) {
    formName = 'update_menu_form';
  } //Morning


  var addMorningRecipeButton = document.getElementById('add_morning_recipe_button');
  var incrementedMorningId = document.getElementsByName('morning_recipe_row').length + 1;
  addMorningRecipeButton.addEventListener('click', function () {
    var buttonRow = document.getElementById('add_morning_recipe_row');
    var newRow = "<tr name=\"morning_recipe_row\">\n        <td class=\"text--center p--1\">\n          <select name=\"morning[".concat(incrementedMorningId, "][recipe]\" id=\"recipe_morning_").concat(incrementedMorningId, "\" aria-label=\"Recipe\" form=\"").concat(formName, "\" class=\"text--center input--inset\" title=\"Recipe\" required>\n            ").concat(recipeOptions, "\n          </select>\n        </td>\n        <td>\n          <input type=\"number\" aria-label=\"Portions\" min=\"0\" name=\"morning[").concat(incrementedMorningId, "][portion]\" form=\"").concat(formName, "\" class=\"text--center input--inset\" placeholder=\"Portions\" required>\n        </td>\n        <td class=\"text--center p--1\">\n          <button type=\"button\" name=\"delete_row\" id=\"delete_morning_row").concat(incrementedMorningId, "\" class=\"button--sm\">Delete row</button>\n        </td>\n      </tr>");
    incrementedMorningId++;
    buttonRow.insertAdjacentHTML('beforebegin', newRow);
  }); //Noon

  var addNoonRecipeButton = document.getElementById('add_noon_recipe_button');
  var incrementedNoonId = document.getElementsByName('noon_recipe_row').length + 1;
  addNoonRecipeButton.addEventListener('click', function () {
    var buttonRow = document.getElementById('add_noon_recipe_row');
    var newRow = "<tr name=\"noon_recipe_row\">\n        <td class=\"text--center p--1\">\n          <select name=\"noon[".concat(incrementedNoonId, "][recipe]\" id=\"recipe_noon_").concat(incrementedNoonId, "\" aria-label=\"Recipe\" form=\"").concat(formName, "\" class=\"text--center input--inset\" title=\"Recipe\" required>\n            ").concat(recipeOptions, "\n          </select>\n        </td>\n        <td>\n          <input type=\"number\" aria-label=\"Portions\" min=\"0\" name=\"noon[").concat(incrementedNoonId, "][portion]\" form=\"").concat(formName, "\" class=\"text--center input--inset\" placeholder=\"Portions\" required>\n        </td>\n        <td class=\"text--center p--1\">\n          <button type=\"button\" name=\"delete_row\" id=\"delete_noon_row").concat(incrementedNoonId, "\" class=\"button--sm\">Delete row</button>\n        </td>\n      </tr>");
    incrementedNoonId++;
    buttonRow.insertAdjacentHTML('beforebegin', newRow);
  }); //Evening

  var addEveningRecipeButton = document.getElementById('add_evening_recipe_button');
  var incrementedEveningId = document.getElementsByName('evening_recipe_row').length + 1;
  addEveningRecipeButton.addEventListener('click', function () {
    var buttonRow = document.getElementById('add_evening_recipe_row');
    var newRow = "<tr name=\"evening_recipe_row\">\n        <td class=\"text--center p--1\">\n          <select name=\"evening[".concat(incrementedEveningId, "][recipe]\" id=\"recipe_evening_").concat(incrementedEveningId, "\" aria-label=\"Recipe\" form=\"").concat(formName, "\" class=\"text--center input--inset\" title=\"Recipe\" required>\n          ").concat(recipeOptions, "\n          </select>\n        </td>\n        <td>\n          <input type=\"number\" aria-label=\"Portions\" min=\"0\" name=\"evening[").concat(incrementedEveningId, "][portion]\" form=\"").concat(formName, "\" class=\"text--center input--inset\" placeholder=\"Portions\" required>\n        </td>\n        <td class=\"text--center p--1\">\n          <button type=\"button\" name=\"delete_row\" id=\"delete_evening_row").concat(incrementedEveningId, "\" class=\"button--sm\">Delete row</button>\n        </td>\n      </tr>");
    incrementedEveningId++;
    buttonRow.insertAdjacentHTML('beforebegin', newRow);
  }); //Delete a recipe row

  window.onload = _checkClickedButton();
}
/******/ })()
;