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

    $('.bt_buy').click(function(){
        let product_id = $(this).data("productid");
        let product_name = $(this).data("productname");
        let product_description = $(this).data("producdescription");
        let product_picture = $(this).data("producpicture");
        let product_price = $(this).data("producprice");
        let quantity = $(this).data("qty");
        // let quantity = $('#' + product_id).val();
        // if(quantity != '' && quantity > 0)
        // {
        $.ajax({
            url: url,
            method:"POST",
            data:{product_id:product_id, product_name:product_name, product_description:product_description, product_picture:product_picture, product_price:product_price, quantity:quantity},
            success:function(data)
            {
            alert("Product Added into Cart");
            $('#cart').html(data);
            $('#' + product_id).val('');
            }
        });
        // }
        // else
        // {
        // alert("Please Enter quantity");
        // }
    });
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