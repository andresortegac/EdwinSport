<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\StoreItem;
use App\Support\ShopExternalCatalog;
use Illuminate\Support\Facades\Schema;

class CrearEventoDeveloperController extends Controller
{
    public function index()
    {
        $eventos = Event::latest()->get();
        $storeItems = collect();

        if (Schema::hasTable('store_items')) {
            $storeItems = StoreItem::query()
                ->orderByDesc('created_at')
                ->limit(50)
                ->get();
        }

        return view('events.crear-eventodeveloper', [
            'eventos' => $eventos,
            'storeItems' => $storeItems,
            'externalStoreItems' => collect(ShopExternalCatalog::items()),
        ]);
    }
}

