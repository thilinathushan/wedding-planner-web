<script setup lang="ts">
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';
import 'vue-sonner/style.css';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';


defineOptions({
    // Explicitly type the layout function for better type safety
    layout: (h: any, page: any) =>
        h(
            AppLayout,
            {
                breadcrumbs: [
                    {
                        title: 'Dashboard',
                        href: '/dashboard',
                    },
                ],
            },
            () => page,
        ),
});
</script>

<template>
    <Head title="Dashboard" />

    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                <PlaceholderPattern />
                <Button variant="outline" class="absolute top-2 right-2" @click="() => toast.success('This is a success toast!')"> Toast </Button>
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                <PlaceholderPattern />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                <PlaceholderPattern />
            </div>
        </div>
        <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
            <PlaceholderPattern />
        </div>
    </div>
</template>
