<?php

namespace App\Repositories;

use App\Models\Hotel;
use Illuminate\Support\Collection;
use App\Repositories\BaseRepository;
use App\Repositories\HotelRepositoryInterface;

/**
 * Class HotelRepository
 * @package App\Repositories
 * @version July 20, 2020, 8:03 pm UTC
*/

class HotelRepository extends BaseRepository implements HotelRepositoryInterface
{
    /**
     * allowed Filtering Parameters 
     * @var array
     */
    protected $fieldSearchable = [
        'product_name',
        'vendor_name',
        'price'
    ];

    /**
     * allowed sorting Parameters 
     * @var array
     */
    protected $fieldSortable = [
        'price',
        'most_selling',
        'customer_votes'
    ];

    protected $model;

	public function __construct (Hotel $model) {
		$this->model = $model;
	}


    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Return sortable fields
     *
     * @return array
     */
    public function getFieldsSortable()
    {
        return $this->fieldSortable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        // $response = Http::get('api.mocki.io/v1/076dee79');
        // return collect($response->json());
        return Hotel::class;
    }

    /**
     * Build a query for retrieving all records.
     *
     * @param array $search
     * @param array $sort
     * @param int|null $skip
     * @param int|null $limit
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function allQuery($search = [], $sort = [], $skip = null, $limit = null)
    {
        $query = $this->model->newQuery();

        if (count($search)) {
            foreach($search as $key => $value) {
                if (in_array($key, $this->getFieldsSearchable())) {
                    $query->where($key, $value);
                }
            }
        }

        if (count($sort)) {
            foreach($sort as $key => $value) {
                if (in_array($key, $this->getFieldsSortable())) {
                    $direction = isset($value)? $value: 'ASC';
                    $query->orderBy($key, $direction);
                }
            }
        }

        if (!is_null($skip)) {
            $query->skip($skip);
        }

        if (!is_null($limit)) {
            $query->limit($limit);
        }

        return $query;
    }

    /**
     * Retrieve all records with given filter criteria
     *
     * @param array $search
     * @param int|null $skip
     * @param int|null $limit
     * @param array $columns
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all($search = [], $sort = [], $skip = null, $limit = null, $columns = ['*']): Collection
    {
        $query = $this->allQuery($search, $sort, $skip, $limit);

        return $query->get($columns);
    }


    /**
     * Paginate records for scaffold.
     *
     * @param int $perPage
     * @param array $columns
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage, $columns = ['*'])
    {
        $query = $this->allQuery();

        return $query->paginate($perPage, $columns);
    }

    /**
     * Create model record
     *
     * @param array $input
     *
     * @return Model
     */
    public function create($input)
    {
        $model = $this->model->newInstance($input);

        $model->save();

        return $model;
    }

    /**
     * Find model record for given id
     *
     * @param int $id
     * @param array $columns
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function find($id, $columns = ['*'])
    {
        $query = $this->model->newQuery();

        return $query->find($id, $columns);
    }

    /**
     * Update model record for given id
     *
     * @param array $input
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model
     */
    public function update($input, $id)
    {
        $query = $this->model->newQuery();

        $model = $query->findOrFail($id);

        $model->fill($input);

        $model->save();

        return $model;
    }

    /**
     * @param int $id
     *
     * @throws \Exception
     *
     * @return bool|mixed|null
     */
    public function delete($id)
    {
        $query = $this->model->newQuery();

        $hotel = $query->findOrFail($id);

        return $hotel->delete();
    }
}
