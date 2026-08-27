<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm } from "@inertiajs/vue3";
import {
    Save,
    Settings as SettingsIcon,
    Mail,
    Globe,
    Eye,
    EyeOff,
} from "lucide-vue-next";
import { ref, computed } from "vue";

const props = defineProps({
    settings: Array,
});

const showMailPassword = ref(false);

// SMTP related setting keys
const smtpKeys = [
    "mail_host",
    "mail_port",
    "mail_username",
    "mail_password",
    "mail_encryption",
    "mail_from_address",
    "mail_from_name",
];

// Computed splits
const generalSettings = computed(() => {
    return props.settings.filter((s) => !smtpKeys.includes(s.key));
});

const smtpSettings = computed(() => {
    return props.settings.filter((s) => smtpKeys.includes(s.key));
});

const submitSettingChange = (setting) => {
    const form = useForm({
        value: setting.value,
    });
    form.post("/admin/settings/" + setting.id, {
        preserveScroll: true,
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="mb-8 flex items-center gap-4">
            <div
                class="p-2.5 bg-white border border-slate-200 rounded-lg text-slate-600"
            >
                <SettingsIcon class="w-6 h-6 text-orange-500" />
            </div>
            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    إعدادات المنصة والنظام العامة
                </h2>
                <p class="text-slate-500 text-sm mt-1">
                    تحديث وتعديل الكلمات الدلالية، الرموز، والمفاتيح التشغيلية
                    للموقع.
                </p>
            </div>
        </div>

        <!-- Section 1: General Platform & Pixels Settings -->
        <div class="space-y-6 mb-12">
            <div class="flex items-center gap-2 border-b border-slate-200 pb-3">
                <Globe class="w-5 h-5 text-slate-500" />
                <h3 class="font-bold text-slate-800 text-md">
                    إعدادات الموقع وتتبع البيانات
                </h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div
                    v-for="set in generalSettings"
                    :key="set.id"
                    class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 flex flex-col justify-between space-y-4"
                >
                    <div>
                        <span
                            class="px-2 py-1 bg-slate-100 text-slate-600 font-mono text-[10px] rounded font-bold"
                            >{{ set.key }}</span
                        >
                        <p class="text-xs text-slate-400 mt-2">
                            {{ set.description }}
                        </p>
                    </div>

                    <div
                        class="flex items-center gap-3 pt-4 border-t border-slate-100"
                    >
                        <input
                            type="text"
                            v-model="set.value"
                            class="flex-1 px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                        />
                        <button
                            @click="submitSettingChange(set)"
                            class="px-3 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg transition cursor-pointer shadow-sm flex items-center justify-center"
                        >
                            <Save class="w-4 h-4" />
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: SMTP Mail Server Settings -->
        <div class="space-y-6">
            <div class="flex items-center gap-2 border-b border-slate-200 pb-3">
                <Mail class="w-5 h-5 text-slate-500" />
                <h3 class="font-bold text-slate-800 text-md">
                    إعدادات خادم البريد الإلكتروني (SMTP)
                </h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div
                    v-for="set in smtpSettings"
                    :key="set.id"
                    class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 flex flex-col justify-between space-y-4"
                >
                    <div>
                        <span
                            class="px-2 py-1 bg-slate-100 text-slate-600 font-mono text-[10px] rounded font-bold"
                            >{{ set.key }}</span
                        >
                        <p class="text-xs text-slate-400 mt-2">
                            {{ set.description }}
                        </p>
                    </div>

                    <div
                        class="flex items-center gap-3 pt-4 border-t border-slate-100 relative"
                    >
                        <!-- Password field protection -->
                        <input
                            v-if="set.key === 'mail_password'"
                            :type="showMailPassword ? 'text' : 'password'"
                            v-model="set.value"
                            class="flex-1 px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left font-mono pl-10"
                            dir="ltr"
                        />
                        <input
                            v-else
                            type="text"
                            v-model="set.value"
                            class="flex-1 px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left font-mono"
                            dir="ltr"
                        />

                        <!-- Toggle visibility button for password key -->
                        <button
                            v-if="set.key === 'mail_password'"
                            type="button"
                            @click="showMailPassword = !showMailPassword"
                            class="absolute left-14 top-1/2 -translate-y-3 bg-transparent border-none text-slate-400 hover:text-slate-600 transition cursor-pointer flex items-center justify-center p-1"
                        >
                            <Eye v-if="!showMailPassword" class="w-4 h-4" />
                            <EyeOff v-else class="w-4 h-4" />
                        </button>

                        <button
                            @click="submitSettingChange(set)"
                            class="px-3 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg transition cursor-pointer shadow-sm flex items-center justify-center"
                        >
                            <Save class="w-4 h-4" />
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
