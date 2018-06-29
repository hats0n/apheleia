<?php
/**
 * Created by IntelliJ IDEA.
 * User: HatsOn
 * Date: 6/29/2018
 * Time: 1:46 PM
 */

namespace App\Models;


class Product
{
    private $id = null;
    private $title = null;
    private $description = null;
    private $variants = [];

    public function __construct($data = [])
    {
        if (!$data) {
            return;
        }
        $this->id = isset($data['id']) ? $data['id'] : null;
        $this->id = isset($data['_id']) ? $data['_id'] : null;
        $this->title = isset($data['title']) ? $data['title'] : null;
        $this->description = isset($data['description']) ? $data['description'] : null;
        $this->variants = [];

        if (isset($data['variants'])) {
            foreach ($data['variants'] as $variant) {
                $this->variants[] = new ProductVariant($variant);
            }
        }
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return array
     */
    public function getVariants(): array
    {
        return $this->variants;
    }


}