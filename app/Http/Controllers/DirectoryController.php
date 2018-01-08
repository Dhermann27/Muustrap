<?php

namespace App\Http\Controllers;

use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DirectoryController extends Controller
{
    public function index()
    {
        try {
            $client = new \GuzzleHttp\Client();
            $fb = new Facebook([
                'app_id' => '102898313117617',
                'app_secret' => '00a949b18cbaacd080ef80ae71b7d599',
                'http_client_handler' => new \App\Guzzle6HttpClient($client),
            ]);

            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->get(
                '/28250481135/members?limit=999&fields=name,picture,link', env('FACEBOOK_LONG_TOKEN')
            );

            $graph = json_decode($response->getGraphEdge());
            $pictures = [];
            foreach ($graph as $picture) {
                $pictures[$picture->name]["url"] = $picture->picture->url;
                $pictures[$picture->name]["link"] = $picture->link;
            }
        } catch (FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
        }

        $years = \App\Yearattending::select('year')
            ->where('camperid', \App\Camper::where('email', Auth::user()->email)->first()->id)->get();
        return view('directory', ['letters' => \App\Byyear_Family::select('id', DB::raw('LEFT(`name`, 1) AS first'), 'name', 'city', 'statecd', DB::raw('GROUP_CONCAT(`year`) AS years'))
            ->groupBy('id')->whereIn('year', $years)->with('allcampers')->orderBy('name')
            ->orderBy('statecd')->orderBy('city')->get(), 'pix' => $pictures]);
    }
}
