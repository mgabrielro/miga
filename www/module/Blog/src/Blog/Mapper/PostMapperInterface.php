<?php

namespace Blog\Mapper;

use Blog\Model\PostInterface;

interface PostMapperInterface
{
    /**
     * @param int|string $id
     * @return PostInterface
     * @throws \InvalidArgumentException
     */
    public function find($id);

    /**
     * @return array|PostInterface[]
     */
    public function findAll();

    /**
     * All posts by search term
     *
     * @return array|PostInterface[]
     */
    public function findPostByTerm($term);

    /**
     * @param PostInterface $postObject
     *
     * @return PostInterface
     * @throws \Exception
     */
    public function save(PostInterface $postObject);

    /**
     * @param PostInterface $postObject
     *
     * @return PostInterface
     * @throws \Exception
     */
    public function delete(PostInterface $postObject);
}