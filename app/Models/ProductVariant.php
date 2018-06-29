<?php
/**
 * Created by IntelliJ IDEA.
 * User: HatsOn
 * Date: 6/29/2018
 * Time: 1:47 PM
 */

namespace App\Models;


class ProductVariant
{
    private $color;
    private $price;

    public function __construct($data)
    {
        $this->color = isset($data['color']) ? $data['color'] : null;
        $this->price = isset($data['price']) ? $data['price'] : null;
    }

    /**
     * @return null
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @return null
     */
    public function getPrice()
    {
        return $this->price;
    }



}