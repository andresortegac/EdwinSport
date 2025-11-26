<!-- Modal -->
    <div class="modal fade" id="passwordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Ingrese contraseña</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="passwordForm">
                    <div class="modal-body">

                        <label class="form-label">Contraseña</label>
                        <input type="password" id="passwordInput" class="form-control" required>

                        <small id="errorMsg" class="text-danger d-none mt-2">
                            Contraseña incorrecta
                        </small>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Entrar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>