<?php

namespace App\Models\Deposit;
use Illuminate\Database\Eloquent\Model;

class DepositsReturn extends Model

{
    protected $guarded = array();
    protected $table = 'deposits_return';
    public function depositereturn()
    {
        return $this->belongsTo('App\Models\Deposit\Deposite','deposit_id', 'id');
    }

}

?>

