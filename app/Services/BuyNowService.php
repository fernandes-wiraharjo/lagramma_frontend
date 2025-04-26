<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class BuyNowService
{
    protected $sessionKey = 'buy_now';

    public function get()
    {
        return Session::get($this->sessionKey, []);
    }

    public function save($data)
    {
        Session::put($this->sessionKey, $data);
    }

    public function clear()
    {
        Session::forget($this->sessionKey);
    }

    public function addItem(array $item)
    {
        $data = $this->get();

        if ($item['type'] === 'hampers') {
            $key = $this->generateHampersKey($item);
        } else {
            $key = $this->generateKey($item);
        }

        $data[$key] = $item;
        $data[$key]['total_price'] = $data[$key]['quantity'] * ($data[$key]['price'] + collect($data[$key]['modifiers'])->sum('price'));

        $this->save($data);
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
