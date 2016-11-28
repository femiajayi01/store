$(document).ready(function () {

    $('.editItem').click(function () {
        var name = $(this).text();
        $("#editProduct").text(name);
        // var id = $(this).attr("data-productId");     
        var id = $(this).data("productId");
        $("#editBody").load("edit_product.php?id=" + id);
        $('#product_edit_modal').modal('show');
    });


    $('.deleteItem').click(function () {
        var name = $(this).text();
        $("#deleteProduct").text(name);
        // var id = $(this).attr("data-productId");     
        var id = $(this).data("productId");
        $("#deleteBody").load("delete_product.php?id=" + id);
        $('#product_delete_modal').modal('show');
    });

    $('#product_delete_modal')
        .on('show.bs.modal', function () {
            var modal = $(this);
            modal.on('hidden.bs.modal', function () {
                $('#deleteAction').off('click');
            });
            $('#deleteAction').click(function (ev) {
                var $btn = $(ev.target).button('loading');
                $.post('confirm_delete_product.php', { id: modal.find('input#productId').val() })
                    .done(function () {
                        location.reload();
                        modal.modal('hide');
                    })
                    .fail(function (e) {

                    })
                    .always(function () {
                        $btn.button('reset');
                    });
            });
        });

    $('#confirmPassword').focusout(function () {
        var pass = $('#password').val();
        var pass2 = $('#confirmPassword').val();
        if (pass != pass2) {
            $("#divCheckPasswordMatch").html("Passwords do not match!");
        } else {
            $("#divCheckPasswordMatch").html("");
        }

    });

    $('#password').focusout(function () {
        var pass = $('#password').val().length;
        if (pass < 6) {
            $('#passLength').html("Password must have a minimum of 6 characters!");
        } else {
            $('#passLength').html("");
        }
    });

    $('#add_to_cart').click(function () {
        var id = $(this).data('id');
        $.post('cart.php?id=' + id, { id: id })
            .done(function (data) {
                $("#cart_count").html(data.items_count);
                $("#user_cart").html(data.cart);
                // set_events();
            })
    });

    $("#dropdown.cart").on('hover', function () {
        $("#user_cart").load("cart.php");
    });


    $('#user_cart').on("click", '.delete_cart', function () {
        var id = $(this).data('id');
        modify_cart(id, 'action=delete&');
    });
    $('#checkout_page').on("click", '.del_cart', function () {
        var id = $(this).data('id');
        modify_cart(id, 'action=delete&');
    });


    $('#user_cart').on("click", '.increase_cart', function () {
        var id = $(this).data('id');
        modify_cart(id);
    });
    $('#checkout_page').on("click", '.inc_cart', function () {
        var id = $(this).data('id');
        modify_cart(id);
    });


    $('#user_cart').on("click", '.decrease_cart', function () {
        var id = $(this).data('id');
        modify_cart(id, 'action=put&');
    });
    $('#checkout_page').on("click", '.dec_cart', function () {
        var id = $(this).data('id');
        modify_cart(id, 'action=put&');
    });

    function modify_cart(id, param) {
        $.post('cart.php?' + (param || '') + 'id=' + id, { id: id })
            .done(function (data) {
                $("#cart_count").html(data.items_count);
                $("#user_cart").html(data.cart);
                $("#checkout_page").html(data.checkout_cart);
            })
    }

    $('#editProfile').click(function () {
        $('#profile_edit_modal').modal('show');
    });




});