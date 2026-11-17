<?php

namespace App\Plugins\RackBuilder\Models;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    protected $table = 'rack_builder_servers';

    protected $fillable = ['rack_id', 'panel', 'name', 'u_height', 'u_position', 'num_nodes', 'description', 'color', 'slot_position', 'side'];

    protected function casts(): array
    {
        return [
            'u_height' => 'integer',
            'u_position' => 'integer',
            'num_nodes' => 'integer',
        ];
    }

    public function rack()
    {
        return $this->belongsTo(Rack::class, 'rack_id');
    }

    public function nodes()
    {
        return $this->hasMany(Node::class, 'server_id')->orderBy('node_number');
    }
}
