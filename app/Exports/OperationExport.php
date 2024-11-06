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

class OperationExport  implements FromView, WithTitle
{
    use Exportable;
    
    public function __construct(array $param)
    {
        $this->param = $param;
    }

    public function title(): string
    {
        return 'Operations';
    }

    public function view(): View
    {
        $data = app('operation')->getAll($this->param, false);

        return view('admin.exports.operations', [
            'data' => $data
        ]);
    }
}
?>