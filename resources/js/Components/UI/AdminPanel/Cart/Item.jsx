import { usePage, router } from '@inertiajs/react';
import { useState } from 'react';
import { formatNumber, formatCurrency } from '@/utils/formatter';
import { useCartItem } from '@/hooks/useCartItem';

export default function CartItem({ cartItem, addOrderForm }) {
    const { assetUrl, appUrl, storageUrl } = usePage().props;
    const [quantity, setQuantity] = useState(cartItem.quantity);
    const { updateCartItemForm, updateCartItem, destroyCartItemForm, destroyCartItem } = useCartItem(cartItem.product.id, quantity);

    function handleUpdateCart(e) {
        e.preventDefault();
        updateCartItem(cartItem.id);
        addOrderForm.setData('order_items', addOrderForm.data.order_items.map(item => {
            if (item.product_id === cartItem.product.id) {
                return {
                    ...item,
                    quantity: quantity,
                };
            }
            return item;
        }));
    }

    function handleRemoveFromCart(e) {
        e.preventDefault();
        destroyCartItem(cartItem.id);
        addOrderForm.setData('order_items', addOrderForm.data.order_items.filter(item => item.product_id !== cartItem.product.id));
    }

    return (
        <div className="border-b border-gray-200 py-4 flex items-center">
            {cartItem.product.product_images.length > 0 ? (
                <img
                    src={appUrl + storageUrl + cartItem.product.product_images[0].image_path}
                    alt={cartItem.product.name}
                    className="w-16 h-16 object-cover rounded mr-4"
                />
            ) : (
                <img
                    src={assetUrl + 'images/no-image-available.jpg'}
                    alt={cartItem.product.name}
                    className="w-16 h-16 object-cover rounded mr-4"
                />
            )}
            <div className="flex-1">
                <h3 className="text-lg font-semibold">{cartItem.product.name}</h3>
                <p className="text-gray-600">Price: {formatCurrency(cartItem.product.price)}</p>
                <p className="text-gray-600">Quantity: {formatNumber(cartItem.quantity)}</p>
                <p className="text-gray-800 font-bold">Total: {formatCurrency(cartItem.product.price * cartItem.quantity)}</p>
            </div>

            {updateCartItemForm.hasErrors && (
                <div className="text-red-600 mr-4">
                    {updateCartItemForm.errors.quantity}
                </div>
            )}

            <div>
                <input
                    type="number"
                    min="1"
                    value={quantity}
                    onChange={(e) => {  setQuantity(e.target.value); updateCartItemForm.setData('quantity', e.target.value); }}
                    className="border rounded w-20 px-2 py-1 mr-4"
                />
            </div>
            <div>
                <button
                    onClick={handleUpdateCart}
                    disabled={updateCartItemForm.processing}
                    className="bg-blue-600 text-white px-4 py-2 rounded mr-2 hover:bg-blue-700"
                >
                    Update
                </button>
                <button
                    onClick={handleRemoveFromCart}
                    disabled={destroyCartItemForm.processing}
                    className="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700"
                >
                    Remove
                </button>
            </div>
        </div>
    );
}
