<?php
/**
 * Created by IntelliJ IDEA.
 * User: HatsOn
 * Date: 6/29/2018
 * Time: 3:13 PM
 */

namespace App\DB;


interface ProductsStore
{
    /**
     * @param string $search_phrase: a phrase that the products should get filtered with
     * @param array $color_filter_array: array of color names
     * @param $price_range: an array containing two keys (max, min) for filtering the price range
     * @return array an array pf all products
     */
    public function searchProduct($search_phrase, $color_filter_array = [], $price_range=[]);

    public function deleteProduct($product_id);

    public function saveNewProduct($product_data);

    public function getSingleProduct($product_id);
}