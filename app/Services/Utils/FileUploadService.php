<?php

namespace App\Services\Utils;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

/**
 * FileUploadService
 */
class FileUploadService
{

    /**
     * uploadFile
     *
     * @param  mixed $file
     * @param  mixed $upload_path
     * @param  mixed $delete_path
     * @return void
     */
    public function uploadFile($file, $upload_path = null, $delete_path = null, $use_original_name = false)
    {
        try {
            // Upload image
            // Delete old file
            if ($delete_path) {
                $this->deleteFile($delete_path);
            }
            // Upload new file
            return $this->upload($file, $upload_path, $use_original_name);
        } catch (Exception $ex) {
            return null;
        }
    }
    public function deleteFile($path = '')
    {
        try {
            // Delete image form public directory
            // $path = storage_path("app/" . $path);
            $path = storage_path("app/public/" . $path);
            // dd($path);
            if (file_exists($path)) unlink($path);
        } catch (\Exception $ex) {
        }
    }

    /**
     * upload
     *
     * @param  mixed $file
     * @param  mixed $path
     * @return void
     */
    public function upload($file, $path = 'others', $use_original_name = false)
    {
        // dd($file);
        try {
            if (!$use_original_name) {
                $name = time() . rand(1111, 9999) . '.' . $file->getClientOriginalExtension();
            } else {
                $full_name = $file->getClientOriginalName();
                $extract_name = explode('.', $full_name);

                $name = generateSlug($extract_name[0]) . '-' . time() . '.' . $file->getClientOriginalExtension();
            }
            // Store image to public disk

            // $file->storeAs('public/payment/documents', $name);
            $file->storeAs($path, $name);

            return $name ?? '';
        } catch (Exception $ex) {
            return '';
        }
    }

    /**
     * delete
     *
     * @param  mixed $path
     * @return void
     */
//     public function delete($path = '')
//     {
//         try {
//             // Delete image form public directory

//                 Storage::disk(config('filesystems.default'))->delete($path);


// //            if (file_exists($path)) unlink($path);
//         } catch (Exception $ex) {
//         }
//     }
    public function delete($path = '')
    {
        try {
            // Delete image form public directory

                // Storage::disk('public')->delete($path);
           if (file_exists( public_path($path))) {
            unlink(  public_path($path));
           }
        } catch (\Exception $ex) {
        }
    }



    public function uploadBase64File($file, $upload_path = null, $img_name = null, $delete_path = null)
    {

        try {
            // Upload image
            if ($file) {
                // Delete old file
                if ($delete_path) {
                    // dd('delete_path', $delete_path);
                    $this->delete($delete_path);
                }
                // Upload new file
                return $this->uploadBase64($file, $upload_path, $img_name);
            }
            return null;
        } catch (\Exception $ex) {
            return null;
        }
    }

    public function uploadBase64($file, $upload_path = 'others', $img_name = null)
    {
        try {
            if ($file) {
                if(is_null($img_name)){
                    $img_name = time() . Str::uuid() . '.png';
                }

                $img = substr($file, strpos($file, ",") + 1);
                Storage::disk('public')->put($upload_path . '/' . $img_name, base64_decode($img));
                return $img_name;
            }
        } catch (\Exception $ex) {
            return '';
        }
    }

}
