import ProductCard from '@/Components/UI/AdminPanel/Products/Card';

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

                            {products.map((product) => (
                                <ProductCard key={product.id} product={product} />
                            ))}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
