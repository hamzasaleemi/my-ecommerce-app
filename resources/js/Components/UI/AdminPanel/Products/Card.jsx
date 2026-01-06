import { useState } from 'react';
import Slideshow from '@/Components/UI/Slideshow';
import { usePage } from '@inertiajs/react';
import { TrashIcon } from '@/Components/UI/Icon';
import { formatCurrency, formatNumber } from '@/utils/formatter';
import { useCartItem } from '@/hooks/useCartItem';

export default function ProductCard({ product }) {
    const { assetUrl, settings } = usePage().props;
    const [ quantity, setQuantity ] = useState(product.cart_items.length > 0 ? product.cart_items[0].quantity : 1);
    const {
        addCartItemForm,
        addCartItem,
        updateCartItemForm,
        updateCartItem,
        destroyCartItemForm,
        destroyCartItem
    } = useCartItem(product.id, quantity);

    const handleAddToCart = (e) => {
        e.preventDefault();
        addCartItem();
        updateCartItemForm.setData('quantity', quantity);
    };

    function handleUpdateCart(e) {
        e.preventDefault();
        updateCartItem(product.cart_items.length > 0 ? product.cart_items[0].id : null);
    }

    function handleRemoveFromCart(e) {
        e.preventDefault();
        destroyCartItem(product.cart_items.length > 0 ? product.cart_items[0].id : null);
        setQuantity(1);
        addCartItemForm.setData('quantity', 1);
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
            <p className="text-gray-800 font-bold mt-2">{formatCurrency(product.price)}</p>
            <p className={`mt-1 ${product.stock_quantity <= settings.low_stock_threshold ? 'text-red-600 font-bold' : 'text-gray-600'}`}>{product.stock_quantity === 0 ? 'Out of Stock' : `Stock: ${formatNumber(product.stock_quantity)}`}</p>
            {product.stock_quantity > 0 &&
                <div className="mt-4 flex items-center">
                    <input
                        type="number"
                        min="1"
                        value={quantity}
                        onChange={(e) => { setQuantity(e.target.value); addCartItemForm.setData('quantity', e.target.value); updateCartItemForm.setData('quantity', e.target.value); }}
                        className="w-20 border border-gray-300 rounded-lg px-2 py-1 mr-4"
                    />
                    <button className="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 disabled:opacity-50 disabled:cursor-not-allowed" onClick={product.cart_items.length > 0 ? handleUpdateCart : handleAddToCart} disabled={addCartItemForm.processing || updateCartItemForm.processing} >
                        {product.cart_items.length > 0 ? 'Update' : 'Add to Cart'}
                    </button>
                    {product.cart_items.length > 0 &&
                        <button className="ml-2 bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 disabled:opacity-50 disabled:cursor-not-allowed" onClick={handleRemoveFromCart} disabled={destroyCartItemForm.processing} >
                            <TrashIcon />
                        </button>
                    }
                </div>
            }
            {(addCartItemForm.hasErrors || updateCartItemForm.hasErrors) && (
                <p className="text-red-600 mt-2">
                    {addCartItemForm.errors.quantity || updateCartItemForm.errors.quantity}
                </p>
            )}
        </div>
    );
}
