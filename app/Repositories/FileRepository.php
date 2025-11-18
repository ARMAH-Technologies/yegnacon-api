<?php
/**
 * Created by PhpStorm.
 * User: Mohammed
 * Date: 2/25/2016
 * Time: 8:35 PM
 */

namespace App\Repositories;

use App\Entities\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;
use Mockery\CountValidator\Exception;
use Webpatser\Uuid\Uuid;

class FileRepository
{
    public function upload($item_type, $item_id)
    {
        $file = Input::file('file');
        $extension = $file->getClientOriginalExtension();

        if (!file_exists('uploads/' . $item_type)) {
            mkdir('uploads/' . $item_type, 0777, true);
        }
        if ($item_type == "project_proforma_request"
            || $item_type == "project_proforma_response"
            || $item_type == "product_proforma_request"
            || $item_type == "product_proforma_response"){
            return $this->uploadFile($item_type, $item_id);
        } else{
            $destinationPath = 'uploads/' . $item_type; // upload path
            $original = sha1(time().time()) . "." .$extension;
            $upload_success = Input::file('file')->move($destinationPath, $original); // uploading file to given path

            $thumbnail = '250x250-' . $original;
            $large_image = '500x500-' . $original;
            Image::make($destinationPath . '/' . $original)->resize(250, 250)->save($destinationPath . '/' . $thumbnail);
            Image::make($destinationPath . '/' . $original)->resize(500, 500)->save($destinationPath . '/' . $large_image);

            if($upload_success) {
                $file_db = new \App\Entities\File();
                $file_db->id  = Uuid::generate(4);
                $file_db->item_id = $item_id;
                $file_db->file_path = $destinationPath;
                $file_db->extension = $extension;
                $file_db->original = $original;
                $file_db->thumbnail = $thumbnail;
                $file_db->large_image = $large_image;
                $file_db->save();
                return Response::json(['status'=>'success'], 200);
            } else {
                return Response::json(['status'=>'error'], 400);
            }
        }
    }

    public function update($file_id)
    {
        $file_db = File::find($file_id);

        if ($file_db){
            $file = Input::file('file');
            $extension = $file->getClientOriginalExtension();

            $destinationPath = $file_db->file_path; // upload path
            $original = sha1(time().time()) . "." .$extension;
            $upload_success = Input::file('file')->move($destinationPath, $original); // uploading file to given path

            $thumbnail = '250x250-' . $original;
            $large_image = '500x500-' . $original;
            Image::make($destinationPath . '/' . $original)->resize(250, 250)->save($destinationPath . '/' . $thumbnail);
            Image::make($destinationPath . '/' . $original)->resize(500, 500)->save($destinationPath . '/' . $large_image);

            if ($upload_success){
                try {
                    if ($file_db -> thumbnail != "default_user.png" && $file_db->thumbnail != "default_product.png"
                            && $file_db -> thumbnail != "default-news.png" && $file_db -> thumbnail != "default_company.png"
                            && $file_db -> thumbnail != "project-default.jpg") {
                        if (file_exists($destinationPath . '/' . $file_db->thumbnail))
                            unlink($destinationPath . '/' . $file_db->thumbnail);
                        if (file_exists($destinationPath . '/' . $file_db->original))
                            unlink($destinationPath . '/' . $file_db->original);
                        if (file_exists($destinationPath . '/' . $file_db->large_image))
                            unlink($destinationPath . '/' . $file_db->large_image);
                    }
                    $file_db->extension = $extension;
                    $file_db->original = $original;
                    $file_db->thumbnail = $thumbnail;
                    $file_db->large_image = $large_image;
                    $file_db->save();
                    return Response::json(['status'=>'success'], 200);
                } catch (Exception $e){
                    return Response::json(['status'=>'error'], 400);
                }

            } else {
                return Response::json(['status'=>'error'], 400);
            }
        }

    }

    public function uploadFile($item_type, $item_id){
        $file = Input::file('file');
        $extension = $file->getClientOriginalExtension();
        $name = $file->getClientOriginalName();

        if (!file_exists('uploads/' . $item_type)) {
            mkdir('uploads/' . $item_type, 0777, true);
        }
        $destinationPath = 'uploads/' . $item_type; // upload path
        $n = str_replace(".".$extension, "_", $name);
        $original = $n . substr(sha1(time().time()), 0, 10) . "." .$extension;
        $upload_success = Input::file('file')->move($destinationPath, $original);
        if ($upload_success){
            $file_db = new \App\Entities\File();
            $file_db->id  = Uuid::generate(4);
            $file_db->item_id = $item_id;
            $file_db->file_path = $destinationPath;
            $file_db->extension = $extension;
            $file_db->original = $original;
            $file_db->save();
            return Response::json(['status'=>'success'], 200);
        } else {
            return Response::json(['status'=>'error'], 400);
        }
    }
}