<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreimageProcessingRequest;
use App\Http\Requests\UpdateimageProcessingRequest;
use App\Models\imageProcessing;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;

class ImageProcessingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return imageProcessing::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreimageProcessingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreimageProcessingRequest $request)
    {
        //
    }

    public function resize(StoreimageProcessingRequest $request)
    {
        $data = $request->all();

//        var_dump($data);
        $image = $data['image'];

        unset($data['image']);

        $savedData = [
            'type' => imageProcessing::TYPE_RESIZE,
            'data' => json_encode($data)
        ];

        $absolutePath =  public_path('images/');
        if($image instanceof UploadedFile) {
            $savedData['name'] = $image->getClientOriginalName();
            $fileName = pathinfo($savedData['name'],PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();
            $originalPath = $absolutePath .$savedData['name'];
            $image->move($absolutePath, $data['name']);
        } else {
            $savedData['name'] = pathinfo($image,PATHINFO_BASENAME);
            $fileName = pathinfo($image,PATHINFO_FILENAME);
            $extension = pathinfo($image,PATHINFO_EXTENSION);
            $originalPath =$absolutePath.$savedData['name'];;
            copy($image,$absolutePath. $savedData['name']);
        }

        $savedData['path'] = $absolutePath . $savedData['name'];

        $width = $data['width'];
        $height = $data['height'] ?? false;

        [$w,$h,$image1] = $this->getImageSize($width,$height,$originalPath);

        $savedData['path'] = $absolutePath. $savedData['name'];
        $fileResizeName = $fileName."-resized.".$extension;

        $image1->resize($w,$h)->save($absolutePath.$fileResizeName);

        $savedData['output_path'] = $absolutePath.$fileResizeName;

        return imageProcessing::create($savedData);


    }


    public function getImagesByAlbum(StoreimageProcessingRequest $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\imageProcessing  $imageProcessing
     * @return \Illuminate\Http\Response
     */
    public function show(imageProcessing $imageProcessing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateimageProcessingRequest  $request
     * @param  \App\Models\imageProcessing  $imageProcessing
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateimageProcessingRequest $request, imageProcessing $imageProcessing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\imageProcessing  $imageProcessing
     * @return \Illuminate\Http\Response
     */
    public function destroy(imageProcessing $imageProcessing)
    {
        //
    }

    /**
     * @param $width
     * @param $height
     * @param string $originalPath
     * @return float[]
     */
    private function getImageSize($width, $height, string $originalPath): array
    {
        $image = Image::make($originalPath);
        $originalWidth = $image->width();
        $originalHeight = $image->height();

        if(str_ends_with($width,'%')) {
            $widthRatio = (float)str_replace('%','', $width);
            $heightRatio = $height ? (float)str_replace('%','', $height) : $widthRatio;

            $newWidth = (float)$originalWidth * ($widthRatio/100);
            $newHeight = (float)$originalHeight * ($heightRatio/100);

        } else {
            $newWidth = (float)$width;
            $newHeight = $height ? (float)$height : ($originalHeight * $newWidth/$originalWidth);
        }

        return [$newWidth,$newHeight,$image];
    }
}
