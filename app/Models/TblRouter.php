<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TblRouter extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'tbl_routers';
    protected $fillable = [
        'active', 
        'active_client', 
        'dns1', 
        'dns2', 
        'lan_interface', 
        'local_address', 
        'port', 
        'r_secret', 
        'radius_acct', 
        'radius_auth', 
        'router_ip', 
        'router_location', 
        'router_name', 
        'router_password', 
        'router_type', 
        'router_username', 
        'ssh_port', 
        'web_server_port', 
        'wefig_pass', 
        'wefig_username'

    ];
        
    public function IpPool() 
    {
        return $this->hasMany(IpPool::class);
    }

    public function MicrotikGraph() 
    {
        return $this->hasMany(MicrotikGraph::class);
    }

    public function TrnClientsService() 
    {
        return $this->hasMany(TrnClientsService::class);
    }
}
