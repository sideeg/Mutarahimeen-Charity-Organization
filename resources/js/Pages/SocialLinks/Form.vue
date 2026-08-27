<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Link } from "@inertiajs/vue3";
import { ArrowRight, Save } from "lucide-vue-next";

const props = defineProps({ link: Object });
const isEditing = !!props.link;

const form = useForm({
    platform_name: props.link?.platform_name || "",
    url: props.link?.url || "",
    icon_name: props.link?.icon_name || "Facebook",
    display_order: props.link?.display_order || 0,
    is_active: props.link ? !!props.link.is_active : true,
});

const submit = () => {
    if (isEditing) {
        form.post("/admin/social-links/" + props.link.id);
    } else {
        form.post("/admin/social-links");
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="mb-8 flex items-center gap-4">
            <Link
                href="/admin/social-links"
                class="p-2 bg-white border border-slate-200 rounded-lg text-slate-600 hover:bg-slate-50 transition"
            >
                <ArrowRight class="w-5 h-5" />
            </Link>
            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    {{
                        isEditing
                            ? "تعديل رابط القناة"
                            : "إضافة قناة تواصل جديدة"
                    }}
                </h2>
                <p class="text-slate-500 text-sm mt-1">
                    إضافة الروابط الرقمية لصفحات وحسابات المنظمة.
                </p>
            </div>
        </div>

        <form
            @submit.prevent="submit"
            class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 md:p-8 space-y-6 max-w-xl"
        >
            <div class="space-y-4">
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >اسم منصة التواصل *</label
                    >
                    <input
                        type="text"
                        v-model="form.platform_name"
                        required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                        placeholder="مثال: فيسبوك"
                    />
                </div>

                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >رابط الصفحة الشخصية الرسمي *</label
                    >
                    <input
                        type="url"
                        v-model="form.url"
                        required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                        dir="ltr"
                        placeholder="https://facebook.com/example"
                    />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label
                            class="block text-sm font-semibold text-slate-700 mb-2"
                            >اسم الأيقونة (Icon Code)</label
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

                <div class="pt-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input
                            type="checkbox"
                            v-model="form.is_active"
                            class="w-4 h-4 text-orange-500 border-slate-300 rounded focus:ring-orange-500"
                        />
                        <span class="text-sm font-semibold text-slate-700"
                            >تنشيط ظهور الرابط بالواجهة</span
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
