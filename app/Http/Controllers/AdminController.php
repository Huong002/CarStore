<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;

class AdminController extends Controller
{
    public function index(){
        return view('admin.index');
    }

    public function brands(){
        $brands = Brand::orderBy('id','DESC')->paginate(10);
        return view('admin.brands', compact('brands'));
    }
    public function add_brand(){
        return view('admin.brand-add');
    }
    // public function brand_store(Request $request){
    //     $request->validate([
    //         'name'  => 'required',
    //         'slug'  => 'required|unique:brands,slug',
    //         'image' => 'mimes:png,jpg,jpeg|max:2048'
    //     ]);
        

    //     $brand = new Brand();
    //     $brand->name= $request->name;
    //     $brand->slug=str::slug($request->name);
    //     $image=$request->file('image');
    //     $file_extenstion = $request->file('image')->extension();
    //     $file_name= Carbon::now()->timestamp.'.'.$file_extenstion;
    //     $this->GenerateBrandThumbailsImage($image,$file_name);
    //     $brand->image= $file_name;
    //     $brand->save();
    //     return redirect()->route('admin.brands')->with('status', 'Them hang thanh cong');
    // }

    // public function GenerateBrandThumbailsImage($image, $imageName){
    //     $destinmationPath =public_path('uploads/brands');
    //     $img = Image::read($image->path());
    //     $img->cover(124,124,"top");
    //     $img->resize(124,124,function($contraint){
    //         $contraint->aspecRatio();
    //     })->save($destinmationPath.'/'.$imageName);
    
    // }

    public function brand_store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'slug'  => 'required|unique:brands,slug',
            'image' => 'required|mimes:png,jpg,jpeg|max:2048'
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        $image = $request->file('image');
        $file_extension = $image->extension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extension;

        // Di chuyển file vào thư mục uploads/brands
        $destinationPath = public_path('uploads/brands');
        $image->move($destinationPath, $file_name);

        $brand->image = $file_name;
        $brand->save();

        return redirect()->route('admin.brands')->with('status', 'Thêm hãng thành công');
    }

    public function brand_edit($id){
        $brand = Brand::find($id);
        return view('admin.brand-edit', compact('brand'));
        
    }

    public function brand_update(Request $request){
        $request->validate([
            'name'  => 'required',
            'slug'  => 'required|unique:brands,slug',
            'image' => 'required|mimes:png,jpg,jpeg|max:2048'
        ]);

        $brand = Brand::find($request -> id);
        if(!$brand ){
            return redirect()->back()->with('error', 'Brand not found');
        }

        $brand->name = $request->name;
        $brand->slug = Str::slug($request->slug);
        
        if($request->hasFile('image')){
            $image= $request->file('image');
            $file_extenstion = $image->extension();
            $file_name =Carbon::now()->timestamp;
            $destinationPath=public_path('uploads/brands');
            $image->move($destinationPath,$file_name);
            $brand->image = $file_name;
            
        }
        $brand->save();
        return redirect()->route('admin.brands')->with('status', 'Cập nhật hãng thành công');
  }

  public function brand_delete($id)
  {
    $brand = Brand::find($id);
    if(!$brand){
        return redirect()->back()->with('error', 'Không tìm thấy thương hiệu');
    }
    // if(File::exits(public_path('uploads/brands').'/'.$brand->image)){
    //     File::delete(public_path('uploads/brands').'/'.$brand->image);
    // }
    if($brand->image && \Illuminate\Support\Facades\File::exists(public_path('uploads/brands/'.$brand->image))){
        \Illuminate\Support\Facades\File::delete(public_path('uploads/brands/'.$brand->image));
    }
    $brand ->delete();
    return redirect()->route('admin.brands')->with('status', 'Đã xóa thương hiệu thành công');

  }

  // danh muc
  public function categories(){
    $categories = Category::orderBy('id', 'DESC')->paginate(10);
    return view('admin.categories', compact('categories'));
  }
  public  function category_add(){
    return view('admin.category-add');
  }
  
  public function category_store(Request $request){
    $request->validate([
        'name'  => 'required',
        'slug'  => 'required|unique:brands,slug',
        'image' => 'required|mimes:png,jpg,jpeg|max:2048'
    ]);

    $category = new Category();
    $category->name = $request->name;
    $category->slug = Str::slug($request->name);
    $image = $request->file('image');
    $file_extension = $image->extension();
    $file_name = Carbon::now()->timestamp . '.' . $file_extension;

    // Di chuyển file vào thư mục uploads/brands
    $destinationPath = public_path('uploads/categories');
    $image->move($destinationPath, $file_name);

    $category->image = $file_name;
    $category->save();

    return redirect()->route('admin.categories')->with('status', 'Thêm danh mục thành công');

  }

  public function category_edit($id){
    $category = Category::find($id);
    return view('admin.category-edit', compact('category'));
  }
    
  public function category_update(Request $request){
    $request->validate([
        'name'  => 'required',
        'slug'  => 'required|unique:brands,slug',
        'image' => 'required|mimes:png,jpg,jpeg|max:2048'
    ]);

    $category = Category::find($request -> id);
    if(!$category ){
        return redirect()->back()->with('error', 'Không tìm thấy danh mục');
    }

    $category->name = $request->name;
    $category->slug = Str::slug($request->slug);
    
    if($request->hasFile('image')){
        $image= $request->file('image');
        $file_extenstion = $image->extension();
        $file_name =Carbon::now()->timestamp;
        $destinationPath=public_path('uploads/categories');
        $image->move($destinationPath,$file_name);
        $category->image = $file_name;
        
    }
    $category->save();
    return redirect()->route('admin.brands')->with('status', 'Cập nhập danh mục thành công');
  }
   public function category_delete($id){
    $category = Category::find($id);
    if(!$category){
        return redirect()->back()->with('error', 'Không tìm thấy danh mục');
    }
    // if(File::exits(public_path('uploads/brands').'/'.$brand->image)){
    //     File::delete(public_path('uploads/brands').'/'.$brand->image);
    // }
    if($category->image && \Illuminate\Support\Facades\File::exists(public_path('uploads/brands/'.$category->image))){
        \Illuminate\Support\Facades\File::delete(public_path('uploads/categories/'.$category->image));
    }
    $category ->delete();
    return redirect()->route('admin.categories')->with('status', 'Đã xóa danh mục thành công');
   }
}

