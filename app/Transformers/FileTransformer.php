<?php

namespace App\Transformers;

use App\Entities\Contractor;
use App\Entities\File;
use App\Entities\Users\User;
use League\Fractal\TransformerAbstract;

class FileTransformer extends TransformerAbstract
{
    public $itemType = null;

    public function transform(File $file)
    {
        return [
            'id' => $file->id,
            'file_name' => $file ? $file->file_path . '/' .  $file->original : '',
        ];
    }
}