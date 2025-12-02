<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\Contactenos;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {

            // ⛔ Evita error "Unknown column 'leido'"
            if (!Schema::hasColumn('contactenos', 'leido')) {
                $view->with([
                    'notificaciones' => collect([]),
                    'notificacionesCount' => 0,
                ]);
                return;
            }

            // ✔ Obtener notificaciones NO leídas
            $notificaciones = Contactenos::where('leido', false)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get()
                ->map(function ($n) {
                    return [
                        'texto' => $n->evento_nombre ?? 'Nuevo mensaje recibido',
                        'fecha' => $n->created_at->format('Y-m-d H:i'),
                        'icon'  => 'fas fa-envelope',
                        'url'   => route('contactos.show', $n->id),
                    ];
                });

            // ✔ Compartir con todas las vistas
            $view->with([
                'notificaciones'      => $notificaciones,
                'notificacionesCount' => $notificaciones->count(),
            ]);
        });
    }
}
