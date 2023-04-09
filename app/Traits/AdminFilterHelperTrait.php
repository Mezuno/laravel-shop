<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

trait AdminFilterHelperTrait
{
    private function addWhereFilterToQuery(&$query, $request, $validated, $name, $operator, bool $like = false): void
    {
        if ($like) {
            $prefixAndPostfix = '%';
        } else {
            $prefixAndPostfix = '';
        }

        if ($request->has($name) && $validated[$name]) {
            $query->where($name, $operator, $prefixAndPostfix.$validated[$name].$prefixAndPostfix);
        }
    }

    private function addWhereBetweenFilterToQuery(&$query, $request, $validated, $name, $from, $to): void
    {
        $nameFrom = $name . '_from';
        $nameTo = $name . '_to';

        if ($request->has($nameFrom) && $validated[$nameFrom]) {
            if (!$validated[$nameFrom] < $from) {
                $from = (int)$validated[$nameFrom];
            }
        }

        if ($request->has($nameTo) && $validated[$nameTo]) {
            if (!($validated[$nameTo] > $to || $validated[$nameTo] == '')) {
                $to = (int)$validated[$nameTo];
            }
        }

        $query->whereBetween($name, [$from, $to]);
    }

    private function getFilterSize($request, $validated, $size = 8): int
    {
        if ($request->has('size') && $validated['size']) {
            if (!(int)$validated['size'] <= 0) {
                $size = (int)$validated['size'];
            }
        }

        return $size;
    }

    private function addWithTrashedFilterToQuery(&$query, $request, $validated)
    {
        if ($request->has('deleted') && $validated['deleted']) {
            $query->withTrashed();
        }
    }

    private function addWhereBoolFilterToQuery(&$query, $request, $validated, $name, $onNull = false)
    {
        $nameFalse = $name . '_false';
        $nameTrue = $name . '_true';

        if ($request->has($nameTrue) && $validated[$nameTrue] == 'on' &&
            $request->has($nameFalse) && $validated[$nameFalse] == 'on') {
            return 0;
        }

        if ($onNull) {
            if ($request->has($nameTrue) && $validated[$nameTrue]) {
                $query->where($name, '!=', null);
            }

            if ($request->has($nameFalse) && $validated[$nameFalse]) {
                $query->where($name, '=', null);
            }

            return 1;
        }

        if ($request->has($nameTrue) && $validated[$nameTrue]) {
            $query->where($name, '=', true);
        }

        if ($request->has($nameFalse) && $validated[$nameFalse]) {
            $query->where($name, '=', false);
        }
    }

    private function addUserPostFilter(&$entities, $request, $validated)
    {
        $filtered = [];

        if ($request->has('user') && $validated['user']) {

            foreach ($entities as $entity) {

                if ($this->likeMatch('%'.$validated['user'].'%', $entity->user->name) or
                    $this->likeMatch('%'.$validated['user'].'%', $entity->user->email) or
                    $this->likeMatch('%'.$validated['user'].'%', $entity->user->id)) {
                    array_push($filtered, $entity);
                }

            }

            $entities = $this->toCollection($filtered);
        }
    }

    private function addProductPostFilter(&$entities, $request, $validated, $json = false)
    {
        if ($request->has('product') && $validated['product']) {
            $filtered = [];
            foreach ($entities as $entity) {

                if ($json) {

                    foreach (json_decode($entity->products) as $product) {
                        if ($product->vendor_code === (int)$validated['product'] or
                            $this->likeMatch('%'.$validated['product'].'%', $product->title)) {
                            array_push($filtered, $entity);
                        }
                    }

                } else {

                    if ($entity->product->vendor_code === (int)$validated['product'] or
                        $this->likeMatch('%'.$validated['product'].'%', $entity->product->title)) {
                        array_push($filtered, $entity);
                    }

                }
            }

            $entities = $this->toCollection($filtered);
        }
    }

    private function likeMatch($pattern, $subject): bool
    {
        $pattern = str_replace('%', '.*', preg_quote($pattern, '/'));
        return (bool) preg_match("/^{$pattern}$/i", $subject);
    }

    private function toCollection(array $array): Collection
    {
        $collection = new Collection();
        foreach($array as $item){
            $collection->push((object)$item);
        }
        return $collection;
    }

    private function paginate($items, $perPage = 15, $page = null, $options = []): LengthAwarePaginator
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
