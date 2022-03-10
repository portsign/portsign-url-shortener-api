<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Shortener;
use Validator;
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
        $user = ['users_id' => auth()->user()->id];
        $data = $input + $user;
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
    public function show($id)
    {
        $shortener = Shortener::find($id);
        if (is_null($shortener)) {
            return $this->sendError('URL not found.');
        }
        return $this->sendResponse(new ShortenerResource($shortener), 'Short URL retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shortener $shortener)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'short_url' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $product->short_encrypt = $input['short_url'];
        $product->save();
        return $this->sendResponse(new ProductResource($product), 'Product updated successfully.');
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