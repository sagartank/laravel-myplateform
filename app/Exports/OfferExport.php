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
use Maatwebsite\Excel\Concerns\WithHeadings;

class OfferExport  implements FromView, WithTitle
{
    use Exportable;
    
    public function __construct(array $param)
    {
        $this->param = $param;
    }

    public function title(): string
    {
        return 'Offers';
    }

    // Public function headings(): array
    // {
    //     return [
    //         'Operation Number',
    //         'Offer Buyer Name',
    //         'Offer Payment Type',
    //         'Offer Amount',
    //         'Offer Status'
    //     ];
    // }
    
    public function view(): View
    {
        $data = app('offer')->getAll($this->param, false);

        return view('admin.exports.offers', [
            'data' => $data
        ]);
    }
}
?>