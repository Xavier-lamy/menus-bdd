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

//Add recipe row
let modifyMenuTable = document.getElementById('modifyMenuTable');
let addMenuTable = document.getElementById('addMenuTable');

if( modifyMenuTable || addMenuTable){
  const recipeOptions = document.getElementById('selectRecipeOptions').innerHTML;

  //Morning
  let addMorningRecipeButton = document.getElementById('addMorningRecipeButton');
  let incrementedMorningId = document.getElementsByName('recipeMorningRow').length + 1;

  addMorningRecipeButton.addEventListener('click', function(){
      let buttonRow = document.getElementById('addMorningRecipeRow');

      let newRow = '<tr>'
      + '<td class="text--center p--1">'
      + '<select name="morning['+ incrementedMorningId +'][recipe]" id="recipe_morning_'+ incrementedMorningId +'" aria-label="Recipe" form="add_menu_form" class="text--center input--inset" title="Recipe" required>'
      + recipeOptions
      + '</select>'
      + '</td>'
      + '<td>'
      + '<input type="number" aria-label="Portions" min="0" name="morning['+ incrementedMorningId +'][portion]" form="add_menu_form" class="text--center input--inset" placeholder="Portions" required>'
      + '</td>'
      + '<td class="text--center p--1">'
      + '<button type="button" name="deleteRow" id="deleteMorningRow'+ incrementedMorningId +'" class="button--sm">Delete row</button>'
      + '</td>'
      + '</tr>';

      if(modifyRecipeTable){
        newRow = '<tr>'
        + '<td class="text--center p--1">'
        + '<select name="morning['+ incrementedMorningId +'][recipe]" id="recipe_morning_'+ incrementedMorningId +'" aria-label="Recipe" form="update_menu_form" class="text--center input--inset" title="Recipe" required>'
        + recipeOptions
        + '</select>'
        + '</td>'
        + '<td>'
        + '<input type="number" aria-label="Portions" min="0" name="morning['+ incrementedMorningId +'][portion]" form="update_menu_form" class="text--center input--inset" placeholder="Portions" required>'
        + '</td>'
        + '<td class="text--center p--1">'
        + '<button type="button" name="deleteRow" id="deleteMorningRow'+ incrementedMorningId +'" class="button--sm">Delete row</button>'
        + '</td>'
        + '</tr>';
      }

      incrementedMorningId ++;

      buttonRow.insertAdjacentHTML('beforebegin', newRow);
  });

  //Noon
  let addNoonRecipeButton = document.getElementById('addNoonRecipeButton');
  let incrementedNoonId = document.getElementsByName('recipeNoonRow').length + 1;

  addNoonRecipeButton.addEventListener('click', function(){
      let buttonRow = document.getElementById('addNoonRecipeRow');

      let newRow = '<tr>'
      + '<td class="text--center p--1">'
      + '<select name="noon['+ incrementedNoonId +'][recipe]" id="recipe_noon_'+ incrementedNoonId +'" aria-label="Recipe" form="add_menu_form" class="text--center input--inset" title="Recipe" required>'
      + recipeOptions
      + '</select>'
      + '</td>'
      + '<td>'
      + '<input type="number" aria-label="Portions" min="0" name="noon['+ incrementedNoonId +'][portion]" form="add_menu_form" class="text--center input--inset" placeholder="Portions" required>'
      + '</td>'
      + '<td class="text--center p--1">'
      + '<button type="button" name="deleteRow" id="deleteNoonRow'+ incrementedNoonId +'" class="button--sm">Delete row</button>'
      + '</td>'
      + '</tr>';

      if(modifyRecipeTable){
        newRow = '<tr>'
        + '<td class="text--center p--1">'
        + '<select name="noon['+ incrementedNoonId +'][recipe]" id="recipe_noon_'+ incrementedNoonId +'" aria-label="Recipe" form="update_menu_form" class="text--center input--inset" title="Recipe" required>'
        + recipeOptions
        + '</select>'
        + '</td>'
        + '<td>'
        + '<input type="number" aria-label="Portions" min="0" name="noon['+ incrementedNoonId +'][portion]" form="update_menu_form" class="text--center input--inset" placeholder="Portions" required>'
        + '</td>'
        + '<td class="text--center p--1">'
        + '<button type="button" name="deleteRow" id="deleteNoonRow'+ incrementedNoonId +'" class="button--sm">Delete row</button>'
        + '</td>'
        + '</tr>';
      }

      incrementedNoonId ++;

      buttonRow.insertAdjacentHTML('beforebegin', newRow);
  });

  //Evening
  let addEveningRecipeButton = document.getElementById('addEveningRecipeButton');
  let incrementedEveningId = document.getElementsByName('recipeEveningRow').length + 1;

  addEveningRecipeButton.addEventListener('click', function(){
      let buttonRow = document.getElementById('addEveningRecipeRow');

      let newRow = '<tr>'
      + '<td class="text--center p--1">'
      + '<select name="evening['+ incrementedEveningId +'][recipe]" id="recipe_evening_'+ incrementedEveningId +'" aria-label="Recipe" form="add_menu_form" class="text--center input--inset" title="Recipe" required>'
      + recipeOptions
      + '</select>'
      + '</td>'
      + '<td>'
      + '<input type="number" aria-label="Portions" min="0" name="evening['+ incrementedEveningId +'][portion]" form="add_menu_form" class="text--center input--inset" placeholder="Portions" required>'
      + '</td>'
      + '<td class="text--center p--1">'
      + '<button type="button" name="deleteRow" id="deleteEveningRow'+ incrementedEveningId +'" class="button--sm">Delete row</button>'
      + '</td>'
      + '</tr>';

      if(modifyRecipeTable){
        newRow = '<tr>'
        + '<td class="text--center p--1">'
        + '<select name="evening['+ incrementedEveningId +'][recipe]" id="recipe_evening_'+ incrementedEveningId +'" aria-label="Recipe" form="update_menu_form" class="text--center input--inset" title="Recipe" required>'
        + recipeOptions
        + '</select>'
        + '</td>'
        + '<td>'
        + '<input type="number" aria-label="Portions" min="0" name="evening['+ incrementedEveningId +'][portion]" form="update_menu_form" class="text--center input--inset" placeholder="Portions" required>'
        + '</td>'
        + '<td class="text--center p--1">'
        + '<button type="button" name="deleteRow" id="deleteEveningRow'+ incrementedEveningId +'" class="button--sm">Delete row</button>'
        + '</td>'
        + '</tr>';
      }

      incrementedEveningId ++;

      buttonRow.insertAdjacentHTML('beforebegin', newRow);
  });

  //Delete a recipe row
  window.onload = checkClickedButton();

  function checkClickedButton() {
    if(document.getElementById("modifyMenuTable")){
      document.getElementById("modifyMenuTable").onclick = clickedButton;    
    }
    else {
      document.getElementById("addMenuTable").onclick = clickedButton;
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
