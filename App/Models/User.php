<?php
namespace App\Models;

use Core\Model;

class User extends Model
{
    public int $id;
    public string|null $username;
    public string|null $password;
    public string|null $email;
    public string|null $token;
    public string|null $created_at;
    public string|null $updated_at;

    static protected string|null $tableName = 'users';


}