import AuthenticatedLayout from '@/Components/Layouts/AuthenticatedLayout';
import DashboardCard from '@/Components/UI/AdminPanel/Dashboard/Card';
import ProductList from '@/Components/UI/AdminPanel/Products/List';
import { UserIcon, ShoppingBagIcon, WarningIcon } from '@/Components/UI/Icon';
import { Head, usePage } from '@inertiajs/react';


export default function Dashboard({ usersCount, ordersCount, lowStockProductsCount, products }) {
    const { auth } = usePage().props;
    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Dashboard
                </h2>
            }
        >
            <Head title="Dashboard" />

            {auth.user.role === 'admin' &&
                <div className="pt-6">
                    <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                        <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                            <div className="p-6 text-gray-900">
                                <div className="grid grid-cols-1 gap-6 md:grid-cols-3">
                                    <DashboardCard
                                        title="Total Users"
                                        value={usersCount}
                                        icon={<UserIcon />}
                                        type="info"
                                    />
                                    <DashboardCard
                                        title="Total Orders"
                                        value={ordersCount}
                                        icon={<ShoppingBagIcon />}
                                        type="success"
                                    />
                                    <DashboardCard
                                        title="Low Stock Products"
                                        value={lowStockProductsCount}
                                        icon={<WarningIcon />}
                                        type="warning"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            }
            <ProductList products={products} />
        </AuthenticatedLayout>
    );
}
