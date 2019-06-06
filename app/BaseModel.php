<?php


namespace App;


use App\Library\ValidateError;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use ValidateError;
}