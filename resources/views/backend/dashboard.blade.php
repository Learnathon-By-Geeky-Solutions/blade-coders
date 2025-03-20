<x-backend-layout>
    <div class="-m-6 mb-3 flex items-center justify-between bg-indigo-600 px-8 pb-16 pt-10 lg:pt-14">
        <h1 class="text-xl text-white">{{ __('Dashboard') }}</h1>
        <a class="btn border-gray-600 bg-white text-gray-800 hover:border-gray-200 hover:bg-gray-100 hover:text-gray-800 focus:outline-none focus:ring-4 focus:ring-indigo-300 active:border-gray-200 active:bg-gray-100 active:text-gray-800"
            href="#">
            Create New Project
        </a>
    </div>

    <div class="py-6">
        <div class="-mt-[4.5rem] mb-6 grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2 xl:grid-cols-4">
            <!-- card -->
            <div class="card shadow">
                <!-- card body -->
                <div class="card-body">
                    <!-- content -->
                    <div class="flex items-center justify-between">
                        <h4>Projects</h4>
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-md bg-indigo-600 bg-opacity-10 text-center text-indigo-600">
                            <i data-feather="briefcase"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex flex-col gap-0 text-base">
                        <h2 class="text-xl font-bold">18</h2>
                        <div>
                            <span>2</span>
                            <span class="text-gray-500">Completed</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- card -->
            <div class="card shadow">
                <!-- card boduy -->
                <div class="card-body">
                    <!-- content -->
                    <div class="flex items-center justify-between">
                        <h4>Active Task</h4>
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-md bg-indigo-600 bg-opacity-10 text-center text-indigo-600">
                            <i data-feather="list"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex flex-col gap-0 text-base">
                        <h2 class="text-xl font-bold">132</h2>
                        <div>
                            <span>28</span>
                            <span class="text-gray-500">Completed</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- card -->
            <div class="card shadow">
                <!-- card body -->
                <div class="card-body">
                    <!-- content -->
                    <div class="flex items-center justify-between">
                        <h4>Teams</h4>
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-md bg-indigo-600 bg-opacity-10 text-center text-indigo-600">
                            <i data-feather="users"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex flex-col gap-0 text-base">
                        <h2 class="text-xl font-bold">12</h2>
                        <div>
                            <span>1</span>
                            <span class="text-gray-500">Completed</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- card -->
            <div class="card shadow">
                <!-- card body -->
                <div class="card-body">
                    <!-- content -->
                    <div class="flex items-center justify-between">
                        <h4>Productivity</h4>
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-md bg-indigo-600 bg-opacity-10 text-center text-indigo-600">
                            <i data-feather="target"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex flex-col gap-0 text-base">
                        <h2 class="text-xl font-bold">76%</h2>
                        <div>
                            <span class="text-green-600">5%</span>
                            <span class="text-gray-500">Completed</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-flow-row-dense grid-cols-1 grid-rows-1 gap-6 xl:grid-cols-3">
            <div class="xl:col-span-2">
                <div class="card h-full shadow">
                    <!-- heading -->
                    <div class="border-b border-gray-300 px-5 py-4">
                        <h4>Active Projects</h4>
                    </div>

                    <div class="relative overflow-x-auto">
                        <!-- table -->
                        <table class="w-full whitespace-nowrap text-left">
                            <thead class="text-gray-700">
                                <tr>
                                    <th class="border-b bg-gray-100 px-6 py-3" scope="col">Project name</th>
                                    <th class="border-b bg-gray-100 px-6 py-3" scope="col">Hours</th>
                                    <th class="border-b bg-gray-100 px-6 py-3" scope="col">Priority</th>
                                    <th class="border-b bg-gray-100 px-6 py-3" scope="col">Members</th>
                                    <th class="border-b bg-gray-100 px-6 py-3" scope="col">Progress</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                        <div class="flex items-center">
                                            <img class="h-6 w-6" src="./assets/images/svg/brand-logo-1.svg"
                                                alt="" />

                                            <h5 class="mb-1 ml-4"><a href="#!">Dropbox Design System</a></h5>
                                        </div>
                                    </td>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">34</td>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                        <span
                                            class="inline-block whitespace-nowrap rounded-full bg-yellow-200 px-2 py-1 text-center text-sm font-medium text-yellow-700">Medium</span>
                                    </td>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                        <div class="-space-x-5">
                                            <img class="relative inline-block h-8 w-8 rounded-full border-2 border-white object-cover"
                                                src="./assets/images/avatar/avatar-1.jpg" alt="Profile image" />
                                            <img class="relative inline-block h-8 w-8 rounded-full border-2 border-white object-cover"
                                                src="./assets/images/avatar/avatar-2.jpg" alt="Profile image" />
                                            <img class="relative inline-block h-8 w-8 rounded-full border-2 border-white object-cover"
                                                src="./assets/images/avatar/avatar-1.jpg" alt="Profile image" />
                                            <div
                                                class="relative inline-flex h-8 w-8 items-center justify-center rounded-full border-2 border-white bg-indigo-600 text-sm text-white">
                                                2+</div>
                                        </div>
                                    </td>
                                    <td class="border-b border-gray-300 px-6 py-3 pe-6 text-left">
                                        <div class="flex items-center gap-2">
                                            <div>15%</div>
                                            <div class="h-1.5 w-full rounded-full bg-gray-200">
                                                <div class="h-1.5 rounded-full bg-indigo-600" style="width: 15%"></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                        <div class="flex items-center">
                                            <img class="h-6 w-6" src="./assets/images/svg/brand-logo-2.svg"
                                                alt="" />
                                            <h5 class="ml-4"><a href="#!">Slack Team UI Design</a></h5>
                                        </div>
                                    </td>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">47</td>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                        <span
                                            class="inline-block whitespace-nowrap rounded-full bg-red-200 px-2 py-1 text-center text-sm font-medium text-red-700">High</span>
                                    </td>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                        <div class="-space-x-5">
                                            <img class="relative inline-block h-8 w-8 rounded-full border-2 border-white object-cover"
                                                src="./assets/images/avatar/avatar-4.jpg" alt="Profile image" />
                                            <img class="relative inline-block h-8 w-8 rounded-full border-2 border-white object-cover"
                                                src="./assets/images/avatar/avatar-5.jpg" alt="Profile image" />
                                            <img class="relative inline-block h-8 w-8 rounded-full border-2 border-white object-cover"
                                                src="./assets/images/avatar/avatar-6.jpg" alt="Profile image" />
                                            <div
                                                class="relative inline-flex h-8 w-8 items-center justify-center rounded-full border-2 border-white bg-indigo-600 text-sm text-white">
                                                2+</div>
                                        </div>
                                    </td>
                                    <td class="border-b border-gray-300 px-6 py-3 pe-6 text-left">
                                        <div class="flex items-center gap-2">
                                            <div>35%</div>
                                            <div class="h-1.5 w-full rounded-full bg-gray-200">
                                                <div class="h-1.5 rounded-full bg-indigo-600" style="width: 35%">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                        <div class="flex items-center">
                                            <img class="h-6 w-6" src="./assets/images/svg/brand-logo-3.svg"
                                                alt="" />
                                            <h5 class="ml-4"><a href="#!">GitHub Satellite</a></h5>
                                        </div>
                                    </td>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">120</td>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                        <span
                                            class="inline-block whitespace-nowrap rounded-full bg-cyan-200 px-2 py-1 text-center text-sm font-medium text-cyan-700">Low</span>
                                    </td>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                        <div class="-space-x-5">
                                            <img class="relative inline-block h-8 w-8 rounded-full border-2 border-white object-cover"
                                                src="./assets/images/avatar/avatar-7.jpg" alt="Profile image" />
                                            <img class="relative inline-block h-8 w-8 rounded-full border-2 border-white object-cover"
                                                src="./assets/images/avatar/avatar-8.jpg" alt="Profile image" />
                                            <img class="relative inline-block h-8 w-8 rounded-full border-2 border-white object-cover"
                                                src="./assets/images/avatar/avatar-9.jpg" alt="Profile image" />
                                            <div
                                                class="relative inline-flex h-8 w-8 items-center justify-center rounded-full border-2 border-white bg-indigo-600 text-sm text-white">
                                                5+</div>
                                        </div>
                                    </td>
                                    <td class="border-b border-gray-300 px-6 py-3 pe-6 text-left">
                                        <div class="flex items-center gap-2">
                                            <div>75%</div>
                                            <div class="h-1.5 w-full rounded-full bg-gray-200">
                                                <div class="h-1.5 rounded-full bg-indigo-600" style="width: 75%">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                        <div class="flex items-center">
                                            <img class="h-6 w-6" src="./assets/images/svg/brand-logo-4.svg"
                                                alt="" />
                                            <h5 class="ml-4"><a href="#!">3D Character Modelling</a></h5>
                                        </div>
                                    </td>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">89</td>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                        <span
                                            class="inline-block whitespace-nowrap rounded-full bg-yellow-200 px-2 py-1 text-center text-sm font-medium text-yellow-700">Medium</span>
                                    </td>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                        <div class="-space-x-5">
                                            <img class="relative inline-block h-8 w-8 rounded-full border-2 border-white object-cover"
                                                src="./assets/images/avatar/avatar-10.jpg" alt="Profile image" />
                                            <img class="relative inline-block h-8 w-8 rounded-full border-2 border-white object-cover"
                                                src="./assets/images/avatar/avatar-11.jpg" alt="Profile image" />
                                            <img class="relative inline-block h-8 w-8 rounded-full border-2 border-white object-cover"
                                                src="./assets/images/avatar/avatar-12.jpg" alt="Profile image" />
                                            <div
                                                class="relative inline-flex h-8 w-8 items-center justify-center rounded-full border-2 border-white bg-indigo-600 text-sm text-white">
                                                5+</div>
                                        </div>
                                    </td>
                                    <td class="border-b border-gray-300 px-6 py-3 pe-6 text-left">
                                        <div class="flex items-center gap-2">
                                            <div>63%</div>
                                            <div class="h-1.5 w-full rounded-full bg-gray-200">
                                                <div class="h-1.5 rounded-full bg-indigo-600" style="width: 63%">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                        <div class="flex items-center">
                                            <img class="h-6 w-6" src="./assets/images/svg/brand-logo-5.svg"
                                                alt="" />
                                            <h5 class="ml-4"><a href="#!">Webapp Design System</a></h5>
                                        </div>
                                    </td>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">89</td>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                        <span
                                            class="inline-block whitespace-nowrap rounded-full bg-green-200 px-2 py-1 text-center text-sm font-medium text-green-700">Track</span>
                                    </td>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                        <div class="-space-x-5">
                                            <img class="relative inline-block h-8 w-8 rounded-full border-2 border-white object-cover"
                                                src="./assets/images/avatar/avatar-13.jpg" alt="Profile image" />
                                            <img class="relative inline-block h-8 w-8 rounded-full border-2 border-white object-cover"
                                                src="./assets/images/avatar/avatar-11.jpg" alt="Profile image" />
                                            <img class="relative inline-block h-8 w-8 rounded-full border-2 border-white object-cover"
                                                src="./assets/images/avatar/avatar-12.jpg" alt="Profile image" />
                                            <div
                                                class="relative inline-flex h-8 w-8 items-center justify-center rounded-full border-2 border-white bg-indigo-600 text-sm text-white">
                                                5+</div>
                                        </div>
                                    </td>
                                    <td class="border-b border-gray-300 px-6 py-3 pe-6 text-left">
                                        <div class="flex items-center gap-2">
                                            <div>100%</div>
                                            <div class="h-1.5 w-full rounded-full bg-gray-200">
                                                <div class="h-1.5 rounded-full bg-green-600" style="width: 100%">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                        <div class="flex items-center">
                                            <img class="h-6 w-6" src="./assets/images/svg/brand-logo-6.svg"
                                                alt="" />
                                            <h5 class="ml-4"><a href="#!">Github Event Design</a></h5>
                                        </div>
                                    </td>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">120</td>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                        <span
                                            class="inline-block whitespace-nowrap rounded-full bg-cyan-200 px-2 py-1 text-center text-sm font-medium text-cyan-700">Low</span>
                                    </td>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                        <div class="-space-x-5">
                                            <img class="relative inline-block h-8 w-8 rounded-full border-2 border-white object-cover"
                                                src="./assets/images/avatar/avatar-13.jpg" alt="Profile image" />
                                            <img class="relative inline-block h-8 w-8 rounded-full border-2 border-white object-cover"
                                                src="./assets/images/avatar/avatar-11.jpg" alt="Profile image" />
                                            <img class="relative inline-block h-8 w-8 rounded-full border-2 border-white object-cover"
                                                src="./assets/images/avatar/avatar-12.jpg" alt="Profile image" />
                                            <div
                                                class="relative inline-flex h-8 w-8 items-center justify-center rounded-full border-2 border-white bg-indigo-600 text-sm text-white">
                                                4+</div>
                                        </div>
                                    </td>
                                    <td class="border-b border-gray-300 px-6 py-3 pe-6 text-left">
                                        <div class="flex items-center gap-2">
                                            <div>75%</div>
                                            <div class="h-1.5 w-full rounded-full bg-gray-200">
                                                <div class="h-1.5 rounded-full bg-indigo-600" style="width: 75%">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- card -->
            <div class="card h-full shadow">
                <div class="flex items-center justify-between border-b border-gray-300 px-5 py-4">
                    <h4>Tasks Performance</h4>
                    <!-- dropdown -->
                    <div class="dropdown leading-4">
                        <button class="rounded-full p-2 text-gray-600 transition-all hover:bg-gray-300"
                            data-bs-toggle="dropdown" type="button" aria-expanded="false">
                            <i class="h-4 w-4" data-feather="more-vertical"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </div>
                </div>
                <!-- card body -->
                <div class="card-body">
                    <div id="perfomanceChart"></div>
                    <div class="flex items-center justify-around py-4">
                        <!-- content -->
                        <div class="text-center">
                            <div class="mb-3">
                                <i class="mx-auto h-6 w-6 text-green-500" data-feather="check-circle"></i>
                            </div>

                            <span class="text-2xl font-bold text-gray-800">76%</span>
                            <p class="text-gray-600">Completed</p>
                        </div>
                        <!-- content -->
                        <div class="text-center">
                            <div class="mb-3">
                                <i class="mx-auto h-6 w-6 text-yellow-500" data-feather="trending-up"></i>
                            </div>

                            <span class="text-2xl font-bold text-gray-800">32%</span>
                            <p class="text-gray-600">In-Progress</p>
                        </div>
                        <!-- content -->
                        <div class="text-center">
                            <div class="mb-3">
                                <i class="mx-auto h-6 w-6 text-red-500" data-feather="trending-down"></i>
                            </div>
                            <span class="text-2xl font-bold text-gray-800">13%</span>
                            <p class="text-gray-600">Behind</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-6 grid grid-flow-row-dense grid-cols-1 grid-rows-1 gap-6 lg:grid-cols-2">
            <div>
                <div class="card h-full shadow">
                    <div class="flex w-full items-center justify-between border-b border-gray-300 px-5 py-4">
                        <!-- title -->
                        <div>
                            <h4>My Task</h4>
                        </div>
                        <div>
                            <!-- button -->
                            <div class="dropdown leading-4">
                                <button
                                    class="btn btn-sm gap-x-2 border border-gray-300 bg-white text-gray-800 hover:border-gray-700 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-4 focus:ring-gray-300 active:border-gray-700 active:bg-gray-700 disabled:pointer-events-none disabled:opacity-50"
                                    data-bs-toggle="dropdown" type="button" aria-expanded="false">
                                    Add Task
                                </button>
                                <!-- list -->
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="relative overflow-x-auto">
                        <!-- table -->
                        <table class="w-full whitespace-nowrap text-left">
                            <thead class="text-gray-700">
                                <tr>
                                    <th class="border-b bg-gray-100 px-6 py-3" scope="col">Name</th>
                                    <th class="border-b bg-gray-100 px-6 py-3" scope="col">Deadline</th>
                                    <th class="border-b bg-gray-100 px-6 py-3" scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                        <div class="flex items-center">
                                            <input
                                                class="h-4 w-4 rounded border-gray-300 bg-white text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-600"
                                                id="checkboxOne" type="checkbox" />
                                            <label class="ml-2 text-base text-slate-600" for="checkboxOne">Design a
                                                FreshCart Home page</label>
                                        </div>
                                    </td>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">Today</td>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                        <span
                                            class="rounded-md bg-green-100 px-2 py-1 text-sm font-medium text-green-700">Approved</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                        <div class="flex items-center">
                                            <input
                                                class="h-4 w-4 rounded border-gray-300 bg-white text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-600"
                                                id="checkboxTwo" type="checkbox" />
                                            <label class="ml-2 text-base text-slate-600" for="checkboxTwo">Dash UI
                                                Dark Version Design</label>
                                        </div>
                                    </td>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">Yesterday</td>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                        <span
                                            class="rounded-md bg-red-100 px-2 py-1 text-sm font-medium text-red-700">Pending</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                        <div class="flex items-center">
                                            <input
                                                class="h-4 w-4 rounded border-gray-300 bg-white text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-600"
                                                id="checkboxThree" type="checkbox" />
                                            <label class="ml-2 text-base text-slate-600" for="checkboxThree">Dash UI
                                                landing page design</label>
                                        </div>
                                    </td>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">16 Sept, 2023
                                    </td>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                        <span
                                            class="rounded-md bg-yellow-100 px-2 py-1 text-sm font-medium text-yellow-700">In
                                            Progress</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                        <div class="flex items-center">
                                            <input
                                                class="focus:ring-3 h-4 w-4 rounded-md border-gray-300 bg-white text-indigo-600 focus:outline-none focus:outline-indigo-600 focus:ring-indigo-400"
                                                id="checkboxFour" type="checkbox" />
                                            <label class="ml-2 text-base text-slate-600" for="checkboxFour">Next.js
                                                Dash UI version</label>
                                        </div>
                                    </td>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">23 Sept, 2023
                                    </td>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                        <span
                                            class="rounded-md bg-green-100 px-2 py-1 text-sm font-medium text-green-700">Approved</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                        <div class="flex items-center">
                                            <input
                                                class="h-4 w-4 rounded border-gray-300 bg-white text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-600"
                                                id="checkboxFive" type="checkbox" />
                                            <label class="ml-2 text-base text-slate-600" for="checkboxFive">Develop a
                                                Dash UI Laravel</label>
                                        </div>
                                    </td>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">20 Sept, 2023
                                    </td>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                        <span
                                            class="rounded-md bg-red-100 px-2 py-1 text-sm font-medium text-red-700">Pending</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                        <div class="flex items-center">
                                            <input
                                                class="h-4 w-4 rounded border-gray-300 bg-white text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-600"
                                                id="checkboxSix" type="checkbox" />
                                            <label class="ml-2 text-base text-slate-600" for="checkboxSix">Coach home
                                                page design</label>
                                        </div>
                                    </td>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">12 Sept, 2023
                                    </td>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                        <span
                                            class="rounded-md bg-green-100 px-2 py-1 text-sm font-medium text-green-700">Approved</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                        <div class="flex items-center">
                                            <input
                                                class="h-4 w-4 rounded border-gray-300 bg-white text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-600"
                                                id="checkboxSeven" type="checkbox" />
                                            <label class="ml-2 text-base text-slate-600" for="checkboxSeven">Develop a
                                                Dash UI Laravel</label>
                                        </div>
                                    </td>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">11 Sept, 2023
                                    </td>
                                    <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                        <span
                                            class="rounded-md bg-red-100 px-2 py-1 text-sm font-medium text-red-700">Pending</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- card -->
            <div class="card h-full shadow">
                <div class="border-b border-gray-300 px-5 py-4">
                    <h4>Teams</h4>
                </div>
                <div class="relative overflow-x-auto" data-simplebar="" style="max-height: 380px">
                    <!-- table -->
                    <table class="w-full whitespace-nowrap text-left">
                        <thead class="text-gray-700">
                            <tr>
                                <th class="border-b bg-gray-100 px-6 py-3" scope="col">Name</th>
                                <th class="border-b bg-gray-100 px-6 py-3" scope="col">Role</th>
                                <th class="border-b bg-gray-100 px-6 py-3" scope="col">Last Activity</th>
                                <th class="border-b bg-gray-100 px-6 py-3" scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                    <div class="flex items-center">
                                        <div>
                                            <a class="inline-block h-10 w-10" href="#!"><img
                                                    class="rounded-full" src="assets/images/avatar/avatar-2.jpg"
                                                    alt="Image" /></a>
                                        </div>
                                        <div class="ml-3 leading-4">
                                            <h5 class="mb-1"><a href="#!">Anita Parmar</a></h5>
                                            <p class="mb-0 text-gray-500">anita@example.com</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">Front End
                                    Developer</td>
                                <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">3 May, 2023</td>
                                <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                    <div class="dropdown leading-4">
                                        <button class="rounded-full p-2 text-gray-600 transition-all hover:bg-gray-300"
                                            data-bs-toggle="dropdown" type="button" aria-expanded="false">
                                            <i class="h-4 w-4" data-feather="more-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Action</a></li>
                                            <li><a class="dropdown-item" href="#">Another action</a></li>
                                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                    <div class="flex items-center">
                                        <div>
                                            <a class="inline-block h-10 w-10" href="#!">
                                                <img class="rounded-full" src="assets/images/avatar/avatar-3.jpg"
                                                    alt="Image" />
                                            </a>
                                        </div>
                                        <div class="ml-3 leading-4">
                                            <h5 class="mb-1"><a href="#!">Jitu Chauhan</a></h5>
                                            <p class="mb-0 text-gray-500">jituchauhan@example.com</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">Project Director
                                </td>
                                <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">Today</td>
                                <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                    <div class="dropdown leading-4">
                                        <button class="rounded-full p-2 text-gray-600 transition-all hover:bg-gray-300"
                                            data-bs-toggle="dropdown" type="button" aria-expanded="false">
                                            <i class="h-4 w-4" data-feather="more-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Action</a></li>
                                            <li><a class="dropdown-item" href="#">Another action</a></li>
                                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                    <div class="flex items-center">
                                        <div>
                                            <a class="inline-block h-10 w-10" href="#!"><img
                                                    class="rounded-full" src="assets/images/avatar/avatar-2.jpg"
                                                    alt="Image" /></a>
                                        </div>
                                        <div class="ml-3 leading-4">
                                            <h5 class="mb-1"><a href="#!">Sandeep Chauhan</a></h5>
                                            <p class="mb-0 text-gray-500">sandeepchauhan@example.com</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">Full- Stack
                                    Developer</td>
                                <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">Yesterday</td>
                                <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                    <div class="dropdown leading-4">
                                        <button class="rounded-full p-2 text-gray-600 transition-all hover:bg-gray-300"
                                            data-bs-toggle="dropdown" type="button" aria-expanded="false">
                                            <i class="h-4 w-4" data-feather="more-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Action</a></li>
                                            <li><a class="dropdown-item" href="#">Another action</a></li>
                                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                    <div class="flex items-center">
                                        <div>
                                            <a class="inline-block h-10 w-10" href="#!"><img
                                                    class="rounded-full" src="assets/images/avatar/avatar-5.jpg"
                                                    alt="Image" /></a>
                                        </div>
                                        <div class="ml-3 leading-4">
                                            <h5 class="mb-1"><a href="#!">Amanda Darnell</a></h5>
                                            <p class="mb-0 text-gray-500">amandadarnell@example.com</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">Digital Marketer
                                </td>
                                <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">3 May, 2023</td>
                                <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                    <div class="dropdown leading-4">
                                        <button class="rounded-full p-2 text-gray-600 transition-all hover:bg-gray-300"
                                            data-bs-toggle="dropdown" type="button" aria-expanded="false">
                                            <i class="h-4 w-4" data-feather="more-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Action</a></li>
                                            <li><a class="dropdown-item" href="#">Another action</a></li>
                                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                    <div class="flex items-center">
                                        <div>
                                            <a class="inline-block h-10 w-10" href="#!"><img
                                                    class="rounded-full" src="assets/images/avatar/avatar-6.jpg"
                                                    alt="Image" /></a>
                                        </div>
                                        <div class="ml-3 leading-4">
                                            <h5 class="mb-1"><a href="#!">Patricia Murrill</a></h5>
                                            <p class="mb-0 text-gray-500">patriciamurrill@example.com</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">Account Manager
                                </td>
                                <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">3 May, 2023</td>
                                <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                    <div class="dropdown leading-4">
                                        <button class="rounded-full p-2 text-gray-600 transition-all hover:bg-gray-300"
                                            data-bs-toggle="dropdown" type="button" aria-expanded="false">
                                            <i class="h-4 w-4" data-feather="more-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Action</a></li>
                                            <li><a class="dropdown-item" href="#">Another action</a></li>
                                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                    <div class="flex items-center">
                                        <div>
                                            <a class="inline-block h-10 w-10" href="#!"><img
                                                    class="rounded-full" src="assets/images/avatar/avatar-7.jpg"
                                                    alt="Image" /></a>
                                        </div>
                                        <div class="ml-3 leading-4">
                                            <h5 class="mb-1"><a href="#!">Darshini Nair</a></h5>
                                            <p class="mb-0 text-gray-500">darshininair@example.com</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">Front End
                                    Developer</td>
                                <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">3 May, 2023</td>
                                <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                    <div class="dropdown leading-4">
                                        <button class="rounded-full p-2 text-gray-600 transition-all hover:bg-gray-300"
                                            data-bs-toggle="dropdown" type="button" aria-expanded="false">
                                            <i class="h-4 w-4" data-feather="more-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Action</a></li>
                                            <li><a class="dropdown-item" href="#">Another action</a></li>
                                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                    <div class="flex items-center">
                                        <div>
                                            <a class="inline-block h-10 w-10" href="#!"><img
                                                    class="rounded-full" src="assets/images/avatar/avatar-8.jpg"
                                                    alt="Image" /></a>
                                        </div>
                                        <div class="ml-3 leading-4">
                                            <h5 class="mb-1"><a href="#!">Patricia Murrill</a></h5>
                                            <p class="mb-0 text-gray-500">patriciamurrill@example.com</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">Account Manager
                                </td>
                                <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">3 May, 2023</td>
                                <td class="border-b border-gray-300 px-6 py-3 text-left font-medium">
                                    <div class="dropdown leading-4">
                                        <button class="rounded-full p-2 text-gray-600 transition-all hover:bg-gray-300"
                                            data-bs-toggle="dropdown" type="button" aria-expanded="false">
                                            <i class="h-4 w-4" data-feather="more-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Action</a></li>
                                            <li><a class="dropdown-item" href="#">Another action</a></li>
                                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-backend-layout>
