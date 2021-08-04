<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image as FacadeImage;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;


class TestController extends Controller
{
    public function image_upload(Request $request){
        $this->validate($request, [
            'image' => 'required|mimes:jpeg,png,jpg,svg'
        ]);
        //$image = $this->imageStore($request);
        // $image = $this->imageStoreStorage($request);
        $image = $this->resizeImage($request);
        if($image){
            return back()->with('success','Image Stored');
        }else{
            return back()->with('error','Image not Stored');
        }
    }
    public function multi_image_upload(Request $request){
        
        if($request->hasFile('multi_images')){
            $images = $request->file('multi_images');
            foreach($images as $image){
                $this->multiImageStoreStorage($image);
            }
            return back()->with('multi-success','Images Stored');
        }
        return back()->with('multi-error','Images not Stored');

    }
    public function imageStore($request){
        $clientImageName = explode('.',$request->file('image')->getClientOriginalName());
        $imageName = $clientImageName[0].time().".".$clientImageName[1];
        $imagePath = $request->image->move(public_path('images'),$imageName);
        $image = Image::create(['image_name'=>$imageName, 'image_url'=>$imagePath]);
        return $image;
    }
    public function imageStoreStorage($request){
        $clientImageName = explode('.',$request->file('image')->getClientOriginalName());
        $imageName = $clientImageName[0].time().".".$clientImageName[1];
        $imagePath = $request->image->storeAs('/images',$imageName);
        $image = Image::create(['image_name'=>$imageName, 'image_url'=>$imagePath]);
        return $image;
    }
    public function multiImageStoreStorage($image){
        $clientImageName = explode('.',$image->getClientOriginalName());
        $imageName = $clientImageName[0].time().".".$clientImageName[1];
        $imagePath = $image->storeAs('/images',$imageName);
        $image = Image::create(['image_name'=>$imageName, 'image_url'=>$imagePath]);
    }
    public function resizeImage($request){
        $clientImageName = explode('.',$request->file('image')->getClientOriginalName());
        $imageName = $clientImageName[0].time().".".$clientImageName[1];
        $image_resize = FacadeImage::make($request->file('image'));
        $image_resize->resize(100,100);
        $image_resize->save(storage_path('app/images/thumbnail/').$imageName);
        $image = Image::create(['image_name'=>$imageName, 'image_url'=>'images/thumbnail/'.$imageName]);
        return $image;
    }

    public function downloadImage(Image $image){
        $file_path = storage_path()."\app\\".$image->image_url;
        if(file_exists($file_path)){
            return Response::download($file_path,$image->image_name);
        }
        else{
            abort(404);
        }

    }
}
