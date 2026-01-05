import AuthenticatedLayout from '@/Components/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import CartItem from '@/Components/UI/AdminPanel/Cart/Item';
import { formatCurrency } from '@/utils/formatter';
import { useOrder } from '@/hooks/useOrder';

export default function View({ cartItems }) {
    const orderItems = cartItems.map(item => ({
        product_id: item.product.id,
        quantity: item.quantity,
    }));
    const { addOrderForm, addOrder } = useOrder(orderItems);

    function handleAddOrder(e) {
        e.preventDefault();
        addOrder();
    }

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Cart
                </h2>
            }
        >
            <Head title="Cart" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            {addOrderForm.hasErrors && (
                                <div className="mb-4 p-4 bg-red-100 text-red-700 rounded">
                                    <button
                                        type="button"
                                        className="float-right text-red-700 hover:text-red-900"
                                        onClick={() => addOrderForm.clearErrors()}
                                    >
                                        &times;
                                    </button>
                                    <span className="font-bold">Failed:</span>
                                    <ul className="list-disc list-inside">
                                        {Object.values(addOrderForm.errors).map((error, index) => (
                                            <li key={index}>{error}</li>
                                        ))}
                                    </ul>
                                </div>
                            )}

                            {cartItems.length === 0 ?
                                <p className="text-center text-gray-500">Your cart is empty.</p> :
                                <>
                                    {cartItems.map((cartItem) => (
                                        <CartItem key={cartItem.id} cartItem={cartItem} addOrderForm={addOrderForm} />
                                    ))}

                                    <div className="mt-6 text-right">
                                        <span className="text-lg font-semibold">
                                            Total: {formatCurrency(cartItems.reduce((total, item) => total + item.product.price * item.quantity, 0))}
                                        </span>
                                    </div>

                                    <div className="mt-6 text-right">
                                        <button
                                            type="button"
                                            className="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                            disabled={addOrderForm.processing}
                                            onClick={handleAddOrder}
                                        >
                                            Buy Now
                                        </button>
                                    </div>
                                </>
                            }
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
