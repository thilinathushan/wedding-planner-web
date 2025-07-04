<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Calendar } from '@/components/ui/calendar';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import AppLayout from '@/layouts/AppLayout.vue';
import { cn } from '@/lib/utils';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { CalendarDate, DateFormatter, type DateValue, getLocalTimeZone, today } from '@internationalized/date';
import { CalendarIcon, LoaderCircle } from 'lucide-vue-next';
import { ref, watch } from 'vue';

const userLocale = navigator.language || 'en-LK';
const df = new DateFormatter(userLocale, {
  dateStyle: 'long',
})

const value = ref<DateValue>()
const isPopoverOpen = ref(false);

// Set minimum date (today)
const tzToday = today(getLocalTimeZone());
const minDate = new CalendarDate(tzToday.year, tzToday.month, tzToday.day);

watch(value, (selectedDate) => {
    if (selectedDate) {
        // Convert to JS Date using user timezone
        const jsDate = selectedDate.toDate(getLocalTimeZone());
        const year = jsDate.getFullYear();
        const month = String(jsDate.getMonth() + 1).padStart(2, '0');
        const day = String(jsDate.getDate()).padStart(2, '0');

        // Format YYYY-MM-DD
        form.wedding_date = `${year}-${month}-${day}`;

        // Close popover automatically
        isPopoverOpen.value = false;
    } else {
        form.wedding_date = '';
    }
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Onboarding',
        href: '/onboarding/setup',
    },
];

const form = useForm({
    wedding_date: '',
    partner_email: '',
});

const submit = async () => {
    let hasError = false;

    if (!form.wedding_date) {
        form.setError('wedding_date', 'Wedding date is required.');
        hasError = true;
    }

    if (!form.partner_email) {
        form.setError('partner_email', 'Partner email is required.');
        hasError = true;
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.partner_email)) {
        form.setError('partner_email', 'Please enter a valid email address.');
        hasError = true;
    }

    if (hasError) {
        return;
    }

    form.post(route('onboarding.store'), {
        onFinish: () => {
            form.reset('wedding_date', 'partner_email');
            value.value = undefined;
        },
    });
};
</script>

<template>
    <Head title="Onboarding" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-1 flex-col items-center justify-center gap-6 p-4">
            <div class="text-center">
                <Heading
                    title="Welcome to Your Wedding Planning Journey!"
                    description="Please fill out the details below to create your couple profile and invite your partner."
                />
            </div>

            <Card class="w-full max-w-md">
                <CardHeader class="pt-6 text-center">
                    <CardTitle>Let's Plan Your Big Day!</CardTitle>
                    <CardDescription class="text-sm text-gray-500 dark:text-gray-400">
                        Fill in your wedding date and partner's email to get started.
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <form @submit.prevent="submit" class="flex flex-col gap-6">
                        <div class="grid w-full items-center gap-4">
                            <div class="flex flex-col gap-2">
                                <Label for="wedding_date">Wedding Date</Label>
                                <Popover id="wedding_date">
                                    <PopoverTrigger as-child :tabindex="1" autofocus>
                                        <Button
                                            variant="outline"
                                            :class="
                                                cn(
                                                    'justify-start text-left font-normal',
                                                    !value && 'text-muted-foreground',
                                                    form.errors.wedding_date && 'border-red-500 focus:border-red-500 focus:ring-red-500',
                                                )
                                            "
                                        >
                                            <CalendarIcon class="mr-2 h-4 w-4" />
                                            {{ value ? df.format(value.toDate(getLocalTimeZone())) : 'Pick a date' }}
                                        </Button>
                                    </PopoverTrigger>
                                    <PopoverContent class="w-auto p-0">
                                        <Calendar
                                            initial-focus
                                            :min-value="minDate"
                                            :model-value="value"
                                            @update:model-value="(v) => {
                                                if (v) {
                                                    value = v;
                                                }
                                                else {
                                                    value = undefined;
                                                }
                                            }"
                                        />
                                    </PopoverContent>
                                </Popover>
                                <InputError :message="form.errors.wedding_date" />
                            </div>
                            <div class="flex flex-col gap-2">
                                <Label for="partner_email">Partner Email</Label>
                                <Input
                                    id="partner_email"
                                    type="email"
                                    :tabindex="2"
                                    v-model="form.partner_email"
                                    class="focus:border-primary focus:ring-primary"
                                    placeholder="partner@mail.com"
                                />
                                <InputError :message="form.errors.partner_email" />
                            </div>
                        </div>
                        <div class="pb-6">
                            <Button
                                type="submit"
                                class="mt-2 flex w-full items-center justify-center gap-2"
                                :tabindex="3"
                                :disabled="form.processing"
                            >
                                <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                                Save & Invite Partner
                            </Button>
                        </div>
                    </form>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
