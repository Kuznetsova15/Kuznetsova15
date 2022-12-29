function calc() {
    let form = document.forms.calculator;
    const regex = /^[1-9][0-9]*$/;
    for(let i = 0; i<10; i++) {
        let price = form.elements['price' + i].value;
        let count = form.elements['count' + i].value;
        if(!count.match(regex)){
            alert("Error");
            break;
        }
    }
    let result = document.getElementById("result");
    let sum = 0;
    for(let i = 0; i<10; i++){
        sum+=form.elements['price' + i].value * form.elements['count' + i].value;
    }
    result.innerHTML = "Total cost: " + sum;
}
window.addEventListener("DOMContentLoaded", function (event) {
  console.log("DOM fully loaded and parsed");
  let b = document.getElementById("CalculateButton");
  b.addEventListener("click", calc);
});