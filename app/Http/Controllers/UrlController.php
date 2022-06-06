<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlRequest;
use App\Models\Url;
use Carbon\Carbon;

class UrlController extends Controller
{
    public function generateUrl(UrlRequest $request)
    {
        $short_url = $this->generateShortUrl();
        $url = Url::create([
            'full_url' => $request->url,
            'short_url' => $short_url,

        ]);
        return redirect('/')->with('short_url', url($url->short_url));
    }

    public function redirectToOrignalurl()
    {
        $url = Url::where('short_url', request()->short_url)->firstOrFail();
        $url->increment('visited_count');
        $url->last_visit = Carbon::now();
        $url->save();
        return redirect($url->full_url);
    }

    private function generateShortUrl()
    {
        $random_string = $this->generateRandomString();
        $short_url_exist = Url::where('short_url', $random_string)->first();
        if ($short_url_exist) {
            $this->generateShortUrl();
        }
        return $random_string;
    }

    private function generateRandomString()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 5; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
