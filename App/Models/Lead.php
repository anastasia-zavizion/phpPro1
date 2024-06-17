<?php
namespace App\Models;

use Core\Model;

class Lead extends Model
{
    public int $id;
    public int|null $lead_id;
    public int|null $user_id;
    public string|null $email;
    public string|null $name;
    public string|null $city;
    public string|null $phone;
    public string|null $address;

    static protected string|null $tableName = 'leads';


}