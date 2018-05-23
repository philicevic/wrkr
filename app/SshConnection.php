<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SshConnection extends Model
{
    /**
     * change the routeKeyName for Route Model Binding
     *
     * @return string
     */
    public function getRouteKeyName() {
        return 'host';
    }
}
