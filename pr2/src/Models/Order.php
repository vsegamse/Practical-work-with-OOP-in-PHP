<?php
declare(strict_types=1);

namespace Shop\Models;

class Order
{
    public function __construct(
        public Customer $customer,
        public float $total,
    ) {
    }
}
