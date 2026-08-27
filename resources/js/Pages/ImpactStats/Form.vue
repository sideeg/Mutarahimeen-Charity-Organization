<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Link } from "@inertiajs/vue3";
import { ArrowRight, Save } from "lucide-vue-next";

const props = defineProps({ stat: Object });
const isEditing = !!props.stat;

const form = useForm({
    label_ar: props.stat?.label_ar || "",
    label_en: props.stat?.label_en || "",
    number_value: props.stat?.number_value || 0,
    suffix: props.stat?.suffix || "",
    description_ar: props.stat?.description_ar || "",
    description_en: props.stat?.description_en || "",
    source_type: props.stat?.source_type || "manual",
    calculation_key: props.stat?.calculation_key || "",
    icon_name: props.stat?.icon_name || "Heart",
    display_order: props.stat?.display_order || 0,
    is_active: props.stat ? !!props.stat.is_active : true,
});

const submit = () => {
    if (isEditing) {
        form.post("/admin/impact-stats/" + props.stat.id);
    } else {
        form.post("/admin/impact-stats");
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="mb-8 flex items-center gap-4">
            <Link
                href="/admin/impact-stats"
                class="p-2 bg-white border border-slate-200 rounded-lg text-slate-600 hover:bg-slate-50 transition"
            >
                <ArrowRight class="w-5 h-5" />
            </Link>
            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    {{ isEditing ? "تعديل مؤشر الأثر" : "إضافة مؤشر أثر جديد" }}
                </h2>
                <p class="text-slate-500 text-sm mt-1">
                    تحديد القيمة وتسمية المؤشر والترتيب العرضي.
                </p>
            </div>
        </div>

        <form
            @submit.prevent="submit"
            class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 md:p-8 space-y-6 max-w-2xl"
        >
            <div class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label
                            class="block text-sm font-semibold text-slate-700 mb-2"
                            >اسم المؤشر (بالعربي) *</label
                        >
                        <input
                            type="text"
                            v-model="form.label_ar"
                            required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                            placeholder="مثال: آبار مياه محفورة"
                        />
                    </div>
                    <div>
                        <label
                            class="block text-sm font-semibold text-slate-700 mb-2"
                            >اسم المؤشر (بالإنجليزي)</label
                        >
                        <input
                            type="text"
                            v-model="form.label_en"
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                            dir="ltr"
                            placeholder="e.g. Clean water wells"
                        />
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div class="col-span-2">
                        <label
                            class="block text-sm font-semibold text-slate-700 mb-2"
                            >القيمة العددية المرصودة *</label
                        >
                        <input
                            type="number"
                            v-model="form.number_value"
                            required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left font-mono"
                        />
                    </div>
                    <div>
                        <label
                            class="block text-sm font-semibold text-slate-700 mb-2"
                            >الملحق البصري (Suffix)</label
                        >
                        <input
                            type="text"
                            v-model="form.suffix"
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-center"
                            placeholder="مثال: + أو %"
                        />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label
                            class="block text-sm font-semibold text-slate-700 mb-2"
                            >مصدر حساب القيمة *</label
                        >
                        <select
                            v-model="form.source_type"
                            required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                        >
                            <option value="manual">تعديل يدوي من النظام</option>
                            <option value="calculated">
                                تلقائي (من قاعدة البيانات)
                            </option>
                        </select>
                    </div>
                    <div>
                        <label
                            class="block text-sm font-semibold text-slate-700 mb-2"
                            >المفتاح البرمجي للحساب (اختياري)</label
                        >
                        <input
                            type="text"
                            v-model="form.calculation_key"
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                            placeholder="e.g. total_beneficiaries"
                        />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label
                            class="block text-sm font-semibold text-slate-700 mb-2"
                            >رمز الأيقونة (Icon)</label
                        >
                        <input
                            type="text"
                            v-model="form.icon_name"
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
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
                            min="0"
                            step="1"
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                        />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label
                            class="block text-sm font-semibold text-slate-700 mb-2"
                            >وصف أو توضيح المؤشر (بالعربي)</label
                        >
                        <textarea
                            v-model="form.description_ar"
                            rows="3"
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                        ></textarea>
                    </div>
                    <div>
                        <label
                            class="block text-sm font-semibold text-slate-700 mb-2"
                            >وصف أو توضيح المؤشر (بالإنجليزي)</label
                        >
                        <textarea
                            v-model="form.description_en"
                            rows="3"
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                            dir="ltr"
                        ></textarea>
                    </div>
                </div>

                <div class="pt-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input
                            type="checkbox"
                            v-model="form.is_active"
                            class="w-4 h-4 text-orange-500 border-slate-300 rounded focus:ring-orange-500"
                        />
                        <span class="text-sm font-semibold text-slate-700"
                            >تنشيط مؤشر الأثر للعمل بالصفحة الرئيسية</span
                        >
                    </label>
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="flex items-center gap-2 px-6 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-bold text-sm rounded-lg shadow-sm transition"
                >
                    <Save class="w-4 h-4" />
                    <span>حفظ البيانات</span>
                </button>
            </div>
        </form>
    </AuthenticatedLayout>
</template>
