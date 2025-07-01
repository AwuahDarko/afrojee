<?php

if (!function_exists('get_setting')) {
    function get_setting($key, $default = null, $lang = false)
    {
        return "";
    }
}

//return file uploaded via uploader
if (!function_exists('uploaded_asset')) {
    function uploaded_asset($id)
    {

        // $asset = \DB::table('uploads')->where('id', $id)->first();

        // return my_local_asset($asset->file_name); 

        return null;
    }
}

//return file uploaded via uploader


if (!function_exists('my_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @param bool|null $secure
     * @return string
     */
    function my_asset($path, $secure = null)
    {

        // https://awibuy-new-bucket.eu-central-1.linodeobjects.com/uploads/all/NXvdWv9Zq0idHvvBlc7amAIVwi6IXMhvvj1FYchS.png
        // return Storage::disk('s3')->url($path);
        return 'http://localhost/uploads/' . $path;
    }
}

if (!function_exists('my_local_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @param bool|null $secure
     * @return string
     */
    function my_local_asset($path, $secure = null)
    {
        // if (env('FILESYSTEM_DRIVER') == 's3') {
        //     return Storage::disk('s3')->url($path);
        // } else {
        // }
        return app('url')->asset('public/' . $path, $secure);
    }
}

if (!function_exists('static_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @param bool|null $secure
     * @return string
     */
    function static_asset($path, $secure = null)
    {
        return app('url')->asset('public/' . $path, $secure);
    }
}

if (!function_exists('getBaseURL')) {
    function getBaseURL()
    {
        $root = '//' . $_SERVER['HTTP_HOST'];
        // dd($root);
        $root .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
        return $root;
    }
}


if (!function_exists('getFileBaseURL')) {
    function getFileBaseURL()
    {

        return getBaseURL() . 'public/';
    }
}

if (!function_exists('getLocalFileBaseURL')) {
    function getLocalFileBaseURL()
    {

        return getBaseURL() . 'public/';
    }
}


if (!function_exists('generateUuidV4')) {
    function generateUuidV4()
    {
        $data = random_bytes(16);

        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}



if (!function_exists('app_currency')) {
    function app_currency()
    {
        return "€";
    }
}
