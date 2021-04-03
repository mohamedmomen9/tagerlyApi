<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use App\Http\Resources\HotelResource;
use App\Repositories\HotelRepository;
use App\Http\Requests\CreateHotelRequest;
use App\Http\Requests\UpdateHotelRequest;
use App\Repositories\HotelRepositoryInterface;

class HotelController extends Controller
{
    private $hotelRepository;

    public function __construct(HotelRepositoryInterface $hotelRepository)
   {
       $this->hotelRepository = $hotelRepository;
   }

    public function index(Request $request)
    {
        $search = (array)json_decode($request->get('search'));
        $sort = (array)json_decode($request->get('sort'));
        $skip = $request->get('skip');
        $limit = $request->get('limit');
        $columns = $request->get('columns');
        $hotels = $this->hotelRepository->all($search, $sort, $skip, $limit);

        return $this->sendResponse(HotelResource::collection($hotels), 'hotels retrieved successfully');
    }

    public function store(CreateHotelRequest $request)
    {
        try {
            $input = $request->all();
            $hotel = $this->hotelRepository->create($input);
        } catch(\Exception $e) {
            return $this->sendError([$e->getMessage()], 400);
        }
        return $this->sendResponse(new HotelResource($hotel), 'Hotel saved successfully');
    }

    public function show($id)
    {
        $hotel = $this->hotelRepository->find($id);

        if (empty($hotel)) {
            return $this->sendError('Hotel not found');
        }

        return $this->sendResponse(new HotelResource($hotel), 'Hotel retrieved successfully');
    }

    public function update($id, UpdateHotelRequest $request)
    {
        $hotel =$this->hotelRepository->find($id);

        if (empty($hotel)) {
            return $this->sendError('Hotel not found');
        }

        $hotel->fill($request->all());
        $hotel->save();

        return $this->sendResponse(new HotelResource($hotel), 'Hotel updated successfully');
    }

    public function destroy($id)
    {
        $hotel = $this->hotelRepository->find($id);

        if (empty($hotel)) {
            return $this->sendError('Hotel not found');
        }

        $this->hotelRepository->delete($id);

        return $this->sendSuccess('Hotel deleted successfully');
    }
}
