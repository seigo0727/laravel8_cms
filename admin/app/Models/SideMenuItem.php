<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SideMenuItem extends BaseModel
{
    use HasFactory;

    public function parent()
    {
        return $this->belongsTo(SideMenuItem::class, 'parent_id', 'id');
    }
}
