<?php

namespace App\Support;

class ShopExternalCatalog
{
    /**
     * Catalogo de referencia externo para mostrar contenido inicial.
     */
    public static function items(): array
    {
        return [
            [
                'name' => 'Guayos Pro Match',
                'category' => 'Futbol',
                'description' => 'Guayos para grama natural con capellada ligera y ajuste de alto rendimiento.',
                'price' => '$349.900',
                'currency' => 'COP',
                'purchase_url' => 'https://www.nike.com/co/w/futbol-calzado-1gdj0zy7ok',
                'image_url' => 'https://images.unsplash.com/photo-1607522370275-f14206abe5d3?auto=format&fit=crop&w=1000&q=80',
                'source' => 'Catalogo externo',
            ],
            [
                'name' => 'Balon Competencia Elite',
                'category' => 'Futbol',
                'description' => 'Balon oficial con costura termica, ideal para entrenamiento y competencia.',
                'price' => '$159.900',
                'currency' => 'COP',
                'purchase_url' => 'https://www.adidas.co/futbol-balones',
                'image_url' => 'https://images.unsplash.com/photo-1614632537423-5e80c0d4334b?auto=format&fit=crop&w=1000&q=80',
                'source' => 'Catalogo externo',
            ],
            [
                'name' => 'Canilleras Shield X',
                'category' => 'Proteccion',
                'description' => 'Canilleras ergonomicas con cubierta rigida y ajuste elastico.',
                'price' => '$79.900',
                'currency' => 'COP',
                'purchase_url' => 'https://www.decathlon.com.co/2922-proteccion-futbol',
                'image_url' => 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?auto=format&fit=crop&w=1000&q=80',
                'source' => 'Catalogo externo',
            ],
            [
                'name' => 'Camiseta Training Club',
                'category' => 'Indumentaria',
                'description' => 'Camiseta de entrenamiento respirable para sesiones intensas.',
                'price' => '$119.900',
                'currency' => 'COP',
                'purchase_url' => 'https://www.puma.com/es/es/deportes/futbol',
                'image_url' => 'https://images.unsplash.com/photo-1521412644187-c49fa049e84d?auto=format&fit=crop&w=1000&q=80',
                'source' => 'Catalogo externo',
            ],
            [
                'name' => 'Guantes Arquero Grip 4',
                'category' => 'Arqueria',
                'description' => 'Guantes con palma de alto agarre para entrenamiento y partido.',
                'price' => '$139.900',
                'currency' => 'COP',
                'purchase_url' => 'https://www.umbro.com.co/futbol',
                'image_url' => 'https://images.unsplash.com/photo-1602211844066-d3bb556e983b?auto=format&fit=crop&w=1000&q=80',
                'source' => 'Catalogo externo',
            ],
            [
                'name' => 'Mochila Deportiva Team',
                'category' => 'Accesorios',
                'description' => 'Mochila con compartimiento para calzado y accesorios de entrenamiento.',
                'price' => '$99.900',
                'currency' => 'COP',
                'purchase_url' => 'https://www.decathlon.com.co/2948-bolsos-deporte',
                'image_url' => 'https://images.unsplash.com/photo-1622560480605-d83c853bc5c3?auto=format&fit=crop&w=1000&q=80',
                'source' => 'Catalogo externo',
            ],
        ];
    }
}

