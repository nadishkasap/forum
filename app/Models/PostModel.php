<?php namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model{
  protected $table = 'post';
  protected $primaryKey = 'post_id';
  protected $allowedFields = ['post_title','post_description','post_status','post_user_id'];

  public function findPostById($id)
  {
      $post = $this
          ->asArray()
          ->where(['post_id' => $id])
          ->first();

      if (!$post) throw new Exception('Could not find post for specified ID');

      return $post;
  }
  public function findApprovedPost()
  {
      $post = $this
          ->asArray()
          ->where(['post_status' => 1])
          ->findAll();
      return $post;
  }

}
