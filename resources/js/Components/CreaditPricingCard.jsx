import { usePage } from "@inertiajs/react";

export default function CreaditPricingCard({ packages, features }) {
    const { csrf_token } = usePage().props;
    return (
        <section className="bg-gray-900">
            <div className="py-8 px-4">
                <div className="text-center mb-8">
                    <h2 className="mb-4 text-4xl font-extrabold text-white">
                        The more credits you choose the bigger saving you will
                        make.
                    </h2>
                </div>

                <div className="space-y-8 lg:grid lg:grid-cols-3 sm:gap-6 xl:gap-10 lg:space-y-0">
                    {packages?.map((p) => (
                        <div
                            key={p.id}
                            className="flex flex-col align-stretch p-6 mx-auto lg:mx-0 max-w-lg text-center rounded-lg border shadow border-gray-600 bg-gray-800 text-white"
                        >
                            <h3 className="mb-4 text-2xl font-semibold">
                                {p.name}
                            </h3>
                            <div className="flex justify-center items-baseline my-8">
                                <span className="mr-2 text-5xl font-extrabold ">
                                    {p.price}
                                </span>
                                <span className=" text-2xl dark:text-gray-400 ">
                                    {p.credits} credits
                                </span>
                            </div>

                            <ul
                                role="list"
                                className="mb-8 space-y-4 text-left"
                            >
                                {features?.map((feature) => (
                                    <li
                                        key={feature.id}
                                        className="flex items-center space-x-3"
                                    >
                                        <svg
                                            className="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                fillRule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clipRule="evenodd"
                                            ></path>
                                        </svg>
                                        <span>{feature.name}</span>
                                    </li>
                                ))}
                            </ul>

                            <form
                                action={route("credit.buy", p)}
                                method="post"
                                className="w-full"
                            >
                                <input
                                    type="hidden"
                                    name="_token"
                                    value={csrf_token}
                                    autoComplete="off"
                                />
                                <button className="text-white  bg-blue-500  hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:text-white  dark:focus:ring-primary-900 w-full">
                                    Get Started
                                </button>
                            </form>
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}
