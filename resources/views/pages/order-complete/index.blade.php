<x-layouts.app>
    <!-- breadcrumb start -->
    <section class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-index">
                        <ul class="breadcrumb-ul">
                            <li class="breadcrumb-li">
                                <a class="breadcrumb-link" href="{{ route('home') }}">Inicio</a>
                            </li>
                            <li class="breadcrumb-li">
                                <span class="breadcrumb-text">Seguimiento de Pedido</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb end -->

    <!-- order-complete with tracking start -->
    <section class="order-complete section-ptb">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="order-area">
                        <!-- order-price start -->
                        <div class="order-price">
                            <ul class="total-order" data-animate="animate__fadeInUp">
                                <li>
                                    <span class="order-no">Pedido N.º {{ $order->uuid }}</span>
                                    <span class="order-date">{{ $order->created_at->format('d/m/Y h:i A') }}</span>
                                </li>
                                <li>
                                    <span class="total-price">Total del Pedido</span>
                                    <span class="amount">${{ number_format($order->total, 2, ',', '.') }}</span>
                                </li>
                            </ul>
                        </div>
                        <!-- order-price end -->

                        <!-- order-details: thank you message -->
                        <div class="order-details">
                            <span class="text-success order-i" data-animate="animate__fadeInUp"><i class="fa fa-check-circle"></i></span>
                            <h6 data-animate="animate__fadeInUp">¡Gracias por tu pedido!</h6>
                            <span class="order-s" data-animate="animate__fadeInUp">
                                Tu pedido ha sido recibido y está actualmente en estado **{{ $order->payment_method->getLabel() ?? 'N/A' }}**.
                                Pronto nos pondremos en contacto para finalizar tu compra.
                            </span>

                            @php
                                $storeWhatsappNumber = App\Models\Setting::where('key', 'phone')->first()->value ?? null;
                                $cleanedPhoneNumber = $storeWhatsappNumber ? preg_replace('/[^0-9]/', '', $storeWhatsappNumber) : null;
                                $paymentMethod = $order->payment_method->value;

                                // Generar el mensaje base de WhatsApp
                                $whatsappMessage  = "¡Hola, TecnnyGames! 👋\n\n";
                                $whatsappMessage .= "Acabo de realizar un pedido en su sitio web y me gustaría confirmarlo.\n\n";
                                $whatsappMessage .= "Número de Pedido: `" . $order->uuid . "`\n";
                                $whatsappMessage .= "Total del Pedido: $" . number_format($order->total, 2, ',', '.') . "\n";
                                $whatsappMessage .= "Método de Pago: " . ($order->payment_method->getLabel() ?? 'N/A') . "\n\n";
                                $whatsappMessage .= "¡Muchas gracias! Quedo atento a las instrucciones para completar el pago.";

                                $encodedWhatsappMessage = urlencode($whatsappMessage);
                                $whatsappUrl = $cleanedPhoneNumber ? 'https://wa.me/' . $cleanedPhoneNumber . '?text=' . $encodedWhatsappMessage : null;
                            @endphp

                        </div>
                        <!-- order-details end -->

                        <!-- tracking start -->
                        <section class="track-block">
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <div class="track-area">
                                            <div class="track-price">
                                                <ul class="track-order" data-animate="animate__fadeInUp">
                                                    <li  class="track-li">
                                                        <h6>Tu ID de pedido es: {{ $order->uuid }}</h6>
                                                    </li>
                                                    <li  class="track-li">
                                                        <span class="track-status">Estado Actual:</span>
                                                        @php
                                                            $currentRawStatusValue = $order->statusHistories->first()?->status?->value ?? 'pending';
                                                        @endphp
                                                        <span class="text-capitalize">{{ App\Enums\OrderStatus::tryFrom($currentRawStatusValue)?->getLabel() ?? 'N/A' }}</span>
                                                    </li>
                                                    @if($order->statusHistories->first()?->notes)
                                                    <li class="track-li">
                                                        <span class="track-status">Notas:</span>
                                                        <span>{{ $order->statusHistories->first()->notes }}</span>
                                                    </li>
                                                    @endif
                                                </ul>
                                            </div>
                                            <div class="track-info" data-animate="animate__fadeInUp">
                                                <div class="track-content">
                                                    @php
                                                        $allStatusesForTracking = [
                                                            'pending' => ['label' => 'Pedido confirmado', 'icon' => 'fa fa-check'],
                                                            'processing' => ['label' => 'En preparación', 'icon' => 'fa fa-box-open'],
                                                            'shipped' => ['label' => 'Enviado y en camino', 'icon' => 'fa fa-truck'],
                                                            'delivered' => ['label' => 'Entregado', 'icon' => 'fa fa-archive'],
                                                            // 'cancelled' no se incluiría en el flujo de seguimiento visual si es un estado final negativo
                                                        ];

                                                        $currentStatusIndex = -1;
                                                        $allStatusesKeys = array_keys($allStatusesForTracking);
                                                        foreach ($allStatusesKeys as $index => $key) {
                                                            if ($key === $currentRawStatusValue) {
                                                                $currentStatusIndex = $index;
                                                                break;
                                                            }
                                                        }
                                                    @endphp

                                                    @foreach($allStatusesForTracking as $rawStatus => $statusData)
                                                        <div class="track-wrap {{ $loop->index <= $currentStatusIndex ? 'active' : '' }}">
                                                            <span class="track-icon"><i class="{{ $statusData['icon'] }}"></i></span>
                                                            <span class="track-text">{{ $statusData['label'] }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- tracking end -->

                        <!-- order-delivery start -->
                        <div class="order-delivery">
                            <ul class="delivery-payment">
                                <li class="delivery" data-animate="animate__fadeInUp">
                                    <h6>Dirección de Facturación</h6>
                                    <p>{{ $order->billingAddress->first_name ?? '' }} {{ $order->billingAddress->last_name ?? '' }}</p>
                                    <span class="order-span">{{ $order->billingAddress->address ?? '' }}</span>
                                    <span class="order-span">{{ $order->billingAddress->city ?? '' }}, {{ $order->billingAddress->state ?? '' }} {{ $order->billingAddress->zip_code ?? '' }}</span>
                                    <span class="order-span">{{ $order->billingAddress->country ?? '' }}</span>
                                    <span class="order-span">Teléfono: {{ $order->billingAddress->phone ?? '' }}</span>
                                </li>
                                @if($order->shippingAddress)
                                <li class="delivery" data-animate="animate__fadeInUp">
                                    <h6>Dirección de Envío</h6>
                                    <p>{{ $order->shippingAddress->first_name ?? '' }} {{ $order->shippingAddress->last_name ?? '' }}</p>
                                    <span class="order-span">{{ $order->shippingAddress->address ?? '' }}</span>
                                    <span class="order-span">{{ $order->shippingAddress->city ?? '' }}, {{ $order->shippingAddress->state ?? '' }} {{ $order->shippingAddress->zip_code ?? '' }}</span>
                                    <span class="order-span">{{ $order->shippingAddress->country ?? '' }}</span>
                                    <span class="order-span">Teléfono: {{ $order->shippingAddress->phone ?? '' }}</span>
                                </li>
                                @endif
                                <li class="pay" data-animate="animate__fadeInUp">
                                    <h6>Resumen del Pago</h6>
                                    <p class="transition">Método de pago: <span class="text-capitalize">{{ $order->payment_method->getLabel() ?? 'N/A' }}</span></p>
                                    @foreach($order->orderItems as $item)
                                    <span class="order-span p-label">
                                        <span class="n-price">
                                            @if($item->product && $item->product->slug)
                                                <a href="{{ route('shop.show', ['product' => $item->product->slug]) }}">{{ $item->name }}</a>
                                            @else
                                                {{ $item->name }}
                                            @endif
                                            (x{{ $item->quantity }})
                                        </span>
                                        <span class="o-price">${{ number_format($item->price * $item->quantity, 2, ',', '.') }}</span>
                                    </span>
                                    @endforeach
                                    <span class="order-span p-label">
                                        <span class="n-price">Envío</span>
                                        <span class="o-price">${{ number_format($order->shipping_cost, 2, ',', '.') }}</span>
                                    </span>
                                    <span class="order-span p-label">
                                        <span class="n-price">Total del Pedido</span>
                                        <span class="o-price"><b>${{ number_format($order->total, 2, ',', '.') }}</b></span>
                                    </span>
                                </li>
                            </ul>
                        </div>
                        <!-- order-delivery end -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- order-complete with tracking end -->
</x-layouts.app>