<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Realestate;
use Livewire\WithPagination;
use App\Models\CategoryTranslation;

class CatSearch extends Component
{
    use WithPagination;
    public $search = '';
    public $price = '';
    public $area = '';
    public $category = '';
    public $item = '';
    public $perPage = '12';
    public $orderBy = 'asc';
    public  $clickmenu;


    public function propertyDetail($id)
    {
        $locale = app()->getLocale();
        $url = $locale . '/property/detail/' . $id;
        return redirect()->to($url);
    }

    // public function clickmenu(){
    //     $category2 = request()->segment(3);
    //     return $category2;
    // }

    public function render()
    {

        // $clickmenu = request()->segment(3);
        // $cat = CategoryTranslation::where('name', request()->segment(3))->first();

        // dd( $cat->name);
        // if($item ='buy'){

        // }

            // $this->category = $cat->name;
        $search = $this->search;
        // dd($this->price);

        // query = Realestate::query() with whereHas translate
        $propertyCats = Realestate::
            // where(function ($query) {
            //     if($this->category !=""){
            //         $query->where('category_id', $this->category);
            //     }
            // })
            where(function ($query) {
                $item  = CategoryTranslation::where('name', request()->segment(3))->first();





                if (!is_null($item)) {
                    // $item  = CategoryTranslation::where('name', request()->segment(3))->first();
                    $query->where('category_id', $item->category_id);
                } else {
                    if ($this->category != "") {
                        $query->where('category_id', $this->category);
                    }
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

            ->orderBy('id', $this->orderBy)
            ->paginate($this->perPage);


        return view('livewire.cat-search', [
            'propertyCats' => $propertyCats,
            // 'hot_properties' => $hot_properties
        ]);
    }
}
