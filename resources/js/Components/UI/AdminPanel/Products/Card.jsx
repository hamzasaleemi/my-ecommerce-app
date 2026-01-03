import { useState } from 'react';
import Slideshow from '@/Components/UI/Slideshow';
import { usePage, router } from '@inertiajs/react';
import { TrashIcon } from '@/Components/UI/Icon';

export default function ProductCard({ product, }) {
    const { assetUrl, settings } = usePage().props;
    const [formData, setFormData] = useState({
        quantity: product.cart_quantity > 0 ? product.cart_quantity : 1,
        product_id: product.id,
    });

    function handleAddToCart(e) {
        e.preventDefault();

        router.post('/cart/add-item', formData, {
        onSuccess: () => {
            // Reset form or redirect
        },
        onError: (errors) => {
            // Handle validation errors
            console.log(errors);
        },
        preserveScroll: true,
        });
    }

    function handleUpdateCart(e) {
        e.preventDefault();

        router.post('/cart/update-item', formData, {
        onSuccess: () => {
            // Reset form or redirect
        },
        onError: (errors) => {
            // Handle validation errors
            console.log(errors);
        },
        preserveScroll: true,
        });
    }

    function handleRemoveFromCart(e) {
        e.preventDefault();

        router.post('/cart/remove-item', { product_id: product.id }, {
        onSuccess: () => {
            // Reset form or redirect
            setFormData({ ...formData, quantity: 1 });
        },
        onError: (errors) => {
            // Handle validation errors
            console.log(errors);
        },
        preserveScroll: true,
        });
    }

    return (
        <div className="border p-4 rounded-lg">
            {product.product_images.length > 0
                ?
                    <Slideshow images={product.product_images} />
                :
                    <div className="relative w-full max-w-lg mx-auto">
                        <div className="overflow-hidden rounded-lg">
                            <img
                                src={assetUrl + 'images/no-image-available.jpg'}
                                className="w-full h-64 object-cover"
                            />
                        </div>
                    </div>
            }

            <h3 className="text-lg font-semibold mt-4">{product.name}</h3>
            <p className="text-gray-600 mt-2">{product.description}</p>
            <p className="text-gray-800 font-bold mt-2">${product.price}</p>
            <p className={`mt-1 ${product.stock_quantity <= settings.low_stock_threshold ? 'text-red-600 font-bold' : 'text-gray-600'}`}>Stock: {product.stock_quantity}</p>
            <div className="mt-4 flex items-center">
                <input
                    type="number"
                    min="1"
                    value={formData.quantity}
                    onChange={e => setFormData({ ...formData, quantity: e.target.value })}
                    className="w-16 border rounded-lg p-2 mr-4"
                />
                <button className="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600" onClick={product.cart_quantity > 0 ? handleUpdateCart : handleAddToCart}>
                    {product.cart_quantity > 0 ? 'Update' : 'Add to Cart'}
                </button>
                {product.cart_quantity > 0 &&
                    <button className="ml-2 bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600" onClick={handleRemoveFromCart}>
                        <TrashIcon />
                    </button>
                }
            </div>
        </div>
    );
}
