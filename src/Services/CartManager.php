<?php

namespace Taskinbirtan\EcommerceCart\Services;

use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Event;
use Taskinbirtan\EcommerceCart\Contracts\CartInterface;
use Taskinbirtan\EcommerceCart\Contracts\ProductResolverInterface;
use Illuminate\Support\Str;
use Taskinbirtan\EcommerceCart\Events\CartCleared;
use Taskinbirtan\EcommerceCart\Events\ItemAdded;
use Taskinbirtan\EcommerceCart\Events\ItemRemoved;
use Taskinbirtan\EcommerceCart\Events\ItemUpdated;
use Taskinbirtan\EcommerceCart\Models\CartItem;

class CartManager implements CartInterface
{
    protected string $cartId;
    protected ProductResolverInterface $resolver;
    protected SessionManager $session;

    public function __construct(
        SessionManager $session,
        ProductResolverInterface $resolver
    ) {
        $this->session = $session;
        $this->resolver = $resolver;

        $this->cartId = $session->get('cart_id', (string) Str::uuid());
        $session->put('cart_id', $this->cartId);
    }

    public function addItem(string $itemId, int $quantity = 1, array $options = []): void
    {
        $payload = $this->resolver->resolve($itemId);

        $item = CartItem::firstOrNew([
            'cart_id' => $this->cartId,
            'item_id' => $payload->getId(),
        ]);

        $item->quantity   = $item->exists ? $item->quantity + $quantity : $quantity;
        $item->unit_price = $payload->getUnitPrice();
        $item->options    = $payload->getMeta();
        $item->save();

        Event::dispatch(new ItemAdded($item));
    }

    public function removeItem(string $itemId): void
    {
        $deleted = CartItem::where('cart_id', $this->cartId)
            ->where('item_id', $itemId)
            ->delete();

        if ($deleted) {
            Event::dispatch(new ItemRemoved());
        }
    }

    public function updateQuantity(string $itemId, int $quantity): void
    {
        $item = CartItem::where('cart_id', $this->cartId)
            ->where('item_id', $itemId)
            ->first();

        if (! $item) {
            return;
        }

        if ($quantity <= 0) {
            $item->delete();
            Event::dispatch(new ItemRemoved());
        } else {
            $item->quantity = $quantity;
            $item->save();
            Event::dispatch(new ItemUpdated($item));
        }
    }

    public function clear(): void
    {
        CartItem::where('cart_id', $this->cartId)->delete();
        Event::dispatch(new CartCleared());
    }

    public function items(): array
    {
        // veritabanından tüm öğeleri model dizisi olarak çekip diziye çeviriyoruz
        return CartItem::where('cart_id', $this->cartId)
            ->get()
            ->toArray();
    }

    public function total(): float
    {
        // items() dizisini dolaşıp unit_price * quantity toplamı
        return array_reduce(
            $this->items(),
            fn($sum, $item) => $sum + ($item['unit_price'] * $item['quantity']),
            0.0
        );
    }
}