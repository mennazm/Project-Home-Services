<?php

namespace App\Http\Livewire\Admin;
use App\Models\Service;
use App\Models\ServiceCategory;
use Livewire\Component;
use Illuminate\support\Str;
use Livewire\WithFileUploads;
use Carbon\Carbon;



class AdminAddServiceComponent extends Component
{

    use WithFileUploads;
    public $name;
    public $slug;
    public $tagline;
    public $service_category_id;
    public $price;
    public $discount;
    public $discount_type;
    public $image;
    public $thumbnail;
    public $description;
    public $inclusion;
    public $exclusion;
        public function generateSlug(){
            $this->slug= Str::slug($this->name,'-');
        }

        public function updated($fields){

            $this->validateOnly($fields,[
                'name'=>'required',
                'slug'=>'required',
                'tagline'=>'required',
                'service_category_id'=>"required",
                'price'=>'required',
                'image'=>"required|mimes:jpeg,png",
                'thumbnail'=>'required|mimes:jpeg,png',
                'description'=>'required',
                'inclusion'=>'required',
                'exclusion'=>'required',
            ]);
        }
          
        public function createService()
        {
            $this->validate([
                'name'=>'required',
                'slug'=>'required',
                'tagline'=>'required',
                'price'=>'required',
                'service_category_id'=>"required",
                'image'=>"required|mimes:jpeg,png",
                'thumbnail'=>'required|mimes:jpeg,png',
                'description'=>'required',
                'inclusion'=>'required',
                'exclusion'=>'required',
            ]);
            $service = new Service();
            $service->name=$this->name;
            $service->slug=$this->slug;
            $service->tagline=$this->tagline;
            $service->price=$this->price; 
            $service->service_category_id=$this->service_category_id;  
            $service->discount=$this->discount;
            $service->discount_type=$this->discount_type;
            $service->description=$this->description;
            $service->inclusion= str_replace("\n",'|',trim($this->inclusion));
            $service->exclusion= str_replace("\n",'|',trim($this->exclusion));
            $service->thumbnail=$this->thumbnail;
            $imageName= carbon::now()->timestamp. '.' .$this->thumbnail->extension();
            $this->thumbnail->storeAs('services/thumbnails',$imageName);
            $service->thumbnail=$imageName;
            $imageName2= carbon::now()->timestamp. '.' .$this->image->extension();
            $this->image->storeAs('services',$imageName2);
            $service->thumbnail=$imageName;
            $service->image = $imageName2;
            $service->save();
            session()->flash('message','Service has been created successfully!');


        }
       

    public function render()
    {
        $categories = ServiceCategory::all();
        return view('livewire.admin.admin-add-service-component',['categories'=>$categories])->layout('layouts.base');
    }
}
