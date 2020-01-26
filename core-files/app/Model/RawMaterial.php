<?php

namespace App\Model;

use App\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RawMaterial extends Model
{
    use SoftDeletes;
    use CompanyTrait;
    protected $fillable = ['name','unit_id','company_id'];
    protected $appends = ['unit_name'];

    public function unit()
    {
        return $this->belongsTo("App\Model\Unit","unit_id","id");
    }

    public function getUnitNameAttribute(){
        return $this->unit ? $this->unit->name : '';
    }

    public function purchaseOrderDetail()
    {
        return $this->hasMany('App\Model\PurchaseOrderDetail', 'raw_material_id', 'id');
    }

}
