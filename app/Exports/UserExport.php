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

class UserExport  implements FromView, WithTitle
{
    use Exportable;
    
    public function __construct(array $param)
    {
        $this->param = $param;
    }

    public function title(): string
    {
        return 'User';
    }

    public function view(): View
    {
        $users = app('user-repo')->getAll($this->param, false);

        return view('admin.exports.users', [
            'users' => $users
        ]);
    }
}
?>