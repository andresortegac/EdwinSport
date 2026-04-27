<?php

namespace App\Http\Controllers;

use App\Models\StoreItem;
use App\Support\ShopExternalCatalog;
use Illuminate\Support\Facades\Schema;

class PrincipalController extends Controller
{
    public function index()
    {
        $uploadedHighlights = collect();

        if (Schema::hasTable('store_items')) {
            $uploadedHighlights = StoreItem::query()
                ->orderByDesc('created_at')
                ->limit(4)
                ->get()
                ->map(function (StoreItem $item) {
                    $image = null;
                    if (!empty($item->image_path)) {
                        $image = route('shop.media', ['path' => ltrim(str_replace('\\', '/', (string) $item->image_path), '/')]);
                    } elseif (!empty($item->image_url)) {
                        $image = $item->image_url;
                    }

                    $price = null;
                    if ($item->price !== null) {
                        $price = '$' . number_format((float) $item->price, 0, ',', '.');
                    }

                    return [
                        'name' => $item->name,
                        'category' => $item->category ?: 'Producto',
                        'description' => $item->description ?: 'Producto agregado desde el modulo de tiendas.',
                        'price' => $price,
                        'image_url' => $image,
                        'purchase_url' => $item->purchase_url,
                        'source' => 'Publicado en tienda',
                    ];
                });
        }

        $fallback = collect(ShopExternalCatalog::items());
        $storeHighlights = $uploadedHighlights
            ->concat($fallback)
            ->take(8)
            ->values();

        return view('principal.principalView', [
            'storeHighlights' => $storeHighlights,
        ]);
    }

    public function about()
    {
        return view('principal.about');
    }
}
