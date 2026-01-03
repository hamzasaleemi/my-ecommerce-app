import { useState } from "react";
import { usePage } from '@inertiajs/react';

export default function Slideshow({ images }) {
    const { storageUrl, appUrl } = usePage().props;
    const [currentIndex, setCurrentIndex] = useState(0);
    return (
        <div className="relative w-full max-w-lg mx-auto">
            <div className="overflow-hidden rounded-lg">
                <img
                    src={appUrl + storageUrl + images[currentIndex]?.image_path}
                    alt={`Slide ${currentIndex + 1}`}
                    className="w-full h-64 object-cover"
                />
            </div>

            {images.length > 1 &&
                <div className="absolute inset-0 flex items-center justify-between">
                    <button
                        onClick={() =>
                            setCurrentIndex((prevIndex) =>
                                prevIndex === 0 ? images.length - 1 : prevIndex - 1
                            )
                        }
                        className="bg-white bg-opacity-50 hover:bg-opacity-75 text-gray-800 font-bold py-2 px-4 rounded-full"
                    >
                        &#10094;
                    </button>
                    <button
                        onClick={() =>
                            setCurrentIndex((prevIndex) =>
                                prevIndex === images.length - 1 ? 0 : prevIndex + 1
                            )
                        }
                        className="bg-white bg-opacity-50 hover:bg-opacity-75 text-gray-800 font-bold py-2 px-4 rounded-full"
                    >
                        &#10095;
                    </button>
                </div>
            }
        </div>
    );
}
