//este archivo es para los labels de los formularios mas chiquitos cuandoe escribes

const inputs = document.querySelectorAll(".input-field"); // Select all input fields and put them into a nodeless (array)

inputs.forEach(inp => { // Loop through each input field
    inp.addEventListener("focus", () => { // When the input field is focused
       inp.classList.add("active"); // Add the class "active" to the input field 
    });
    
    inp.addEventListener("blur", () => { // When the input field is not focused
        if(inp.value != "") return; // If the input field has a value, return
        inp.classList.remove("active"); // Remove the class "active" from the input field
    });
});