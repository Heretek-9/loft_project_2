<?php
namespace App\models;

class File extends \Illuminate\Database\Eloquent\Model
{
	public $table = "files";
    public $primaryKey = 'id';
    public $timestamps = false;
}