//Add new ingredient row
let modifyRecipeTable = document.getElementById('modifyRecipeTable');
let addRecipeTable = document.getElementById('addRecipeTable');

if( modifyRecipeTable || addRecipeTable){
  let addIngredientButton = document.getElementById('addIngredientButton');
  const ingredientOptions = document.getElementById('selectIngredientOptions').innerHTML;
  let incrementedId = document.getElementsByName('ingredientRow').length + 1;

  addIngredientButton.addEventListener('click', function(){
      let buttonRow = document.getElementById('addIngredientRow');

      let newRow = '<tr>'
      + '<td class="text--center p--1">'
      + '<select name="ingredient['+ incrementedId +'][command_id]" id="ingredient_id_'+ incrementedId +'" aria-label="Ingredient (unit)" form="add_recipe_form" class="text--center input--inset" title="Ingredient (unit)" required>'
      + ingredientOptions
      + '</select>'
      + '</td>'
      + '<td>'
      + '<input type="number" aria-label="Quantity" min="0" name="ingredient['+ incrementedId +'][quantity]" form="add_recipe_form" class="text--center input--inset" placeholder="Quantity" required>'
      + '</td>'
      + '<td class="text--center p--1">'
      + '<button type="button" name="deleteRow" id="deleteRow'+ incrementedId +'" class="button--sm">Delete row</button>'
      + '</td>'
      + '</tr>';

      if(modifyRecipeTable){
        newRow = '<tr>'
        + '<td class="text--center p--1">'
        + '<select name="ingredient['+ incrementedId +'][command_id]" id="ingredient_id_'+ incrementedId +'" aria-label="Ingredient (unit)" form="update_recipe_form" class="text--center input--inset" title="Ingredient (unit)" required>'
        + ingredientOptions
        + '</select>'
        + '</td>'
        + '<td>'
        + '<input type="number" aria-label="Quantity" min="0" name="ingredient['+ incrementedId +'][quantity]" form="update_recipe_form" class="text--center input--inset" placeholder="Quantity" required>'
        + '</td>'
        + '<td class="text--center p--1">'
        + '<button type="button" name="deleteRow" id="deleteRow'+ incrementedId +'" class="button--sm">Delete row</button>'
        + '</td>'
        + '</tr>';
      }

      incrementedId ++;

      buttonRow.insertAdjacentHTML('beforebegin', newRow);
  });

  //Delete an ingredient row
  window.onload = checkClickedButton();

  function checkClickedButton() {
    if(document.getElementById("modifyRecipeTable")){
      document.getElementById("modifyRecipeTable").onclick = clickedButton;    
    }
    else {
      document.getElementById("addRecipeTable").onclick = clickedButton;
    }
  }

  function clickedButton(e) {
    if (e.target.name == 'deleteRow') {
      targetId = e.target.id;
      let elementToDelete = document.getElementById(targetId);
      elementToDelete.closest('tr').remove();
    }
  }
  
}
