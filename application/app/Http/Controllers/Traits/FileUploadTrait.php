<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

trait FileUploadTrait {

    /**
     * removing the public_path thing from path as we are storing files out of public_path as on oct 1 2017
     * eg: $path = public_path('uploads/' . $folder)
     * File upload trait used in controllers to upload files
     */
    public function saveFiles(Request $request, $image, $fileType, $oldImage = '') {
        $folder = $this->img_folder;
        if ($request->hasFile($image)) {
            $filenames = [];
            foreach ($request->file($image) as $file) {
                $this->checkDir($folder);
                $ext = $file->getClientOriginalExtension();
                $allowed = $this->chekFileType($fileType, $ext);
                if (FALSE == $allowed) {
                    $data['success'] = 0;
                    $data['msg'] = 'Please select the valid file type.';
                    break;
                } else {
                    $unik = time() . '_' . $file->getClientOriginalName();
                    $path = ('assets/uploads/' . $folder);
                    $upload = $file->move($path, $unik);
                    if ($upload) {
                        if ($fileType == 'image') {
                            //image thumb>>
                            $new_dir_path = ('assets/uploads/' . $folder . '/' . $unik);
                            $new_dir_path_th = ('assets/uploads/' . $folder . '/thumbs/' . $unik);
                            Image::make($new_dir_path)->fit(config('site.image.w'), config('site.image.h'))->save($new_dir_path_th);
                            //image thumb<<
                        }
                        $filenames[] = $unik;
                        //# workouts for old image>>
                        $this->deleteOldImage($oldImage);
                        //# workouts for old image<<
                    } else {
                        $data['success'] = 0;
                        $data['msg'] = ' / image upload failed';
                        break;
                    }
                }
            }
            $data['success'] = 1;
            $data['msg'] = json_encode($filenames);
            return $data;
        } else {
            $data['success'] = 0;
            $data['msg'] = ' No image found.';
            return $data;
        }
    }

    /**
     * Creates the folder if not exists.
     * @param type $folder
     * @return boolean
     */
    public function checkDir($folder) {
        $dir = ('assets/uploads/' . $folder);
//        echo $dir;exit;
        if (!file_exists($dir)) {
            mkdir($dir);
            $indexFile = fopen($dir . '/index.html', 'w');
            fwrite($indexFile, '-No Direct Access-');
            fclose($indexFile);
            //now thumbs folder
            mkdir($dir . '/thumbs');
            $indexFile_th = fopen($dir . '/thumbs/index.html', 'w');
            fwrite($indexFile_th, '-No Direct Access-');
            fclose($indexFile_th);
        }
        return TRUE;
    }

    /**
     * lists the allowed file extensions
     * @param type $fileType
     * @param type $ext
     * @return type
     */
    public function chekFileType($fileType, $ext) {
        switch ($fileType) {
            case 'image':
                $allowed = array('JPG', 'jpg', 'jpeg', 'gif', 'png');
                break;
            case 'audio':
                $allowed = array('mp3', 'flv', 'mpg', 'mpeg', 'mp4');
                break;
            case 'document':
                $allowed = array('docx', 'xlsx', 'pptx', 'pdf');
                break;
            default:
                $allowed = array('JPG', 'jpg', 'jpeg', 'gif', 'png', 'mp3', 'flv', 'mpg', 'mpeg', 'mp4', 'docx', 'xlsx', 'pptx', 'pdf');
                break;
        }
        return $this->checkFileValidity($allowed, $ext);
    }

    /**
     * checks if the given extension is valid
     * @param type $allowed
     * @param type $ext
     * @return boolean
     */
    public function checkFileValidity($allowed, $ext) {
        if (in_array($ext, $allowed)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Deletes image
     * @param type $folder
     * @param type $oldImage
     */
    public function deleteOldImage($oldImage) {
        $folder = $this->img_folder;
        $dir_path = ('assets/uploads/' . $folder . '/' . $oldImage);
        if ($oldImage != '') {
            if (file_exists($dir_path)) {
                $dpath = 'assets/uploads/' . $folder . '/' . $oldImage;
//                Storage::delete($dpath); //# not working
                unlink($dpath);
                //# now for thumb
                $dir_path_thumb = ('assets/uploads/' . $folder . '/thumbs/' . $oldImage);
                if ($oldImage !== '' && file_exists($dir_path_thumb)) {
                    $dpath_th = 'assets/uploads/' . $folder . '/thumbs/' . $oldImage;
                    unlink($dpath_th);
                }
            }
        }
    }

    /**
     * returns the image info specially for edit page
     * @param type $imgname
     * @return string
     */
    public function getDisplayImage($imgname) {
        $folder = $this->img_folder;
        if ($imgname == '') {
            $img['path'] = asset('assets/uploads/sample.jpg');
            $img['title'] = 'sample';
        } else {
            $dir_path = ('assets/uploads/' . $folder . '/thumbs/' . $imgname);
            if (file_exists($dir_path)) {
                $img['path'] = asset('assets/uploads/' . $folder . '/thumbs/' . $imgname);
                $img['title'] = $imgname;
//                print_r($img);exit;
            } else {
                $img['path'] = asset('assets/uploads/sample.jpg');
                $img['title'] = 'sample';
            }
        }
        return $img;
    }

}
