<template>
    <aside class="w-64 h-screen border-r p-3 transition
                bg-white border-gray-200
                dark:bg-[#0b0b0b] dark:border-gray-800">

        <ul class="space-y-1 text-sm">
            <!-- dashboard -->
            <li>    
                <router-link to="/admin/dashboard" class="group flex items-center gap-3 px-3 py-2 rounded-md transition
                 text-gray-600 hover:bg-gray-100 hover:text-black
                 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
                    active-class="bg-gray-200 text-black dark:bg-gray-800 dark:text-white">
                    <IconGauge class="w-4 h-4 opacity-70 group-hover:opacity-100" />
                    <span>Dashboard</span>
                </router-link>
            </li>

            <!-- Categories -->
            <li>
                <router-link
                    to="/admin/categories"
                    class="group flex items-center gap-3 px-3 py-2 rounded-md transition
                    text-gray-600 hover:bg-gray-100 hover:text-black
                    dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
                    active-class="bg-gray-200 text-black dark:bg-gray-800 dark:text-white"
                >
                    <IconFolder class="w-4 h-4 opacity-70 group-hover:opacity-100" />
                    <span>Categories</span>
                </router-link>
            </li>

            <!-- Songs -->
            <li>
                <router-link
                    to="/admin/song"
                    class="group flex items-center gap-3 px-3 py-2 rounded-md transition
                    text-gray-600 hover:bg-gray-100 hover:text-black
                    dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
                    active-class="bg-gray-200 text-black dark:bg-gray-800 dark:text-white"
                >
                    <IconMusic class="w-4 h-4 opacity-70 group-hover:opacity-100" />
                    <span>Songs</span>
                </router-link>
            </li>
                

            <!-- Profile -->
            <li>
                <router-link to="/admin/profile" class="group flex items-center gap-3 px-3 py-2 rounded-md transition
                 text-gray-600 hover:bg-gray-100 hover:text-black
                 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
                    active-class="bg-gray-200 text-black dark:bg-gray-800 dark:text-white">
                    <IconUser class="w-4 h-4 opacity-70 group-hover:opacity-100" />
                    <span>Profile</span>
                </router-link>
            </li>

            <!-- Settings -->
            <li>
                <router-link to="/admin/settings" class="group flex items-center gap-3 px-3 py-2 rounded-md transition
                 text-gray-600 hover:bg-gray-100 hover:text-black
                 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
                    active-class="bg-gray-200 text-black dark:bg-gray-800 dark:text-white">
                    <IconSettings class="w-4 h-4 opacity-70 group-hover:opacity-100" />
                    <span>Settings</span>
                </router-link>
            </li>

        </ul>
    </aside>
</template>