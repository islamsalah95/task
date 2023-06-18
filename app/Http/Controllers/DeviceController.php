<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreDeviceRequest;
use App\Http\Requests\UpdateDeviceRequest;

class DeviceController extends Controller
{

    public function register_devices_by_user(Request $request)
    {

        
      $result=Device::create([
                'device_name' => $request->device_name,
                'user_id' => Auth::user()->id,
            ]);
        
        return  response()->json($result, 200);
    }

    public function get_device_users($id)
    {

      $Device=  Device::findOrfail($id);
      $results= $Device->user;

      return  response()->json($results, 200);


    }


    public function get_user_devices($id)
    {
     $user=  User::findOrfail($id);
      $results= $user->device;
      
      return  response()->json($results, 200);
    }

   
}
