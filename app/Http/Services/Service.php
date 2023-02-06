<?php

namespace App\Http\Services;

class Service
{
    protected $model;

    public function __construct()
    {
        //
    }

    public function getFirst()
    {
        return $this->model::first();
    }

    public function getLast()
    {
        return $this->model::latest()->first();
    }

    public function getAll()
    {
        return $this->model::get();
    }

    public function getById($id)
    {
        return $this->model::find($id);
    }

    public function getByEmail($value)
    {
        return $this->model::where('email', $value)->first();
    }

    public function getByField($field, $value)
    {
        return $this->model::where($field, $value)->first();
    }

    public function modelCreate(array $data)
    {
        return $this->model::create($data);
    }

    public function modelUpdate($model, $data)
    {
        $model->fill($data);
        $model->save();
        return $model;
    }

    public function modelRemove($model)
    {
        return $model->delete();
    }
}