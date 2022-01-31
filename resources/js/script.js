//Add new ingredient row
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
    + '<td class="text--center p--1">'
    + '<button type="button" name="deleteRow" id="deleteRow'+ incrementedId +'" class="button--sm">Delete row</button>'
    + '</td>'
    + '</tr>';

    incrementedId ++;

    buttonRow.insertAdjacentHTML('beforebegin', newRow);
});

//Delete an ingredient row
window.onload = checkClickedButton();

function checkClickedButton() {
  document.getElementById("addRecipeTable").onclick = clickedButton;
}

function clickedButton(e) {
  if (e.target.name == 'deleteRow') {
    targetId = e.target.id;
    let elementToDelete = document.getElementById(targetId);
    elementToDelete.closest('tr').remove();
  }
}
