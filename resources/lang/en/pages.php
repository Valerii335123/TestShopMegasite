<?php

return [
    'common' => [
        'cart_title' => 'Cart',
        'sku' => 'SKU:',
        'out_of_stock' => 'Out of Stock',
        'in_stock' => 'In Stock',
        'quantity_is_not_available' => 'Quantity is not available',
    ],
    'product' => [
        'add_to_cart' => 'Add to Cart',
        'remove_from_cart' => 'Remove from Cart',
        'empty_image' => 'Product Image',
        'description' => 'Description:',
        'index' => [
            'title' => 'Products',
            'search_placeholder' => 'Search products...',
            'sort' => [
                'select' => 'Select....',
                'name_asc' => 'Name (A-Z)',
                'name_desc' => 'Name (Z-A)',
                'price_asc' => 'Price (Low to High)',
                'price_desc' => 'Price (High to Low)',
                'stock_asc' => 'Availability asc',
                'stock_desc' => 'Availability desc',
            ],
            'no_products' => 'No products found.',
        ],
    ],
    'checkout' => [
        'header' => 'Checkout',
        'first_name' => 'First Name:',
        'last_name' => 'Last Name:',
        'email' => 'Email:',
        'phone' => 'Phone:',
        'address' => 'Address:',
        'delivery_method' => 'Delivery method:',
        'delivery_method_values' => [
            'pickup' => 'Pickup',
            'post' => 'Postal Delivery'
        ],
        'payment_method' => 'Payment method:',
        'payment_method_values' => [
            'online' => 'Online',
            'postpaid' => 'Cash on Delivery'
        ],
        'submit' => 'Submit',
        'back_to_cart' => 'Back to Cart',
    ],
    'checkout_success' => [
        'title' => 'Order Successfully Placed!',
        'content' => "Thank you for your order. We'll process it right away.",
        'button_text' => 'Continue Shopping',
    ],

    'cart' => [
        'header' => 'Shopping Cart',
        'total' => 'Total:',
        'empty_text' => 'Your cart is empty',
        'empty_link' => 'Continue Shopping',
        'button' => [
            'remove' => 'Remove',
            'checkout' => 'Proceed to Checkout',
        ]
    ]
];