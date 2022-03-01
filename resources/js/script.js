/**
 * Add new ingredient row
 */
let modifyRecipeTable = document.getElementById('modify_recipe_table');
let addRecipeTable = document.getElementById('add_recipe_table');

if( modifyRecipeTable || addRecipeTable){
  const ingredientOptions = document.getElementById('select_ingredient_options').innerHTML;

  //Define form name depending on situation
  let formName = 'add_recipe_form';
  if(modifyRecipeTable){
    formName = 'update_recipe_form';
  }

  let addIngredientButton = document.getElementById('add_ingredient_button');
  let incrementedId = document.getElementsByName('ingredient_row').length + 1;

  addIngredientButton.addEventListener('click', function(){
      let buttonRow = document.getElementById('add_ingredient_row');

      let newRow = `<tr name="ingredient_row">
        <td class="text--center p--1">
          <select name="ingredient[${incrementedId}][command_id]" id="ingredient_id_${incrementedId}" aria-label="Ingredient (unit)" form="${formName}" class="text--center input--inset" title="Ingredient (unit)" required>
            ${ingredientOptions}
          </select>
        </td>
        <td>
          <input type="number" aria-label="Quantity" min="0" name="ingredient[${incrementedId}][quantity]" form="${formName}" class="text--center input--inset" placeholder="Quantity" required>
        </td>
        <td class="text--center p--1">
          <button type="button" name="delete_row" id="delete_row${incrementedId}" class="button--sm">Delete row</button>
        </td>
      </tr>`;

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

/**
 * Add recipe row in menu
 */  
let modifyMenuTable = document.getElementById('modify_menu_table');
let addMenuTable = document.getElementById('add_menu_table');

if( modifyMenuTable || addMenuTable){
  const recipeOptions = document.getElementById('select_recipe_options').innerHTML;

  //Define form name depending on situation
  let formName = 'add_menu_form';
  if(modifyMenuTable){
    formName = 'update_menu_form';
  }

  //Loop through all buttons with attribute data-moment
  let addRecipeButtons = document.querySelectorAll('[data-moment]');

  addRecipeButtons.forEach(addRecipeButton => {
      let moment = addRecipeButton.dataset.moment;
      let incrementId = document.getElementsByName(`${moment}_recipe_row`).length + 1;

      addRecipeButton.addEventListener('click', function(){
        let buttonRow = document.getElementById(`add_${moment}_recipe_row`);

        let newRow = `<tr name="${moment}_recipe_row">
        <td class="text--center p--1">
          <select name="${moment}[${incrementId}][recipe]" id="recipe_${moment}_${incrementId}" aria-label="Recipe" form="${formName}" class="text--center input--inset" title="Recipe" required>
            ${recipeOptions}
          </select>
        </td>
        <td>
          <input type="number" aria-label="Portions" min="0" name="${moment}[${incrementId}][portion]" form="${formName}" class="text--center input--inset" placeholder="Portions" required>
        </td>
        <td class="text--center p--1">
          <button type="button" name="delete_row" id="delete_${moment}_row${incrementId}" class="button--sm">Delete row</button>
        </td>
      </tr>`;

      incrementId ++;

      buttonRow.insertAdjacentHTML('beforebegin', newRow);

      });
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
