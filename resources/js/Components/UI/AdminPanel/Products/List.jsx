import ProductCard from '@/Components/UI/AdminPanel/Products/Card';
import { Link } from '@inertiajs/react';

export default function ProductList({ products }) {
    return (
        <div className="pt-6">
            <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="p-6 text-gray-900">
                        <div className="grid grid-cols-1 gap-6 md:grid-cols-3">

                            <div className="md:col-span-3">
                                <h2 className="text-2xl font-semibold mb-6">Products</h2>
                            </div>

                            {products.data.map((product) => (
                                <ProductCard key={product.id} product={product} />
                            ))}


                            <div className="md:col-span-3 mt-6 flex justify-center space-x-2">
                                {products.links.map((link, index) => (
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
