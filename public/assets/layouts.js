// $(document).ready(function() {
//     EventBus.subscribe('delete_items:insales:cart', function (data) {
//         if (Site.template && Site.template != 'cart') {
//             return false;
//         }
//
//         var $button = data.action.button;
//         var $cartItem = $button.parents('.cart-item:first');
//         var $emptyMessage = $('.js-cart-empty');
//         var $cartForm = $('[data-cart-form]');
//
//         $cartItem
//             .slideUp(300, function () {
//                 $(this).remove();
//             });
//     });
//
//     EventBus.subscribe('update_items:insales:cart', function (cart) {
//
//         updateItemTotal(cart.order_lines);
//
//         updateTotalPrice(cart.total_price);
//
//     });
//
//     function updateTotalPrice(_totalPrice) {
//         $('.js-cart-totals').html( Shop.money.format( _totalPrice ) );
//     }
//
//     function updateItemTotal(order_lines) {
//         _.forEach(order_lines, function (item) {
//             var $item = $('[data-item-id="'+item.variant_id+'"]');
//             $item.find('.js-item-total_price').each(function(index, el) {
//                 $(el).html( Shop.money.format( item.total_price ) );
//             });;
//         });
//     }
//
// });

// $(document).ready(function() {
//     initCollectionMenu();
//     initCollectionFilter();
//     initMobileMenu();
//     initReviews ();
// });
//
// function initCollectionFilter() {
//     $('.filter').collapse({
//         toggle: '.filter-toggle',
//         target: '.filter-items-wrapper',
//         startActive: 'is-active'
//     });
//
//     $('.js-filter-range-slider').rangeSlider();
//     $('.js-filter-range-slider-price').rangeSlider();
// }
//
// function initCollectionMenu () {
//     $('.collection-menu-item').collapse({
//         toggle: '.collection-menu-marker',
//         target: '.collection-menu',
//         startActive: 'is-current'
//     });
// };
//
// function initMobileMenu () {
//     $('.mobile-menu-item').collapse({
//         toggle: '.mobile-menu-marker',
//         target: '.mobile-menu.level-2',
//         startActive: 'is-notcurrent'
//     });
// };
//
// function initReviews () {
//     $('.reviews').collapse({
//         toggle: '.js-toggle-reviews',
//         target: '.reviews-content',
//         startActive: 'is-current'
//     });
// };
//
//
// $(function () {
//     var random_url = prod_urls[Math.floor(Math.random()*prod_urls.length)];
//     $('.js-random-url').attr('href',random_url);
//
//     $('.filter-title a').on('click', function(e){
//         e.preventDefault();
//         if ($(this).parents('.filter-title').next('.filter-items-wrapper').hasClass('opened')) {
//             $('.filter-items-wrapper').removeClass('opened');
//         } else {
//             $('.filter-items-wrapper').removeClass('opened');
//             $(this).parents('.filter-title').next('.filter-items-wrapper').addClass('opened');
//         }
//     });
//
//     $(document).mouseup(function(e) {
//         if($(e.target).parents(".collection-filter").length==0) {
//             $('.filter-items-wrapper').removeClass('opened');
//         }
//     });
//
//
//     $('.js-filter-trigger').on('change', function (event) {
//         $(this).parents('form:first')
//             .submit();
//     });
//     $(document)
//         .on('click', 'label', function (event) {
//             var $form = $(this).parents('form:first');
//             var $filterItem = $(this).parents('.filter-item');
//             var $checkbox = $filterItem.find(':checkbox');
//
//             if ($form.hasClass('collection-filter')) {
//                 event.preventDefault();
//                 $checkbox
//                     .prop('checked', !$checkbox.prop('checked'))
//                     .trigger('change');
//             }
//         })
//         .on('change', 'input', function (event) {
//             var $form = $(this).parents('form:first');
//
//             sendFilter($form, $(this));
//         })
//         .on('click', '[type="submit"]', function (event) {
//             var $form = $(this).parents('form:first');
//
//             if ($form.hasClass('collection-filter')) {
//                 event.preventDefault();
//                 sendFilter($form, $(event.target));
//             }
//         })
//         .on('check', '.collection-filter', function (event) {
//
//             sendFilter($(this), $(this));
//         });
//
//     function sendFilter ($form, $source) {
//         if (!$form.hasClass('collection-filter')) {
//             return false;
//         }
//
//         var isSubmitOnChange = $form.data('submit-onchange');
//         var isButton = $source.is('button');
//
//         if (isSubmitOnChange || isButton) {
//             $form.submit();
//         }
//     };
// });
//
// function declOfNum(number, titles)
//
// {
//     cases = [2, 0, 1, 1, 1, 2];
//     return titles[ (number%100>4 && number%100<20)? 2 : cases[(number%10<5)?number%10:5] ];
// }

//
// $(function(e){
//     $('.js-mobile-catalog-toggle').on('click', function(e){
//         e.preventDefault();
//         $('body').toggleClass('menu-opened');
//     });
// });

// Products.setConfig({
//     initOption: true,
//     filtered: false,
//     showVariants: true,
//     useMax: false,
//     decimal: {
//         kgm: 1,
//         dmt: 1
//     },
//     options: {
//         'Цвет': 'option-span',
//         'Размер': 'option-span',
//         'default': 'option-span'
//     }
// });
// $(document).ready(function() {
//
//     EventBus.subscribe('update_variant:insales:product', function (variantData) {
//         updateVariantInfo(variantData, {
//             oldPrice: '[data-product-old-price]',
//             price: '[data-product-price]',
//             sku: '[data-product-sku]',
//         });
//     });
//
//     function updateVariantInfo(variantData, options) {
//
//         var _defaults = {
//             oldPrice: '[data-product-old-price]',
//             price: '[data-product-price]',
//             sku: '[data-product-sku]',
//             available: '[data-product-available]'
//         }
//
//         if (!variantData.action) {
//             return false;
//         }
//
//         var _options = options || {};
//         var _arguments = _.merge(_defaults, _options)
//
//         var _productId = variantData.product_id;
//         var $form = variantData.action.product;
//         var $price = $form.find(_arguments.price);
//         var $oldPrice = $form.find(_arguments.oldPrice);
//         var $available = $form.find(_arguments.available);
//         var $sku = $form.find(_arguments.sku);
//
//         $price.html(Shop.money.format(variantData.price))
//
//         if (variantData.old_price) {
//             var _oldPrice = Shop.money.format(variantData.old_price);
//             $oldPrice.show().html(_oldPrice)
//         }else{
//             $oldPrice.hide()
//         }
//
//         if (variantData.sku) {
//             $sku.html(variantData.sku).show()
//         }else{
//             $sku.html('').hide()
//         }
//
//         if (variantData.available) {
//             $available.html('Есть в наличии').addClass('is-available');
//         }else{
//             $available.html('Нет в наличии').removeClass('is-available');
//         }
//     }
// });