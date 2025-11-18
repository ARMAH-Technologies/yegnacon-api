<?php

namespace App\Http\Controllers;


use App\Repositories\FileRepository;
use Illuminate\Support\Facades\Input;

class FileController extends Controller
{
    protected $fileRepository;

    public function __construct(FileRepository $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }
    public function upload($item_type,$item_id)
    {
        $response = $this->fileRepository->upload($item_type, $item_id);

        return $response;

    }

    public function update($file_id)
    {
        $response = $this->fileRepository->update($file_id);
        return $response;
    }

}
