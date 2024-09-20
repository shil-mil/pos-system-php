$(document).ready(function(){

    alertify.set('notifier','position', 'top-right');
    $(document).on('click', '.increment', function(){

        var $quantityInput = $(this).closest('.qtyBox').find('.qty');
        var productId  = $(this).closest('.qtyBox').find('.prodId').val();

        var currentValue = parseInt($quantityInput.val());

        if(!isNaN(currentValue)){
            var qtyVal = currentValue + 1;
            $quantityInput.val(qtyVal);
            quantityIncDec(productId, qtyVal);
        }
    });

    $(document).on('click', '.decrement', function(){

        var $quantityInput = $(this).closest('.qtyBox').find('.qty');
        var productId  = $(this).closest('.qtyBox').find('.prodId').val();

        var currentValue = parseInt($quantityInput.val());

        if(!isNaN(currentValue) && currentValue > 1 ){
            var qtyVal = currentValue - 1;
            $quantityInput.val(qtyVal);
            quantityIncDec(productId, qtyVal);  
        }
    });

    function quantityIncDec(prodId, qty){
        $.ajax({
            type: "POST",
            url: "orders-code.php",
            data: {
                'productIncDec': true,
                'product_id': prodId,
                'quantity': qty
            },
            success: function(response){
                var res = JSON.parse(response);
                // console.log(res);

                if(res.status == 200){
                    // window.location.reload();
                    $('#productArea').load(' #productContent');
                    alertify.success(res.message);
                } else {
                    alertify.error(res.message);
                }
            }
        });
    }

    //proceed to place order button click
    $(document).on('click', '.proceedToPlace', function(){

        var cphone = $('#cphone').val();
        var payment_mode = $('#payment_mode').val();
    
        // Validate Payment Method
        if(payment_mode == ''){
            swal("Select Payment Method", "Select your payment method", "warning");
            return false;
        }
    
        // Validate Phone Number
        if(cphone == '' || !$.isNumeric(cphone)){
            swal("Enter Phone Number", "Enter valid phone number", "warning");
            return false;
        }
    
        var data = {
            'proceedToPlaceBtn': true,
            'cphone': cphone,
            'payment_mode': payment_mode,
        };
    
        $.ajax({
            type: "POST",
            url: "orders-code.php",
            data: data,
            success: function(response){
                var res;
                try {
                    res = JSON.parse(response); // Parse response manually, but it could be redundant
                } catch(e) {
                    console.error('Error parsing JSON', e);
                    return;
                }
            
                if (res.status == 200) {
                    window.location.href = "order-summary.php";
                } else if (res.status == 404) {
                    swal(res.message, res.message, res.status_type, {
                        buttons: {
                            catch: {
                                text: "Add Customer",
                                value: "catch"
                            },
                            cancel: "Cancel"
                        }
                    }).then((value) => {
                        switch (value) {
                            case "catch":
                                $('#c_phone').val(cphone);
                                $('#addCustomerModal').modal('show');
                                // console.log('Pop the customer add modal');
                                break;
                            default:
                        }
                    });
                } else {
                    swal(res.message, res.message, res.status_type);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error', textStatus, errorThrown);
                swal('Error', 'Failed to process the request', 'error');
            }
            
        });
    });

    //Add customers to customer table
    $(document).on('click', '.saveCustomer', function() {

        var c_name = $('#c_name').val();
        var c_phone = $('#c_phone').val();

        if(c_name != '' && c_phone != ''){
            if($.isNumeric(c_phone)){

                var data = {
                    'saveCustomerBtn': true,
                    'name': c_name,
                    'phone': c_phone,  // Correct value for phone
                };
                

                $.ajax({
                    type: "POST",
                    url: "orders-code.php",
                    data: data,
                    success: function(response){
                        var res = JSON.parse(response);

                        if(res.status == 200){
                            swal(res.message, res.message, res.status_type);
                            $('#addCustomerModal').modal('hide');
                        }else if(res.status == 422){
                            swal(res.message, res.message, res.status_type);
                        }else{
                            swal(res.message, res.message, res.status_type);
                        }
                    }
                });
            }else{
                swal("Enter Valid Phone Number","","warning");
            }
        }else{
            swal("Please fill required fields","","warning");
        }

    });
    
});