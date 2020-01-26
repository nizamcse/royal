<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    protected $fillable = ['raw_material_id','unit_id','size','thickness','quantity','type','company_id'];
    protected $appends = ['name'];

    public function rawMaterial(){
        return $this->belongsTo('App\Model\RawMaterial','raw_material_id','id');
    }

    public function materialName(){
        return $this->rawMaterial ? $this->rawMaterial->name : '';
    }

    public function unit(){
        return $this->belongsTo('App\Model\Unit','unit_id','id');
    }

    public function unitName(){
        return $this->unit ? $this->unit->name : '';
    }

    public function getNameAttribute(){

        if($this->type ==2){
            return $this->materialName(). ' Thickness: '.$this->thickness.' Size: '.$this->size;
        }
        return $this->materialName();
    }
}
