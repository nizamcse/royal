<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Good extends Model
{
    use SoftDeletes;
    use CompanyTrait;
    protected $fillable = ['name','unit_id','price','thickness','size','company_id'];
    protected $appends = ['unit_name','detail_name'];

    public function unit(){
        return $this->belongsTo('App\Model\Unit','unit_id','id');
    }

    public function getUnitNameAttribute(){
        return $this->unit ? $this->unit->name : '';
    }

    public function producedGoods(){
        return $this->hasMany('App\Model\ProducedGood','good_id','id');
    }

    public function getDetailNameAttribute(){
        $name = $this->name;
        $name.= $this->thickness ? ',Thickness: '.$this->thickness : '';
        $name .= $this->size ? ', Size: '. $this->size : '';
        return $name;
    }
}
