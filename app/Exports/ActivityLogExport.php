<?php
namespace App\Exports;

use App\Models\Operation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Excel;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Spatie\Activitylog\Models\Activity;

class ActivityLogExport  implements FromView, WithTitle
{
    use Exportable;
    
    public function __construct(array $param)
    {
        $this->param = $param;
    }

    public function title(): string
    {
        return 'ActivityLogExport';
    }

    public function view(): View
    {

        return view('admin.exports.activity-log-section', [
            'activityLog' =>  Activity::find($this->param['id']),
        ]);
    }
}
?>