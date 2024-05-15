<?php

namespace App\Http\Livewire\Admin;
use Livewire\Component;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\support\Str;
use Livewire\WithFileUploads;
use Carbon\Carbon;

class AdminAddServiceCategoryComponent extends Component
{

    use WithFileUploads;
    public $name;
    public $slug;
    public $image;
    public function generateSlug(){
        $this->slug=str::slug($this->name,'-');
    }
    public function updated($fields){
        $this->validateonly($fields,[
            'name'=>'required',
            'slug'=>'required',
            'image'=>"required|mimes:jpeg,png",

        ]);
    }
        public function createNewCategory(){
            $this->validate([
                'name'=>'required',
                'slug'=>'required',
                'image'=>"required|mimes:jpeg,png",
            ]);

            $scategory=new ServiceCategory();
            $scategory->name=$this->name;
            $scategory->slug=$this->slug;
            $imageName= carbon::now()->timestamp. '.' .$this->image->extension();
            $this->image->storeAs('categories',$imageName);
            $scategory->image=$imageName;
            $scategory->save();
            session()->flash('message','Category has been created successfully!');
        }

  
    public function render()
    {
        return view('livewire.admin.admin-add-service-category-component')->layout('layouts.base');
    }
}
