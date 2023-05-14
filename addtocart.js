const product = [
    {
      id: 0,
      image: "image/1.png",
      title: "Veg Mexican Bowl",
      price: 120,
    },
    {
      id: 1,
      image: "image/2.png",
      title: "Veg Fritters",
      price: 100,
    },
    {
      id: 2,
      image: "image/3.png",
      title: "Salmon Salad",
      price: 200,
    },
    {
      id: 3,
      image: "image/4.png",
      title: "Mango Smoothie",
      price: 100,
    },
    {
      id: 4,
      image: "image/1.png",
      title: "Non Veg Mexican Bowl",
      price: 180,
    },
    {
      id: 5,
      image: "image/2.png",
      title: "Non Veg Fritters",
      price: 120,
    },
    {
      id: 6,
      image: "image/3.png",
      title: "Tuna Salad",
      price: 300,
    },
    {
      id: 7,
      image: "image/4.png",
      title: "Pineapple Smoothie",
      price: 120,
    },
    {
      id: 8,
      image: "image/1.png",
      title: "Vegan Mexican Salad",
      price: 180,
    },
    {
      id: 9,
      image: "image/2.png",
      title: "Mushroom Fritters",
      price: 50,
    },
    {
      id: 10,
      image: "image/3.png",
      title: "Vegan Salad",
      price: 200,
    },
    {
      id: 11,
      image: "image/4.png",
      title: "Protein smoothie",
      price: 175,
    },
  ];
  
  const categories = [...new Set(product.map((item) => {
    return { title: item.title, image: item.image, price: item.price };
  }))];
  
  let i = 0;
  document.getElementById("root").innerHTML = categories.map((item) => {
    var { image, title, price } = item;
    return (
      `<div class="box">
              <div class="img-box">
                  <img class="images" src=${image}></img>
              </div>
          <div class="bottom">
          <p>${title}</p>
          <h2> ${price}.00</h2>` +
      '<button onclick="addtocart(' +
      (i++) +
      ')">Add to cart</button>' +
      `</div>
          </div>`
    );
  }).join("");
  
  var cart = [];
  
  function addtocart(a) {
    cart.push({ ...categories[a] });
    displaycart();
  }
  
  function delElement(a) {
    cart.splice(a, 1);
    displaycart();
  }
  
  function checkout() {
    const totalAmount = document.getElementById("total").innerHTML;
    $.post(
      "paymentconfirm.php",
      { totalAmount: totalAmount },
      function (data) {
        console.log("Server response:", data);
      }
    );
  }
  
  function displaycart() {
    let j = 0,
      total = 0;
    document.getElementById("count").innerHTML = cart.length;
    const btn = document.getElementById("btn");
    if (cart.length == 0) {
      document.getElementById("cartItem").innerHTML = "Your cart is empty";
      document.getElementById("total").innerHTML = 0 + ".00";
    } else {
      document.getElementById("cartItem").innerHTML = cart
        .map((items) => {
          var { image, title, price } = items;
          total += price; // add the price of each item to the total
          return (
            `<div class="cart-item">
                  <div class="row-img">
                      <img class="rowimg" src=${image}>
                  </div>
                  <p style="font-size:12px;">${title}</p>
                  <h2 style="font-size: 15px;"> ${price}.00</h2>` +
            '<i class="fa-solid fa-trash" onclick="delElement(' +
            j++ +
            ')"></i></div>'
          );
        })
        .join("");
      document.getElementById("total").innerHTML = total + ".00";
      checkout();
    }
  }
  





// function displaycart(){
//     let j = 0, total=0;
//     document.getElementById("count").innerHTML=cart.length;
//     const btn = document.getElementById("btn");
//     if(cart.length==0){
//         document.getElementById('cartItem').innerHTML = "Your cart is empty";
//         document.getElementById("total").innerHTML = 0+".00";
//     }
//     else{
//         document.getElementById("cartItem").innerHTML = cart.map((items)=>
//         {
//             var {image, title, price} = items;
//             total=total+price;
//             return(
//                 `<div class='cart-item'>
//                 <div class='row-img'>
//                     <img class='rowimg' src=${image}>
//                 </div>
//                 <p style='font-size:12px;'>${title}</p>
//                 <h2 style='font-size: 15px;'> ${price}.00</h2>`+
//                 "<i class='fa-solid fa-trash' onclick='delElement("+ (j++) +")'></i></div>"
//             );
//         }).join('');
//         // document.getElementById("total").innerHTML = total + ".00";
//         // checkout(); // Call the checkout function to submit the form 
//     }
// }

// // function checkout() {
// //     document.getElementById("totalAmount").value = document.getElementById("total").innerHTML;
// //     document.querySelector("form").submit();
// //   }
  

  
