//Вставляем этот код в наш functions.php


//Делаем из тенге доллары для facebook конверсии
// woocommerce_review_order_after_order_total
add_action('woocommerce_after_checkout_form', 'addFacebookPixel', 10, 1);
function addFacebookPixel($order_id) {
    global $woocommerce;

    $amount = floatval( preg_replace( '#[^\d.]#', '', $woocommerce->cart->get_cart_total() ) );
    $final_exchange = 0;
   
    $html2 = "<table class='table_exchange'><tbody><tr><td><span class='KZT-price'>$amount</span></td><td><bdi class='price_exchange'>$final_exchange</bdi></td></tr></tbody></table>";
    echo $html2;

    echo '<style>
    .table_exchange, .table_exchange td{
        color: white;
        }
</style>
<script>
async function getExchangeRate() {
        try {
            const response = await fetch("https://api.exchangerate-api.com/v4/latest/USD");
            const data = await response.json();
            const rate = data.rates.KZT;
            return rate;
        } catch (error) {
            console.error(error);
        }
        }
async function setUSD() {

    var exchange_kzt = await getExchangeRate();
    jQuery("bdi.price_exchange").html(Math.round('.$amount.'/exchange_kzt));
};

jQuery(function() {
    setUSD();
 });
    </script>';

}
