<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;

class CartService
{
    protected $sessionKey = 'shopping_cart';

    public function getCart()
    {
        return Session::get($this->sessionKey, []);
    }

    public function saveCart($cart)
    {
        Session::put($this->sessionKey, $cart);
    }

    public function clearCart()
    {
        Session::forget($this->sessionKey);
    }

    public function addItem(array $item)
    {
        $cart = $this->getCart();

        if ($item['type'] === 'hampers') {
            $key = $this->generateHampersKey($item);
        } else {
            $key = $this->generateKey($item);
        }

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $item['quantity'];
        } else {
            $cart[$key] = $item;
        }

        $cart[$key]['total_price'] = $cart[$key]['quantity'] * ($cart[$key]['price'] + collect($cart[$key]['modifiers'])->sum('price'));

        $this->saveCart($cart);
    }

    public function updateItemQuantity($key, $quantity)
    {
        $cart = $this->getCart();

        if (isset($cart[$key])) {
            if ($quantity < 1) {
                unset($cart[$key]);
            } else {
                $cart[$key]['quantity'] = $quantity;
                $cart[$key]['total_price'] = $quantity * ($cart[$key]['price'] + collect($cart[$key]['modifiers'])->sum('price'));
            }
        }

        $this->saveCart($cart);
    }

    public function removeItem($key)
    {
        $cart = $this->getCart();

        unset($cart[$key]);

        $this->saveCart($cart);
    }

    protected function generateKey($item)
    {
        $modifiers = $item['modifiers'];
        $modifierKeyPart = "";
        if (!empty($modifiers)) {
            // Sort modifiers to make consistent key
            usort($modifiers, function ($a, $b) {
                return $a['modifier_option_id'] <=> $b['modifier_option_id'];
            });

            $modifierKeyPart = "_" . md5(collect($modifiers)->pluck('modifier_option_id')->implode('-'));
        }

        return 'product_' . $item['product_id'] . '_' . $item['product_variant_id'] . $modifierKeyPart;
    }

    protected function generateHampersKey($item)
    {
        $baseKey = 'product_' . $item['product_id'] . '_' . $item['product_variant_id'];

        if (!empty($item['items'])) {
            // Sort for consistent hashing
            $sortedItems = collect($item['items'])->sortBy('name')->sortBy('quantity')->values()->all();
            $hash = md5(json_encode($sortedItems));
            return $baseKey . '_' . $hash;
        }

        return $baseKey . '_' . uniqid(); // fallback
    }
}
