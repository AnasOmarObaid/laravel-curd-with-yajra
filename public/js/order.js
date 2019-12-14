$(document).ready(function () {
    var id = "";
    // get product data
    $('.product-data').on('click', function (q) {
        q.preventDefault();
        var name = $(this).data('name');
        id = $(this).data('id');
        var quantity = $(this).data('quantity');
        var uniPrice = $.number($(this).data('price'), 2);
        var html =
            `<tr id = "order_${id}">
                <td>${name}</td>
                <td><input type = "number"  data-quantity = ${quantity} data-stock = "#stock-product${id}" data-price = ${uniPrice} class = "form-control input-price input-sm" name = "quantity[][${id}]" min = "1" value = "1" max = "${quantity}"/></td>
                <td data-price = "${uniPrice}" class = "product_price">${uniPrice}</td>
                <td><span class = "btn btn-sm btn-danger remove-order"  data-quantity = ${quantity}  data-stock = "#stock-product${id}" data-product = "${id}" style = "cursor:pointer"><i class = "fa fa-trash"></i></span></td>
            </tr>`;
        $('.table-head').append(html);
        $(this).addClass('disabled');
        $('#stock-product' + id).html(quantity - 1);
        calcTotal();
    }); //-- end of product data

    // remove product data
    $('body').on('click', '.remove-order', function () {
        $("#link-product" + $(this).data('product')).removeClass('disabled').addClass('btn-success');
        $('#order_' + $(this).data('product')).remove();
        var selector = $(this).data('stock');
        $(selector).html($(this).data('quantity'));
        calcTotal();
    }); //-- end of remove

    $('#order-submit').submit(function (e) {
        var tr = $('.table-head tr').length;
        if (tr == 0) {
            alert('You Must Add Order Before Click Here !');
            return false;
        }
        return true;
    }); //-- end submit

    // get data order
    $('.get-order').on('click', function (e) {
        e.preventDefault();
        var productName = $(this).data('name');
        var productQuantity = $(this).data('quantity');
        var productPrice = $.number($(this).data('price'), 2);
        var productTotalPrice = $.number($(this).data('total'), 2);

        $('#order-data').find('.order-content').fadeOut();

        var html = `
        <div class = "order-content order-area-print">
            <table class = "table table-hover">
                <thead>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Product Price</th>
                </thead>
                <tbody>
                    <tr>
                        <td>${productName}</td>
                        <td>${productQuantity}</td>
                        <td><span class ="span-price">${productPrice}</span></td>
                    </tr>
                </tbody>
            </table>
            <h3 style="margin-top:10px; margin-bottom:15px">Total Price: ${productTotalPrice}</h3>
            <button class = "btn btn-block btn-print-order btn-info"><i class="fas fa-print fa-fw"></i> Print </button>
        </div>
        `;

        $('#order-data').append(html);

    }); //-- end get data order


    // checked btn
    var b = '';
    $('.btn-checked').on('click', function () {
        b = confirm('Do You Want To Delete It ?');
    }); //-- end checked btn

    // submit to destroy order
    $('.destroy-order').submit(function () {
        if (b == true)
            return true;
        return false;
    }); //-- end submit to destroy order

    // calculate the total price
    $('.edit-number').on('keyup change', function () {
        $('.total-edit-price').html($.number(Number($(this).data('price')) * Number($(this).val()), 2));
    });
    //-- end calculate the total price
    // change the number 100 to 100.00
    $('.span-price').number(true, 2);
}); //-- end of document

// input price change
$('body').on('keyup change', '.input-price', function () {
    var price = parseInt($(this).data('price'));
    var totalPrice = price * parseInt($(this).val());
    $(this).parent().next().html($.number(totalPrice, 2));
    var selector = $(this).data('stock');
    var originalCount = parseInt($(this).data('quantity'));
    var bigValue = parseInt($(this).val()) + 1; //  6 then 7
    var smallValue = parseInt($(this).val()) - 1; // 5 then 6
    smallValue >= bigValue ? $(selector).html((parseInt($(selector).html()) + (1))) : $(selector).html(originalCount - parseInt($(this).val()));
    calcTotal();
}); //-- end of input price

// start print order
$(document).on('click', '.btn-print-order', function () {
    $('.order-area-print').printThis();
}); //-- end print order

function calcTotal() {
    'use strict';
    var totalPrice = 0;
    $('.table-head tr').each(function () {
        totalPrice += Number($(this).find('.product_price').html().replace(/,/g, ''));
    });
    $('#total-price').html($.number(totalPrice, 2) + '$');

    totalPrice == 0 ? $('.btn-submit').addClass('disabled') : $('.btn-submit').removeClass('disabled');
} //-- end calcTotal
