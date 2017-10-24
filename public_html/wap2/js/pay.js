jQuery(document).ready(function($) {
    $('.orderPlans .plan').on({
        click: function() {
            var index = $(this).index();
            var curPlan = $(this).attr('data-plan');
            var price = '';
            $(this).addClass('current').siblings().removeClass('current');
            var priceDiscount = '';

            var priceRate = 198 / 59.8;
            switch (curPlan) {
                case '1':
                    price = '29.80';
                    priceDiscount = 29.80 * priceRate;
                    break;
                case '2':
                    price = '59.80';
                    priceDiscount = 59.80 * priceRate;
                    break;
                case '3':
                    price = '158.00';
                    priceDiscount = 158.00 * priceRate;
                    break;
            }
            $("input[name='software_price']").val(price);
            $('.price').html(price);
            $('.priceDiscount').html('原价' + parseInt(priceDiscount));
        }
    })
});