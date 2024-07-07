<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use ScaleXY\iClock\Models\Command;

class IClockController extends \Illuminate\Routing\Controller
{
    const new_line = '
';

    const break = '
';

    public function get_cdata(Request $req)
    {
        // Log::warning("Class function call: get_cdata");
        // Log::warning($req->all());
        $resp = 'Stamp=9999
OpStamp=0
PhotoStamp=0
ErrorDelay=10
Delay=10
TransTimes=18:20;18:25
TransInterval=1
TransFlag=111111101101
Realtime=1
TimeOut=60
TimeZone=330
Encrypt=0

';

        return $resp;
    }

    public function get_getrequest(Request $req)
    {
        $commands_array = [];
        // Device::
        foreach (Command::where('executed', false)->where('device_id', $req->device->id)->get() as $command) {
            $commands_array[] = 'C:'.$command->id.':'.$command->command;
        }
        array_push($commands_array, 'OK');

        return implode(self::new_line, $commands_array).self::new_line;
    }

    public function post_devicecmd(Request $req)
    {
        foreach (explode(self::break, $req->getContent()) as $command_return) {
            if (strlen($command_return) == 0) {
                continue;
            }
            $id = explode('=', explode('&', $command_return)[0])[1];
            Log::warning('Deleting command ID: '.$id);
            Command::whereId($id)->update(['executed' => 1]);
        }

        return 'OK'.self::new_line;
    }

    public function post_cdata(Request $req)
    {
        Log::warning('Class function call: post_cdata');
        Log::warning($req->getContent());

        return 'OK'.self::new_line;
    }

    public function log_everything(Request $req)
    {
        Log::warning($req->method().': '.$req->path());
        Log::warning(json_encode($req->all()));
    }
}
