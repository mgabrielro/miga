<?php

namespace Product\Model;

use Zend\Db\TableGateway\TableGateway;

class ProductTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getProduct($id)
    {
        $id     = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row    = $rowset->current();

        if (!$row) {
            throw new \Exception("Could not find row $id");
        }

        return $row;

    }

    public function saveProduct(Product $product)
    {
        $data = array(
            'category_id'     => $product->category_id,
            'manufacturer_id' => $product->manufacturer_id,
            'name'            => $product->name,
            'description'     => $product->description,
            'size'            => $product->size,
            'color'           => $product->color,
        );

        $id = (int) $product->id;

        if ($id == 0) {

            $data['created'] = date('y-m-d H:i:s');
            $this->tableGateway->insert($data);

        } else {

            if ($this->getProduct($id)) {

                $data['updated'] = date('y-m-d H:i:s');
                $this->tableGateway->update($data, array('id' => $id));

            } else {
                throw new \Exception('Product id does not exist');
            }

        }
    }

    public function deleteProduct($id)
    {
        $this->tableGateway->delete(array('id' => (int) $id));
    }
}