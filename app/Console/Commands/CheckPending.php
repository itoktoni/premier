<?php

namespace App\Console\Commands;

use App\Dao\Enums\HilangType;
use App\Dao\Enums\LogType;
use App\Dao\Enums\ProcessType;
use App\Dao\Models\Detail;
use App\Dao\Models\Outstanding;
use App\Dao\Models\Transaksi;
use App\Dao\Models\ViewDetailLinen;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Plugins\History as PluginsHistory;

class CheckPending extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:pending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Commands check is there any pending rfid';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $outstanding = Outstanding::query()
            ->select(Outstanding::field_primary())
            ->whereDate(Outstanding::field_updated_at(), '>=', Carbon::now()->subMinutes(1440)->toDateString())
            ->whereDate(Outstanding::field_updated_at(), '<', Carbon::now()->toDateString())
            ->where(Outstanding::field_status_hilang(), HilangType::NORMAL)
            ->get();

        if ($outstanding) {

            $rfid = $outstanding->pluck(Outstanding::field_primary());

            PluginsHistory::bulk($rfid, LogType::PENDING, 'RFID Pending');
            Outstanding::whereIn(Outstanding::field_primary(), $rfid)->update([
                Outstanding::field_status_hilang() => ProcessType::PENDING,
                Outstanding::field_pending_created_at() => date('Y-m-d H:i:s'),
                Outstanding::field_pending_updated_at() => date('Y-m-d H:i:s'),
            ]);
        }

        $this->info('The system has been check successfully!');
    }
}
