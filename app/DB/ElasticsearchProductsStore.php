<?php
/**
 * Created by IntelliJ IDEA.
 * User: HatsOn
 * Date: 6/29/2018
 * Time: 3:06 PM
 */

namespace App\DB;


use App\Models\Product;
use Elasticsearch\ClientBuilder;

class ElasticsearchProductsStore implements ProductsStore
{

    private $index_name = 'products';
    private $client = null;
    /***
     * Elasticsearch constructor.
     * @param $elastic_search_configuration: an array containing elasticsearch's connection configuration, default
     * value of this parameter is an empty array and the program will try to connect to elastic search at localhost:9200
     */
    public function __construct($elastic_search_configuration = array())
    {
        $this->client = ClientBuilder::create()->build();
    }

    /**
     * @param string $search_phrase : a phrase that the products should get filtered with
     * @param array $color_filter_array : array of color names
     * @param $price_range : an array containing two keys (max, min) for filtering the price range
     * @return array an array pf all products
     */
    public function searchProduct($search_phrase, $color_filter_array = [], $price_range = [])
    {
        $elastic_params = [
            'index' => $this->index_name,
            'size' => 100,
            'body' => [
                'query' => [
                    'bool' => []
                ]
            ]
        ];
        if ($search_phrase) {
            $elastic_params['body']['query']['bool'] = [
                'should' => [
                    'match' => [
                        'full_text_search'=>$search_phrase
                    ]
                ]
            ];
        }
        if ($color_filter_array) {
            $elastic_params['body']['query']['bool'] = [
                'filter' => [
                    'terms' => [
                        'variants.color'=>$color_filter_array
                    ]
                ]
            ];
        }
        if (!count($elastic_params['body']['query']['bool'])) {
            unset($elastic_params['body']);
        }

        $resp = $this->client->search($elastic_params);
        $products = [];
        $distinct_colors = [];
        foreach ($resp['hits']['hits'] as $doc) {
            $products[] = new Product(["_id"=> $doc['_id']] +   $doc['_source']);
            foreach($doc['_source']['variants'] as $var)
                $distinct_colors[$var['color']] = true;
        }
        return [
            'products' => $products,
            'colors' => $distinct_colors
        ];
    }

    public function deleteProduct($product_id)
    {
        $this->client->delete([
            'index' => $this->index_name,
            'type' => '_doc',
            'id' => $product_id,
        ]);
    }

    public function saveNewProduct($product_data)
    {
        $full_text_search = '';
        $variants = [];
        foreach ($product_data['product_color'] as $index => $color) {
            $variants[] = ['color' => $color, 'price' => (float)($product_data['product_price'][$index])];
            $full_text_search .= " $color";
        }
        $resp = $this->client->index([
            'index'=> 'products',
            'type' => '_doc',
            'body'=>[
                'title' => $product_data['product_title'],
                'description' => $product_data['product_description'],
                'variants' => $variants,
                'full_text_search' => "{$product_data['product_title']} {$product_data['product_description']}$full_text_search",
            ]
        ]);
        $product_id = $resp['_id'];
        return $product_id;
    }

    public function getSingleProduct($product_id)
    {
        $resp = $this->client->get([
            'id'=> $product_id,
            'type' => '_doc',
            'index' => 'products'
        ]);

        return new Product($resp['_source'] + ['_id' => $resp['_id']]);
    }
}