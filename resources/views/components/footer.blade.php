<footer class="footer-premium mt-5">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="footer-brand-wrap">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo Edwin Sport" width="48" height="48">
                        <h4 class="mb-0">Edwin Sport</h4>
                    </div>
                    <p class="mb-3">Plataforma para gestionar eventos, reservas, competiciones y experiencia deportiva con estandares profesionales.</p>
                    <div class="social-row d-flex gap-2">
                        <a href="https://www.facebook.com/" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="https://www.instagram.com/" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="https://x.com/" aria-label="X"><i class="bi bi-twitter-x"></i></a>
                        <a href="https://www.youtube.com/" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-2">
                <h5>Navegacion</h5>
                <ul class="footer-links">
                    <li><a href="{{ route('principal') }}">Inicio</a></li>
                    <li><a href="{{ route('about') }}">Acerca de</a></li>
                    <li><a href="{{ route('events.index') }}">Eventos</a></li>
                    <li><a href="{{ route('canchas.index') }}">Canchas</a></li>
                    <li><a href="{{ route('contactenos') }}">Contacto</a></li>
                </ul>
            </div>

            <div class="col-6 col-lg-3">
                <h5>Soluciones</h5>
                <ul class="footer-links">
                    <li><a href="{{ route('events.index') }}">Organizacion de torneos</a></li>
                    <li><a href="{{ route('canchas.index') }}">Reservas inteligentes</a></li>
                    <li><a href="{{ route('tournament.form') }}">Sorteos y fixture</a></li>
                    <li><a href="{{ route('participantes.index') }}">Participantes</a></li>
                </ul>
            </div>

            <div class="col-lg-3">
                <h5>Contacto</h5>
                <ul class="footer-contact list-unstyled mb-3">
                    <li><i class="bi bi-geo-alt"></i> Medellin, Colombia</li>
                    <li><i class="bi bi-envelope"></i> contacto@edwinsport.com</li>
                    <li><i class="bi bi-telephone"></i> +57 300 000 0000</li>
                </ul>
                <a href="{{ route('contactenos') }}" class="btn btn-footer">Hablar con nosotros</a>
            </div>
        </div>

        <div class="footer-bottom mt-4 pt-3 d-flex flex-column flex-md-row justify-content-between gap-2">
            <p class="mb-0">&copy; {{ date('Y') }} Edwin Sport. Todos los derechos reservados.</p>
            <div class="footer-mini-links d-flex gap-3">
                <a href="{{ route('about.mision') }}">Mision</a>
                <a href="{{ route('about.vision') }}">Vision</a>
                <a href="{{ route('about.valores') }}">Valores</a>
            </div>
        </div>
    </div>
</footer>
