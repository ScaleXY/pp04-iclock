<?php

namespace ScaleXY\iClock\Models;

use ScaleXY\Tools\Traits\AutoRunFunctionToAddMissingUUIDOnCreatingTrait;
use ScaleXY\Tools\Traits\AutoRunTrait;

class Device extends \ScaleXY\Tools\Models\Model
{
    use AutoRunFunctionToAddMissingUUIDOnCreatingTrait;
    use AutoRunTrait;

    public function Commands()
    {
        return $this->hasMany(Command::class);
    }

    public function NewCommand($command_string)
    {
        $command = new Command();
        $command->device_id = $this->id;
        $command->command = $command_string;
        $command->save();

        return $command;
    }
}
