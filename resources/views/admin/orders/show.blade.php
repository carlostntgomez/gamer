<x-layouts.app>
    <div class="container my-5">
        <h1>Detalles del Pedido #{{ $order->id }}</h1>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Historial de Estados</div>
                    <div class="card-body">
                        <div class="timeline-area">
                            @foreach($order->statusHistories as $history)
                            <div class="timeline-item">
                                <div class="timeline-icon"></div>
                                <div class="timeline-content">
                                    <h5 class="timeline-title">{{ $history->status }}</h5>
                                    <p class="timeline-text">{{ $history->notes }}</p>
                                    <span class="timeline-date">{{ $history->created_at->format('d/m/Y h:i A') }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">Actualizar Estado del Pedido</div>
                    <div class="card-body">
                        <form action="{{ route('orders.status.store', $order) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="status" class="form-label">Nuevo Estado</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="En Preparación">En Preparación</option>
                                    <option value="Enviado">Enviado</option>
                                    <option value="En Tránsito">En Tránsito</option>
                                    <option value="Entregado">Entregado</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="notes" class="form-label">Notas (opcional)</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Añadir al Historial</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Detalles del Cliente</div>
                    <div class="card-body">
                        <p><strong>Nombre:</strong> {{ $order->billingAddress->first_name }} {{ $order->billingAddress->last_name }}</p>
                        <p><strong>Email:</strong> {{ $order->billingAddress->email }}</p>
                        <p><strong>Teléfono:</strong> {{ $order->billingAddress->phone }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
