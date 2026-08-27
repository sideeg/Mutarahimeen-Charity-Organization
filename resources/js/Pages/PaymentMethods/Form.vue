<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Link } from "@inertiajs/vue3";
import { ArrowRight, Save } from "lucide-vue-next";
import { ref } from "vue";

const props = defineProps({ method: Object });
const isEditing = !!props.method;
const fileInput = ref(null);

const iconPreview = ref(props.method?.icon_url || null);

const form = useForm({
    method_name_ar: props.method?.method_name_ar || "",
    method_name_en: props.method?.method_name_en || "",
    account_name: props.method?.account_name || "",
    account_number: props.method?.account_number || "",
    instructions_ar: props.method?.instructions_ar || "",
    instructions_en: props.method?.instructions_en || "",
    display_order: props.method?.display_order || 0,
    is_active: props.method ? !!props.method.is_active : true,
    icon_file: null,
});

const handleFile = (e) => {
    const file = e.target.files[0];
    form.icon_file = file;
    if (file) {
        iconPreview.value = URL.createObjectURL(file);
    }
};

const submit = () => {
    if (isEditing) {
        form.post("/admin/payment-methods/" + props.method.id);
    } else {
        form.post("/admin/payment-methods");
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="mb-8 flex items-center gap-4">
            <Link
                href="/admin/payment-methods"
                class="p-2 bg-white border border-slate-200 rounded-lg text-slate-600 hover:bg-slate-50 transition"
            >
                <ArrowRight class="w-5 h-5" />
            </Link>
            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    {{
                        isEditing
                            ? "تعديل وسيلة الدفع والتحويل"
                            : "إضافة حساب بنكي / وسيلة تحويل جديدة"
                    }}
                </h2>
                <p class="text-slate-500 text-sm mt-1">
                    تعديل بيانات الحسابات المصرفية المتاحة لفاعلي الخير لإجراء
                    الإيداع المالي المباشر.
                </p>
            </div>
        </div>

        <form
            @submit.prevent="submit"
            class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 md:p-8 space-y-6 max-w-3xl"
        >
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2 space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-sm font-semibold text-slate-700 mb-2"
                                >اسم منفذ التبرع (بالعربي) *</label
                            >
                            <input
                                type="text"
                                v-model="form.method_name_ar"
                                required
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                            />
                        </div>
                        <div>
                            <label
                                class="block text-sm font-semibold text-slate-700 mb-2"
                                >اسم منفذ التبرع (بالإنجليزي)</label
                            >
                            <input
                                type="text"
                                v-model="form.method_name_en"
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                                dir="ltr"
                            />
                        </div>
                    </div>

                    <div
                        class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-slate-100"
                    >
                        <div>
                            <label
                                class="block text-sm font-semibold text-slate-700 mb-2"
                                >اسم صاحب الحساب بالكامل</label
                            >
                            <input
                                type="text"
                                v-model="form.account_name"
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                            />
                        </div>
                        <div>
                            <label
                                class="block text-sm font-semibold text-slate-700 mb-2"
                                >رقم الحساب / رقم المحفظة الرقمية</label
                            >
                            <input
                                type="text"
                                v-model="form.account_number"
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left font-mono"
                            />
                        </div>
                    </div>

                    <div
                        class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-slate-100"
                    >
                        <div>
                            <label
                                class="block text-sm font-semibold text-slate-700 mb-2"
                                >أيقونة أو لوجو منفذ الدفع</label
                            >
                            <input
                                type="file"
                                ref="fileInput"
                                @change="handleFile"
                                accept="image/*"
                                class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-xs focus:outline-none"
                            />
                        </div>
                        <div>
                            <label
                                class="block text-sm font-semibold text-slate-700 mb-2"
                                >ترتيب العرض</label
                            >
                            <input
                                type="number"
                                v-model="form.display_order"
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                            />
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100">
                        <label
                            class="block text-sm font-semibold text-slate-700 mb-2"
                            >تعليمات أو شروط التحويل والتحقق (بالعربي)</label
                        >
                        <textarea
                            v-model="form.instructions_ar"
                            rows="3"
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                        ></textarea>
                    </div>

                    <div class="pt-4 border-t border-slate-100">
                        <label
                            class="block text-sm font-semibold text-slate-700 mb-2"
                            >تعليمات أو شروط التحويل والتحقق (بالإنجليزي)</label
                        >
                        <textarea
                            v-model="form.instructions_en"
                            rows="3"
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                            dir="ltr"
                        ></textarea>
                    </div>

                    <div class="pt-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input
                                type="checkbox"
                                v-model="form.is_active"
                                class="w-4 h-4 text-orange-500 border-slate-300 rounded focus:ring-orange-500"
                            />
                            <span class="text-sm font-semibold text-slate-700"
                                >تنشيط وسيلة التحويل للعمل بالواجهة</span
                            >
                        </label>
                    </div>
                </div>

                <div
                    class="bg-slate-50 p-4 border border-slate-200 rounded-xl flex flex-col h-fit justify-between"
                >
                    <span
                        class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2"
                        >معاينة الأيقونة</span
                    >
                    <div
                        class="aspect-square w-full max-w-[160px] mx-auto bg-white border border-slate-300 rounded-xl flex items-center justify-center p-3 shadow-inner"
                    >
                        <img
                            v-if="iconPreview"
                            :src="iconPreview"
                            class="max-h-full max-w-full object-contain rounded"
                        />
                        <div v-else class="text-slate-400 text-xs">
                            لا توجد أيقونة
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="flex items-center gap-2 px-6 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-bold text-sm rounded-lg shadow-sm transition"
                >
                    <Save class="w-4 h-4" />
                    <span>حفظ البيانات المالية</span>
                </button>
            </div>
        </form>
    </AuthenticatedLayout>
</template>
