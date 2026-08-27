<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, router } from "@inertiajs/vue3";
import { Plus, Edit2, Trash2 } from "lucide-vue-next";

defineProps({ partners: Array });

const deletePartner = (id) => {
    if (confirm("هل أنت متأكد من رغبتك بحذف هذا الشريك؟")) {
        router.delete("/admin/partners/" + id);
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <div
            class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4"
        >
            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    شركاء النجاح والمنظمات الصديقة (Partners)
                </h2>
                <p class="text-slate-500 text-sm mt-1">
                    إضافة وإدارة شعارات وروابط الهيئات والمنظمات الداعمة
                    لجهودنا.
                </p>
            </div>
            <Link
                href="/admin/partners/create"
                class="flex items-center gap-2 px-4 py-2.5 bg-orange-500 text-white rounded-lg font-bold text-sm hover:bg-orange-600 transition"
            >
                <Plus class="w-4 h-4" />
                <span>إضافة شريك جديد</span>
            </Link>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-6">
            <div
                v-for="part in partners"
                :key="part.id"
                class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm flex flex-col justify-between group relative overflow-hidden"
            >
                <div
                    class="aspect-video w-full flex items-center justify-center p-2"
                >
                    <img
                        :src="part.logo_url"
                        class="max-h-full max-w-full object-contain"
                    />
                </div>
                <div class="text-center mt-3">
                    <h4 class="font-bold text-slate-800 text-xs truncate">
                        {{ part.name_ar }}
                    </h4>
                    <span
                        class="inline-block mt-2 w-2 h-2 rounded-full"
                        :class="
                            part.is_active ? 'bg-emerald-500' : 'bg-red-400'
                        "
                    ></span>
                </div>

                <div
                    class="absolute inset-x-0 bottom-0 bg-slate-900/95 p-3 flex items-center justify-center gap-4 translate-y-full group-hover:translate-y-0 transition duration-200"
                >
                    <Link
                        :href="'/admin/partners/' + part.id + '/edit'"
                        class="p-1.5 bg-slate-800 hover:bg-slate-700 rounded text-slate-300 hover:text-white transition"
                    >
                        <Edit2 class="w-4.5 h-4.5" />
                    </Link>
                    <button
                        @click="deletePartner(part.id)"
                        class="p-1.5 bg-slate-800 hover:bg-red-900 text-slate-400 hover:text-red-300 rounded transition cursor-pointer"
                    >
                        <Trash2 class="w-4.5 h-4.5" />
                    </button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
