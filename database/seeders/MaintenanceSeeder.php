<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Device;
use App\Models\DeviceType;
use App\Models\DeviceData;

class MaintenanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DeviceType MODEL
        DeviceType::create(['name' => 'Gépek']);
        DeviceType::create(['name' => 'Elszívók']);
        DeviceType::create(['name' => 'Kompresszorok']);

        // Device MODEL
        Device::create([
            'name' => 'Robotkar',
            'type_id' => 1,
            'gyarto' => 'GAMMA',
        ]);
        Device::create([
            'name' => 'Esztergályos gép',
            'type_id' => 1,
            'gyarto' => 'BETA',
        ]);
        Device::create([
            'name' => 'Levegőkompresszor',
            'type_id' => 2,
            'gyarto' => 'DELTA',
        ]);
        Device::create([
            'name' => 'Vákuumkompresszor',
            'type_id' => 2,
            'gyarto' => 'EPSILON',
        ]);
        Device::create([
            'name' => 'Porelszívó',
            'type_id' => 3,
            'gyarto' => 'ETA',
        ]);
        Device::create([
            'name' => 'Füstgázelszívó',
            'type_id' => 3,
            'gyarto' => 'ZETA',
        ]);


        //DEVICE DATA

        DeviceData::create([
            'device_id' => 1,
            'fogyasztas' => 1.3,
            'teljesitmeny' => 2,
            'mukodesiido' => 3,
        ]);
        DeviceData::create([
            'device_id' => 2,
            'fogyasztas' => 3.1,
            'teljesitmeny' => 4,
            'mukodesiido' => 7,
        ]);
        DeviceData::create([
            'device_id' => 3,
            'fogyasztas' => 1.4,
            'teljesitmeny' => 2.2,
            'mukodesiido' => 3.6,
        ]);
        DeviceData::create([
            'device_id' => 4,
            'fogyasztas' => 3,
            'teljesitmeny' => 1.6,
            'mukodesiido' => 2,
        ]);
        DeviceData::create([
            'device_id' => 5,
            'fogyasztas' => 2.3,
            'teljesitmeny' => 1.5,
            'mukodesiido' => 3,
        ]);
        DeviceData::create([
            'device_id' => 6,
            'fogyasztas' => 1.5,
            'teljesitmeny' => 2.3,
            'mukodesiido' => 5,
        ]);
    }
}
