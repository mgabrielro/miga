<?php

namespace Base\Service;

use Base\Mapper\PostMapperInterface;
use Base\Model\PostInterface;

class PostService implements PostServiceInterface
{
    /**
     * @var \Base\Mapper\PostMapperInterface
     */
    protected $postMapper;

    /**
     * @param PostMapperInterface $postMapper
     */
    public function __construct(PostMapperInterface $postMapper)
    {
        $this->postMapper = $postMapper;
    }

    /**
     * {@inheritDoc}
     */
    public function findAllPosts()
    {
        return $this->postMapper->findAll();
    }

    /**
     * {@inheritDoc}
     */
    public function findPost($id)
    {
        return $this->postMapper->find($id);
    }

    /**
     * {@inheritDoc}
     */
    public function findPostByTerm($term)
    {
        return $this->postMapper->findPostByTerm($term);
    }

    /**
     * {@inheritDoc}
     */
    public function savePost(PostInterface $post)
    {
        return $this->postMapper->save($post);
    }

    /**
     * {@inheritDoc}
     */
    public function deletePost(PostInterface $post)
    {
        return $this->postMapper->delete($post);
    }
}