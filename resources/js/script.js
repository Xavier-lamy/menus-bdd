let recipeTable = document.getElementById('addRecipeTable');
let addIngredientButton = document.getElementById('addIngredientButton');
const ingredientOptions = document.getElementById('ingredient_id_1').innerHTML;
let incrementedId = 2;

addIngredientButton.addEventListener('click', function(){
    let buttonRow = document.getElementById('addIngredientRow');

    let newRow = '<tr>'
    + '<td class="text--center p--1">'
    + '<select name="ingredient_id_'+ incrementedId +'" id="ingredient_id_'+ incrementedId +'" aria-label="Ingredient (unit)" form="add_recipe_form" class="text--center input--inset" title="Ingredient (unit)" required>'
    + ingredientOptions
    + '</select>'
    + '</td>'
    + '<td>'
    + '<input type="number" aria-label="Quantity" min="0" name="quantity_'+ incrementedId +'" form="add_recipe_form" class="text--center input--inset" placeholder="Quantity" required>'
    + '</td>'
    + '</tr>';

    incrementedId ++;

    buttonRow.insertAdjacentHTML('beforebegin', newRow);
});