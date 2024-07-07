<?php

namespace ScaleXY\iClock\Models;

class Command extends \ScaleXY\Tools\Models\Model
{
    public function Device()
    {
        return $this->belongsTo(Device::class);
    }
}
