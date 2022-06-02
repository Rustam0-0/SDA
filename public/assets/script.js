// Убавляем кол-во по клику
$('.quantity_inner .bt_minus').click(function () {
    let $input = $(this).parent().find('.quantity');
    let count = parseInt($input.val()) - 1;
    count = count < 1 ? 1 : count;
    $input.val(count);
});
// Прибавляем кол-во по клику
$('.quantity_inner .bt_plus').click(function () {
    let $input = $(this).parent().find('.quantity');
    let count = parseInt($input.val()) + 1;
    count = count > parseInt($input.data('max-count')) ? parseInt($input.data('max-count')) : count;
    $input.val(parseInt(count));
});
// Убираем все лишнее и невозможное при изменении поля
$('.quantity_inner .quantity').bind("change keyup input click", function () {
    if (this.value.match(/[^0-9]/g)) {
        this.value = this.value.replace(/[^0-9]/g, '');
    }
    if (this.value == "") {
        this.value = 1;
    }
    if (this.value > parseInt($(this).data('max-count'))) {
        this.value = parseInt($(this).data('max-count'));
    }
});


function updateCountCart(myForm, prod_id, increment = 0) {

    if (increment == 1) {
        document.getElementById('qty['+prod_id+']').stepUp();
    }
    else if (increment == -1) {
        document.getElementById('qty['+prod_id+']').stepDown();
    }

    //myForm.submit();


    // // console.log(prod_id);
    // let tot = parseInt($('input[type=number]').val());
    // // console.log(tot);
    // tot = (tot + increment);
    // // console.log(document.getElementById('qty['+prod_id+']').value);
    // if (tot < 1) tot = 1;
    // if (document.getElementById('qty['+prod_id+']').value != tot) {
    //     document.getElementById('qty['+prod_id+']').value = tot;
    //     // document.querySelector('input[type=number]').val(document.querySelector('input[type=number]').val() + increment);
    //     let cart = document.getElementsByClassName('shopcart-counter active');
    //     // console.log(cart);
    //     for (let i = 0; i < cart.length; i += 1) {
    //         // console.log(parseInt(cart[i].innerHTML));
    //         cart[i].innerHTML = parseInt(cart[i].innerHTML) + increment;
    //     }
    // }
    // // console.log(cart[0].innerHTML);

}

$('form').submit(function (event) {
    // event.preventDefault();
    console.log(event.target.action);
    // cart
    const cartadd = "/cart/add";
    const cartupdate = "/cart/update";
    const found = (event.target.action.match(cartadd) || event.target.action.match(cartupdate));
    if (found) {
        event.preventDefault();
        // if (window.prompt())
        let formData = $(this).serialize();
        $.ajax({
            url: event.target.action + '/json',
            type: "POST",
            dataType: 'json',
            data: formData
        }).done(function (response) {
            let result = 0;
            let prix = 0;
            $.each(response, function (key, val) {
                // console.log(val.qty);
                result += parseInt(val.qty);
                prix += parseFloat(val.price) * parseInt(val.qty);
            });
            // console.log(response);
            // console.log(result);
            $("#bought").html(result);
            console.log(response);
            console.log(prix);
            // document.getElementById('total').innerHTML=prix+'€';
            $("#total").html(prix);
        });
    }
});

// $('form').submit(function (event) {
//     // event.preventDefault();
//     console.log(event.target.action);
//     // prodlist->base->'shopcart-counter active'
//     const regex = "/cart/add";
//     const found = event.target.action.match(regex);
//     if (found) {
//         event.preventDefault();
//         // if (window.prompt())
//         let formData = $(this).serialize();
//         $.ajax({
//             url: event.target.action + '/json',
//             type: "POST",
//             dataType: 'json',
//             data: formData
//         }).done(function (response) {
//             let result = 0;
//             $.each(response, function (key, val) {
//                 console.log(val.qty);
//                 result += parseInt(val.qty);
//             });
//             console.log(response);
//             console.log(result);
//             // updateCountCart(result)
//         });
//     }
// });



// L-O-G-I-N /////////////////////////////////////////////////////////

// $(function() {
//     $(".btn").click(function() {
//         $(".form-signin").toggleClass("form-signin-left");
//         $(".form-signup").toggleClass("form-signup-left");
//         $(".frame").toggleClass("frame-long");
//         $(".signup-inactive").toggleClass("signup-active");
//         $(".signin-active").toggleClass("signin-inactive");
//         $(".forgot").toggleClass("forgot-left");
//         $(this).removeClass("idle").addClass("active");
//     });
// });
//
// $(function() {
//     $(".btn-signup").click(function() {
//         $(".nav").toggleClass("nav-up");
//         $(".form-signup-left").toggleClass("form-signup-down");
//         $(".success").toggleClass("success-left");
//         $(".frame").toggleClass("frame-short");
//     });
// });
//
// $(function() {
//     $(".btn-signin").click(function() {
//         $(".btn-animate").toggleClass("btn-animate-grow");
//         $(".welcome").toggleClass("welcome-left");
//         $(".cover-photo").toggleClass("cover-photo-down");
//         $(".frame").toggleClass("frame-short");
//         $(".profile-photo").toggleClass("profile-photo-down");
//         $(".btn-goback").toggleClass("btn-goback-up");
//         $(".forgot").toggleClass("forgot-fade");
//     });
// });

