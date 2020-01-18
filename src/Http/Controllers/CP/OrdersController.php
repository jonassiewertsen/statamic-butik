<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\CP;

use Illuminate\Http\Request;
use Jonassiewertsen\StatamicButik\Blueprints\ShippingBlueprint;
use Jonassiewertsen\StatamicButik\Http\Controllers\Controller;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Jonassiewertsen\StatamicButik\Http\Models\Shipping;
use Scrumpy\HtmlToProseMirror\Test\TestCase;
use Statamic\Contracts\Auth\User;
use Statamic\CP\Column;
use Statamic\Facades\Blueprint;

class OrdersController extends Controller
{
//    public function index() {
//        $shippings = Shipping::all()->filter(function ($collection) {
//            return true;
//            // TODO: Add permissions
//            //return User::current()->can('view', $collection);
//        })->map(function ($shipping) {
//            return [
//                'title'      => $shipping->title,
//                'price'      => $shipping->price,
//                'edit_url'   => $shipping->editUrl(),
//                'id'         => $shipping->slug,
//
//                // TODO: Add permissions
//                // 'deleteable' => User::current()->can('delete', $collection)
//                'deleteable' => true,
//            ];
//        })->values();
//
//        return view('statamic-butik::cp.shippings.index', [
//            'shippings' => $shippings,
//            'columns' => [
//                Column::make('title')->label(__('statamic-butik::shipping.singular')),
//                Column::make('price')->label(__('statamic-butik::cp.price')),
//            ],
//        ]);
//    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id'           => 'required|unique:orders,id',
            'products'     => 'required',
            'total_amount' => 'required|integer',
            'paid_at'      => 'required|date',
            'shipped_at'   => 'nullable|date',
        ]);

        Order::create($validatedData);
    }

//    public function edit(Shipping $shipping) {
//        $values = $shipping->toArray();
//        $blueprint = new ShippingBlueprint();
//        $fields = $blueprint()->fields()->addValues($values)->preProcess();
//
//        return view('statamic-butik::cp.shippings.edit', [
//            'blueprint' => $blueprint()->toPublishArray(),
//            'values'    => $fields->values(),
//            'id'        => $shipping->slug,
//            'meta'      => $fields->meta(),
//        ]);
//    }
//
//    public function update(Request $request, Shipping $shipping) {
//        $blueprint = new ShippingBlueprint();
//        $fields = $blueprint()->fields()->addValues($request->all());
//        $fields->validate();
//        $values = $fields->process()->values();
//        $shipping->update($values->toArray());
//    }
//
//    public function destroy(Shipping $shipping)
//    {
//        // TODO: Add Permissions
//        $shipping->delete();
//    }
}
