//Add new ingredient row
let modifyRecipeTable = document.getElementById('modify_recipe_table');
let addRecipeTable = document.getElementById('add_recipe_table');

if( modifyRecipeTable || addRecipeTable){
  let addIngredientButton = document.getElementById('add_ingredient_button');
  const ingredientOptions = document.getElementById('select_ingredient_options').innerHTML;
  let incrementedId = document.getElementsByName('ingredient_row').length + 1;

  addIngredientButton.addEventListener('click', function(){
      let buttonRow = document.getElementById('add_ingredient_row');

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
      + '<button type="button" name="delete_row" id="delete_row'+ incrementedId +'" class="button--sm">Delete row</button>'
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
        + '<button type="button" name="delete_row" id="delete_row'+ incrementedId +'" class="button--sm">Delete row</button>'
        + '</td>'
        + '</tr>';
      }

      incrementedId ++;

      buttonRow.insertAdjacentHTML('beforebegin', newRow);
  });

  //Delete an ingredient row
  window.onload = checkClickedButton();

  function checkClickedButton() {
    if(document.getElementById("modify_recipe_table")){
      document.getElementById("modify_recipe_table").onclick = clickedButton;    
    }
    else {
      document.getElementById("add_recipe_table").onclick = clickedButton;
    }
  }

  function clickedButton(e) {
    if (e.target.name == 'delete_row') {
      targetId = e.target.id;
      let elementToDelete = document.getElementById(targetId);
      elementToDelete.closest('tr').remove();
    }
  }
}

//Add recipe row
let modifyMenuTable = document.getElementById('modify_menu_table');
let addMenuTable = document.getElementById('add_menu_table');

if( modifyMenuTable || addMenuTable){
  const recipeOptions = document.getElementById('select_recipe_options').innerHTML;

  //Morning
  let addMorningRecipeButton = document.getElementById('add_morning_recipe_button');
  let incrementedMorningId = document.getElementsByName('recipe_morning_row').length + 1;

  addMorningRecipeButton.addEventListener('click', function(){
      let buttonRow = document.getElementById('add_morning_recipe_row');

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
      + '<button type="button" name="delete_row" id="delete_morning_row'+ incrementedMorningId +'" class="button--sm">Delete row</button>'
      + '</td>'
      + '</tr>';

      if(modifyMenuTable){
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
        + '<button type="button" name="delete_row" id="delete_morning_row'+ incrementedMorningId +'" class="button--sm">Delete row</button>'
        + '</td>'
        + '</tr>';
      }

      incrementedMorningId ++;

      buttonRow.insertAdjacentHTML('beforebegin', newRow);
  });

  //Noon
  let addNoonRecipeButton = document.getElementById('add_noon_recipe_button');
  let incrementedNoonId = document.getElementsByName('recipe_noon_row').length + 1;

  addNoonRecipeButton.addEventListener('click', function(){
      let buttonRow = document.getElementById('add_noon_recipe_row');

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
      + '<button type="button" name="delete_row" id="delete_noon_row'+ incrementedNoonId +'" class="button--sm">Delete row</button>'
      + '</td>'
      + '</tr>';

      if(modifyMenuTable){
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
        + '<button type="button" name="delete_row" id="delete_noon_row'+ incrementedNoonId +'" class="button--sm">Delete row</button>'
        + '</td>'
        + '</tr>';
      }

      incrementedNoonId ++;

      buttonRow.insertAdjacentHTML('beforebegin', newRow);
  });

  //Evening
  let addEveningRecipeButton = document.getElementById('add_evening_recipe_button');
  let incrementedEveningId = document.getElementsByName('recipe_evening_row').length + 1;

  addEveningRecipeButton.addEventListener('click', function(){
      let buttonRow = document.getElementById('add_evening_recipe_row');

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
      + '<button type="button" name="delete_row" id="delete_evening_row'+ incrementedEveningId +'" class="button--sm">Delete row</button>'
      + '</td>'
      + '</tr>';

      if(modifyMenuTable){
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
        + '<button type="button" name="delete_row" id="delete_evening_row'+ incrementedEveningId +'" class="button--sm">Delete row</button>'
        + '</td>'
        + '</tr>';
      }

      incrementedEveningId ++;

      buttonRow.insertAdjacentHTML('beforebegin', newRow);
  });

  //Delete a recipe row
  window.onload = checkClickedButton();

  function checkClickedButton() {
    if(document.getElementById("modify_menu_table")){
      document.getElementById("modify_menu_table").onclick = clickedButton;    
    }
    else {
      document.getElementById("add_menu_table").onclick = clickedButton;
    }
  }

  function clickedButton(e) {
    if (e.target.name == 'delete_row') {
      targetId = e.target.id;
      let elementToDelete = document.getElementById(targetId);
      elementToDelete.closest('tr').remove();
    }
  }
}