// </login /////////////////////////////////////////////////////////




// function updateCountCart(count) {
//     let cart = document.getElementsByClassName('shopcart-counter active');
//     //console.log(cart.lenght);
//     if(cart.length>0){
//         for (let i = 0; i < cart.length; i += 1) {
//             console.log(parseInt(cart[i].innerHTML))
//             cart[i].innerHTML = count;
//         }
//     }
//     else
//     {
//         let parentcart = document.getElementsByClassName('shopcart-counter active');
//         for(let i = 0; i < parentcart.length; i += 1) {
//
//             // console.log(parseInt(panier[i].innerHTML))
//             //   parentpanier[i].innerHTML = count;
//             let newDiv = document.createElement("span");
//             newDiv.className  ="shopcart-counter active";
//
//             // et lui donne un peu de contenu
//             let newContent = document.createTextNode(count);
//             // ajoute le nœud texte au nouveau div créé
//             newDiv.appendChild(newContent);
//
//             // ajoute le nouvel élément créé et son contenu dans le DOM
//             //   var currentDiv = document.getElementById('div1');
//             parentcart[i].parentNode.insertBefore(newDiv, parentcart[i].nextSibling);
//         }
//     }
// }


// $(document).ready(function () {
//     $('[data-toggle="popover"]').popover({trigger: "hover", container: 'body'});

    // $("form").submit(function (event) {
    //     console.log(event.target.action)
    //     const regex = "/cart/add";
    //     const found = event.target.action.match(regex);
    //     console.log(found);
    //     if (found) {
    //         event.preventDefault();
    //         // console.log(event.target.action)
    //         let formData = $(this).serialize();
    //
    //         $.ajax({
    //             url: event.target.action + '/json',
    //             type: "POST",
    //             dataType: 'json',
    //             data: formData
    //         }).done(function (response) {
    //             let resultat = 0;
    //             let prix = 0;
    //             let temp = "";
    //             $.each(response, function (key, val) {
    //                 // console.log(val.qte);
    //                 resultat += parseInt(val.qty);
    //                 prix += parseFloat(val.price) * parseInt(val.qty);
    //                 let teste = `<p><img height='50px' src='/assets/images/PRODUCTS/${val.picture}'
//                                      alt='${val.name}'>${val.name}
//                                  </p>
    //                              <p>Quantité : <span class='text-success'>${val.qty}</span>
    //                                 Prix : <span class='text-success'>${val.price}€</span>
    //                              </p><hr>`
    //                     temp += teste;
    //             });
    //             let total = `<p>Total : <span class='text-success'>  ${prix} €</span> </p>
    //             <p><a class="btn btn-success text-light" href="/cart/">Voir le panier</a></p>`;
    //             temp = temp + total;
    //             // console.log(response);
    //             // console.log(prix);
    //             updateCountCart(resultat)
    //             updateCart(temp)
    //         });
    //     }
    // });
// });


//для боковой корзины
// function updateCart(newData) {
//     let objcart = document.getElementById('contentcart');
//     objcart.innerHTML = newData;
// }
//
// function openNav() {
//     // document.getElementById("sideNavigation").style.width = "30%";
//     document.getElementById("sideNavigation").classList.add("widthcart");
// }
//
// function closeNav() {
//     document.getElementById("sideNavigation").classList.remove("widthcart");
//     //  document.getElementById("sideNavigation").style.width = "0";
// }





// function updateProduct(formproduitcc){
//     //var dataToSend = document.querySelector("form").serialize();
//     console.log(event.target.action)
//     const dataz = new FormData(formproduitcc);
//
//     let formproduit = $(formproduitcc).serialize();
//     // console.log(dataz);
//     //   console.log(this.id);
//     console.log(formproduitcc.elements.namedItem('id').value);
//     const idprod = formproduitcc.elements.namedItem('id').value;
//     const qteprod = parseInt(formproduitcc.elements.namedItem('qty['+idprod+']').value);
//     console.log(formproduitcc.elements.namedItem('qty['+idprod+']').value);
//     if(qteprod===0){
//         document.getElementById('prod'+idprod).remove();
//     }
//
//     $.ajax({
//         url: formproduitcc.action+'/json' ,
//         type: "POST",
//         dataType: 'json',
//         data: formproduit
//     }).done(function (response) {
//         let resultat = 0;
//         let prix = 0;
//         let temp = "";
//         $.each(response, function (key, val) {
//             // console.log(val.qty);
//             resultat += parseInt(val.qty);
//             prix += parseFloat(val.price) * parseInt(val.qty);
//             let teste = `<p><img height='50px' src='/assets/images/PRODUCTS/${val.picture}' alt='${val.name}'> ${val.name}</p>
//             <p>Quantité : <span class='text-success'>${val.qty}</span>
//                 Prix : <span class='text-success'>${val.price}€</span>
//             </p><hr>`
//             temp += teste;
//         });
//         let total = `<p>Total : <span class='text-success'>  ${prix} €</span> </p>
//         <p><a class="btn btn-success text-light" href="/cart/">Voir le panier</a></p>`;
//         temp = temp + total;
//         // console.log(response);
//         // console.log(prix);
//         updateCountCart(resultat)
//         updateCart(temp)
//         document.getElementById('totalpanier').innerHTML=prix+'€';
//     });
// }


