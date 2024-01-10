<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Database\Query\Builder as QueryBuilder;


trait CanLoadRelations{

    public function loadRelations(Model|QueryBuilder|EloquentBuilder $for, ?array $availableRelations = null) 
    : Model|QueryBuilder|EloquentBuilder{
        $relations = $availableRelations ?? $this->availableRelations ?? [];

        foreach($relations as $relation){
            $for->when(
                $this->isRelationIncluded($relation), 
                fn($q) => $for instanceof Model ? $for->load($relation) : $q->with($relation)
            );
        }

        return $for;
    }

    public function isRelationIncluded(string $relation) : bool {
        $include = request()->query('include');
        if (!$include) return false;

        $requested_realtions = array_map('trim', explode(',', $include));
        return in_array($relation, $requested_realtions);
    }
}