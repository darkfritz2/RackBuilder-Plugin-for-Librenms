<?php

namespace App\Plugins\RackBuilder\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Device;

class Node extends Model
{
    protected $table = 'rack_builder_nodes';

    protected $fillable = ['server_id', 'node_number', 'label', 'device_id', 'description'];

    protected function casts(): array
    {
        return [
            'node_number' => 'integer',
            'device_id' => 'integer',
        ];
    }

    public function server()
    {
        return $this->belongsTo(Server::class, 'server_id');
    }

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id', 'device_id');
    }
}
