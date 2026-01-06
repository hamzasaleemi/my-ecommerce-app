import InputError from '@/Components/UI/Input/InputError';
import InputLabel from '@/Components/UI/Input/InputLabel';
import PrimaryButton from '@/Components/UI/Button/PrimaryButton';
import TextInput from '@/Components/UI/Input/TextInput';
import { Transition } from '@headlessui/react';
import { Link, useForm, usePage } from '@inertiajs/react';

export default function UpdateSettings({ settings }) {
    const { data, setData, put, errors, processing, recentlySuccessful } =
        useForm({
            low_stock_threshold: settings?.low_stock_threshold,
        });

    const submit = (e) => {
        e.preventDefault();

        put(route('settings.update'));
    };

    return (
        <section className="max-w-xl">
            <header>
                <h2 className="text-lg font-medium text-gray-900">
                    Settings
                </h2>

                <p className="mt-1 text-sm text-gray-600">
                    Update your admin settings.
                </p>
            </header>

            <form onSubmit={submit} className="mt-6 space-y-6">
                <div>
                    <InputLabel htmlFor="low_stock_threshold" value="Low Stock Threshold" />

                    <TextInput
                        id="low_stock_threshold"
                        className="mt-1 block w-full"
                        value={data.low_stock_threshold}
                        onChange={(e) => setData('low_stock_threshold', e.target.value)}
                        required
                        isFocused
                        autoComplete="low_stock_threshold"
                    />

                    <InputError className="mt-2" message={errors.low_stock_threshold} />
                </div>

                <div className="flex items-center gap-4">
                    <PrimaryButton disabled={processing}>Save</PrimaryButton>

                    <Transition
                        show={recentlySuccessful}
                        enter="transition ease-in-out"
                        enterFrom="opacity-0"
                        leave="transition ease-in-out"
                        leaveTo="opacity-0"
                    >
                        <p className="text-sm text-gray-600">
                            Saved.
                        </p>
                    </Transition>
                </div>
            </form>
        </section>
    );
}
