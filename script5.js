function updatePrice(i) {
      let s = document.getElementsByName("itemType"+i);
      let select = s[0];
      let price = 0;
      let prices = getPrices();
      let priceIndex = parseInt(select.value) - 1;
      if (priceIndex >= 0) {
      price = prices.itemTypes[priceIndex];
      }
      
      
      let radioDiv = document.getElementById("itemRadio"+i);
      radioDiv.style.display = (select.value != "2" ? "block" : "none");
      
      let itemRadio = document.getElementsByName("myradio"+i);
      itemRadio.forEach(function(radio) {
      if (radio.checked) {
          let optionPrice = prices.myradio[radio.value];
          if (optionPrice !== undefined) {
          price += optionPrice;
          }
      }
      });
  
      let checkDiv = document.getElementById("itemProp"+i);
      checkDiv.style.display = (select.value == "2" ? "none" : "block");
      
      let itemProp = document.querySelectorAll("#itemProp"+ i +" input");
      itemProp.forEach(function(checkbox) {
      if (checkbox.checked) {
          let propPrice = prices.prodProperties[checkbox.name];
          if (propPrice !== undefined) {
          price += propPrice;
          }
      }
      });
      let count = document.getElementById("count"+i).value;
      price*=parseInt(count);
      let resultx = document.getElementById("result"+i);
      resultx.innerHTML = price;
      calc();
    }
  function getPrices() {
    return {
      itemTypes: [100, 110, 150],
      myradio: {
        Option1:55,
        Option2: 30,
        Option3: 43,
      },
      prodProperties: {
        prop1: 30,
        prop2: 10,
      }
    };
  }
  function calc(){
    let sum = 0;;
    let result = document.getElementById("result");
    for(let i =1; i<5; i++){
      let p = parseInt(document.getElementById("result"+i).innerHTML);
      sum+=p;
    }
    result.innerHTML = "Total cost: " + sum;
  }
  window.addEventListener('DOMContentLoaded', function (event) {
    for(let i = 1; i<5;i++){
    let radioDiv = document.getElementById("itemRadio"+i);
    radioDiv.style.display = "none";
    
    let s = document.getElementsByName("itemType"+i);
    let select = s[0];
    select.addEventListener("change", function(event) {
      updatePrice(i);
    });
    let count = document.getElementById("count"+i);
    count.addEventListener("change", function(event) {
        updatePrice(i);
    }); 
    let itemRadio = document.getElementsByName("myradio"+i);
    itemRadio.forEach(function(radio) {
      radio.addEventListener("change", function(event) {
        updatePrice(i);
      });
    });
  
    let itemProp = document.querySelectorAll("#itemProp"+i +" input");
    itemProp.forEach(function(checkbox) {
      checkbox.addEventListener("change", function(event) {
        updatePrice(i);
      });
    });
  
    updatePrice(i);
    calc();
    }
  });
