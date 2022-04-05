<?php

namespace App\Console\Commands;

use App\Models\Decision\DecisionReport;

use App\Models\ShipManage\ShipCertRegistry;
use App\Models\ShipManage\ShipRegister;
use Exception;
use Illuminate\Console\Command;

class UpdateShipInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'command:update_ship_id';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $table_report = 'tb_decision_report';

    protected $table_cert_register = 'tb_ship_certregistry';

    protected $table_ship = 'tb_ship_register';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $shipList = ShipRegister::orderBy('id')->get();
            foreach ($shipList as $key => $item) {
                DecisionReport::where('shipNo', $item->id)->update([
                    'shipNo' => $item->IMO_No,
                ]);

                ShipCertRegistry::where('ship_id', $item->id)->update([
                    'ship_id' => $item->IMO_No,
                ]);
            }
        } catch (Exception $ex) {
            Log::info('Failed to update Ship IDs!');
            Log::error($ex->getMessage());
        }
    }
}
