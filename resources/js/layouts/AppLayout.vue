<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { onMounted, watch } from 'vue';
import { Toaster, toast } from 'vue-sonner';
import 'vue-sonner/style.css';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

// Define a reusable function to handle the toast logic
const showFlashToast = (flash: any) => {
    if (!flash) return;

    if (flash.success) {
        toast.success('Success!', {
            description: flash.success,
        });
    } else if (flash.error) {
        toast.error('Oops! Something went wrong.', {
            description: flash.error,
        });
    } else if (flash.info) {
        toast.info('Just so you know...', {
            description: flash.info,
        });
    }
};

// Keep the watcher for subsequent flash messages (e.g., from an API call on the same page)
watch(
    () => usePage().props.flash,
    (flash) => {
        showFlashToast(flash);
    },
    { deep: true },
);

// Use `onMounted` to check for a flash message when the layout first loads
onMounted(() => {
    showFlashToast(usePage().props.flash);
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <Toaster position="top-right" :offset="{ top: 72, right: 24 }" :mobileOffset="{ top: 75 }" richColors />
        </div>
        <slot />
    </AppLayout>
</template>
