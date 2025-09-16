<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Form, Head } from '@inertiajs/vue3';
import { Eye, EyeOff, LoaderCircle } from 'lucide-vue-next';
import { ref } from 'vue';

const showPassword = ref(false);
const showPasswordConfirm = ref(false);

const togglePassword = () => {
    showPassword.value = !showPassword.value;
};

const togglePasswordConfirm = () => {
    showPasswordConfirm.value = !showPasswordConfirm.value;
};
</script>

<template>
    <AuthBase title="أنشأ حسابك الخاص" description="قم بإدخال معلوماتك الشخصية الى حسابك ">

        <Head title="Register" />

        <Form dir="rtl" method="post" :action="route('register')"
            :reset-on-success="['password', 'password_confirmation']" v-slot="{ errors, processing }"
            class="flex flex-col gap-6">
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="name">الاسم</Label>
                    <Input id="name" type="text" required autofocus :tabindex="1" autocomplete="name" name="name"
                        placeholder="Full name" />
                    <InputError :message="errors.name" />
                </div>

                <div class="grid gap-2">
                    <Label for="email">عنوان البريد الالكتروني</Label>
                    <Input id="email" type="email" required :tabindex="2" autocomplete="email" name="email"
                        placeholder="email@example.com" />
                    <InputError :message="errors.email" />
                </div>

                <!-- Password with eye toggle -->
                <div class="grid gap-2">
                    <Label for="password">كلمة المرور</Label>
                    <div class="relative">
                        <Input id="password" :type="showPassword ? 'text' : 'password'" required :tabindex="3"
                            autocomplete="new-password" name="password" placeholder="Password" class="pr-10" />
                        <button type="button" :aria-label="showPassword ? 'إخفاء كلمة المرور' : 'إظهار كلمة المرور'"
                            class="absolute inset-y-0 left-2 flex items-center text-muted-foreground hover:text-foreground"
                            @click="togglePassword" tabindex="-1">
                            <Eye v-if="!showPassword" class="h-4 w-4" />
                            <EyeOff v-else class="h-4 w-4" />
                        </button>
                    </div>
                    <InputError :message="errors.password" />
                </div>

                <!-- Password confirmation with eye toggle -->
                <div class="grid gap-2">
                    <Label for="password_confirmation">تأكيد كلمة المرور</Label>
                    <div class="relative">
                        <Input id="password_confirmation" :type="showPasswordConfirm ? 'text' : 'password'" required
                            :tabindex="4" autocomplete="new-password" name="password_confirmation"
                            placeholder="Confirm password" class="pr-10" />
                        <button type="button"
                            :aria-label="showPasswordConfirm ? 'إخفاء كلمة المرور' : 'إظهار كلمة المرور'"
                            class="absolute inset-y-0 left-2 flex items-center text-muted-foreground hover:text-foreground"
                            @click="togglePasswordConfirm" tabindex="-1">
                            <Eye v-if="!showPasswordConfirm" class="h-4 w-4" />
                            <EyeOff v-else class="h-4 w-4" />
                        </button>
                    </div>
                    <InputError :message="errors.password_confirmation" />
                </div>

                <Button type="submit" class="mt-2 w-full" tabindex="5" :disabled="processing">
                    <LoaderCircle v-if="processing" class="h-4 w-4 animate-spin" />
                    إنشاء حساب
                </Button>
            </div>

            <div class="text-center text-sm text-muted-foreground">
                هل لديك حساب بالفعل?
                <TextLink :href="route('login')" class="underline underline-offset-4" :tabindex="6"> تسجيل الدخول
                </TextLink>
            </div>
        </Form>
    </AuthBase>
</template>
