import { formatCurrency, formatDate } from '@/utils/formatter';
import { Link } from '@inertiajs/react';

export default function OrderList({ orders, title }) {
    return (
        <div className="py-6">
            <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="p-6 text-gray-900">
                        <h3 className="text-lg font-semibold mb-4">{title}</h3>
                        <table className="w-full table-auto border-collapse border border-gray-200">
                            <thead>
                                <tr className="bg-gray-100">
                                    <th className="border border-gray-200 px-4 py-2 text-left">Order ID</th>
                                    <th className='border border-gray-200 px-4 py-2 text-left'>Products</th>
                                    <th className="border border-gray-200 px-4 py-2 text-left">Total Amount</th>
                                    <th className="border border-gray-200 px-4 py-2 text-left">Date</th>
                                    <th className="border border-gray-200 px-4 py-2 text-left">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                {orders.data && orders.data.length === 0 && (
                                    <tr>
                                        <td colSpan="5" className="border border-gray-200 px-4 py-2 text-center text-gray-500">
                                            No orders found.
                                        </td>
                                    </tr>
                                )}
                                {orders.data.map((order) => (
                                    <tr key={order.id} className="hover:bg-gray-50">
                                        <td className="border border-gray-200 px-4 py-2">{order.id}</td>
                                        <td className="border border-gray-200 px-4 py-2">{order.order_items.map(orderItem =>
                                            orderItem.quantity > 1
                                            ? `${orderItem.product.name} (${orderItem.quantity})`
                                            : orderItem.product.name
                                        ).join(', ')}</td>
                                        <td className="border border-gray-200 px-4 py-2">{formatCurrency(order.total_amount)}</td>
                                        <td className="border border-gray-200 px-4 py-2">{formatDate(order.created_at)}</td>
                                        <td className="border border-gray-200 px-4 py-2">{order.status}</td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>

                        <div className="mt-4">
                            <div className="flex justify-center space-x-2">
                                {orders.links.map((link, index) => (
                                    <Link
                                        key={index}
                                        href={link.url || '#'}
                                        className={`px-3 py-1 border rounded ${link.active ? 'bg-blue-500 text-white' : 'bg-white text-blue-500 hover:bg-blue-100'}`}
                                        dangerouslySetInnerHTML={{ __html: link.label }}
                                    />
                                ))}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
