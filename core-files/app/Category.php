<?php

namespace App;

use App\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use CompanyTrait;
    protected $fillable = ['name','company_id'];
}
