<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Equipamento;

class File extends Model
{
    use HasFactory;
    public function equipamento()
    {
        return $this->belongsTo(Equipamento::class);
    }
}
