<?php

namespace App\Repositories\traits;

trait UploadFile
{
    // Upload image function
    /**
     * @param $image
     * @param $path
     * @return string
     */
    public function UploadImage($image, $path)
    {
        //get file name with extention
        $filenameWithExt = $image->getClientOriginalName();
        //get just file name
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        //GET EXTENTION
        $extention = $image->getClientOriginalExtension();
        //file name to store
        $fileNameToStore = $path.'/'.$filename.'_'.time().'.'.$extention;
        //upload image
        $path = $image->storeAs('public/', $fileNameToStore);

        return $fileNameToStore;
    }

    // Update image function
    public function UpdateImage($image, $path, $oldImage): string
    {
        unlink(public_path('storage/'.$oldImage));

        return $this->UploadImage($image, $path);
    }
}
