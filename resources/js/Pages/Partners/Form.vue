<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Link } from "@inertiajs/vue3";
import { ArrowRight, Save } from "lucide-vue-next";
import { ref } from "vue";

const props = defineProps({ partner: Object });
const isEditing = !!props.partner;
const fileInput = ref(null);

const partnerPreview = ref(props.partner?.logo_url || null);

const form = useForm({
    name_ar: props.partner?.name_ar || "",
    name_en: props.partner?.name_en || "",
    website_url: props.partner?.website_url || "",
    display_order: props.partner?.display_order || 0,
    is_active: props.partner ? !!props.partner.is_active : true,
    logo_file: null,
});

const handleFile = (e) => {
    const file = e.target.files[0];
    form.logo_file = file;
    if (file) {
        partnerPreview.value = URL.createObjectURL(file);
    }
};

const submit = () => {
    if (isEditing) {
        form.post("/admin/partners/" + props.partner.id);
    } else {
        form.post("/admin/partners");
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="mb-8 flex items-center gap-4">
            <Link
                href="/admin/partners"
                class="p-2 bg-white border border-slate-200 rounded-lg text-slate-600 hover:bg-slate-50 transition"
            >
                <ArrowRight class="w-5 h-5" />
            </Link>
            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    {{
                        isEditing
                            ? "تعديل بيانات الشريك"
                            : "إضافة شريك نجاح جديد"
                    }}
                </h2>
                <p class="text-slate-500 text-sm mt-1">
                    رفع شعار الهيئة الداعمة وإدراج الروابط الإلكترونية.
                </p>
            </div>
        </div>

        <form
            @submit.prevent="submit"
            class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 md:p-8 space-y-6 max-w-3xl"
        >
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Inputs -->
                <div class="md:col-span-2 space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-sm font-semibold text-slate-700 mb-2"
                                >اسم الشريك / الهيئة (بالعربي) *</label
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
                                >اسم الشريك / الهيئة (بالإنجليزي)</label
                            >
                            <input
                                type="text"
                                v-model="form.name_en"
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                                dir="ltr"
                            />
                        </div>
                    </div>

                    <div>
                        <label
                            class="block text-sm font-semibold text-slate-700 mb-2"
                            >الموقع الإلكتروني (رابط)</label
                        >
                        <input
                            type="url"
                            v-model="form.website_url"
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                            dir="ltr"
                            placeholder="https://example.com"
                        />
                    </div>

                    <div>
                        <label
                            class="block text-sm font-semibold text-slate-700 mb-2"
                            >ترتيب العرض بالتطبيق</label
                        >
                        <input
                            type="number"
                            v-model="form.display_order"
                            min="0"
                            step="1"
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                        />
                    </div>

                    <div>
                        <label
                            class="block text-sm font-semibold text-slate-700 mb-2"
                            >شعار الشريك (PNG أو JPG) *</label
                        >
                        <input
                            type="file"
                            ref="fileInput"
                            @change="handleFile"
                            :required="!isEditing"
                            accept="image/*"
                            class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-xs focus:outline-none"
                        />
                    </div>

                    <div class="pt-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input
                                type="checkbox"
                                v-model="form.is_active"
                                class="w-4 h-4 text-orange-500 border-slate-300 rounded focus:ring-orange-500"
                            />
                            <span class="text-sm font-semibold text-slate-700"
                                >تفعيل ظهور شعار الشريك بالواجهة</span
                            >
                        </label>
                    </div>
                </div>

                <!-- Preview logo container -->
                <div
                    class="bg-slate-50 p-4 border border-slate-200 rounded-xl flex flex-col h-fit justify-between"
                >
                    <span
                        class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2"
                        >معاينة الشعار</span
                    >
                    <div
                        class="aspect-video w-full bg-white border border-slate-300 rounded-lg flex items-center justify-center p-4 shadow-inner"
                    >
                        <img
                            v-if="partnerPreview"
                            :src="partnerPreview"
                            class="max-h-full max-w-full object-contain"
                        />
                        <div v-else class="text-slate-400 text-xs">
                            لا يوجد شعار
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
                    <span>حفظ الشريك</span>
                </button>
            </div>
        </form>
    </AuthenticatedLayout>
</template>
