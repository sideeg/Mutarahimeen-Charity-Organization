<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Link } from "@inertiajs/vue3";
import { ArrowRight, Save } from "lucide-vue-next";

const props = defineProps({
    category: Object,
});

const isEditing = !!props.category;

const form = useForm({
    name_ar: props.category?.name_ar || "",
    name_en: props.category?.name_en || "",
    description_ar: props.category?.description_ar || "",
    description_en: props.category?.description_en || "",
    icon_name: props.category?.icon_name || "Heart",
    display_order: props.category?.display_order || 0,
    is_active: props.category ? !!props.category.is_active : true,
});

const submit = () => {
    if (isEditing) {
        form.post("/admin/categories/" + props.category.id);
    } else {
        form.post("/admin/categories");
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="mb-8 flex items-center gap-4">
            <Link
                href="/admin/categories"
                class="p-2 bg-white border border-slate-200 rounded-lg text-slate-600 hover:bg-slate-50 transition"
            >
                <ArrowRight class="w-5 h-5" />
            </Link>
            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    {{
                        isEditing ? "تعديل بيانات التصنيف" : "إضافة تصنيف جديد"
                    }}
                </h2>
                <p class="text-slate-500 text-sm mt-1">
                    تحديد المسميات وخصائص العرض للمجموعات الرئيسية.
                </p>
            </div>
        </div>

        <form
            @submit.prevent="submit"
            class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 md:p-8 space-y-6 max-w-2xl"
        >
            <div class="space-y-4">
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >اسم التصنيف باللغة العربية *</label
                    >
                    <input
                        type="text"
                        v-model="form.name_ar"
                        required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                    />
                </div>

                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >اسم التصنيف بالإنجليزية</label
                    >
                    <input
                        type="text"
                        v-model="form.name_en"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                        dir="ltr"
                    />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label
                            class="block text-sm font-semibold text-slate-700 mb-2"
                            >اسم الأيقونة (رمز مرئي)</label
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

                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >وصف التصنيف (بالعربي)</label
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
                        >وصف التصنيف (بالإنجليزي)</label
                    >
                    <textarea
                        v-model="form.description_en"
                        rows="3"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                        dir="ltr"
                    ></textarea>
                </div>

                <div class="pt-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input
                            type="checkbox"
                            v-model="form.is_active"
                            class="w-4 h-4 text-orange-500 border-slate-300 rounded focus:ring-orange-500"
                        />
                        <span class="text-sm font-semibold text-slate-700"
                            >تنشيط التصنيف للعمل فوراً</span
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
                    <span>حفظ التغييرات</span>
                </button>
            </div>
        </form>
    </AuthenticatedLayout>
</template>
