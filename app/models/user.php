<?php
namespace App\models;

class User extends \Illuminate\Database\Eloquent\Model
{
	public $table = "users";
    public $primaryKey = 'id';
    public $timestamps = true;
}