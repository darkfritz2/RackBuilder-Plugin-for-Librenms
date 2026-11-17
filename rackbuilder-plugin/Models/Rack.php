<?php

namespace App\Plugins\RackBuilder\Models;

use Illuminate\Database\Eloquent\Model;

class Rack extends Model
{
    protected $table = 'rack_builder_racks';

    protected $fillable = ['name', 'size', 'layout', 'description'];

    protected function casts(): array
    {
        return [
            'size' => 'integer',
        ];
    }

    public function servers()
    {
        return $this->hasMany(Server::class, 'rack_id');
    }
}
