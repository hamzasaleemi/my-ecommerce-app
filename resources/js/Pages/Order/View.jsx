import AuthenticatedLayout from '@/Components/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import OrderList from "@/Components/UI/AdminPanel/Orders/List";
import { usePage } from '@inertiajs/react';

export default function View({ orders }) {
    const { auth } = usePage().props;
    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Orders
                </h2>
            }
        >
            <Head title="Orders" />
            <OrderList orders={orders} title={`${auth.user.role === 'admin' ? 'All' : 'My'} Orders`} />

        </AuthenticatedLayout>
    );
}
