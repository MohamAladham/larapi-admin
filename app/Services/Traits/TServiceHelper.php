<?php

namespace App\Services\Traits;

use App\Tenant\Models\Attachment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

trait TServiceHelper
{
    public $audio_exts = [ 'wmv', 'mp3', 'wav' ];
    public $video_exts = [ 'flv', 'mp4', 'm3u8', '3gp', 'mov', 'avi', 'wmv', 'mp3', 'wav' ];
    public $imgs_exts = [ 'jpg', 'jpeg', 'gif', 'png', 'bmp', 'svg' ];
    public $docs_exts = [ 'ttf', 'doc', 'docx', 'pdf', 'xls', 'xlsx', 'ppt', 'pptx', 'zip', 'rar', 'rtf' ];

    private function upload_file( $file, $folder = '', $relative_path = TRUE )
    {

        if ( !$file )
        {
            return NULL;
        }
        $file_path = Storage::disk( 'public' )->putFile( $folder, $file );
        if ( $relative_path )
        {
            return $file_path;
        }
        $file_name = basename( $file_path );

        return $file_name;

    }

    private function upload_image( $image_key, $folder = '' )
    {
        if ( $file = request()->file( $image_key ) )
        {
            return $this->upload_file( $file, $folder );
        } else
        {
            if ( request()->get( $image_key . '_remove' ) )
            {
                return NULL;
            }
        }

    }

}
