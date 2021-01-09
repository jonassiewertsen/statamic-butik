<?php

namespace Jonassiewertsen\StatamicButik\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Jonassiewertsen\StatamicButik\Blueprints\OrderBlueprint;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Statamic\CP\Column;
use Statamic\Http\Resources\CP\Concerns\HasRequestedColumns;

class OrderResource extends ResourceCollection
{
    use HasRequestedColumns;

    public $collects = Order::class;
    protected $blueprint;
    protected $columns;

    public function __construct($resource)
    {
        parent::__construct($resource);

        $orderBlueprint = new OrderBlueprint();
        $this->blueprint = $orderBlueprint();
    }

    public function columnPreferenceKey($key)
    {
        $this->columnPreferenceKey = $key;

        return $this;
    }

    private function setColumns()
    {
        $columns = $this->blueprint
            ->columns()
            ->ensurePrepended(Column::make('datestamp')->label('Date'));

        if ($key = $this->columnPreferenceKey) {
            $columns->setPreferred($key);
        }

        $this->columns = $columns->rejectUnlisted()->values();
    }

    public function toArray($request)
    {
        $this->setColumns();

        return [
            'data' => $this->collection->each(function ($collection) {
                $collection
                    ->blueprint($this->blueprint)
                    ->columns($this->requestedColumns());
            }),

            'meta' => [
                'columns' => $this->visibleColumns(),
            ],
        ];
    }
}
