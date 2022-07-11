<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model{
  protected $table = 'user';
  protected $primaryKey = 'user_id';
  protected $allowedFields = ['user_name','user_email','user_password','user_type'];

  protected $beforeInsert = ['beforeInsert'];
  protected $beforeUpdate = ['beforeUpdate'];

  protected function beforeInsert(array $data): array
  {
      return $this->getUpdatedDataWithHashedPassword($data);
  }

  protected function beforeUpdate(array $data): array
  {
      return $this->getUpdatedDataWithHashedPassword($data);
  }

  private function getUpdatedDataWithHashedPassword(array $data): array
  {
      if (isset($data['data']['user_password'])) {
          $plaintextPassword = $data['data']['user_password'];
          $data['data']['user_password'] = $this->hashPassword($plaintextPassword);
      }
      return $data;
  }

  private function hashPassword(string $plaintextPassword): string
  {
      return password_hash($plaintextPassword, PASSWORD_BCRYPT);
  }
                                    
  public function findUserByEmailAddress(string $emailAddress)
  {
      $user = $this
          ->asArray()
          ->where(['user_email' => $emailAddress])
          ->first();

      if (!$user) 
          throw new Exception('User does not exist for specified email address');

      return $user;
  }

  public function getUserTypeByUserId($user_id){
    $usertype = $this
    ->asArray()
    ->select('user_type')
    ->where(['user_id' => $user_id])
    ->first();
    return $usertype;
  }

}
