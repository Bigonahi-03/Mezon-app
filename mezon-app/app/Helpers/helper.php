<?php


// این تابع مسیر ذخیره عکس را از پنل ادمین می دهد
function imageUrl($imageName){
    return env('ADMIN_PANEL_URL') . env("PRODUCT_IMAGE_PATH") . $imageName;
}

// این تابع قیمت و قیمت با تخفیت را می گیرد و درصد تخفیف را نشان می دهد
function salePercent($price, $salePrice) {
    $result = (($price - $salePrice) / $price ) * 100 ;
    return round($result);
}