//
// $('form').submit(function (event) {
//     // cart
//     const regex = "/cart/delete";
//     const found = event.target.action.match(regex);
//     if (found) {
//         event.preventDefault();
//         // if (window.prompt())
//         let formData = $(this).serialize();
//         $.ajax({
//             url: event.target.action + '/json',
//             type: "POST",
//             dataType: 'json',
//             data: formData
//         }).done(function (response) {
//             let result = 0;
//             $.each(response, function (key, val) {
//                 console.log(val.qty);
//                 result += parseInt(val.qty);
//             });
//             console.log(response);
//             console.log(result);
//             updateCart(result)
//         });
//     }
// });




//
//     // confirmation de supprision de produit
//     $(document).on('click', '.button_del', function()
//     {
//         // var prod_id = $(this).attr("id");
//         var prod_id = $('#id').val();
//         if(confirm("Are you sure you want to remove this?"))
//         {
//             $.ajax(
//             {
//                 url:"<?php echo base_url(); ?>Pages/product_delete",
//                 method:"POST",
//                 data:{prod_id:prod_id},
//                 success:function(data)
//                 {
//                     // alert("Product removed from Cart");
//                     // $('#cart_details').html(data);
//                 }
//             });
//         }
//         else
//         {
//             return false;
//         }
//     });


// Добавляем в корзину
// $('.quantity_inner .bt_buy').click(function () {
//
// });

// $.post(url, {
//     total_price: total_price,
//     total_items: total_items
// }, function(data) { // ожидаем ответа сервера (строка, число или объект)
//
//     if(data===1) { // если пришло 1, записываем данные в элементы
//         $('#bought').html(total_items); // Запись в нужные места на странице
//         $('#sum').html(total_price);
//     }
//     else {
//         alert('Something's wrong...');
//     }
// });
//
// $('.bt_buy').click(function () {
//     let formURL = "{{ path('cart_add')}}";
//     let formData = new FormData(this);
//     $.ajax({
//         url: formURL,
//         type: 'POST',
//         data: formData,
//         mimeType: "multipart/form-data",
//         contentType: false,
//         cache: false,
//         processData: false,
//         success: function (data, textStatus, jqXHR) {
//             // console.log($.parseJSON(data));
//             console.log(data);
//         },
//         error: function (jqXHR, textStatus, errorThrown) {
//             console.log('pjoih');
//         }
//     });
// });
//
// let cart = {
//
// };
//
// document.onclick = event => {
//     console.log(event.target.classList);
//     if (event.target.classList.contains('bt_buy')) {
//         plusFunction(event.target.dataset.id);
//     }
// }
//
// const plusFunction = id => {
//     cart[id] ++;
//     renderCart();
// }
//
// const renderCart = () => {
//     console.log(cart);
// }
//
// renderCart();

// function updateCountCart(count) {
//     let cart = document.getElementsByClassName('shopcart-counter active');
//     //console.log(cart.lenght);
//     if(cart.length>0){
//         for (let i = 0; i < cart.length; i += 1) {
//             console.log(parseInt(cart[i].innerHTML))
//             cart[i].innerHTML = count;
//         }
//     }else{
//         let parentcart = document.getElementsByClassName('icon ion-ios-cart-outline');
//         for(let i = 0; i < parentcart.length; i += 1) {
//
//             // console.log(parseInt(panier[i].innerHTML))
//             //   parentpanier[i].innerHTML = count;
//             let newDiv = document.createElement("span");
//             newDiv.className  ="shopcart-counter";
//
//             // et lui donne un peu de contenu
//             let newContent = document.createTextNode(count);
//             // ajoute le nœud texte au nouveau div créé
//             newDiv.appendChild(newContent);
//
//             // ajoute le nouvel élément créé et son contenu dans le DOM
//             //   var currentDiv = document.getElementById('div1');
//             parentcart[i].parentNode.insertBefore(newDiv, parentcart[i].nextSibling);
//         }
//     }
// }
