<?php

namespace Base\Service;

use Base\Model\PostInterface;

interface PostServiceInterface
{
    /**
     * Should return a set of all blog posts that we can iterate over. Single entries of the array are supposed to be
     * implementing \Base\Model\PostInterface
     *
     * @return array|PostInterface[]
     */
    public function findAllPosts();

    /**
     * Should return a single blog post
     *
     * @param  int $id Identifier of the Post that should be returned
     * @return PostInterface
     */
    public function findPost($id);

    /**
     * Should return all blog posts that contain the string $term
     *
     * @param  string $term String to search for
     * @return PostInterface
     */
    public function findPostByTerm($term);

    /**
     * Should save a given implementation of the PostInterface and return it. If it is an existing Post the Post
     * should be updated, if it's a new Post it should be created.
     *
     * @param  PostInterface $blog
     * @return PostInterface
     */
    public function savePost(PostInterface $blog);

    /**
     * Delete a specific post
     *
     * @param  PostInterface $blog
     * @return PostInterface
     */
    public function deletePost(PostInterface $blog);

}