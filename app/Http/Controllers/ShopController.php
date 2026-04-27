<?php

namespace App\Http\Controllers;

use App\Models\StoreItem;
use App\Support\ShopExternalCatalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{
    public function index()
    {
        $uploadedItems = collect();
        if (Schema::hasTable('store_items')) {
            $uploadedItems = StoreItem::query()
                ->orderByDesc('created_at')
                ->get();
        }

        $externalItems = collect(ShopExternalCatalog::items());

        return view('store.index', [
            'uploadedItems' => $uploadedItems,
            'externalItems' => $externalItems,
        ]);
    }

    public function media(string $path)
    {
        $path = ltrim($path, '/');
        $path = str_replace('\\', '/', $path);

        if ($path === '' || str_contains($path, '..')) {
            abort(404);
        }

        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }

        return response()->file(Storage::disk('public')->path($path));
    }

    public function store(Request $request)
    {
        if (!Schema::hasTable('store_items')) {
            return back()
                ->withErrors([
                    'name' => 'La tabla de tienda no existe aun. Ejecuta las migraciones e intenta de nuevo.',
                ], 'storeItem')
                ->withInput();
        }

        $data = $request->validateWithBag('storeItem', [
            'name' => 'required|string|max:180',
            'category' => 'nullable|string|max:120',
            'description' => 'nullable|string|max:2000',
            'price' => 'nullable|numeric|min:0|max:9999999999.99',
            'currency' => 'nullable|string|max:8',
            'purchase_url' => 'nullable|url|max:2048',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
            'image_url' => 'nullable|url|max:2048',
            'company_name' => 'nullable|string|max:180',
            'company_phone' => 'nullable|string|max:60',
            'company_email' => 'nullable|email|max:180',
            'company_location' => 'nullable|string|max:220',
            'company_website' => 'nullable|url|max:2048',
            'company_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,svg|max:4096',
            'company_logo_url' => 'nullable|url|max:2048',
            'catalog_summary' => 'nullable|string|max:1500',
            'catalog_images' => 'nullable|array|max:12',
            'catalog_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:5120',
            'catalog_image_urls' => 'nullable|string|max:12000',
        ]);

        $catalogUrlData = $this->parseCatalogUrls((string) ($data['catalog_image_urls'] ?? ''));
        if (!empty($catalogUrlData['invalid'])) {
            return back()
                ->withErrors([
                    'catalog_image_urls' => 'Hay URLs de catalogo invalidas. Verifica cada enlace en una linea separada.',
                ], 'storeItem')
                ->withInput();
        }

        if (!$request->hasFile('image') && empty(trim((string) ($data['image_url'] ?? '')))) {
            return back()
                ->withErrors([
                    'image' => 'Debes subir una imagen o pegar una URL de imagen externa.',
                ], 'storeItem')
                ->withInput();
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('tiendas', 'public');
        }

        $imageUrl = !empty($data['image_url']) ? trim((string) $data['image_url']) : null;
        if ($imagePath) {
            // Si hay archivo local subido, siempre lo priorizamos.
            $imageUrl = null;
        }

        $companyLogoPath = null;
        if ($request->hasFile('company_logo')) {
            $companyLogoPath = $request->file('company_logo')->store('tiendas/logos', 'public');
        }

        $companyLogoUrl = !empty($data['company_logo_url']) ? trim((string) $data['company_logo_url']) : null;
        if ($companyLogoPath) {
            $companyLogoUrl = null;
        }

        $catalogUploadedPaths = [];
        if ($request->hasFile('catalog_images')) {
            foreach ((array) $request->file('catalog_images') as $catalogImageFile) {
                if (!$catalogImageFile) {
                    continue;
                }

                $catalogUploadedPaths[] = $catalogImageFile->store('tiendas/catalogo', 'public');
            }
        }

        $catalogEntries = $this->buildCatalogEntries($catalogUploadedPaths, $catalogUrlData['valid']);

        StoreItem::create([
            'name' => trim((string) $data['name']),
            'category' => !empty($data['category']) ? trim((string) $data['category']) : null,
            'description' => !empty($data['description']) ? trim((string) $data['description']) : null,
            'price' => isset($data['price']) && $data['price'] !== '' ? (float) $data['price'] : null,
            'currency' => !empty($data['currency']) ? strtoupper(trim((string) $data['currency'])) : 'COP',
            'purchase_url' => !empty($data['purchase_url']) ? trim((string) $data['purchase_url']) : null,
            'image_path' => $imagePath,
            'image_url' => $imageUrl,
            'company_name' => !empty($data['company_name']) ? trim((string) $data['company_name']) : null,
            'company_phone' => !empty($data['company_phone']) ? trim((string) $data['company_phone']) : null,
            'company_email' => !empty($data['company_email']) ? trim((string) $data['company_email']) : null,
            'company_location' => !empty($data['company_location']) ? trim((string) $data['company_location']) : null,
            'company_website' => !empty($data['company_website']) ? trim((string) $data['company_website']) : null,
            'company_logo_path' => $companyLogoPath,
            'company_logo_url' => $companyLogoUrl,
            'catalog_summary' => !empty($data['catalog_summary']) ? trim((string) $data['catalog_summary']) : null,
            'catalog_images' => !empty($catalogEntries) ? $catalogEntries : null,
            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('events.crear-evento-developer')
            ->with('store_success', 'Producto de tienda guardado correctamente.');
    }

    public function update(Request $request, StoreItem $storeItem)
    {
        if (!Schema::hasTable('store_items')) {
            return back()
                ->withErrors([
                    'name' => 'La tabla de tienda no existe aun. Ejecuta las migraciones e intenta de nuevo.',
                ], 'storeItem')
                ->withInput();
        }

        $data = $request->validateWithBag('storeItem', [
            'name' => 'required|string|max:180',
            'category' => 'nullable|string|max:120',
            'description' => 'nullable|string|max:2000',
            'price' => 'nullable|numeric|min:0|max:9999999999.99',
            'currency' => 'nullable|string|max:8',
            'purchase_url' => 'nullable|url|max:2048',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
            'image_url' => 'nullable|url|max:2048',
            'company_name' => 'nullable|string|max:180',
            'company_phone' => 'nullable|string|max:60',
            'company_email' => 'nullable|email|max:180',
            'company_location' => 'nullable|string|max:220',
            'company_website' => 'nullable|url|max:2048',
            'company_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,svg|max:4096',
            'company_logo_url' => 'nullable|url|max:2048',
            'catalog_summary' => 'nullable|string|max:1500',
            'catalog_images' => 'nullable|array|max:12',
            'catalog_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:5120',
            'catalog_image_urls' => 'nullable|string|max:12000',
        ]);

        $catalogUrlData = $this->parseCatalogUrls((string) ($data['catalog_image_urls'] ?? ''));
        if (!empty($catalogUrlData['invalid'])) {
            return back()
                ->withErrors([
                    'catalog_image_urls' => 'Hay URLs de catalogo invalidas. Verifica cada enlace en una linea separada.',
                ], 'storeItem')
                ->withInput();
        }

        $newImagePath = $storeItem->image_path;
        $newImageUrl = $storeItem->image_url;

        if ($request->hasFile('image')) {
            if (!empty($storeItem->image_path) && Storage::disk('public')->exists($storeItem->image_path)) {
                Storage::disk('public')->delete($storeItem->image_path);
            }

            $newImagePath = $request->file('image')->store('tiendas', 'public');
            $newImageUrl = null;
        } elseif (!empty(trim((string) ($data['image_url'] ?? '')))) {
            if (!empty($storeItem->image_path) && Storage::disk('public')->exists($storeItem->image_path)) {
                Storage::disk('public')->delete($storeItem->image_path);
            }

            $newImagePath = null;
            $newImageUrl = trim((string) $data['image_url']);
        }

        $newCompanyLogoPath = $storeItem->company_logo_path;
        $newCompanyLogoUrl = $storeItem->company_logo_url;
        if ($request->hasFile('company_logo')) {
            if (!empty($storeItem->company_logo_path) && Storage::disk('public')->exists($storeItem->company_logo_path)) {
                Storage::disk('public')->delete($storeItem->company_logo_path);
            }

            $newCompanyLogoPath = $request->file('company_logo')->store('tiendas/logos', 'public');
            $newCompanyLogoUrl = null;
        } elseif (!empty(trim((string) ($data['company_logo_url'] ?? '')))) {
            if (!empty($storeItem->company_logo_path) && Storage::disk('public')->exists($storeItem->company_logo_path)) {
                Storage::disk('public')->delete($storeItem->company_logo_path);
            }

            $newCompanyLogoPath = null;
            $newCompanyLogoUrl = trim((string) $data['company_logo_url']);
        }

        $catalogUploadedPaths = [];
        if ($request->hasFile('catalog_images')) {
            foreach ((array) $request->file('catalog_images') as $catalogImageFile) {
                if (!$catalogImageFile) {
                    continue;
                }

                $catalogUploadedPaths[] = $catalogImageFile->store('tiendas/catalogo', 'public');
            }
        }

        $catalogEntries = $storeItem->catalog_images;
        $rawCatalogUrls = trim((string) ($data['catalog_image_urls'] ?? ''));
        $hasCatalogPayload = !empty($catalogUploadedPaths) || $rawCatalogUrls !== '';
        if ($hasCatalogPayload) {
            $oldCatalogPaths = $this->extractLocalCatalogPaths(is_array($storeItem->catalog_images) ? $storeItem->catalog_images : []);
            foreach ($oldCatalogPaths as $oldCatalogPath) {
                if (Storage::disk('public')->exists($oldCatalogPath)) {
                    Storage::disk('public')->delete($oldCatalogPath);
                }
            }

            $catalogEntries = $this->buildCatalogEntries($catalogUploadedPaths, $catalogUrlData['valid']);
        }

        $storeItem->update([
            'name' => trim((string) $data['name']),
            'category' => !empty($data['category']) ? trim((string) $data['category']) : null,
            'description' => !empty($data['description']) ? trim((string) $data['description']) : null,
            'price' => isset($data['price']) && $data['price'] !== '' ? (float) $data['price'] : null,
            'currency' => !empty($data['currency']) ? strtoupper(trim((string) $data['currency'])) : 'COP',
            'purchase_url' => !empty($data['purchase_url']) ? trim((string) $data['purchase_url']) : null,
            'image_path' => $newImagePath,
            'image_url' => $newImageUrl,
            'company_name' => !empty($data['company_name']) ? trim((string) $data['company_name']) : null,
            'company_phone' => !empty($data['company_phone']) ? trim((string) $data['company_phone']) : null,
            'company_email' => !empty($data['company_email']) ? trim((string) $data['company_email']) : null,
            'company_location' => !empty($data['company_location']) ? trim((string) $data['company_location']) : null,
            'company_website' => !empty($data['company_website']) ? trim((string) $data['company_website']) : null,
            'company_logo_path' => $newCompanyLogoPath,
            'company_logo_url' => $newCompanyLogoUrl,
            'catalog_summary' => !empty($data['catalog_summary']) ? trim((string) $data['catalog_summary']) : null,
            'catalog_images' => !empty($catalogEntries) ? $catalogEntries : null,
        ]);

        return redirect()
            ->route('events.crear-evento-developer')
            ->with('store_success', 'Producto actualizado correctamente.');
    }

    /**
     * @return array{valid: array<int, string>, invalid: array<int, string>}
     */
    private function parseCatalogUrls(string $rawCatalogUrls): array
    {
        $valid = [];
        $invalid = [];
        $lines = preg_split('/\r\n|\r|\n/', $rawCatalogUrls) ?: [];

        foreach ($lines as $line) {
            $url = trim((string) $line);
            if ($url === '') {
                continue;
            }

            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                $invalid[] = $url;
                continue;
            }

            $valid[] = $url;
        }

        $valid = array_values(array_unique($valid));
        $invalid = array_values(array_unique($invalid));

        return [
            'valid' => $valid,
            'invalid' => $invalid,
        ];
    }

    /**
     * @param array<int, string> $uploadedPaths
     * @param array<int, string> $urls
     * @return array<int, array<string, string>>
     */
    private function buildCatalogEntries(array $uploadedPaths, array $urls): array
    {
        $entries = [];

        foreach ($uploadedPaths as $path) {
            $entries[] = [
                'type' => 'upload',
                'path' => ltrim($path, '/'),
            ];
        }

        foreach ($urls as $url) {
            $entries[] = [
                'type' => 'url',
                'url' => trim($url),
            ];
        }

        return $entries;
    }

    /**
     * @param array<int, mixed> $catalogEntries
     * @return array<int, string>
     */
    private function extractLocalCatalogPaths(array $catalogEntries): array
    {
        $paths = [];

        foreach ($catalogEntries as $entry) {
            if (is_array($entry)) {
                $entryType = (string) ($entry['type'] ?? '');
                $entryPath = trim((string) ($entry['path'] ?? ''));

                if ($entryType === 'upload' && $entryPath !== '') {
                    $paths[] = ltrim($entryPath, '/');
                }

                continue;
            }

            if (!is_string($entry)) {
                continue;
            }

            $entryValue = trim($entry);
            if ($entryValue === '' || preg_match('/^https?:\/\//i', $entryValue)) {
                continue;
            }

            $paths[] = ltrim($entryValue, '/');
        }

        return array_values(array_unique($paths));
    }
}
