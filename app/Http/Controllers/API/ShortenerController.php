<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Shortener;
use Validator;
use App\Helpers\PseudoCrypt;
use App\Http\Resources\ShortenerResource;

class ShortenerController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shortener = Shortener::all();
        return $this->sendResponse(ShortenerResource::collection($shortener), 'Short URL retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $short_encrypt = PseudoCrypt::hash(rand(1,9999));
        $user = ['users_id' => auth()->user()->id, 'short_encrypt' => $short_encrypt];
        $data = $input + $user;

        $validate = Shortener::where('short_encrypt', '=', $short_encrypt);

        if ($validate->count() > 0) {
            return $this->sendError('Url Same');
        }

        $validator = Validator::make($input, [
            'long_url' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $shortener = Shortener::create($data);
        return $this->sendResponse(new ShortenerResource($shortener), 'Short URL created successfully.');
    } 

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $short_url = $request->short_url;
        $urlParts = explode('/', str_ireplace(array('http://', 'https://'), '', $short_url));
        $shortener = Shortener::where('short_encrypt', '=', $urlParts[1]);
        if ($shortener->count() < 1) {
            return $this->sendError('Short URL not found.');
        }
        return $this->sendResponse(new ShortenerResource($shortener->firstOrFail()), 'Short URL retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function custom_url(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'short_url' => 'required',
            'custom_url' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $short_url = $request->short_url;
        $urlParts = explode('/', str_ireplace(array('http://', 'https://'), '', $short_url));
        $shortener = Shortener::where('short_encrypt', $urlParts[1]);
        $short_id = $shortener->get()[0]->id;
        $updateShortener = $shortener->update(['short_encrypt' => $input['custom_url']]);
        return $this->sendResponse(new ShortenerResource(Shortener::find($short_id)), 'Short URL updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shortener $shortener)
    {
        $shortener->delete();
        return $this->sendResponse([], 'Short URL deleted successfully.');
    }
}