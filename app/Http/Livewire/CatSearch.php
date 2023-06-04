<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Realestate;
use Livewire\WithPagination;
use App\Models\CategoryTranslation;

class CatSearch extends Component
{
    use WithPagination;
    public $search = '';
    public $price = '';
    public $area = '';
    public $category;
    public $item = '';
    public $perPage = '12';
    public $orderBy = 'asc';
    public $orderByPrice='asc';


    public function propertyDetail($id)
    {
        $locale = app()->getLocale();
        $url = $locale . '/property/detail/' . $id;
        return redirect()->to($url);
    }



    public function mount()
    {
        $this->category = request()->segment(3);
    }


    public function render()
    {

        $search = $this->search;
        $item  = CategoryTranslation::where('name', $this->category)->first();
        $hot_properties = Realestate::where('category_id',$item->category_id)->latest()->take(4)->get();

        // query = Realestate::query() with whereHas translate
        $propertyCats = Realestate::where(function ($query) {
                if (!is_null($this->category)) {
                    $item  = CategoryTranslation::where('name', $this->category)->first();
                    $query->where('category_id', $item->category_id);
                }
            })

            ->whereHas('translations', function ($query) use ($search) {
                $query->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('address', 'like', '%' . $search . '%');
            })
            ->where(function ($query) {
                if ($this->price == '50000') {
                    $query->whereBetween('price', [0, 50000]);
                } elseif ($this->price == '100000') {
                    $query->whereBetween('price', [50001, 100000]);
                } elseif ($this->price == '200000') {
                    $query->whereBetween('price', [100001, 200000]);
                } elseif ($this->price == '500000') {
                    $query->whereBetween('price', [200001, 50000000]);
                } else {

                }
            })

            ->where(function ($query) {
                if ($this->area == '1000') {
                    $query->whereBetween('area', [0, 1000]);
                } elseif ($this->area == '10000') {
                    $query->whereBetween('area', [1001, 10000]);
                } elseif ($this->area == '50000') {
                    $query->whereBetween('area', [10001, 50000]);
                } elseif ($this->area == '50001') {
                    $query->whereBetween('area', [50001, 50000000]);
                } else {
                }
            })

            ->orderBy('price',$this->orderByPrice)
            ->orderBy('id', $this->orderBy)
            ->paginate($this->perPage);


        return view('livewire.cat-search', [
            'propertyCats' => $propertyCats,
            'hot_properties' => $hot_properties
        ]);
    }
}
