<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\ShippingZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        $subtotal = array_reduce($cart, fn ($carry, $item) => $carry + $item['price'] * $item['quantity'], 0);

        $shippingZones = ShippingZone::orderBy('municipality')->orderBy('neighborhood')->get();
        $municipalities = $shippingZones->unique('municipality')->sortBy('municipality')->values();

        $shippingCost = 0;
        $total = $subtotal + $shippingCost;

        return view('pages.checkout.index', [
            'cart' => $cart,
            'cartCount' => count($cart),
            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'total' => $total,
            'shippingZones' => $shippingZones,
            'municipalities' => $municipalities,
            'shippingDetails' => [],
        ]);
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        Log::debug('Cart content at start of store method:', ['cart' => $cart]); // Debug Point 1
        if (empty($cart)) {
            return response()->json(['message' => 'Tu carrito está vacío.'], 400);
        }

        $validatedData = $request->validate([
            'f-name' => 'required|string|max:255',
            'l-name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'apartment' => 'nullable|string|max:255',
            'city' => 'required|string|exists:shipping_zones,municipality',
            'neighborhood' => 'required|string',
            'state' => 'required|string|max:255',
            'mail' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'ship_to_different_address' => 'nullable|boolean',
            'shipping_f-name' => 'required_if:ship_to_different_address,1|nullable|string|max:255',
            'shipping_l-name' => 'required_if:ship_to_different_address,1|nullable|string|max:255',
            'shipping_address' => 'required_if:ship_to_different_address,1|nullable|string|max:255',
            'shipping_city' => 'required_if:ship_to_different_address,1|nullable|string|exists:shipping_zones,municipality',
            'shipping_neighborhood' => 'required_if:ship_to_different_address,1|nullable|string',
            'shipping_state' => 'required_if:ship_to_different_address,1|nullable|string',
            'notes' => 'nullable|string',
            'payment_method' => 'required|string',
            'terms_and_conditions' => 'accepted',
            'submit_type' => 'required|string|in:direct,whatsapp',
        ], [
            'terms_and_conditions.accepted' => 'Debes aceptar los términos y condiciones para continuar.'
        ]);

        try {
            // Recalculate subtotal on the server-side to be safe
            $subtotal = 0;
            foreach ($cart as $id => $details) {
                $product = Product::find($id);
                if ($product) {
                    $price = $product->sale_price ?? $product->price;
                    $subtotal += $price * $details['quantity'];
                }
            }
            Log::debug('Calculated subtotal:', ['subtotal' => $subtotal]); // Debug Point 2
            
            $shipping_city = !empty($validatedData['ship_to_different_address']) ? $validatedData['shipping_city'] : $validatedData['city'];
            $shipping_neighborhood = !empty($validatedData['ship_to_different_address']) ? $validatedData['shipping_neighborhood'] : $validatedData['neighborhood'];

            $zone = ShippingZone::where('municipality', $shipping_city)->where('neighborhood', $shipping_neighborhood)->first();
            
            // SOLUCIÓN #3: Validar que la zona de envío existe
            if (!$zone) {
                throw ValidationException::withMessages([
                    'neighborhood' => 'El barrio no es válido para el municipio seleccionado. Por favor, revísalo.'
                ]);
            }
            $shippingCost = $zone->price;
            Log::debug('Calculated shipping cost:', ['shippingCost' => $shippingCost, 'zone_found' => $zone->toArray()]); // Debug Point 3

            $total = $subtotal + $shippingCost;
            Log::debug('Final total before transaction:', ['subtotal' => $subtotal, 'shippingCost' => $shippingCost, 'total' => $total]); // Debug Point 4

            $order = DB::transaction(function () use ($validatedData, $cart, $subtotal, $shippingCost, $total) {
                // 1. Create the Order
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'subtotal' => $subtotal,
                    'shipping_cost' => $shippingCost,
                    'total' => $total,
                    'payment_method' => $validatedData['payment_method'],
                    'notes' => $validatedData['notes'] ?? null,
                ]);

                Log::debug('Order total AFTER creation in transaction:', ['order_id' => $order->id, 'order_uuid' => $order->uuid, 'total_from_db' => $order->total]); // <-- NUEVA LÍNEA DE DEBUG

                // 2. Create the Billing Address
                $order->billingAddress()->create([
                    'first_name' => $validatedData['f-name'], 'last_name' => $validatedData['l-name'],
                    'address' => $validatedData['address'], 'apartment' => $validatedData['apartment'] ?? null,
                    'city' => $validatedData['city'], 'state' => 'Colombia',
                    'country' => 'Colombia', 'neighborhood' => $validatedData['neighborhood'],
                    'email' => $validatedData['mail'], 'phone' => $validatedData['phone'],
                ]);

                // 3. Create the Shipping Address
                if (!empty($validatedData['ship_to_different_address'])) {
                    $order->shippingAddress()->create([
                        'first_name' => $validatedData['shipping_f-name'], 'last_name' => $validatedData['shipping_l-name'],
                        'address' => $validatedData['shipping_address'], 'city' => $validatedData['shipping_city'],
                        'state' => 'Colombia', 'country' => 'Colombia',
                        'neighborhood' => $validatedData['shipping_neighborhood'],
                    ]);
                } else {
                     $order->shippingAddress()->create([
                        'first_name' => $validatedData['f-name'], 'last_name' => $validatedData['l-name'],
                        'address' => $validatedData['address'], 'city' => $validatedData['city'],
                        'state' => 'Colombia', 'country' => 'Colombia',
                        'neighborhood' => $validatedData['neighborhood'],
                    ]);
                }

                // 4. Create Order Items & SOLUCIONES #1 y #2
                foreach ($cart as $id => $details) {
                    $product = Product::lockForUpdate()->find($id); // Bloquear el producto para evitar race conditions

                    if (!$product || $product->stock_quantity < $details['quantity']) {
                        throw new \Exception("Stock insuficiente para el producto: " . ($product->name ?? $details['name']));
                    }

                    // SOLUCIÓN #1: Decrementar el stock
                    $product->decrement('stock_quantity', $details['quantity']);

                    // SOLUCIÓN #2: Usar el precio y nombre actuales de la base de datos
                    $order->orderItems()->create([
                        'product_id' => $id,
                        'name' => $product->name, 
                        'price' => $product->sale_price ?? $product->price,
                        'quantity' => $details['quantity'],
                    ]);
                }

                // 5. Create the initial status history
                $order->statusHistories()->create([
                    'status' => OrderStatus::Pending,
                    'notes' => 'Pedido creado por el cliente.',
                ]);

                return $order;
            });

            if (!$order) {
                Log::error('Error en Checkout: La transacción de la base de datos falló y el pedido no se creó.', ['request_data' => $validatedData]);
                return response()->json(['message' => 'No se pudo procesar tu pedido. Por favor, intenta de nuevo.'], 500);
            }

            session()->forget('cart');

            if ($validatedData['submit_type'] === 'whatsapp') {
                $whatsappUrl = $this->generateWhatsAppUrl($order, $validatedData, $cart, $subtotal, $shippingCost, $total);
                return response()->json([
                    'status' => 'success',
                    'type' => 'whatsapp',
                    'whatsapp_url' => $whatsappUrl,
                ]);
            } 
            
            return response()->json([
                'status' => 'success',
                'type' => 'direct',
                'redirect_url' => route('order-complete.index', ['order' => $order->uuid]), // MODIFICADO: Usar uuid en lugar de id
            ]);

        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error en Checkout: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return response()->json(['message' => 'Error del servidor: ' . $e->getMessage()], 500);
        }
    }

    private function generateWhatsAppUrl(Order $order, array $data, array $cart, float $subtotal, float $shippingCost, float $total): string
    {
        $storeWhatsappNumber = Setting::where('key', 'phone')->first()->value ?? null;
        if (!$storeWhatsappNumber) {
            return '';
        }
        
        // Corrected line: Removed incorrect backslashes from the regex pattern
        $cleanedPhoneNumber = preg_replace('/[^0-9]/', '', $storeWhatsappNumber);

        $paymentEnum = PaymentMethod::tryFrom($data['payment_method']);
        $paymentText = $paymentEnum ? $paymentEnum->getLabel() : 'No especificado';

        $message  = "*¡Hola, TecnnyGames!* 👋\n\n";
        $message .= "Acabo de realizar un pedido en su sitio web y me gustaría confirmarlo.\n\n";
        $message .= "*Número de Pedido:* `" . $order->uuid . "`\n\n"; // MODIFICADO: Usar uuid en lugar de id
        $message .= "➖➖➖➖➖➖➖➖➖➖➖➖\n\n";
        $message .= "*👤 DATOS DEL CLIENTE:*\n";
        $message .= "- *Nombre:* " . $data['f-name'] . " " . $data['l-name'] . "\n";
        $message .= "- *Celular:* " . $data['phone'] . "\n";
        $message .= "- *Email:* " . $data['mail'] . "\n\n";

        $message .= "*🚚 DIRECCIÓN DE FACTURACIÓN:*\n";
        $billing_address = $data['address'];
        if (!empty($data['apartment'])) {
            $billing_address .= ", " . $data['apartment'];
        }
        $billing_address .= "\n" . $data['neighborhood'] . ", " . $data['city'] . "\n" . $data['state'] . ", Colombia";
        $message .= $billing_address . "\n\n";

        if (!empty($data['ship_to_different_address'])) {
            $message .= "*📦 DIRECCIÓN DE ENVÍO:*\n";
            $shipping_address = "*Recibe:* " . $data['shipping_f-name'] . " " . $data['shipping_l-name'] . "\n";
            $shipping_address .= $data['shipping_address'] . "\n";
            $shipping_address .= $data['shipping_neighborhood'] . ", " . $data['shipping_city'] . "\n" . $data['shipping_state'] . ", Colombia";
            $message .= $shipping_address . "\n\n";
        }

        $message .= "➖➖➖➖➖➖➖➖➖➖➖➖\n\n";
        $message .= "*🛒 RESUMEN DE LA COMPRA:*\n";
        // Usamos los datos del pedido recién creado para el mensaje de WhatsApp para máxima consistencia
        foreach ($order->orderItems as $item) {
            $item_total = number_format($item->price * $item->quantity, 0, ',', '.');
            $message .= "- " . $item->quantity . "x " . $item->name . " (*$" . $item_total . "*)\n";
        }
        $message .= "\n";
        
        $subtotalF = number_format($order->subtotal, 0, ',', '.');
        $shipping_costF = number_format($order->shipping_cost, 0, ',', '.');
        $totalF = number_format($order->total, 0, ',', '.');

        $message .= "- *Subtotal:* $" . $subtotalF . "\n";
        $message .= "- *Costo de Envío:* $" . $shipping_costF . "\n";
        $message .= "- *TOTAL A PAGAR:* *$" . $totalF . "*\n\n";

        $message .= "➖➖➖➖➖➖➖➖➖➖➖➖\n\n";
        $message .= "*💳 MÉTODO DE PAGO:*\n" . $paymentText . "\n\n";

        if (!empty($data['notes'])) {
            $message .= "*📝 NOTAS ADICIONALES:*\n" . $data['notes'] . "\n\n";
        }

        $message .= "¡Muchas gracias! Quedo atento a las instrucciones para completar el pago.";

        return 'https://wa.me/' . $cleanedPhoneNumber . '?text=' . urlencode($message);
    }
}