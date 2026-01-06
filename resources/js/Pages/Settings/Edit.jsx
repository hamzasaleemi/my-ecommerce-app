import AuthenticatedLayout from '@/Components/Layouts/AuthenticatedLayout';
import UpdateSettings from '@/Components/Forms/Settings/UpdateSettingsForm';
import { Head } from '@inertiajs/react';

export default function Edit({ settings }) {
    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Settings
                </h2>
            }
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                    <div className="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                        <UpdateSettings settings={settings} />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
