<script setup>
import { useForm } from "@inertiajs/vue3";
import { HeartHandshake } from "lucide-vue-next";

defineProps({
    captcha_question: String,
});

const form = useForm({
    email: "",
    password: "",
    captcha: "",
});

const submit = () => {
    form.post("/admin/login", {
        onFinish: () => form.reset("password", "captcha"),
    });
};
</script>

<template>
    <div
        class="min-h-screen bg-slate-900 flex flex-col justify-center py-12 sm:px-6 lg:px-8"
        dir="rtl"
    >
        <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
            <div
                class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-800 mb-4"
            >
                <HeartHandshake class="w-10 h-10 text-orange-500" />
            </div>
            <h2 class="text-center text-3xl font-extrabold text-white">
                منظمة متراحمين الخيرية
            </h2>
            <p class="mt-2 text-center text-sm text-slate-400">
                تسجيل الدخول إلى لوحة إدارة الخير
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div
                class="bg-slate-800 py-8 px-4 shadow sm:rounded-lg sm:px-10 border border-slate-700"
            >
                <form @submit.prevent="submit" class="space-y-6">
                    <div>
                        <label
                            for="email"
                            class="block text-sm font-semibold text-slate-300"
                            >البريد الإلكتروني</label
                        >
                        <div class="mt-1">
                            <input
                                id="email"
                                v-model="form.email"
                                type="email"
                                required
                                autocomplete="email"
                                class="appearance-none block w-full px-3 py-2 border border-slate-600 rounded-md shadow-sm placeholder-slate-400 text-white bg-slate-700 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm text-left font-mono"
                                dir="ltr"
                            />
                        </div>
                        <p
                            v-if="form.errors.email"
                            class="mt-2 text-xs text-red-400"
                        >
                            {{ form.errors.email }}
                        </p>
                    </div>

                    <div>
                        <label
                            for="password"
                            class="block text-sm font-semibold text-slate-300"
                            >كلمة المرور</label
                        >
                        <div class="mt-1">
                            <input
                                id="password"
                                v-model="form.password"
                                type="password"
                                required
                                autocomplete="current-password"
                                class="appearance-none block w-full px-3 py-2 border border-slate-600 rounded-md shadow-sm placeholder-slate-400 text-white bg-slate-700 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm text-left font-mono"
                                dir="ltr"
                            />
                        </div>
                    </div>

                    <!-- Math Captcha Block -->
                    <div>
                        <label
                            class="block text-sm font-semibold text-slate-300 mb-1"
                            >مسألة الأمان (منع الروبوتات) *</label
                        >
                        <div class="mt-1 flex items-center gap-3">
                            <span
                                class="text-white bg-slate-700 px-4 py-2 rounded-md font-mono font-bold select-none text-sm"
                            >
                                {{ captcha_question }} =
                            </span>
                            <input
                                type="text"
                                v-model="form.captcha"
                                required
                                placeholder="الإجابة"
                                class="appearance-none block w-full px-3 py-2 border border-slate-600 rounded-md shadow-sm text-white bg-slate-700 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm text-center font-mono"
                            />
                        </div>
                        <p
                            v-if="form.errors.captcha"
                            class="mt-2 text-xs text-red-400"
                        >
                            {{ form.errors.captcha }}
                        </p>
                    </div>

                    <div>
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-md shadow-sm text-sm font-bold text-white bg-orange-500 hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition cursor-pointer"
                        >
                            {{
                                form.processing
                                    ? "جاري التحقق..."
                                    : "تسجيل الدخول"
                            }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
