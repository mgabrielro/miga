<?php

namespace Product\Model;

class Product
{
    public $id;
    public $category_id;
    public $manufacturer_id;
    public $name;
    public $description;
    public $size;
    public $color;
    public $created;
    public $updated;

    public function exchangeArray($data)
    {
        $this->id               = (!empty($data['id'])) ? $data['id'] : null;
        $this->category_id      = (!empty($data['category_id'])) ? $data['category_id'] : null;
        $this->manufacturer_id  = (!empty($data['manufacturer_id'])) ? $data['manufacturer_id'] : null;
        $this->name             = (!empty($data['name'])) ? $data['name'] : null;
        $this->description      = (!empty($data['description'])) ? $data['description'] : null;
        $this->size             = (!empty($data['size'])) ? $data['size'] : null;
        $this->color            = (!empty($data['color'])) ? $data['color'] : null;
        $this->created          = (!empty($data['created'])) ? $data['created'] : null;
        $this->updated          = (!empty($data['updated'])) ? $data['updated'] : null;
    }

}